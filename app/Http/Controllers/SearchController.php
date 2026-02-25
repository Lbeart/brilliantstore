<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    private function normalize(string $s): string
    {
        $s = mb_strtolower(trim($s), 'UTF-8');
        $s = str_replace(['ë', 'ç'], ['e', 'c'], $s);
        $s = preg_replace('/\s+/', ' ', $s);
        return $s ?? '';
    }

    private function containsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $n) {
            $n = $this->normalize((string)$n);
            if ($n !== '' && str_contains($haystack, $n)) return true;
        }
        return false;
    }

    private function withQ(string $route, string $rawQ): string
    {
        return $route . '?' . http_build_query(['q' => $rawQ], '', '&', PHP_QUERY_RFC3986);
    }

    private function inferContextFromReferer(Request $request): ?string
    {
        $ref = $request->headers->get('referer') ?: url()->previous();
        if (!$ref) return null;

        $path = parse_url($ref, PHP_URL_PATH);
        if (!is_string($path) || $path === '') return null;

        $path = rtrim($path, '/');
        if ($path === '') $path = '/';

        if (str_starts_with($path, '/perde-ditore')) return 'perde-ditore';
        if (str_starts_with($path, '/anesore')) return 'anesore';
        if (str_starts_with($path, '/tepiha')) return 'tepiha';
        if (str_starts_with($path, '/mbulesa')) return 'mbulesa';
        if (str_starts_with($path, '/batanije')) return 'batanije';
        if (str_starts_with($path, '/postava')) return 'postava';
        if (str_starts_with($path, '/garnishte')) return 'garnishte';

        return null;
    }

    private function perdeHasMatch(string $rawQ, array $subcats): bool
    {
        $qNorm  = $this->normalize($rawQ);
        $tokens = array_values(array_filter(explode(' ', $qNorm)));

        return Product::query()
            ->where('is_active', 1)
            ->where('category', 'perde')
            ->whereIn('subcategory', $subcats)
            ->where(function ($qq) use ($rawQ, $tokens) {
                // match komplet
                $qq->where('name', 'like', "%{$rawQ}%")
                   ->orWhere('description', 'like', "%{$rawQ}%");

                // match edhe për fjalë (p.sh. "perde kumash" -> "kumash")
                foreach ($tokens as $t) {
                    $qq->orWhere('name', 'like', "%{$t}%")
                       ->orWhere('description', 'like', "%{$t}%");
                }
            })
            ->limit(1)
            ->exists();
    }

    public function index(Request $request)
    {
        $raw = (string) $request->get('q', '');
        $q   = $this->normalize($raw);

        if ($q === '') return back();

        $ctx = $this->inferContextFromReferer($request);

        // ================== PERDE LOGIC ==================
        $perdeWords   = ['perde', 'perd', 'curtain'];
        $ditoreWords  = ['ditore', 'ditor', 'dior', 'diore'];     // gabime shkrimi
        $anesoreWords = ['anesore', 'anesor'];                    // "anësore" normalizohet -> "anesore"

        // subcategory values të mundshme në DB (mbulo të dyja formatet)
        $ditoreSubs  = ['ditore', 'perde-ditore', 'perde ditore', 'dior', 'ditor'];
        $anesoreSubs = ['anesore', 'perde-anesore', 'perde anesore', 'anësore'];

        // 1) Nëse e specifikon qartë (ditore/anësore) -> direkt
        if ($this->containsAny($q, $ditoreWords)) {
            return redirect($this->withQ('/perde-ditore', $raw));
        }
        if ($this->containsAny($q, $anesoreWords)) {
            return redirect($this->withQ('/anesore', $raw));
        }

        // 2) Nëse shkruan "perde ..." pa nënkategori -> vendos me DB (KJO TA ZGJIDH "perde kumash")
        if ($this->containsAny($q, $perdeWords)) {
            $hasDitore  = $this->perdeHasMatch($raw, $ditoreSubs);
            $hasAnesore = $this->perdeHasMatch($raw, $anesoreSubs);

            // nëse vetëm njëra ka rezultate -> shko aty
            if ($hasDitore && !$hasAnesore) {
                return redirect($this->withQ('/perde-ditore', $raw));
            }
            if ($hasAnesore && !$hasDitore) {
                return redirect($this->withQ('/anesore', $raw));
            }

            // nëse të dyja kanë -> rri ku je (ctx) si tie-breaker
            if ($hasDitore && $hasAnesore) {
                if ($ctx === 'perde-ditore') return redirect($this->withQ('/perde-ditore', $raw));
                if ($ctx === 'anesore')      return redirect($this->withQ('/anesore', $raw));
                return redirect($this->withQ('/anesore', $raw)); // default
            }

            // nëse asnjëra s’ka -> rri ku je ose default
            if ($ctx === 'perde-ditore') return redirect($this->withQ('/perde-ditore', $raw));
            if ($ctx === 'anesore')      return redirect($this->withQ('/anesore', $raw));
            return redirect($this->withQ('/anesore', $raw));
        }

        // ================== CATEGORIES (tjera) ==================
        $categories = [
            ['route' => '/tepiha',    'keywords' => ['tepiha','tepih','tepija','tepia','tepi','shkallore','hali','otto','rrethore','rrumbullake','round']],
            ['route' => '/garnishte', 'keywords' => ['garnishte','garnish','kanal','plastik','alumin','metal']],
            ['route' => '/batanije',  'keywords' => ['batanije','batan','qebe','rodos','zara','blanket']],
            ['route' => '/mbulesa',   'keywords' => ['mbulesa','mbules','stella','cover','sofa']],
            ['route' => '/postava',   'keywords' => ['postava','postav','car','qar','bedsheet','çar']],
        ];

        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $kw) {
                if (str_contains($q, $this->normalize($kw))) {
                    return redirect($this->withQ($cat['route'], $raw));
                }
            }
        }

        // fallback: rri ku je (nëse je në ndonjë kategori)
        if ($ctx) {
            $ctxRoute = match ($ctx) {
                'perde-ditore' => '/perde-ditore',
                'anesore'      => '/anesore',
                'tepiha'       => '/tepiha',
                'mbulesa'      => '/mbulesa',
                'batanije'     => '/batanije',
                'postava'      => '/postava',
                'garnishte'    => '/garnishte',
                default        => null,
            };

            if ($ctxRoute) return redirect($this->withQ($ctxRoute, $raw));
        }

        return back();
    }
}