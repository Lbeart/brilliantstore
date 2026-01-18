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
        $totalPrice = array_reduce($cart, fn($c,$i)=>$c+($i['price']*$i['qty']), 0);
        return view('cart.index', compact('cart','totalQty','totalPrice'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'size'       => 'nullable|string|max:100',
            'price'      => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cart = session('cart', []);
        // key unike: produkt + size
        $key = $data['product_id'].'|'.($data['size'] ?? '');
        if(isset($cart[$key])){
            $cart[$key]['qty'] += $data['qty'];
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $product->image_path ? asset('storage/'.$product->image_path) : asset('images/placeholder-product.png'),
                'qty'        => $data['qty'],
                'price'      => $data['price'],
                'size'       => $data['size'] ?? null,
            ];
        }
        session(['cart' => $cart]);

        $totalQty = array_sum(array_column($cart, 'qty'));
        session(['cart_total_qty' => $totalQty]);

        // kthe JSON për update badge pa reload
        return response()->json([
            'ok' => true,
            'totalQty' => $totalQty,
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
        if(isset($cart[$request->key])){
            $cart[$request->key]['qty'] = $request->qty;
            session(['cart'=>$cart,'cart_total_qty'=>array_sum(array_column($cart,'qty'))]);
        }
        return back();
    }

    public function remove(Request $request)
    {
        $request->validate(['key'=>'required|string']);
        $cart = session('cart', []);
        unset($cart[$request->key]);
        session(['cart'=>$cart,'cart_total_qty'=>array_sum(array_column($cart,'qty'))]);
        return back();
    }
}
