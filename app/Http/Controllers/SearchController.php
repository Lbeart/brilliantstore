<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    private function normalize(string $s): string
    {
        $s = mb_strtolower(trim($s), 'UTF-8');
        // normalizo ë/ç që "anësore" = "anesore"
        $s = str_replace(['ë', 'ç'], ['e', 'c'], $s);
        // hiq hapësira të dyfishta
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

        // context sipas faqes ku je
        if (str_starts_with($path, '/perde-ditore')) return 'perde-ditore';
        if (str_starts_with($path, '/anesore')) return 'anesore';
        if (str_starts_with($path, '/tepiha')) return 'tepiha';
        if (str_starts_with($path, '/mbulesa')) return 'mbulesa';
        if (str_starts_with($path, '/batanije')) return 'batanije';
        if (str_starts_with($path, '/postava')) return 'postava';
        if (str_starts_with($path, '/garnishte')) return 'garnishte';

        return null; // home ose tjera
    }

    public function index(Request $request)
    {
        $raw = (string) $request->get('q', '');
        $q = $this->normalize($raw);

        if ($q === '') return back();

        $ctx = $this->inferContextFromReferer($request);

        /**
         * ✅ PERDE: prioritet absolut (ditore/anësore)
         * kap edhe gabime shkrimi: dior/ditor
         */
        $perdeWords   = ['perde', 'perd', 'curtain'];
        $ditoreWords  = ['ditore', 'ditor', 'dior', 'diore'];
        $anesoreWords = ['anesore', 'anesor']; // "anësore" normalizohet -> "anesore"

        if ($this->containsAny($q, $ditoreWords)) {
            return redirect($this->withQ('/perde-ditore', $raw));
        }

        if ($this->containsAny($q, $anesoreWords)) {
            return redirect($this->withQ('/anesore', $raw));
        }

        if ($this->containsAny($q, $perdeWords)) {
            // nese je te perde-ditore dhe shkruan "perde", rri aty
            if ($ctx === 'perde-ditore') {
                return redirect($this->withQ('/perde-ditore', $raw));
            }
            return redirect($this->withQ('/anesore', $raw));
        }

        /**
         * ✅ KATEGORITË TJERA: nëse query ka keyword -> shko te ajo kategori
         */
        $categories = [
            [
                'route' => '/tepiha',
                'keywords' => ['tepiha','tepih','tepija','tepia','tepi','shkallore','hali','otto','rrethore','rrumbullake','round']
            ],
            [
                'route' => '/garnishte',
                'keywords' => ['garnishte','garnish','kanal','plastik','alumin','metal']
            ],
            [
                'route' => '/batanije',
                'keywords' => ['batanije','batan','qebe','rodos','zara','blanket']
            ],
            [
                'route' => '/mbulesa',
                'keywords' => ['mbulesa','mbules','stella','cover','sofa']
            ],
            [
                'route' => '/postava',
                'keywords' => ['postava','postav','car','qar','bedsheet','çar']
            ],
        ];

        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $kw) {
                if (str_contains($q, $this->normalize($kw))) {
                    return redirect($this->withQ($cat['route'], $raw));
                }
            }
        }

        /**
         * ✅ FALLBACK: nëse s’u gjet keyword, rri te faqja ku je (ctx)
         * p.sh. je te /perde-ditore dhe shkruan "white" -> rri te /perde-ditore?q=white
         */
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

            if ($ctxRoute) {
                return redirect($this->withQ($ctxRoute, $raw));
            }
        }

        return back();
    }
}