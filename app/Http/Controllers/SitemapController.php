<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('is_active', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('products'))
            ->header('Content-Type', 'application/xml')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    public function products()
    {
        $products = Product::query()
            ->where('is_active', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap-products', compact('products'))
            ->header('Content-Type', 'application/xml')
            ->header('X-Content-Type-Options', 'nosniff');
    }
}
