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

        // 1️⃣ Normalizo fjalët bazë (gabime të vogla)
        $normalize = [
            'tepiha' => ['tepiha','tepih','tepija','tepia','tepi'],
        ];

        foreach ($normalize as $base => $variants) {
            foreach ($variants as $v) {
                if (str_contains($raw, $v)) {
                    $raw = str_replace($v, $base, $raw);
                }
            }
        }

        // 2️⃣ Ndaj search-in në fjalë
        $terms = array_filter(explode(' ', $raw));

        // 3️⃣ FILTER: të paktën NJË fjalë duhet të përputhet
        $query->where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->orWhereRaw('LOWER(name) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
            }
        });

        // 4️⃣ RENDITJE SIPAS RELEVANCËS (më shumë match = më lart)
        $score = [];

        foreach ($terms as $term) {
            $score[] = "
                (CASE 
                    WHEN LOWER(name) LIKE '%{$term}%' THEN 2
                    WHEN LOWER(description) LIKE '%{$term}%' THEN 1
                    ELSE 0
                END)
            ";
        }

        $query->orderByRaw('(' . implode(' + ', $score) . ') DESC');
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
