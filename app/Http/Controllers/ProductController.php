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
    $q = mb_strtolower(trim($request->query('q')));

    // 👉 Fjalë kyçe të pranuara (PROFESIONAL)
    $keywords = [
        'shkallore' => ['shkallore', 'shkalore', 'shkall'],
        'rrethore'  => ['rrethore', 'rrumbullake', 'rreth'],
        'tepiha'    => ['tepiha', 'tepih', 'tepia', 'tepija', 'tepi'],
    ];

    $query = Product::query()
        ->where('category', 'tepiha')
        ->where('is_active', true);

    // 🔍 FILTER I PASTËR SEARCH
    if ($q !== '') {
        $query->where(function ($sub) use ($q, $keywords) {

            // match direkt
            $sub->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$q}%"]);

            // match me keywords (profesional)
            foreach ($keywords as $group) {
                foreach ($group as $word) {
                    if (str_contains($q, $word)) {
                        $sub->orWhereRaw('LOWER(name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(description) LIKE ?', ["%{$word}%"]);
                    }
                }
            }
        });
    }

    // ⭐ PRIORITET I PASTËR (JO HACK)
    $priorityCases = [];

    if (str_contains($q, 'shkall')) {
        $priorityCases[] = "WHEN LOWER(name) LIKE '%shkall%' THEN 0";
    }

    if (str_contains($q, 'rreth')) {
        $priorityCases[] = "WHEN LOWER(name) LIKE '%rreth%' OR LOWER(name) LIKE '%rrumbull%' THEN 0";
    }

    if (!empty($priorityCases)) {
        $query->orderByRaw("
            CASE
                " . implode("\n", $priorityCases) . "
                ELSE 1
            END
        ");
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
