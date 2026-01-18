<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // =====================
    // LISTA GLOBALE
    // =====================
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    // =====================
    // SHOW PRODUCT
    // =====================
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        return view('products.show', compact('product'));
    }

    // =====================================================
    // 🔥 FUNKSION I PËRBASHKËT SEARCH (PËR KREJT KATEGORITË)
    // =====================================================
    private function categorySearch(Request $request, string $category, array $genericWords)
    {
        $raw = mb_strtolower(trim($request->query('q')));

        $query = Product::where('category', $category)
            ->where('is_active', true);

        if ($raw !== '') {

            // nda fjalët
            $words = array_filter(explode(' ', $raw));

            // hiq fjalët e përgjithshme
            $filterTerms = array_values(array_diff($words, $genericWords));

            // filtro vetëm nëse ka fjalë konkrete
            if (!empty($filterTerms)) {
                foreach ($filterTerms as $term) {
                    $query->where(function ($q) use ($term) {
                        $q->whereRaw('LOWER(name) LIKE ?', ["%{$term}%"])
                          ->orWhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
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
            'tepiha',
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
            'perde',
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
            'perde',
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
            'postava',
            ['postava','postav','çar','qar']
        );

        return view('products.postavaa', compact('products'));
    }

    // =====================
    // MBULESA
    // =====================
    public function mbulesa(Request $request)
    {
        $products = $this->categorySearch(
            $request,
            'mbulesa',
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
            'jastekdekorues',
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
            'batanije',
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
            'tepihebanjo',
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
            'posteqia',
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
            'garnishte',
            ['garnishte','garnish','kanal']
        );

        return view('products.garnishte', compact('products'));
    }
}
