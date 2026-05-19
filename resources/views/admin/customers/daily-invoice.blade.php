<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Shitjet ditore {{ $day->format('d.m.Y') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:DejaVu Sans, Arial, sans-serif;background:#f4f6f9;margin:0;padding:20px;color:#17202a}
    .invoice{max-width:980px;margin:0 auto;background:#fff;border-radius:10px;padding:28px;box-shadow:0 10px 25px rgba(16,24,40,.10)}
    .header{display:table;width:100%;border-bottom:2px solid #e5e7eb;padding-bottom:18px;margin-bottom:18px}
    .header>div{display:table-cell;vertical-align:top}
    .logo{height:66px;max-width:170px;object-fit:contain}
    .company{font-size:13px;color:#667085;line-height:1.5;margin-top:8px}
    .title{text-align:right}
    .title h1{margin:0;color:#dc3545;font-size:30px;letter-spacing:1px}
    .title div{font-size:13px;color:#344054;line-height:1.6}
    .summary{display:table;width:100%;table-layout:fixed;border-spacing:8px 0;margin:18px -8px}
    .box{display:table-cell;border:1px solid #e5e7eb;border-radius:8px;padding:12px;background:#fbfcfd}
    .box .label{font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:#667085;font-weight:800}
    .box .value{font-size:18px;font-weight:900;margin-top:4px}
    table{width:100%;border-collapse:collapse;margin-top:18px}
    th,td{border:1px solid #e5e7eb;padding:10px;text-align:left;font-size:12px;vertical-align:top}
    th{background:#f2f4f7;color:#344054;text-transform:uppercase;font-size:10px;letter-spacing:.05em}
    .text-end{text-align:right}
    .receipt-head{background:#fff7f8;font-weight:800}
    .total{margin-top:18px;text-align:right;font-size:24px;font-weight:900;color:#dc3545}
    .actions{margin-top:22px}
    .btn{display:inline-block;border-radius:8px;padding:10px 14px;text-decoration:none;border:0;font-weight:700;cursor:pointer;font-size:14px}
    .btn-dark{background:#111827;color:#fff}
    .btn-red{background:#dc3545;color:#fff}
    .btn-muted{background:#6c757d;color:#fff}
    .footer{margin-top:34px;text-align:center;color:#667085;font-size:12px;border-top:1px solid #e5e7eb;padding-top:16px}
    @media print{body{background:#fff;padding:0}.invoice{box-shadow:none;border-radius:0}.actions{display:none}}
    @media (max-width:760px){.header,.summary,.header>div,.box{display:block}.summary{margin:18px 0}.box{margin-bottom:8px}.title{text-align:left;margin-top:16px}.invoice{padding:18px}}
  </style>
</head>
<body>
<div class="invoice">
  <div class="header">
    <div>
      @php $logoPath = public_path('images/llogo.png'); @endphp
      @if(is_file($logoPath))
        <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Brillant">
      @else
        <h2 style="margin:0;color:#dc3545">Brillant</h2>
      @endif
      <div class="company">
        Salloni i Perdeve, Tepihave Brillant<br>
        Rruga Gjergj Fishta, Lipjan<br>
        Tel: 044 996 926
      </div>
    </div>
    <div class="title">
      <h1>SHITJET DITORE</h1>
      <div><strong>Data:</strong> {{ $day->format('d.m.Y') }}</div>
      <div><strong>Fatura:</strong> {{ $summary['receipts_count'] }}</div>
    </div>
  </div>

  @if(session('error') && !$isPdf)
    <div style="background:#fef3f2;border:1px solid #fecdca;color:#b42318;border-radius:8px;padding:10px 12px;margin-bottom:16px;font-weight:700">
      {{ session('error') }}
    </div>
  @endif

  <div class="summary">
    <div class="box"><div class="label">Shitje total</div><div class="value">{{ number_format((float) $summary['total'], 2) }} EUR</div></div>
    <div class="box"><div class="label">Paguar</div><div class="value">{{ number_format((float) $summary['paid'], 2) }} EUR</div></div>
    <div class="box"><div class="label">Borxh</div><div class="value">{{ number_format((float) $summary['balance'], 2) }} EUR</div></div>
    <div class="box"><div class="label">Artikuj</div><div class="value">{{ (int) $summary['items_count'] }}</div></div>
  </div>

  <div class="summary">
    <div class="box"><div class="label">Cash</div><div class="value">{{ number_format((float) $summary['cash'], 2) }} EUR</div></div>
    <div class="box"><div class="label">Kartel</div><div class="value">{{ number_format((float) $summary['card'], 2) }} EUR</div></div>
    <div class="box"><div class="label">Banke</div><div class="value">{{ number_format((float) $summary['bank'], 2) }} EUR</div></div>
    <div class="box"><div class="label">E perzier</div><div class="value">{{ number_format((float) $summary['mixed'], 2) }} EUR</div></div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Fatura / Klienti</th>
        <th>Produkti</th>
        <th>Dimensioni</th>
        <th class="text-end">Sasia</th>
        <th class="text-end">Cmimi</th>
        <th class="text-end">Totali</th>
      </tr>
    </thead>
    <tbody>
      @foreach($receipts as $receipt)
        @php
          $statusLabels = ['paid' => 'Paguar', 'partial' => 'Pjese', 'unpaid' => 'Pa paguar'];
          $paymentLabels = ['cash' => 'Cash', 'card' => 'Kartel', 'bank' => 'Banke', 'mixed' => 'E perzier'];
          $receiptCustomer = $receipt->customer;
        @endphp
        <tr class="receipt-head">
          <td colspan="6">
            {{ $receipt->code }} - {{ optional($receiptCustomer)->name ?? 'Klient' }}
            | {{ $paymentLabels[$receipt->payment_method] ?? $receipt->payment_method }}
            | {{ $statusLabels[$receipt->payment_status] ?? $receipt->payment_status }}
            | Total {{ number_format((float) $receipt->total, 2) }} EUR
            | Paguar {{ number_format((float) $receipt->paid_amount, 2) }} EUR
            | Mbetur {{ number_format((float) $receipt->balance, 2) }} EUR
          </td>
        </tr>
        @foreach($receipt->purchases as $purchase)
          <tr>
            <td>{{ optional($receiptCustomer)->phone ?: '-' }}</td>
            <td>{{ $purchase->item_name }}</td>
            <td>{{ $purchase->size ?: '-' }}</td>
            <td class="text-end">{{ $purchase->quantity }}</td>
            <td class="text-end">{{ number_format((float) $purchase->unit_price, 2) }} EUR</td>
            <td class="text-end">{{ number_format((float) $purchase->total, 2) }} EUR</td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

  <div class="total">TOTAL DITOR: {{ number_format((float) $summary['total'], 2) }} EUR</div>

  @if(!$isPdf)
    <div class="actions">
      <button class="btn btn-dark" onclick="window.print()">Printo</button>
      <a class="btn btn-red" href="{{ route('admin.customers.daily-invoice.pdf', $day->format('Y-m-d')) }}" target="_blank" rel="noopener">Hap PDF</a>
      <a class="btn btn-muted" href="{{ route('admin.customers.index') }}">Kthehu te klientet</a>
    </div>
  @endif

  <div class="footer">Raport ditor i shitjeve - Brillant</div>
</div>
</body>
</html>
