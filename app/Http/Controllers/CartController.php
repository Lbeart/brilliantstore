<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Support\ProductImages;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);
        $productIds = collect($cart)->pluck('product_id')->filter()->unique()->values();
        $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as &$item) {
            $product = $products->get($item['product_id'] ?? null);
            if ($product) {
                $item['image'] = $this->productImageForColor($product, $item['color'] ?? null);
            }
        }
        unset($item);

        $this->storeCart($cart);
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
            'color'      => 'nullable|string|max:80',
            'cover_mode'   => 'nullable|in:meter,set',
            'cover_option' => 'nullable|string|max:100',
            'cover_value'  => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($data['product_id']);

        // ✅ Mos e merr price prej request-it (security)
        $unitPrice = (float) $product->price;
        $sizeLabel = $data['size'] ?? null;
        $colorLabel = $this->selectedColorLabel($product, $data['color'] ?? null);

        if (($product->category ?? '') === 'mbulesa' && !empty($data['cover_mode']) && !empty($data['cover_option'])) {
            $cover = $this->calculateCoverPrice(
                $product,
                (string) $data['cover_mode'],
                (string) $data['cover_option'],
                (string) ($data['cover_value'] ?? '')
            );

            if (!$cover) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Llogaritja e mbuleses nuk eshte valide.',
                ], 422);
            }

            $unitPrice = $cover['price'];
            $sizeLabel = $cover['label'];
        } elseif ($sizeLabel) {
            foreach ($this->productSizes($product) as $s) {
                if ((string)($s['label'] ?? '') === (string)$sizeLabel) {
                    if (isset($s['price'])) $unitPrice = (float)$s['price'];
                    break;
                }
            }
        }

        $cart = session('cart', []);
        $key = 'product|'.$product->id.'|'.($sizeLabel ?? '').'|'.($colorLabel ?? '');

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += (int)$data['qty'];
        } else {
            $cart[$key] = [
                'type'       => 'product',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->productImageForColor($product, $colorLabel),
                'qty'        => (int)$data['qty'],
                'price'      => round($unitPrice, 2),
                'size'       => $sizeLabel,
                'color'      => $colorLabel,
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
            'width'      => 'required|numeric|min:0.1|max:50',
            'height'     => 'required|numeric|min:0.1|max:50',
            'fold_type'  => 'required|string|max:50',
            'color'      => 'nullable|string|max:80',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $colorLabel = $this->selectedColorLabel($product, $data['color'] ?? null);

        $foldMap = [
            'fold1'   => ['label' => 'Fold 1 (1:2)',     'ratio' => 2.0,  'extra' => 0.0],
            'fold2'   => ['label' => 'Fold 2 (1:2.5)',   'ratio' => 2.5,  'extra' => 0.0],
            'fold3'   => ['label' => 'Fold 3 (1:3)',     'ratio' => 3.0,  'extra' => 0.0],

            // ✅ GROMMET: si në JS (rings per meter + ring price)
            'grommet' => [
                'label'      => 'Grommet',
                'ratio'      => 2.5,
                'extra'      => 0.0,
                'rings'      => 5,   // rings per meter (si data-rings)
                'ring_price' => 1,   // price per ring
            ],

            'pencil'  => ['label' => 'Pencil Pleat',     'ratio' => 1.5,  'extra' => 0.0],
            'swave'   => ['label' => 'S-Wave',           'ratio' => 2.8,  'extra' => 2.5],
        ];

        if (!isset($foldMap[$data['fold_type']])) {
            return back()->withErrors(['fold_type' => 'Folding system i pavlefshëm']);
        }

        $width  = (float)$data['width'];
        $height = (float)$data['height'];

        $ratio  = (float)$foldMap[$data['fold_type']]['ratio'];
        $extra  = (float)$foldMap[$data['fold_type']]['extra'];
        $pricePerMeter = (float)$product->price;

        // METERS (si në JS)
        $meters = $width * $ratio;

        // TOTAL bazë (si e ke ti)
        $unitPrice = $meters * ($pricePerMeter + $extra);

        // ✅ SHTESA VETËM PËR GROMMET (unaza) – pa prish tjera llogaritje
        $rings = 0;
        $ringsTotal = 0.0;

        if ($data['fold_type'] === 'grommet') {
            $ringsPerMeter = (float)($foldMap['grommet']['rings'] ?? 0);
            $ringPrice     = (float)($foldMap['grommet']['ring_price'] ?? 0);

            $rings = (int) ceil($meters * $ringsPerMeter);
            $ringsTotal = $rings * $ringPrice;

            $unitPrice += $ringsTotal;
        }

        $unitPrice = round($unitPrice, 2);

        $cart = session('cart', []);

        $key = "curtain|{$product->id}|"
            .number_format($width,2,'.','')."|"
            .number_format($height,2,'.','')."|"
            .$data['fold_type']."|"
            .($colorLabel ?? '');

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += 1;
        } else {
            $cart[$key] = [
                'type'       => 'curtain',
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $this->productImageForColor($product, $colorLabel),
                'qty'        => 1,
                'price'      => $unitPrice,
                'color'      => $colorLabel,
                'curtain'    => [
                    'width'  => $width,
                    'height' => $height,
                    'meters' => round($meters, 2),
                    'fold_type'  => $data['fold_type'],
                    'fold_label' => $foldMap[$data['fold_type']]['label'],
                    'extra_per_meter' => $extra,
                    'base_price_per_meter' => $pricePerMeter,

                    // ✅ vetëm informuese (për shfaqje në shportë)
                    'rings' => $rings,
                    'ring_price' => (float)($foldMap[$data['fold_type']]['ring_price'] ?? 0),
                    'rings_total' => round($ringsTotal, 2),
                ],
            ];
        }

        $this->storeCart($cart);

        return redirect()->back()->with('success', 'Perde u shtua në shportë!');
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

    public function clear()
    {
        session()->forget(['cart', 'cart_total_qty']);

        return back()->with('success', 'Shporta u zbraz me sukses.');
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
        return ProductImages::url($product->image_path, asset('images/placeholder-product.png'), $product);
    }

    private function productImageForColor(Product $product, ?string $colorLabel): string
    {
        $variant = $this->findColorVariant($product, $colorLabel);
        $variantImages = $variant ? ProductImages::decode($variant['image_paths'] ?? ($variant['image_path'] ?? null)) : [];
        $imagePath = $variantImages[0] ?? null;

        if (!empty($imagePath)) {
            return ProductImages::url($imagePath, asset('images/placeholder-product.png'), $product);
        }

        return $this->productImage($product);
    }

    private function selectedColorLabel(Product $product, ?string $color): ?string
    {
        $color = trim((string) $color);
        if ($color === '') {
            return null;
        }

        $variant = $this->findColorVariant($product, $color);

        return $variant ? trim((string) ($variant['name'] ?? '')) : null;
    }

    private function findColorVariant(Product $product, ?string $color): ?array
    {
        $color = trim((string) $color);
        if ($color === '') {
            return null;
        }

        foreach ($this->productColorVariants($product) as $variant) {
            $name = trim((string) ($variant['name'] ?? ''));
            if ($name !== '' && ($name === $color || strtolower($name) === strtolower($color))) {
                return $variant;
            }
        }

        return null;
    }

    private function productColorVariants(Product $product): array
    {
        $variants = $product->color_variants;

        if (is_array($variants)) {
            return array_values(array_filter($variants, fn ($variant) => is_array($variant)));
        }

        if (empty($variants)) {
            return [];
        }

        $decoded = json_decode((string) $variants, true);

        return is_array($decoded) ? array_values(array_filter($decoded, fn ($variant) => is_array($variant))) : [];
    }

    private function productSizes(Product $product): array
    {
        $sizes = $product->sizes;

        if (is_array($sizes)) {
            return $sizes;
        }

        if (empty($sizes)) {
            return [];
        }

        $decoded = json_decode((string) $sizes, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function calculateCoverPrice(Product $product, string $mode, string $option, string $value): ?array
    {
        $matched = null;
        foreach ($this->productSizes($product) as $size) {
            if ((string) ($size['label'] ?? '') === $option) {
                $matched = $size;
                break;
            }
        }

        if (!$matched && $mode === 'meter' && strtolower($option) === 'meter') {
            $matched = [
                'label' => 'meter',
                'price' => $product->price,
            ];
        }

        if (!$matched) {
            return null;
        }

        $basePrice = (float) ($matched['price'] ?? $product->price);
        if ($basePrice <= 0) {
            return null;
        }

        if ($mode === 'meter') {
            $meters = $this->sumMeterExpression($value);
            if ($meters < 0.1 || $meters > 100) {
                return null;
            }

            return [
                'price' => round($basePrice * $meters, 2),
                'label' => 'Me meter: '.$this->formatNumber($meters).' m',
            ];
        }

        $wantedExpression = $this->normalizeCoverExpression($value ?: $option);
        $baseExpression = $this->normalizeCoverExpression($option);
        $wantedUnits = $this->sumCoverExpression($wantedExpression);
        $baseUnits = $this->sumCoverExpression($baseExpression);

        if ($wantedUnits <= 0 || $baseUnits <= 0) {
            return null;
        }

        return [
            'price' => round(($basePrice / $baseUnits) * $wantedUnits, 2),
            'label' => 'Set: '.$wantedExpression,
        ];
    }

    private function normalizeCoverExpression(string $value): string
    {
        $expression = preg_replace('/[^0-9+]/', '', $value) ?? '';
        $expression = preg_replace('/\++/', '+', $expression) ?? '';

        return trim($expression, '+');
    }

    private function sumCoverExpression(string $expression): int
    {
        if ($expression === '') {
            return 0;
        }

        $sum = 0;
        foreach (explode('+', $expression) as $part) {
            if ($part === '') {
                return 0;
            }

            $sum += (int) $part;
        }

        return $sum;
    }

    private function sumMeterExpression(string $expression): float
    {
        $normalized = str_replace(',', '.', trim($expression));
        $normalized = preg_replace('/[^0-9.+]/', '', $normalized) ?? '';
        $normalized = preg_replace('/\++/', '+', $normalized) ?? '';
        $normalized = trim($normalized, '+');

        if ($normalized === '') {
            return 0.0;
        }

        $sum = 0.0;
        foreach (explode('+', $normalized) as $part) {
            if ($part === '') {
                return 0.0;
            }

            $value = (float) $part;
            if ($value <= 0) {
                return 0.0;
            }

            $sum += $value;
        }

        return $sum;
    }

    private function formatNumber(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
