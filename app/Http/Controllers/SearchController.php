<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = strtolower(trim($request->get('q')));

        if (!$q) {
            return redirect()->back();
        }

        // 👉 TEPIHA (krejt sinonimet)
        if (
            str_contains($q, 'tepiha') ||
            str_contains($q, 'tepih') ||
            str_contains($q, 'shkallore') ||
            str_contains($q, 'carpet') ||
            str_contains($q, 'rug')
        ) {
            return redirect('/tepiha');
        }

        // 👉 PERDE
        if (
            str_contains($q, 'perde') ||
            str_contains($q, 'curtain')
        ) {
            return redirect('/anesore');
        }

        // 👉 MBULESA
        if (
            str_contains($q, 'mbulesa') ||
            str_contains($q, 'cover')
        ) {
            return redirect('/mbulesa');
        }
         if (
            str_contains($q, 'garnishte plastik') ||
            str_contains($q, 'garnishte alumin') ||
            str_contains($q, 'garnishte') ||
            str_contains($q, 'garnishte amerikane') ||
            str_contains($q, 'garnishte')
        ) {
            return redirect('/garnishte');
        }
         if (
            str_contains($q, 'batanije') ||
            str_contains($q, 'qebe') ||
            str_contains($q, 'batanije dele') ||
            str_contains($q, 'batanije per ni person') ||
            str_contains($q, 'batanije per ni person')
        ) {
            return redirect('/batanije');
        }
        if (
            str_contains($q, 'set qarqafesh') ||
            str_contains($q, 'postava') ||
            str_contains($q, 'postava per ni person') ||
            str_contains($q, 'postava per dy persona') ||
            str_contains($q, 'postava pambuk')
        ) {
            return redirect('/postava');
        }

        // 👉 NËSE S’PËRPUTHET ME ASNJË KATEGORI
        return redirect()->back();
    }
}