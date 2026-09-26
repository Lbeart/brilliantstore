@php
  // Chrome remains available as a fallback. QZ Tray sends a dynamically sized
  // raster page through the HPRT driver so continuous paper is not split.
  $receiptPageHeightMm = 127;
  foreach ($receipt->purchases as $purchase) {
      $nameLines = max(1, (int) ceil(mb_strlen((string) $purchase->item_name) / 24));
      $sizeLines = $purchase->size ? max(1, (int) ceil(mb_strlen((string) $purchase->size) / 28)) : 0;
      $receiptPageHeightMm += 13 + (($nameLines - 1) * 5) + ($sizeLines * 5);
  }
  $receiptPageHeightMm = min(300, max(80, (int) ceil($receiptPageHeightMm)));

@endphp
<!doctype html>
<html lang="sq">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dokument shitjeje {{ $receipt->code }}</title>
  <style>
    *{box-sizing:border-box}script{display:none!important}body{margin:0;padding:24px;background:#f2f4f7;color:#111;font:13px/1.4 Arial,sans-serif}
    .actions{max-width:520px;margin:0 auto 10px;display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .actions a,.actions button{border:1px solid #222;background:#fff;color:#111;padding:9px 12px;text-decoration:none;cursor:pointer;border-radius:5px;font:inherit}
    .actions .qz-print{background:#dc3545;border-color:#dc3545;color:#fff;font-weight:700}
    .actions button:disabled{cursor:wait;opacity:.65}
    .print-status{max-width:520px;margin:0 auto 16px;padding:9px 12px;border-radius:6px;background:#e8f3ff;color:#164e7a;display:none}
    .print-status.is-visible{display:block}.print-status.is-success{background:#e5f7ec;color:#146c3b}.print-status.is-error{background:#ffe6e6;color:#9c1c1c}
    .paper{width:50mm;max-width:100%;margin:auto;background:#fff;padding:4mm 3mm;box-shadow:0 5px 30px #0002}
    h1{font-size:20px;letter-spacing:.06em;text-align:center;margin:0}.center{text-align:center}.muted{color:#555}.rule{border-top:1px dashed #111;margin:10px 0}
    .row{display:flex;justify-content:space-between;gap:8px;margin:4px 0}.row span:last-child{text-align:right}
    .item{margin:10px 0}.item strong{display:block}.total{font-size:17px;font-weight:bold}.note{font-size:11px;margin-top:14px}
    @media print{
      html,body{margin:0!important;padding:0!important;background:#fff;width:50mm;min-height:0!important}
      body>*:not(.paper){display:none!important}
      .paper{box-shadow:none;width:50mm;max-width:none;margin:0;padding:4mm 3mm;break-inside:avoid;page-break-inside:avoid}
      .item,.row,.rule{break-inside:avoid;page-break-inside:avoid}
      .actions,.print-status{display:none!important}
    }
  </style>
  <style id="receipt-page-size">@page{size:50mm {{ $receiptPageHeightMm }}mm;margin:0}</style>
</head>
<body>
  <div class="actions">
    <button class="qz-print" type="button" data-qz-print>Printo direkt me QZ</button>
    <button type="button" onclick="printReceipt()">Rezervë: Chrome</button>
    <a href="{{ route('admin.customers.invoice', [$receipt->customer_id, $receipt->code]) }}">Fatura A4</a>
    <a href="{{ route('admin.pos.index') }}">Kthehu te arka</a>
  </div>
  <div class="print-status" data-print-status role="status" aria-live="polite"></div>
  <div class="paper" data-estimated-page-height="{{ $receiptPageHeightMm }}">
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

  <script src="{{ asset('js/qz-tray.js') }}?v=2.3.0"></script>
  <script>
    const receiptCode = @json((string) $receipt->code, JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT);
    const preferredPrinterPatterns = [
      /^HPRT\s+LPQ80$/i,
      /^LPQ80\s+faktura$/i,
      /LPQ80/i,
    ];

    function qzReceiptHeightMm() {
      const paper = document.querySelector('.paper');
      if (!paper) return 100;

      const pixelsPerMillimeter = 96 / 25.4;
      const contentHeight = paper.getBoundingClientRect().height / pixelsPerMillimeter;
      return Math.max(60, Math.ceil(contentHeight) + 4);
    }

    function buildPixelReceipt(pageHeight) {
      const paper = document.querySelector('.paper');
      if (!paper) throw new Error('Përmbajtja e faturës nuk u gjet.');

      return '<!doctype html><html><head><meta charset="utf-8">' +
        '<style>' +
        '@page{size:50mm ' + pageHeight + 'mm;margin:0}' +
        '*{box-sizing:border-box}' +
        'html,body{width:50mm;height:' + pageHeight + 'mm;margin:0;padding:0;background:#fff;color:#111}' +
        'body{font:13px/1.4 Arial,sans-serif}' +
        '.paper{width:50mm;margin:0;padding:4mm 3mm;background:#fff}' +
        'h1{font-size:20px;letter-spacing:.06em;text-align:center;margin:0}' +
        '.center{text-align:center}.muted{color:#555}' +
        '.rule{border-top:1px dashed #111;margin:10px 0}' +
        '.row{display:flex;justify-content:space-between;gap:8px;margin:4px 0}' +
        '.row span:last-child{text-align:right}.item{margin:10px 0}.item strong{display:block}' +
        '.total{font-size:17px;font-weight:bold}.note{font-size:11px;margin-top:14px}' +
        '</style></head><body><div class="paper">' + paper.innerHTML + '</div></body></html>';
    }

    function showPrintStatus(message, type = '') {
      const status = document.querySelector('[data-print-status]');
      if (!status) return;
      status.textContent = message;
      status.className = 'print-status is-visible' + (type ? ' is-' + type : '');
    }

    async function connectQzTray() {
      if (!window.qz) throw new Error('Biblioteka QZ Tray nuk u ngarkua. Rifresko faqen.');
      if (!qz.websocket.isActive()) {
        await qz.websocket.connect({ retries: 3, delay: 1 });
      }
    }

    async function findReceiptPrinter() {
      const printers = await qz.printers.find();
      const savedPrinter = localStorage.getItem('brillant-qz-printer');
      let printer = null;

      for (const pattern of preferredPrinterPatterns) {
        printer = printers.find((name) => pattern.test(name));
        if (printer) break;
      }

      printer = printer || printers.find((name) => name === savedPrinter);

      if (!printer) {
        throw new Error('Printeri HPRT LPQ80 nuk u gjet. Kontrollo që është ndezur dhe i instaluar në Windows. Printerët e gjetur: ' + (printers.join(', ') || 'asnjë'));
      }

      localStorage.setItem('brillant-qz-printer', printer);
      return printer;
    }

    async function printWithQz() {
      const button = document.querySelector('[data-qz-print]');
      if (button) button.disabled = true;
      showPrintStatus('Duke u lidhur me QZ Tray…');

      try {
        await connectQzTray();
        const printer = await findReceiptPrinter();
        showPrintStatus('Duke e dërguar faturën te ' + printer + '…');
        const pageHeight = qzReceiptHeightMm();
        const config = qz.configs.create(printer, {
          colorType: 'grayscale',
          copies: 1,
          margins: 0,
          orientation: 'portrait',
          rasterize: true,
          scaleContent: false,
          size: { width: 50, height: pageHeight, custom: true },
          units: 'mm',
          jobName: 'B-Brillant ' + receiptCode,
        });
        await qz.print(config, [{
          type: 'pixel',
          format: 'html',
          flavor: 'plain',
          data: buildPixelReceipt(pageHeight),
          options: { pageWidth: 50, pageHeight: pageHeight },
        }]);
        showPrintStatus('Fatura u dërgua me sukses te ' + printer + '. Letra ndalet menjëherë pas faturës.', 'success');
      } catch (error) {
        console.error(error);
        const detail = error && error.message ? error.message : String(error);
        showPrintStatus('Printimi direkt dështoi: ' + detail + ' Hape QZ Tray, shtyp Allow dhe shëno “Remember this decision”, pastaj provo përsëri.', 'error');
      } finally {
        if (button) button.disabled = false;
      }
    }

    function prepareReceiptPage(){
      const paper = document.querySelector('.paper');
      const pageStyle = document.getElementById('receipt-page-size');
      if (!paper || !pageStyle) return;

      const pixelsPerMillimeter = 96 / 25.4;
      const contentHeight = paper.getBoundingClientRect().height / pixelsPerMillimeter;
      const pageHeight = Math.max(Math.ceil(contentHeight * 10) / 10 + 1, 45);
      pageStyle.textContent = '@page{size:50mm ' + pageHeight + 'mm;margin:0}';
    }

    function printReceipt(){
      prepareReceiptPage();
      requestAnimationFrame(() => requestAnimationFrame(() => window.print()));
    }

    document.querySelector('[data-qz-print]')?.addEventListener('click', printWithQz);
    window.addEventListener('beforeprint', prepareReceiptPage);
    window.addEventListener('load', () => {
      const ready = document.fonts?.ready || Promise.resolve();
      ready.then(() => {
        prepareReceiptPage();
        @if(request()->boolean('print'))
          setTimeout(printWithQz, 150);
        @endif
      });
    });
  </script>
  <script>try { sessionStorage.removeItem('brillant-pos-cart'); } catch (_) {}</script>
</body>
</html>
