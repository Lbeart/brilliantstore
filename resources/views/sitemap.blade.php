<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<!-- HOMEPAGE -->
<url>
<loc>{{ url('/') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>daily</changefreq>
<priority>1.00</priority>
</url>

<!-- MAIN PAGES -->
<url>
<loc>{{ url('/about') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>monthly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>{{ url('/contact') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>monthly</changefreq>
<priority>0.80</priority>
</url>

<!-- CATEGORIES -->
<url>
<loc>{{ url('/products') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.90</priority>
</url>

<url>
<loc>{{ url('/tepiha') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.95</priority>
</url>

<url>
<loc>{{ url('/anesore') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.92</priority>
</url>

<url>
<loc>{{ url('/perde-ditore') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.92</priority>
</url>

<url>
<loc>{{ url('/postava') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.90</priority>
</url>

<url>
<loc>{{ url('/mbulesa') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.90</priority>
</url>

<url>
<loc>{{ url('/batanije') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.88</priority>
</url>

<url>
<loc>{{ url('/tepihebanjo') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.88</priority>
</url>

<url>
<loc>{{ url('/posteqia') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.88</priority>
</url>

<url>
<loc>{{ url('/jastekdekorues') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.88</priority>
</url>

<url>
<loc>{{ url('/garnishte') }}</loc>
<lastmod>{{ now()->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.88</priority>
</url>

<!-- 🔥 PRODUKTET AUTOMATIKE -->
@foreach($products as $product)
@if($product->slug)
<url>
<loc>{{ url('/products/'.$product->slug) }}</loc>
<lastmod>{{ optional($product->updated_at)->toAtomString() }}</lastmod>
<changefreq>weekly</changefreq>
<priority>0.85</priority>
</url>
@endif
@endforeach

</urlset>
