<!doctype html>
<html lang="sq">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dokument shitjeje {{ $receipt->code }}</title>
  <style>
    *{box-sizing:border-box}body{margin:0;padding:24px;background:#f2f4f7;color:#111;font:13px/1.4 Arial,sans-serif}
    .actions{max-width:380px;margin:0 auto 16px;display:flex;gap:8px;flex-wrap:wrap}
    .actions a,.actions button{border:1px solid #222;background:#fff;color:#111;padding:9px 12px;text-decoration:none;cursor:pointer;border-radius:5px;font:inherit}
    .paper{width:80mm;max-width:100%;margin:auto;background:#fff;padding:5mm 4mm;box-shadow:0 5px 30px #0002}
    h1{font-size:20px;letter-spacing:.06em;text-align:center;margin:0}.center{text-align:center}.muted{color:#555}.rule{border-top:1px dashed #111;margin:10px 0}
    .row{display:flex;justify-content:space-between;gap:8px;margin:4px 0}.row span:last-child{text-align:right}
    .item{margin:10px 0}.item strong{display:block}.total{font-size:17px;font-weight:bold}.note{font-size:11px;margin-top:14px}
    @page{size:80mm 200mm;margin:0}
    @media print{
      html,body{margin:0!important;padding:0!important;background:#fff;width:80mm;min-height:0!important}
      .paper{box-shadow:none;width:80mm;max-width:none;margin:0;padding:4mm 3mm;break-inside:avoid;page-break-inside:avoid}
      .item,.row,.rule{break-inside:avoid;page-break-inside:avoid}
      .actions{display:none!important}
    }
  </style>
</head>
<body>
  <div class="actions">
    <button type="button" onclick="printReceipt()">Printo 80 mm</button>
    <a href="{{ route('admin.customers.invoice', [$receipt->customer_id, $receipt->code]) }}">Fatura A4</a>
    <a href="{{ route('admin.pos.index') }}">Kthehu te arka</a>
  </div>
  <div class="paper">
    <h1>B-BRILLANT</h1>
    <div class="center muted">Rruga Gjergj Fishta, Lipjan<br>+383 44 996 926</div>
    <div class="rule"></div>
    <div class="center"><strong>DOKUMENT SHITJEJE</strong><br><small>Jo kupon fiskal zyrtar</small></div>
    <div class="rule"></div>
    <div class="row"><span>Nr.</span><span>{{ $receipt->code }}</span></div>
    <div class="row"><span>Data</span><span>{{ optional($receipt->sold_at)->format('d.m.Y H:i') }}</span></div>
    <div class="row"><span>Klienti</span><span>{{ $receipt->customer->name ?? 'Klient POS' }}</span></div>
    <div class="rule"></div>
    @foreach($receipt->purchases as $purchase)
      <div class="item">
        <strong>{{ $purchase->item_name }}</strong>
        @if($purchase->size)<div class="muted">Përmasa: {{ $purchase->size }}</div>@endif
        <div class="row"><span>{{ $purchase->quantity }} × {{ number_format((float) $purchase->unit_price, 2) }} €</span><span>{{ number_format((float) $purchase->total, 2) }} €</span></div>
      </div>
    @endforeach
    <div class="rule"></div>
    <div class="row"><span>Nëntotali</span><span>{{ number_format((float) $receipt->subtotal, 2) }} €</span></div>
    <div class="row"><span>Zbritja</span><span>{{ number_format((float) $receipt->discount, 2) }} €</span></div>
    <div class="row total"><span>Totali</span><span>{{ number_format((float) $receipt->total, 2) }} €</span></div>
    <div class="row"><span>Paguar</span><span>{{ number_format((float) $receipt->paid_amount, 2) }} €</span></div>
    <div class="row"><span>Mbetur</span><span>{{ number_format((float) $receipt->balance, 2) }} €</span></div>
    <div class="row"><span>Pagesa</span><span>{{ strtoupper($receipt->payment_method) }}</span></div>
    <div class="rule"></div>
    <div class="center note">Faleminderit për blerjen!<br>Ky dokument nuk zëvendëson kuponin fiskal të lëshuar nga pajisja e autorizuar.</div>
  </div>
  <style id="receipt-page-size"></style>
  <script>
    function prepareReceiptPage(){
      const paper = document.querySelector('.paper');
      const pageStyle = document.getElementById('receipt-page-size');
      if (!paper || !pageStyle) return;

      const pixelsPerMillimeter = 96 / 25.4;
      const contentHeight = Math.ceil(paper.scrollHeight / pixelsPerMillimeter);
      const pageHeight = Math.max(contentHeight + 2, 45);
      pageStyle.textContent = '@page{size:80mm ' + pageHeight + 'mm;margin:0}';
    }

    function printReceipt(){
      prepareReceiptPage();
      requestAnimationFrame(() => window.print());
    }

    window.addEventListener('beforeprint', prepareReceiptPage);
    window.addEventListener('load', () => {
      prepareReceiptPage();
      @if(request()->boolean('print'))
        setTimeout(printReceipt, 100);
      @endif
    });
  </script>
  <script>try { sessionStorage.removeItem('brillant-pos-cart'); } catch (_) {}</script>
</body>
</html>
