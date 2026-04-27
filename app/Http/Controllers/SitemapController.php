<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    private array $pages = [
        ['path' => '/', 'changefreq' => 'daily', 'priority' => '1.00'],
        ['path' => '/products', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/tepiha', 'changefreq' => 'weekly', 'priority' => '0.95'],
        ['path' => '/anesore', 'changefreq' => 'weekly', 'priority' => '0.92'],
        ['path' => '/perde-ditore', 'changefreq' => 'weekly', 'priority' => '0.92'],
        ['path' => '/postava', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/mbulesa', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/jastekdekorues', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/batanije', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/tepihebanjo', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/posteqia', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/garnishte', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/search', 'changefreq' => 'weekly', 'priority' => '0.60'],
        ['path' => '/track', 'changefreq' => 'weekly', 'priority' => '0.60'],
        ['path' => '/cart', 'changefreq' => 'monthly', 'priority' => '0.40'],
        ['path' => '/checkout', 'changefreq' => 'monthly', 'priority' => '0.40'],
        ['path' => '/about', 'changefreq' => 'monthly', 'priority' => '0.80'],
        ['path' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.80'],
        ['path' => '/terms', 'changefreq' => 'yearly', 'priority' => '0.50'],
        ['path' => '/privacy', 'changefreq' => 'yearly', 'priority' => '0.50'],
    ];

    public function index()
    {
        $pages = $this->pages;
        $products = Product::query()
            ->where('is_active', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('pages', 'products'))
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
