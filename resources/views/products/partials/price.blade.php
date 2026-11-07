@php
  $discountPrice = is_numeric($product->old_price ?? null) && (float) $product->old_price > (float) $price
    ? (float) $product->old_price : null;
  $discountPercent = $discountPrice ? (int) round((1 - ((float) $price / $discountPrice)) * 100) : null;
@endphp
<div class="sale-price-line">
  @if($discountPrice)
    <del class="sale-price-old">{{ number_format($discountPrice, 2) }} €</del>
    <span class="sale-price-divider" aria-hidden="true">/</span>
    <strong class="sale-price-current">{{ number_format((float) $price, 2) }} €</strong>
    <span class="sale-price-badge">BLACK FRIDAY · -{{ $discountPercent }}%</span>
  @else
    <strong class="sale-price-current">{{ number_format((float) $price, 2) }} €</strong>
    <span class="sale-price-badge">BLACK FRIDAY</span>
  @endif
</div>
