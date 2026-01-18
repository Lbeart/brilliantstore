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

        /*
        |--------------------------------------------------------------------------
        | TEPIHA – SUBTYPES (DUHET PARA TEPIHA GENERIKE)
        |--------------------------------------------------------------------------
        */

        // SHKALLORE
        if (
            str_contains($q, 'shkall') ||
            str_contains($q, 'shkal') ||
            str_contains($q, 'stairs')
        ) {
            return redirect('/tepiha?focus=shkallore&q='.$q);
        }

        // RRETHORE / RRUMBULLAKE
        if (
            str_contains($q, 'rreth') ||
            str_contains($q, 'rrumb') ||
            str_contains($q, 'round')
        ) {
            return redirect('/tepiha?focus=rrethore&q='.$q);
        }

        // HALI
        if (str_contains($q, 'hali')) {
            return redirect('/tepiha?focus=hali&q='.$q);
        }

        // OTTO
        if (str_contains($q, 'otto')) {
            return redirect('/tepiha?focus=otto&q='.$q);
        }

        /*
        |--------------------------------------------------------------------------
        | TEPIHA – GENERIKE (KREJT TEPHIAT)
        |--------------------------------------------------------------------------
        */
        if (
            str_contains($q, 'tepi') ||
            str_contains($q, 'tepih') ||
            str_contains($q, 'tepija') ||
            str_contains($q, 'carpet') ||
            str_contains($q, 'rug')
        ) {
            return redirect('/tepiha?q='.$q);
        }

        /*
        |--------------------------------------------------------------------------
        | KATEGORI TË TJERA
        |--------------------------------------------------------------------------
        */

        // PERDE
        if (
            str_contains($q, 'perd') ||
            str_contains($q, 'curtain')
        ) {
            return redirect('/anesore?q='.$q);
        }

        // GARNISHTE
        if (str_contains($q, 'garnish')) {
            return redirect('/garnishte?q='.$q);
        }

        // BATANIJE / QEBE
        if (
            str_contains($q, 'batan') ||
            str_contains($q, 'qebe')
        ) {
            return redirect('/batanije?q='.$q);
        }

        // POSTAVA / ÇARÇAFË
        if (
            str_contains($q, 'postav') ||
            str_contains($q, 'çar') ||
            str_contains($q, 'qar')
        ) {
            return redirect('/postava?q='.$q);
        }

        // MBULESA
        if (
            str_contains($q, 'mbul') ||
            str_contains($q, 'cover')
        ) {
            return redirect('/mbulesa?q='.$q);
        }

        return back();
    }
}
