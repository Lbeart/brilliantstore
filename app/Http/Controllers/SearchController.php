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

    private function withQ(string $route, string $rawQ): string
    {
        return $route . '?' . http_build_query(['q' => $rawQ], '', '&', PHP_QUERY_RFC3986);
    }

    private function inferContextFromReferer(Request $request): ?string
    {
        $ref = $request->headers->get('referer') ?: url()->previous();
        $path = $ref ? parse_url($ref, PHP_URL_PATH) : null;
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

    /**
     * ✅ Kontrollon a ka MATCH në perde + subcategory (ditore/anesore)
     * Kërkon në: name, description, sku, sizes(JSON)
     */
    private function perdeHasMatch(string $rawQ, string $subcat): bool
    {
        $qNorm = $this->normalize($rawQ);
        $tokens = array_values(array_filter(explode(' ', $qNorm)));

        // hiq fjalët “perde” (janë të përgjithshme, ta prishin match-in)
        $tokens = array_values(array_filter($tokens, fn($t) => !in_array($t, ['perde','perd','curtain'], true)));

        return Product::query()
            ->where('is_active', 1)
            ->where('category', 'perde')
            ->where('subcategory', $subcat) // ✅ vetëm 'ditore' ose 'anesore'
            ->where(function ($qq) use ($rawQ, $tokens) {
                // match komplet (nëse ekziston)
                $qq->where('name', 'like', "%{$rawQ}%")
                   ->orWhere('description', 'like', "%{$rawQ}%")
                   ->orWhere('sku', 'like', "%{$rawQ}%")
                   ->orWhere('barcode', 'like', "%{$rawQ}%")
                   ->orWhere('sizes', 'like', "%{$rawQ}%"); // JSON text search

                // match për fjalë (p.sh. "kumash")
                foreach ($tokens as $t) {
                    $qq->orWhere('name', 'like', "%{$t}%")
                       ->orWhere('description', 'like', "%{$t}%")
                       ->orWhere('sku', 'like', "%{$t}%")
                       ->orWhere('barcode', 'like', "%{$t}%")
                       ->orWhere('sizes', 'like', "%{$t}%");
                }
            })
            ->limit(1)
            ->exists();
    }

    public function index(Request $request)
    {
        $raw = (string) $request->get('q', '');
        $q = $this->normalize($raw);

        if ($q === '') return back();

        $barcodeMatch = Product::query()
            ->where('is_active', 1)
            ->where(function ($query) use ($raw) {
                $query->where('barcode', trim($raw))
                    ->orWhere('sku', trim($raw));
            })
            ->first(['id', 'slug']);

        if ($barcodeMatch) {
            return redirect()->route('products.show', $barcodeMatch);
        }

        $sizeBarcodeMatch = Product::query()
            ->where('is_active', 1)
            ->where('sizes', 'like', '%'.trim($raw).'%')
            ->get(['id', 'slug', 'sizes'])
            ->first(function ($product) use ($raw) {
                $sizes = $product->sizes;
                if (is_string($sizes)) {
                    $decoded = json_decode($sizes, true);
                    $sizes = is_array($decoded) ? $decoded : [];
                }

                if (!is_array($sizes)) {
                    return false;
                }

                foreach ($sizes as $size) {
                    if (is_array($size) && ($size['barcode'] ?? null) === trim($raw)) {
                        return true;
                    }
                }

                return false;
            });

        if ($sizeBarcodeMatch) {
            return redirect()->route('products.show', $sizeBarcodeMatch);
        }

        $ctx = $this->inferContextFromReferer($request);

        // ========= 1) PERDE LOGIC (smart) =========
        $isPerdeQuery =
            str_contains($q, 'perde') ||
            str_contains($q, 'perd') ||
            str_contains($q, 'curtain') ||
            $ctx === 'perde-ditore' ||
            $ctx === 'anesore';

        // nëse specifikon qartë “ditore” ose “anesore”
        if ($isPerdeQuery) {
            if (str_contains($q, 'ditore') || str_contains($q, 'ditor') || str_contains($q, 'dior')) {
                return redirect($this->withQ('/perde-ditore', $raw));
            }
            if (str_contains($q, 'anesore') || str_contains($q, 'anesor')) {
                return redirect($this->withQ('/anesore', $raw));
            }

            // ✅ këtu është FIX-i për "perde kumash"
            $hasDitore  = $this->perdeHasMatch($raw, 'ditore');
            $hasAnesore = $this->perdeHasMatch($raw, 'anesore');

            if ($hasDitore && !$hasAnesore) return redirect($this->withQ('/perde-ditore', $raw));
            if ($hasAnesore && !$hasDitore) return redirect($this->withQ('/anesore', $raw));

            // nëse të dyja kanë rezultate -> rri ku je (ctx)
            if ($hasDitore && $hasAnesore) {
                if ($ctx === 'perde-ditore') return redirect($this->withQ('/perde-ditore', $raw));
                if ($ctx === 'anesore')      return redirect($this->withQ('/anesore', $raw));
                return redirect($this->withQ('/perde-ditore', $raw)); // default ma logjike
            }

            // nëse asnjëra s’ka -> rri ku je ose default
            if ($ctx === 'perde-ditore') return redirect($this->withQ('/perde-ditore', $raw));
            if ($ctx === 'anesore')      return redirect($this->withQ('/anesore', $raw));
            return redirect($this->withQ('/perde-ditore', $raw));
        }

        // ========= 2) KATEGORITË TJERA =========
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
