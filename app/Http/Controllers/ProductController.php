<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Të gjitha produktet aktive
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    // Detajet e produktit
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        return view('products.show', compact('product'));
    }

    // =====================
    // TEPIHA (FIX SHKALLORE)
    // =====================
  public function tepiha(Request $request)
{
    $focus = $request->query('focus');
    $q     = trim(strtolower($request->query('q')));

    $query = Product::where('category', 'tepiha')
        ->where('is_active', true);

    // 🔎 SEARCH brenda produkteve
    if ($q) {
        $query->where(function ($sub) use ($q) {
            $sub->where('name', 'LIKE', "%{$q}%")
                ->orWhere('description', 'LIKE', "%{$q}%");
        });
    }

    // ⭐ PRIORITET NGA SEARCH I MENYSË
    if ($focus === 'shkallore') {
        $query->orderByRaw("
            CASE
                WHEN name LIKE '%shkallore%' OR description LIKE '%shkallore%'
                THEN 0 ELSE 1
            END
        ");
    }

    if ($focus === 'rrethore') {
        $query->orderByRaw("
            CASE
                WHEN name LIKE '%rrethore%'
                  OR name LIKE '%rrumbullake%'
                  OR description LIKE '%rrethore%'
                  OR description LIKE '%rrumbullake%'
                THEN 0 ELSE 1
            END
        ");
    }

    $products = $query
        ->orderByDesc('id')
        ->paginate(12)
        ->withQueryString(); // 🔥 ruan q & focus

    return view('products.tepiha', compact('products', 'q'));
}

    // PERDE – ANËSORE
    public function anesore()
    {
        $products = Product::where('category', 'perde')
            ->where('subcategory', 'anesore')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.perde_anesore', compact('products'));
    }

    // PERDE – DITORE
    public function perdeDitore()
    {
        $products = Product::where('category', 'perde')
            ->where('subcategory', 'ditore')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.perde_ditore', compact('products'));
    }

    public function postava()
    {
        $products = Product::where('category', 'postava')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.postavaa', compact('products'));
    }

    public function mbulesa()
    {
        $products = Product::where('category', 'mbulesa')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.mbulesa', compact('products'));
    }

    public function jastekdekorues()
    {
        $products = Product::where('category', 'jastekdekorues')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.jastekdekorues', compact('products'));
    }

    public function batanije()
    {
        $products = Product::where('category', 'batanije')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.batanije', compact('products'));
    }

    public function tepihebanjo()
    {
        $products = Product::where('category', 'tepihebanjo')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.tepihebanjo', compact('products'));
    }

    public function posteqia()
    {
        $products = Product::where('category', 'posteqia')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.posteqia', compact('products'));
    }

    public function garnishte()
    {
        $products = Product::where('category', 'garnishte')
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.garnishte', compact('products'));
    }
}
