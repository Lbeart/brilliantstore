<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

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

    private function loadProducts(): Collection
    {
        try {
            return Product::query()
                ->where('is_active', 1)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->latest('updated_at')
                ->get(['slug', 'updated_at']);
        } catch (\Throwable $exception) {
            Log::error('SitemapController failed to load products', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return collect();
        }
    }

    public function index()
    {
        $pages = $this->pages;
        $products = $this->loadProducts();

        try {
            return response()
                ->view('sitemap', compact('pages', 'products'))
                ->header('Content-Type', 'application/xml')
                ->header('X-Content-Type-Options', 'nosniff');
        } catch (\Throwable $exception) {
            Log::error('SitemapController failed to render sitemap view', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            $content = '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';
            foreach ($pages as $page) {
                $content .= "<url><loc>" . url($page['path']) . "</loc><lastmod>" . now()->toAtomString() . "</lastmod><changefreq>" . $page['changefreq'] . "</changefreq><priority>" . $page['priority'] . "</priority></url>\n";
            }
            $content .= '</urlset>';

            return response($content, 200)
                ->header('Content-Type', 'application/xml')
                ->header('X-Content-Type-Options', 'nosniff');
        }
    }

    public function products()
    {
        $products = $this->loadProducts();

        try {
            return response()
                ->view('sitemap-products', compact('products'))
                ->header('Content-Type', 'application/xml')
                ->header('X-Content-Type-Options', 'nosniff');
        } catch (\Throwable $exception) {
            Log::error('SitemapController failed to render sitemap-products view', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            $content = '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';
            foreach ($products as $product) {
                $content .= "<url><loc>" . url('/products/'.$product->slug) . "</loc><lastmod>" . (optional($product->updated_at)->toAtomString() ?? now()->toAtomString()) . "</lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>\n";
            }
            $content .= '</urlset>';

            return response($content, 200)
                ->header('Content-Type', 'application/xml')
                ->header('X-Content-Type-Options', 'nosniff');
        }
    }
}
