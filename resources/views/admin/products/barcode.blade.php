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
      --ink:#000;
      --muted:#111827;
      --line:#d1d5db;
      --brand:#dc3545;
    }
    *{box-sizing:border-box}
    body{margin:0;background:#eef2f7;font-family:Arial,Helvetica,sans-serif;color:var(--ink);padding:18px}
    .toolbar{max-width:900px;margin:0 auto 14px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:12px 14px;display:flex;gap:10px;align-items:end;justify-content:space-between;box-shadow:0 8px 20px rgba(16,24,40,.08)}
    .toolbar label{display:block;font-size:12px;font-weight:700;color:var(--muted);margin-bottom:4px}
    .toolbar input{width:92px;border:1px solid var(--line);border-radius:8px;padding:9px;font-size:14px}
    .toolbar select{border:1px solid var(--line);border-radius:8px;padding:9px;font-size:14px;min-width:220px;background:#fff;color:#000;font-weight:700}
    .btn{border:0;border-radius:8px;padding:10px 12px;font-weight:800;cursor:pointer;text-decoration:none;display:inline-block;text-align:center}
    .btn-dark{background:#111827;color:#fff}
    .btn-red{background:var(--brand);color:#fff}
    .sheet{display:flex;flex-wrap:wrap;gap:10px;justify-content:center}
    .label{
      width:var(--label-w);
      height:var(--label-h);
      background:#fff;
      border:1px dashed #7b8794;
      border-radius:2mm;
      padding:2.2mm 2.2mm 1.9mm;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      overflow:hidden;
      color:#000;
      box-shadow:0 1mm 3mm rgba(15,23,42,.08);
    }
    .topline{display:flex;justify-content:space-between;gap:2mm;align-items:flex-start}
    .name{font-size:9.4pt;font-weight:900;line-height:1.03;max-height:19.5pt;overflow:hidden}
    .price{font-size:11.8pt;font-weight:900;line-height:1;white-space:nowrap}
    .meta{font-size:6.3pt;color:#111;line-height:1.15;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .barcode-wrap{height:13.2mm;display:flex;align-items:center;justify-content:center}
    .barcode{width:45.5mm;height:12.8mm}
    .code{font-size:6.7pt;font-weight:900;text-align:center;letter-spacing:0;color:#000}
    @page{size:50mm 35mm;margin:0}
    @media print{
      html,body{width:50mm;margin:0;background:#fff;padding:0;-webkit-print-color-adjust:exact;print-color-adjust:exact}
      .toolbar{display:none}
      .sheet{display:block;margin:0;padding:0}
      .label{border:0;border-radius:0;box-shadow:none;page-break-after:always;break-after:page}
      .label:last-child{page-break-after:auto;break-after:auto}
    }
  </style>
</head>
<body>
  @php
    $sizes = $product->sizes;
    if (is_string($sizes)) {
        $decoded = json_decode($sizes, true);
        $sizes = is_array($decoded) ? $decoded : [];
    }
    $sizes = is_array($sizes) ? array_values(array_filter($sizes, fn ($row) => is_array($row) && !empty($row['label']))) : [];
    $selectedSize = request('size');
    if (!empty($sizes)) {
        $validSizeIndexes = array_map('strval', array_keys($sizes));
        $selectedSize = in_array((string) $selectedSize, $validSizeIndexes, true)
            ? (string) $selectedSize
            : (string) array_key_first($sizes);
    } else {
        $selectedSize = 'all';
    }
    $labels = [];

    if (!empty($sizes)) {
        foreach ($sizes as $index => $size) {
            if ((string) $selectedSize !== (string) $index) {
                continue;
            }

            $labels[] = [
                'name' => $product->name,
                'size' => $size['label'] ?? '',
                'price' => (float) ($size['price'] ?? $product->price),
                'stock' => (int) ($size['stock'] ?? 0),
                'sku' => $product->sku ?: '-',
                'barcode' => $size['barcode'] ?? $product->barcode ?? $product->sku ?? ('BRL'.$product->id),
            ];
        }
    }

    if (empty($labels)) {
        $labels[] = [
            'name' => $product->name,
            'size' => '',
            'price' => (float) $product->price,
            'stock' => (int) ($product->stock ?? 0),
            'sku' => $product->sku ?: '-',
            'barcode' => $product->barcode ?: $product->sku ?: ('BRL'.$product->id),
        ];
    }
  @endphp
  <form class="toolbar" method="GET" action="{{ route('admin.products.barcode', $product) }}">
    <div>
      <label>Kopje per printim</label>
      <input type="number" name="copies" min="1" max="100" value="{{ $copies }}">
    </div>
    @if(!empty($sizes))
      <div>
        <label>Dimensioni</label>
        <select name="size" onchange="this.form.submit()">
          @foreach($sizes as $index => $size)
            <option value="{{ $index }}" @selected((string) $selectedSize === (string) $index)>
              {{ $size['label'] }} - {{ number_format((float) ($size['price'] ?? $product->price), 2) }} EUR
            </option>
          @endforeach
        </select>
      </div>
    @endif
    <div style="flex:1">
      <label>Etiketa</label>
      <div style="font-weight:800">{{ $product->name }}</div>
      <div style="font-size:12px;color:#667085">Madhesia: 50mm x 35mm. Ne printer zgjidhe paper size 50 x 35 mm.</div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <button class="btn btn-dark" type="submit">Rifresko</button>
      <button class="btn btn-red" type="submit" name="print" value="1">Printo</button>
      <a class="btn btn-dark" href="{{ route('admin.products.edit', $product) }}">Edito</a>
    </div>
  </form>

  <div class="sheet">
    @foreach($labels as $label)
      @for($i = 0; $i < $copies; $i++)
        <div class="label">
          <div>
            <div class="topline">
              <div class="name">{{ $label['name'] }}</div>
              <div class="price">{{ number_format((float) $label['price'], 2) }}&euro;</div>
            </div>
            <div class="meta">
              @if($label['size'] !== '')
                {{ $label['size'] }} /
              @endif
              SKU: {{ $label['sku'] }}
            </div>
          </div>
          <div class="barcode-wrap">
            <svg class="barcode" data-code="{{ $label['barcode'] }}"></svg>
          </div>
          <div class="code">{{ $label['barcode'] }}</div>
        </div>
      @endfor
    @endforeach
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
  <script>
    document.querySelectorAll('.barcode').forEach(function (node) {
      JsBarcode(node, node.dataset.code, {
        format: 'CODE128',
        displayValue: false,
        margin: 0,
        height: 40,
        width: 1.65
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
