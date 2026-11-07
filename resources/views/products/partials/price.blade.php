@php
  $discountPrice = is_numeric($product->old_price ?? null) && (float) $product->old_price > (float) $price
    ? (float) $product->old_price : null;
  $discountPercent = $discountPrice ? (int) round((1 - ((float) $price / $discountPrice)) * 100) : null;
@endphp
<div class="sale-price-line">
  @if($discountPrice)
    <span class="sale-price-previous"><small>Prej</small><del class="sale-price-old">{{ number_format($discountPrice, 2) }} €</del></span>
    <span class="sale-price-current"><small>Tash</small><strong>{{ number_format((float) $price, 2) }} €</strong></span>
    <span class="sale-price-badge">BLACK FRIDAY · -{{ $discountPercent }}%</span>
  @else
    <span class="sale-price-current"><small>Çmimi aktual</small><strong>{{ number_format((float) $price, 2) }} €</strong></span>
    <span class="sale-price-badge">BLACK FRIDAY</span>
  @endif
</div>
