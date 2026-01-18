<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_strtolower(trim($request->get('q')));

        if (!$q) {
            return back();
        }

        // ===============================
        // MAP: kategori → route
        // ===============================
        $categories = [
            'tepiha' => [
                'route' => '/tepiha',
                'keywords' => [
                    'tepiha','tepih','tepija','tepia','tepi',
                    'hali','otto','shkall','rreth','rrumb','round'
                ]
            ],
            'garnishte' => [
                'route' => '/garnishte',
                'keywords' => [
                    'garnish','kanal','plastik','alumin','metal'
                ]
            ],
            'batanije' => [
                'route' => '/batanije',
                'keywords' => [
                    'batan','qebe','rodos','zara','blanket'
                ]
            ],
            'mbulesa' => [
                'route' => '/mbulesa',
                'keywords' => [
                    'mbules','cover','stella','sofa'
                ]
            ],
            'postava' => [
                'route' => '/postava',
                'keywords' => [
                    'postav','çar','qar','bedsheet'
                ]
            ],
            'perde' => [
                'route' => '/anesore',
                'keywords' => [
                    'perd','curtain','anesore','ditore'
                ]
            ],
        ];

        // ===============================
        // GJET KATEGORINË
        // ===============================
        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $word) {
                if (str_contains($q, $word)) {

                    // hiq fjalët e kategorisë nga query
                    $clean = trim(str_replace($word, '', $q));

                    // nëse s’ka mbet asgjë → vetëm kategori
                    if ($clean === '') {
                        return redirect($cat['route']);
                    }

                    // përndryshe → filtro
                    return redirect($cat['route'].'?q='.urlencode($clean));
                }
            }
        }

        return back();
    }
}
