<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    private array $pages = [
        ['path' => '/', 'changefreq' => 'daily', 'priority' => '1.00'],
        ['path' => '/products', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/tepiha', 'changefreq' => 'weekly', 'priority' => '0.95'],
        ['path' => '/perde', 'changefreq' => 'weekly', 'priority' => '0.95'],
        ['path' => '/anesore', 'changefreq' => 'weekly', 'priority' => '0.92'],
        ['path' => '/perde-ditore', 'changefreq' => 'weekly', 'priority' => '0.92'],
        ['path' => '/postava', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/mbulesa', 'changefreq' => 'weekly', 'priority' => '0.90'],
        ['path' => '/jastekdekorues', 'changefreq' => 'weekly', 'priority' => '0.91'],
        ['path' => '/batanije', 'changefreq' => 'weekly', 'priority' => '0.91'],
        ['path' => '/tepihebanjo', 'changefreq' => 'weekly', 'priority' => '0.91'],
        ['path' => '/posteqia', 'changefreq' => 'weekly', 'priority' => '0.92'],
        ['path' => '/garnishte', 'changefreq' => 'weekly', 'priority' => '0.88'],
        ['path' => '/about', 'changefreq' => 'monthly', 'priority' => '0.80'],
        ['path' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.80'],
        ['path' => '/terms', 'changefreq' => 'yearly', 'priority' => '0.50'],
        ['path' => '/privacy', 'changefreq' => 'yearly', 'priority' => '0.50'],
    ];

    private array $localizedPaths = [
        '/', '/tepiha', '/perde', '/anesore', '/perde-ditore', '/postava', '/mbulesa',
        '/jastekdekorues', '/batanije', '/tepihebanjo', '/posteqia', '/garnishte',
    ];

    private function fillMissingProductSlugs(): void
    {
        try {
            Product::query()
                ->where(function ($query) {
                    $query->whereNull('slug')->orWhere('slug', '');
                })
                ->whereNotNull('name')
                ->chunkById(50, function ($products) {
                    foreach ($products as $product) {
                        $product->slug = Product::generateSlug($product->name);
                        $product->saveQuietly();
                    }
                });
        } catch (\Throwable $exception) {
            Log::error('SitemapController could not fill missing product slugs', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }

    private function loadProducts(): Collection
    {
        try {
            $products = Product::query()
                ->where('is_active', 1)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->latest('updated_at')
                ->get(['slug', 'updated_at']);

            Log::info('SitemapController loaded products', ['count' => $products->count()]);

            return $products;
        } catch (\Throwable $exception) {
            Log::error('SitemapController failed to load products', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return collect();
        }
    }

    private function sitemapResponse(array $urls)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . PHP_EOL;

        foreach ($urls as $url) {
            $content .= '  <url>' . PHP_EOL;
            $content .= '    <loc>' . $this->xml($url['loc']) . '</loc>' . PHP_EOL;
            $content .= '    <lastmod>' . $this->xml($url['lastmod']) . '</lastmod>' . PHP_EOL;
            $content .= '    <changefreq>' . $this->xml($url['changefreq']) . '</changefreq>' . PHP_EOL;
            $content .= '    <priority>' . $this->xml($url['priority']) . '</priority>' . PHP_EOL;
            foreach ($url['alternates'] ?? [] as $language => $href) {
                $content .= '    <xhtml:link rel="alternate" hreflang="'.$this->xml($language).'" href="'.$this->xml($href).'" />' . PHP_EOL;
            }
            $content .= '  </url>' . PHP_EOL;
        }

        $content .= '</urlset>' . PHP_EOL;

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    private function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }

    private function localizedProductUrls(Collection $products): Collection
    {
        return $products->flatMap(function (Product $product) {
            $base = url('/products/'.$product->slug);
            $alternates = [
                'sq' => $base,
                'en' => $base.'?lang=en',
                'sr' => $base.'?lang=sr',
                'x-default' => $base,
            ];

            return collect(['sq', 'en', 'sr'])->map(fn (string $locale) => [
                'loc' => $locale === 'sq' ? $base : $base.'?lang='.$locale,
                'lastmod' => optional($product->updated_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.85',
                'alternates' => $alternates,
            ]);
        });
    }

    public function index()
    {
        $this->fillMissingProductSlugs();

        $products = $this->loadProducts();
        $latestProductUpdate = optional($products->max('updated_at'))->toAtomString() ?? now()->toAtomString();

        Log::info('SitemapController index', ['products_count' => $products->count()]);

        $urls = collect($this->pages)->flatMap(function (array $page) use ($latestProductUpdate) {
            $base = url($page['path']);
            $localized = in_array($page['path'], $this->localizedPaths, true);
            $alternates = $localized ? [
                'sq' => $base,
                'en' => $base.'?lang=en',
                'sr' => $base.'?lang=sr',
                'x-default' => $base,
            ] : [];
            $locales = $localized ? ['sq', 'en', 'sr'] : ['sq'];

            return collect($locales)->map(fn (string $locale) => [
                'loc' => $locale === 'sq' ? $base : $base.'?lang='.$locale,
                'lastmod' => $latestProductUpdate,
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
                'alternates' => $alternates,
            ]);
        });

        $productUrls = $this->localizedProductUrls($products);

        return $this->sitemapResponse($urls->concat($productUrls)->values()->all());
    }

    public function products()
    {
        $this->fillMissingProductSlugs();

        $products = $this->loadProducts();

        $urls = $this->localizedProductUrls($products);

        return $this->sitemapResponse($urls->values()->all());
    }
}
