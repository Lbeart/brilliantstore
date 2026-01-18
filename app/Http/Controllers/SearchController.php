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

        // 👉 SHKALLORE (duhet me u kap PARA tepiha)
        if (str_contains($q, 'shkallore')) {
            return redirect('/tepiha?focus=shkallore');
        }

        // 👉 TEPIHA
        if (
            str_contains($q, 'tepiha') ||
            str_contains($q, 'tepih') ||
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

        // 👉 GARNISHTE
        if (str_contains($q, 'garnishte')) {
            return redirect('/garnishte');
        }

        // 👉 BATANIJE / QEBE
        if (
            str_contains($q, 'batanije') ||
            str_contains($q, 'qebe')
        ) {
            return redirect('/batanije');
        }

        // 👉 POSTAVA / SET ÇARÇAFËSH
        if (
            str_contains($q, 'postava') ||
            str_contains($q, 'çarçaf') ||
            str_contains($q, 'qarqaf')
        ) {
            return redirect('/postava');
        }

        // 👉 MBULESA
        if (
            str_contains($q, 'mbulesa') ||
            str_contains($q, 'cover')
        ) {
            return redirect('/mbulesa');
        }

        // 👉 nëse s’përputhet me asgjë
        return redirect()->back();
    }
}
