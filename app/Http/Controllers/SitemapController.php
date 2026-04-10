<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return response()
            ->view('sitemap', compact('products'))
            ->header('Content-Type', 'application/xml')
            ->header('X-Content-Type-Options', 'nosniff');
    }
}