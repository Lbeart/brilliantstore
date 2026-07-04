<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Barkodi - {{ $product->name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;padding:24px}
    .sheet{max-width:420px;margin:0 auto;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:20px;box-shadow:0 10px 24px rgba(16,24,40,.10)}
    .label{border:1px dashed #9ca3af;border-radius:8px;padding:18px;text-align:center;background:#fff}
    h1{font-size:18px;margin:0 0 4px;font-weight:800}
    .muted{color:#6b7280;font-size:12px}
    .price{font-size:18px;font-weight:900;margin-top:8px}
    svg{width:100%;height:92px;margin-top:12px}
    .actions{display:flex;gap:8px;margin-top:14px}
    .btn{border:0;border-radius:8px;padding:10px 12px;font-weight:700;cursor:pointer;text-decoration:none;display:inline-block;text-align:center}
    .btn-dark{background:#111827;color:#fff}
    .btn-red{background:#dc3545;color:#fff}
    @media print{
      body{background:#fff;padding:0}
      .sheet{box-shadow:none;border:0;max-width:none;padding:0}
      .actions{display:none}
      .label{border:0;border-radius:0}
    }
  </style>
</head>
<body>
  <div class="sheet">
    <div class="label">
      <h1>{{ $product->name }}</h1>
      <div class="muted">SKU: {{ $product->sku ?: '-' }}</div>
      <div class="price">{{ number_format((float) $product->price, 2) }} EUR</div>
      <svg id="barcode"></svg>
      <div class="muted">{{ $product->barcode }}</div>
    </div>
    <div class="actions">
      <button class="btn btn-dark" onclick="window.print()">Printo</button>
      <a class="btn btn-red" href="{{ route('admin.products.edit', $product) }}">Edito produktin</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
  <script>
    JsBarcode('#barcode', @json($product->barcode ?: $product->sku ?: ('BRL' + $product->id)), {
      format: 'CODE128',
      displayValue: false,
      margin: 8,
      height: 70,
      width: 2
    });
  </script>
  @if(request()->boolean('print'))
    <script>
      window.addEventListener('load', function () {
        setTimeout(function () { window.print(); }, 350);
      });
    </script>
  @endif
</body>
</html>
