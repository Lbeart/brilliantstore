<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // =====================
    // LISTA GLOBALE
    // =====================
    public function index()
    {
        $products = Product::query()
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    // =====================
    // SHOW PRODUCT
    // =====================
    public function show(Product $product)
    {
        abort_unless((int) $product->is_active === 1, 404);

        $similarQuery = Product::query()
            ->where('is_active', 1)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category);

        // ✅ nëse është perde, respekto edhe subcategory
        if (($product->category === 'perde') && !empty($product->subcategory)) {
            $similarQuery->where('subcategory', $product->subcategory);
        }

        $similarProducts = $similarQuery
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('products.show', compact('product', 'similarProducts'));
    }

    // =====================================================
    // SEARCH FUNKSION I PËRBASHKËT (PËR KREJT KATEGORITË)
    // =====================================================
    private function categorySearch(Request $request, array $where, array $genericWords)
    {
        $raw = Str::of((string) $request->query('q', ''))->trim()->lower()->value();

        $query = Product::query()
            ->where('is_active', 1);

        // ✅ where të detyrueshme (category, subcategory kur duhet)
        foreach ($where as $col => $val) {
            $query->where($col, $val);
        }

        if ($raw !== '') {
            $words = array_values(array_filter(explode(' ', $raw)));

            // normalizo fjalët e përgjithshme në lowercase
            $genericWords = array_map(fn($w) => mb_strtolower((string)$w), $genericWords);

            // hiq fjalët e përgjithshme + hiq fjalë shumë të shkurta
            $filterTerms = array_values(array_filter(
                array_diff($words, $genericWords),
                fn($t) => mb_strlen($t) >= 2
            ));

            if (!empty($filterTerms)) {
                foreach ($filterTerms as $term) {
                    $query->where(function ($q) use ($term) {
                        $q->where('name', 'like', "%{$term}%")
                          ->orWhere('description', 'like', "%{$term}%")
                          ->orWhere('sku', 'like', "%{$term}%");
                    });
                }
            }
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }

    // =====================
    // TEPIHA
    // =====================
    public function tepiha(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'tepiha'],
            ['tepiha','tepih','tepija','tepia','tepi','tepihat']
        );

        return view('products.tepiha', compact('products'));
    }

    // =====================
    // PERDE – ANËSORE
    // =====================
    public function anesore(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'perde', 'subcategory' => 'anesore'],
            ['perde','perd','anesore','curtain']
        );

        return view('products.perde_anesore', compact('products'));
    }

    // =====================
    // PERDE – DITORE
    // =====================
    public function perdeDitore(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'perde', 'subcategory' => 'ditore'],
            ['perde','perd','ditore','curtain']
        );

        return view('products.perde_ditore', compact('products'));
    }

    // =====================
    // POSTAVA
    // =====================
    public function postava(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'postava'],
            ['postava','postav','çar','qar']
        );

        // ✅ nëse view e ke "postavaa" lëre ashtu,
        // por normalisht duhet "products.postava"
        return view('products.postavaa', compact('products'));
        // return view('products.postava', compact('products'));
    }

    // =====================
    // MBULESA
    // =====================
    public function mbulesa(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'mbulesa'],
            ['mbulesa','mbules','cover','sofa']
        );

        return view('products.mbulesa', compact('products'));
    }

    // =====================
    // JASTËK DEKORUES
    // =====================
    public function jastekdekorues(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'jastekdekorues'],
            ['jastek','jastak','dekor']
        );

        return view('products.jastekdekorues', compact('products'));
    }

    // =====================
    // BATANIJE
    // =====================
    public function batanije(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'batanije'],
            ['batanije','batan','qebe']
        );

        return view('products.batanije', compact('products'));
    }

    // =====================
    // TEPIHA BANJO
    // =====================
    public function tepihebanjo(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'tepihebanjo'],
            ['banjo','bath','wc']
        );

        return view('products.tepihebanjo', compact('products'));
    }

    // =====================
    // POSTEQIA
    // =====================
    public function posteqia(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'posteqia'],
            ['posteqia','pelush','lekure']
        );

        return view('products.posteqia', compact('products'));
    }

    // =====================
    // GARNISHTE
    // =====================
    public function garnishte(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            ['category' => 'garnishte'],
            ['garnishte','garnish','kanal']
        );

        return view('products.garnishte', compact('products'));
    }
}
