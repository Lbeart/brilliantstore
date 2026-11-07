@php
  $discountPrice = is_numeric($product->old_price ?? null) && (float) $product->old_price > (float) $price
    ? (float) $product->old_price : null;
  $discountPercent = $discountPrice ? (int) round((1 - ((float) $price / $discountPrice)) * 100) : null;
@endphp
<div class="sale-price-line">
  <strong class="sale-price-current">{{ number_format((float) $price, 2) }} €</strong>
  @if($discountPrice)
    <del class="sale-price-old">{{ number_format($discountPrice, 2) }} €</del>
    <span class="sale-price-badge">BLACK FRIDAY · -{{ $discountPercent }}%</span>
  @endif
</div>
