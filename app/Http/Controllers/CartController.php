<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);
        $totalQty = array_sum(array_column($cart, 'qty'));
        $totalPrice = array_reduce($cart, fn($c,$i) => $c + ((float)$i['price'] * (int)$i['qty']), 0.0);

        return view('cart.index', compact('cart','totalQty','totalPrice'));
    }

    // ✅ PRODUKT NORMAL (tepiha, postava, etj)
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'size'       => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($data['product_id']);

        // ✅ Mos e merr price prej request-it (security)
        $unitPrice = (float) $product->price;
        $sizeLabel = $data['size'] ?? null;

        if ($sizeLabel) {
            $sizes = json_decode($product->sizes ?? '[]', true);
            if (is_array($sizes)) {
                foreach ($sizes as $s) {
                    if ((string)($s['label'] ?? '') === (string)$sizeLabel) {
                        if (isset($s['price'])) $unitPrice = (float)$s['price'];
                        break;
                    }
                }
            }
        }

        $cart = session('cart', []);
        $key = 'product|'.$product->id.'|'.($sizeLabel ?? '');

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += (int)$data['qty'];
        } else {
            $cart[$key] = [
                'type'       => 'product',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->productImage($product),
                'qty'        => (int)$data['qty'],
                'price'      => round($unitPrice, 2),
                'size'       => $sizeLabel,
            ];
        }

        $this->storeCart($cart);

        return response()->json([
            'ok' => true,
            'totalQty' => session('cart_total_qty', 0),
            'message' => 'U shtua në shportë',
        ]);
    }

    // ✅ PERDE (width + height + folding system me extra)
    public function addCurtain(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1|max:100',
            'width'      => 'required|numeric|min:0.1|max:50',
            'height'     => 'required|numeric|min:0.1|max:50',
            'fold_type'  => 'required|string|max:50',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $foldMap = [
            'classic1' => ['label' => 'Classic Folds 1', 'extra' => 0.0],
            'classic2' => ['label' => 'Classic Folds 2', 'extra' => 0.0],
            'classic3' => ['label' => 'Classic Folds 3', 'extra' => 0.0],
            'grommet'  => ['label' => 'Grommet',        'extra' => 1.5],
            'pencil'   => ['label' => 'Pencil Pleat',   'extra' => 1.0],
            'swave'    => ['label' => 'S-Wave',         'extra' => 2.0],
            'triple'   => ['label' => 'Triple Pleat',   'extra' => 3.0],
        ];

        if (!isset($foldMap[$data['fold_type']])) {
            return response()->json(['ok'=>false,'message'=>'Folding System i pavlefshëm'], 422);
        }

        $width  = (float)$data['width'];
        $height = (float)$data['height'];
        $qty    = (int)$data['qty'];

        // ✅ logjika jote + e përmirësuar:
        // meters = width * 2 (fold standard)
        // total = meters * (pricePerMeter + extra) * height
        $multiplier = 2.0;
        $meters = $width * $multiplier;
        $extra = (float)$foldMap[$data['fold_type']]['extra'];
        $pricePerMeter = (float)$product->price;

        $unitPrice = $meters * ($pricePerMeter + $extra) * $height;
        $unitPrice = round($unitPrice, 2);

        $cart = session('cart', []);

        $key = "curtain|{$product->id}|"
            .number_format($width,2,'.','')."|"
            .number_format($height,2,'.','')."|"
            .$data['fold_type'];

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'type'       => 'curtain',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->productImage($product),
                'qty'        => $qty,
                'price'      => $unitPrice, // ✅ çmimi për 1 set (qty e shumëzon)
                'curtain'    => [
                    'width'  => $width,
                    'height' => $height,
                    'meters' => round($meters, 2),
                    'multiplier' => $multiplier,
                    'fold_type'  => $data['fold_type'],
                    'fold_label' => $foldMap[$data['fold_type']]['label'],
                    'extra_per_meter' => $extra,
                    'base_price_per_meter' => $pricePerMeter,
                ],
            ];
        }

        $this->storeCart($cart);

        return response()->json([
            'ok' => true,
            'totalQty' => session('cart_total_qty', 0),
            'message' => 'U shtua në shportë',
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
            $this->storeCart($cart);
        }
        return back();
    }

    public function remove(Request $request)
    {
        $request->validate(['key'=>'required|string']);

        $cart = session('cart', []);
        unset($cart[$request->key]);
        $this->storeCart($cart);

        return back();
    }

    // =========================
    // Helpers
    // =========================
    private function storeCart(array $cart): void
    {
        session(['cart' => $cart]);
        session(['cart_total_qty' => array_sum(array_column($cart, 'qty'))]);
    }

    private function productImage(Product $product): string
    {
        $imgs = [];
        if (!empty($product->image_path)) {
            $d = json_decode($product->image_path, true);
            $imgs = is_array($d) ? $d : [$product->image_path];
        }
        $main = $imgs[0] ?? null;

        return $main
            ? asset('storage/'.$main)
            : asset('images/placeholder-product.png');
    }
}