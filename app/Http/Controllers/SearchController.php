<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    private function normalize(string $s): string
    {
        $s = mb_strtolower(trim($s), 'UTF-8');

        // normalizo ë/ç (që "anësore" dhe "anesore" me qenë njësoj)
        $s = str_replace(['ë', 'ç'], ['e', 'c'], $s);

        // hiq hapësira të dyfishta
        $s = preg_replace('/\s+/', ' ', $s);

        return $s ?? '';
    }

    private function containsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $n) {
            if ($n !== '' && str_contains($haystack, $n)) return true;
        }
        return false;
    }

    public function index(Request $request)
    {
        $raw = (string) $request->get('q', '');
        $q = $this->normalize($raw);

        if ($q === '') return back();

        // ✅ PERDE: kap edhe gabime shkrimi si "dior"
        $perdeWords  = ['perde', 'perd', 'curtain'];
        $ditoreWords = ['ditore', 'ditor', 'dior', 'diore'];     // shto këtu çka don
        $anesoreWords = ['anesore', 'anesor', 'anësore'];        // "anësore" normalizohet në "anesore"

        if ($this->containsAny($q, $perdeWords)) {
            if ($this->containsAny($q, $ditoreWords)) {
                return redirect('/perde-ditore?q=' . urlencode($raw));
            }

            if ($this->containsAny($q, $anesoreWords)) {
                return redirect('/anesore?q=' . urlencode($raw));
            }

            // default për perde
            return redirect('/anesore?q=' . urlencode($raw));
        }

        // ✅ kategoritë tjera
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
                'keywords' => ['postava','postav','car','qar','bedsheet','çar'] // "çar" e normalizon në "car"
            ],
        ];

        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $keyword) {
                if (str_contains($q, $this->normalize($keyword))) {
                    return redirect($cat['route'] . '?q=' . urlencode($raw));
                }
            }
        }

        return back();
    }
}