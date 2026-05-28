@php
  $schemaProducts = collect();

  if (isset($products)) {
      if ($products instanceof \Illuminate\Contracts\Pagination\Paginator) {
          $schemaProducts = collect($products->items());
      } else {
          $schemaProducts = collect($products);
      }
  }

  $itemListElements = $schemaProducts
      ->filter(fn ($product) => !empty($product->slug) && !empty($product->name))
      ->take(12)
      ->values()
      ->map(fn ($product, $index) => [
          '@type' => 'ListItem',
          'position' => $index + 1,
          'url' => route('products.show', $product->slug),
          'name' => $product->name,
      ])
      ->values();
@endphp

@if($itemListElements->isNotEmpty())
  <script type="application/ld+json">
  {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'ItemList',
      'itemListElement' => $itemListElements->all(),
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
  </script>
@endif
