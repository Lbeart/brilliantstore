<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_strtolower(trim($request->get('q', '')));

        if ($q === '') {
            return back();
        }

        /**
         * ✅ FIX: Perde nënkategori
         * - "ditore" duhet me shku te /perde-ditore
         * - "anesore/anësore" te /anesore
         * - "perde" pa specifikim -> default /anesore
         *
         * Kjo duhet me u bo PARA loop-it, se përndryshe e kap "perde"
         * dhe kthen /anesore gjithmonë.
         */
        if (str_contains($q, 'ditore')) {
            return redirect('/perde-ditore?q=' . urlencode($q));
        }

        if (str_contains($q, 'anësore') || str_contains($q, 'anesore')) {
            return redirect('/anesore?q=' . urlencode($q));
        }

        if (str_contains($q, 'perde') || str_contains($q, 'perd') || str_contains($q, 'curtain')) {
            return redirect('/anesore?q=' . urlencode($q));
        }

        $categories = [
            'tepiha' => [
                'route' => '/tepiha',
                'keywords' => [
                    'tepiha','tepih','tepija','tepia','tepi',
                    'shkallore','hali','otto','rrethore','rrumbullake','round'
                ]
            ],
            'garnishte' => [
                'route' => '/garnishte',
                'keywords' => [
                    'garnishte','garnish','kanal','plastik','alumin','metal'
                ]
            ],
            'batanije' => [
                'route' => '/batanije',
                'keywords' => [
                    'batanije','batan','qebe','rodos','zara','blanket'
                ]
            ],
            'mbulesa' => [
                'route' => '/mbulesa',
                'keywords' => [
                    'mbulesa','mbules','stella','cover','sofa'
                ]
            ],
            'postava' => [
                'route' => '/postava',
                'keywords' => [
                    'postava','postav','çar','qar','bedsheet'
                ]
            ],
        ];

        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $keyword) {
                if (str_contains($q, $keyword)) {

                    // ✅ nëse query është vetëm keyword (p.sh "batanije")
                    if ($q === $keyword) {
                        return redirect($cat['route'] . '?q=' . urlencode($keyword));
                    }

                    // ✅ nëse ka edhe fjalë tjera (p.sh "shkallore otto")
                    return redirect($cat['route'] . '?q=' . urlencode($q));
                }
            }
        }

        return back();
    }
}