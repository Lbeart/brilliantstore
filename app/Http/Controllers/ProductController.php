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
    $raw = mb_strtolower(trim($request->query('q')));

    $query = Product::query()
        ->where('category', 'tepiha')
        ->where('is_active', true);

    if ($raw !== '') {

        // 1️⃣ Normalizim (gabime → formë bazë)
        $map = [
            'tepiha'   => ['tepiha','tepih','tepija','tepia','tepi'],
            'rrethore' => ['rrethore','rrumbullake','rrethor','rrumbullak','rreth'],
            'shkallore'=> ['shkallore','shkalore','shkallor','shkall'],
        ];

        $normalized = [];

        foreach ($map as $base => $variants) {
            foreach ($variants as $v) {
                if (str_contains($raw, $v)) {
                    $normalized[] = $base;
                    break;
                }
            }
        }

        // nëse s’u kap asgjë, nda fjalët normalisht
        if (empty($normalized)) {
            $normalized = array_filter(explode(' ', $raw));
        }

        // 2️⃣ AND logic – çdo term duhet me ekzistu
        foreach ($normalized as $term) {
            $query->where(function ($q) use ($term) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
            });
        }
    }

    $products = $query
        ->orderByDesc('id')
        ->paginate(12)
        ->withQueryString();

    return view('products.tepiha', compact('products'));
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
