<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Stiker barkodi - {{ $product->name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --label-w:50mm;
      --label-h:35mm;
      --ink:#111827;
      --muted:#4b5563;
      --line:#d1d5db;
      --brand:#dc3545;
    }
    *{box-sizing:border-box}
    body{margin:0;background:#eef2f7;font-family:Arial,sans-serif;color:var(--ink);padding:18px}
    .toolbar{max-width:720px;margin:0 auto 14px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:12px;display:flex;gap:10px;align-items:end;justify-content:space-between;box-shadow:0 8px 20px rgba(16,24,40,.08)}
    .toolbar label{display:block;font-size:12px;font-weight:700;color:var(--muted);margin-bottom:4px}
    .toolbar input{width:92px;border:1px solid var(--line);border-radius:8px;padding:9px;font-size:14px}
    .btn{border:0;border-radius:8px;padding:10px 12px;font-weight:800;cursor:pointer;text-decoration:none;display:inline-block;text-align:center}
    .btn-dark{background:#111827;color:#fff}
    .btn-red{background:var(--brand);color:#fff}
    .sheet{display:flex;flex-wrap:wrap;gap:10px;justify-content:center}
    .label{
      width:var(--label-w);
      height:var(--label-h);
      background:#fff;
      border:1px dashed #9ca3af;
      border-radius:2mm;
      padding:2.2mm 2.4mm 1.8mm;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      overflow:hidden;
    }
    .topline{display:flex;justify-content:space-between;gap:2mm;align-items:flex-start}
    .name{font-size:8.5pt;font-weight:800;line-height:1.05;max-height:18pt;overflow:hidden}
    .price{font-size:10.5pt;font-weight:900;white-space:nowrap}
    .meta{font-size:5.8pt;color:var(--muted);line-height:1.1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .barcode-wrap{height:13.5mm;display:flex;align-items:center;justify-content:center}
    .barcode{width:45mm;height:13mm}
    .code{font-size:6pt;font-weight:700;text-align:center;letter-spacing:.2pt}
    @page{size:50mm 35mm;margin:0}
    @media print{
      html,body{width:50mm;margin:0;background:#fff;padding:0}
      .toolbar{display:none}
      .sheet{display:block;margin:0;padding:0}
      .label{border:0;border-radius:0;page-break-after:always;break-after:page}
      .label:last-child{page-break-after:auto;break-after:auto}
    }
  </style>
</head>
<body>
  <form class="toolbar" method="GET" action="{{ route('admin.products.barcode', $product) }}">
    <div>
      <label>Kopje per printim</label>
      <input type="number" name="copies" min="1" max="100" value="{{ $copies }}">
    </div>
    <div style="flex:1">
      <label>Etiketa</label>
      <div style="font-weight:800">{{ $product->name }} - {{ number_format((float) $product->price, 2) }} EUR</div>
      <div style="font-size:12px;color:#667085">Madhesia: 50mm x 35mm. Ne printer zgjidhe paper size 50 x 35 mm.</div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <button class="btn btn-dark" type="submit">Rifresko</button>
      <button class="btn btn-red" type="button" onclick="window.print()">Printo</button>
      <a class="btn btn-dark" href="{{ route('admin.products.edit', $product) }}">Edito</a>
    </div>
  </form>

  <div class="sheet">
    @for($i = 0; $i < $copies; $i++)
      <div class="label">
        <div>
          <div class="topline">
            <div class="name">{{ $product->name }}</div>
            <div class="price">{{ number_format((float) $product->price, 2) }}€</div>
          </div>
          <div class="meta">SKU: {{ $product->sku ?: '-' }}</div>
        </div>
        <div class="barcode-wrap">
          <svg class="barcode" data-code="{{ $product->barcode ?: $product->sku ?: ('BRL'.$product->id) }}"></svg>
        </div>
        <div class="code">{{ $product->barcode ?: $product->sku ?: ('BRL'.$product->id) }}</div>
      </div>
    @endfor
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
  <script>
    document.querySelectorAll('.barcode').forEach(function (node) {
      JsBarcode(node, node.dataset.code, {
        format: 'CODE128',
        displayValue: false,
        margin: 0,
        height: 38,
        width: 1.45
      });
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
