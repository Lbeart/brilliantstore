<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);

        $totalQty = 0;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $q = (int)($item['qty'] ?? 0);
            $p = (float)($item['price'] ?? 0);
            $totalQty += $q;
            $totalPrice += ($p * $q);
        }

        session(['cart_total_qty' => $totalQty]);

        return view('cart.index', compact('cart', 'totalQty', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'size'       => 'nullable|string|max:100',
            // e lejojme me ardh prej frontit, po NUK e besojme – llogarisim server-side
            'price'      => 'nullable|numeric|min:0',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty = (int)$data['qty'];
        $sizeLabel = $data['size'] ?? null;

        // ✅ price + stock server-side (nese ka sizes)
        [$finalPrice, $availableStock] = $this->resolveVariantPriceAndStock($product, $sizeLabel);

        // ✅ stok check (nese ka stok)
        if ($availableStock !== null && $availableStock >= 0 && $qty > $availableStock) {
            return response()->json([
                'ok' => false,
                'message' => 'Sasia e kërkuar tejkalon stokun (' . (int)$availableStock . ').',
            ], 422);
        }

        $cart = session('cart', []);

        // key unike: produkt + size (standard)
        $key = $product->id . '|std|' . ($sizeLabel ?? '');

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'type'       => 'standard',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->firstImageUrl($product),
                'qty'        => $qty,
                'price'      => round((float)$finalPrice, 2),
                'size'       => $sizeLabel,
            ];
        }

        session(['cart' => $cart]);

        $totalQty = array_sum(array_map(fn($i) => (int)($i['qty'] ?? 0), $cart));
        session(['cart_total_qty' => $totalQty]);

        return response()->json([
            'ok'       => true,
            'totalQty' => $totalQty,
            'message'  => 'U shtua në shportë',
        ]);
    }

    public function addCurtain(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'width'      => 'required|numeric|min:0.1',
            'height'     => 'required|numeric|min:0.1',
            'fold_type'  => 'required|string|max:50',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $qty    = (int)$data['qty'];
        $width  = (float)$data['width'];
        $height = (float)$data['height'];
        $fold   = (string)$data['fold_type'];

        // ✅ extras sipas select-it
        $foldExtras = [
            'classic1' => 0.0,
            'classic2' => 0.0,
            'grommet'  => 1.5,
            'pencil'   => 1.0,
            'swave'    => 2.0,
            'triple'   => 3.0,
        ];

        $foldNames = [
            'classic1' => 'Classic Fold 1',
            'classic2' => 'Classic Fold 2',
            'grommet'  => 'Grommet',
            'pencil'   => 'Pencil Pleat',
            'swave'    => 'S-Wave',
            'triple'   => 'Triple Pleat',
        ];

        $extra = $foldExtras[$fold] ?? 0.0;
        $foldName = $foldNames[$fold] ?? $fold;

        // ✅ formula (e rregulluar: perfshin width + height)
        $multiplier = 2; // standard
        $meters = $width * $height * $multiplier;

        $pricePerMeter = (float)$product->price;
        $unit = $pricePerMeter + $extra;

        $oneItemTotal = round($meters * $unit, 2);

        // ✅ key unik per perde (me parametra)
        $key = $product->id
            . '|curtain|'
            . number_format($width, 2, '.', '')
            . 'x'
            . number_format($height, 2, '.', '')
            . '|'
            . $fold;

        $cart = session('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'type'       => 'curtain',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->firstImageUrl($product),
                'qty'        => $qty,
                // ✅ price = total per 1 item (qofte 1 perde)
                'price'      => $oneItemTotal,
                'size'       => number_format($width, 2) . 'm x ' . number_format($height, 2) . 'm • ' . $foldName,
                'meta'       => [
                    'width'      => $width,
                    'height'     => $height,
                    'fold_type'  => $fold,
                    'fold_name'  => $foldName,
                    'multiplier' => $multiplier,
                    'meters'     => $meters,
                    'unit'       => $unit,
                    'extra'      => $extra,
                ],
            ];
        }

        session(['cart' => $cart]);

        $totalQty = array_sum(array_map(fn($i) => (int)($i['qty'] ?? 0), $cart));
        session(['cart_total_qty' => $totalQty]);

        return response()->json([
            'ok'       => true,
            'totalQty' => $totalQty,
            'message'  => 'Perdja u shtua në shportë',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);
        if (isset($cart[$request->key])) {
            $cart[$request->key]['qty'] = (int)$request->qty;
            session([
                'cart' => $cart,
                'cart_total_qty' => array_sum(array_map(fn($i)=> (int)($i['qty'] ?? 0), $cart))
            ]);
        }

        return back();
    }

    public function remove(Request $request)
    {
        $request->validate(['key' => 'required|string']);

        $cart = session('cart', []);
        unset($cart[$request->key]);

        session([
            'cart' => $cart,
            'cart_total_qty' => array_sum(array_map(fn($i)=> (int)($i['qty'] ?? 0), $cart))
        ]);

        return back();
    }

    private function firstImageUrl(Product $product): string
    {
        $path = null;

        if (!empty($product->image_path)) {
            $decoded = json_decode($product->image_path, true);
            if (is_array($decoded)) {
                $path = $decoded[0] ?? null;
            } else {
                $path = $product->image_path;
            }
        }

        return $path
            ? asset('storage/' . ltrim($path, '/'))
            : asset('images/placeholder-product.png');
    }

    /**
     * Kthen: [price, stock]
     * - stock: null nese nuk dihet
     */
    private function resolveVariantPriceAndStock(Product $product, ?string $sizeLabel): array
    {
        $basePrice = (float)$product->price;

        // nese s'ka size
        if (!$sizeLabel || empty($product->sizes)) {
            $stock = isset($product->stock) ? (int)$product->stock : null;
            return [$basePrice, $stock];
        }

        $decoded = json_decode($product->sizes, true);
        if (!is_array($decoded)) {
            $stock = isset($product->stock) ? (int)$product->stock : null;
            return [$basePrice, $stock];
        }

        foreach ($decoded as $sz) {
            $label = (string)($sz['label'] ?? '');
            if (trim(mb_strtolower($label)) === trim(mb_strtolower($sizeLabel))) {
                $p = isset($sz['price']) ? (float)$sz['price'] : $basePrice;
                $st = isset($sz['stock']) ? (int)$sz['stock'] : (isset($product->stock) ? (int)$product->stock : null);
                return [$p, $st];
            }
        }

        // nese s'gjeti size, fallback
        $stock = isset($product->stock) ? (int)$product->stock : null;
        return [$basePrice, $stock];
    }
}