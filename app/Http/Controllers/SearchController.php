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

        // 👉 NËSE S’PËRPUTHET ME ASNJË KATEGORI
        return redirect()->back();
    }
}