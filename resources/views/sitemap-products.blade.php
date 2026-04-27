<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($products as $product)
<url>
<loc>{{ url('/products/'.$product->slug) }}</loc>
<lastmod>{{ optional($product->updated_at)->toAtomString() ?? now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.85</priority>
</url>
@endforeach
</urlset>
