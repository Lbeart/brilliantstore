<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($pages as $page)
<url>
<loc>{{ url($page['path']) }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>{{ $page['changefreq'] }}</changefreq>
<priority>{{ $page['priority'] }}</priority>
</url>
@endforeach
<!-- Products count: {{ $products->count() }} -->
@foreach($products as $product)
<url>
<loc>{{ route('products.show', $product) }}</loc>
<lastmod>{{ optional($product->updated_at)->toAtomString() ?? now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.85</priority>
</url>
@endforeach
</urlset>
