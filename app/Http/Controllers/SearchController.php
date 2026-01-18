<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_strtolower(trim($request->get('q')));

        if ($q === '') {
            return back();
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
            'perde' => [
                'route' => '/anesore',
                'keywords' => [
                    'perde','perd','curtain','anesore','ditore'
                ]
            ],
        ];

        foreach ($categories as $cat) {
            foreach ($cat['keywords'] as $keyword) {

                if (str_contains($q, $keyword)) {

                    /**
                     * 👉 NËSE QUERY = VETËM FJALË KATEGORIE
                     * p.sh. "shkallore", "garnishte", "batanije"
                     */
                    if ($q === $keyword) {
                        return redirect($cat['route'].'?q='.$keyword);
                    }

                    /**
                     * 👉 NËSE KA EDHE FJALË TJERA
                     * p.sh. "shkallore otto", "garnishte plastik"
                     */
                    return redirect($cat['route'].'?q='.urlencode($q));
                }
            }
        }

        return back();
    }
}
