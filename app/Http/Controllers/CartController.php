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
        'width'      => 'required|numeric|min:0.1|max:50',
        'height'     => 'required|numeric|min:0.1|max:50',
        'fold_type'  => 'required|string|max:50',
    ]);

    $product = Product::findOrFail($data['product_id']);

    $foldMap = [
        'fold1'   => ['label' => 'Fold 1 (1:2)',     'ratio' => 2.0,  'extra' => 0.0],
        'fold2'   => ['label' => 'Fold 2 (1:2.5)',   'ratio' => 2.5,  'extra' => 0.0],
        'fold3'   => ['label' => 'Fold 3 (1:3)',     'ratio' => 3.0,  'extra' => 0.0],
        'grommet' => ['label' => 'Grommet',          'ratio' => 2.5,  'extra' => 1.0],
        'pencil'  => ['label' => 'Pencil Pleat',     'ratio' => 1.5,  'extra' => 0.0],
        'swave'   => ['label' => 'S-Wave',           'ratio' => 2.8,  'extra' => 2.5],
    ];

    if (!isset($foldMap[$data['fold_type']])) {
        return back()->withErrors(['fold_type' => 'Folding system i pavlefshëm']);
    }

    $width  = (float)$data['width'];
    $height = (float)$data['height'];

    $ratio  = $foldMap[$data['fold_type']]['ratio'];
    $extra  = $foldMap[$data['fold_type']]['extra'];
    $pricePerMeter = (float)$product->price;

    // METERS
    $meters = $width * $ratio;

    // TOTAL
    $unitPrice = $meters * ($pricePerMeter + $extra);
    $unitPrice = round($unitPrice, 2);

    $cart = session('cart', []);

    $key = "curtain|{$product->id}|"
        .number_format($width,2,'.','')."|"
        .number_format($height,2,'.','')."|"
        .$data['fold_type'];

    if (isset($cart[$key])) {
        $cart[$key]['qty'] += 1;
    } else {
        $cart[$key] = [
            'type'       => 'curtain',
            'product_id' => $product->id,
            'name'       => $product->name,
            'image'      => $this->productImage($product),
            'qty'        => 1,
            'price'      => $unitPrice,
            'curtain'    => [
                'width'  => $width,
                'height' => $height,
                'meters' => round($meters, 2),
                'fold_type'  => $data['fold_type'],
                'fold_label' => $foldMap[$data['fold_type']]['label'],
                'extra_per_meter' => $extra,
                'base_price_per_meter' => $pricePerMeter,
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