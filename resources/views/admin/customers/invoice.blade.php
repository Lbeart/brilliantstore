<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Fatura {{ $receiptCode }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:DejaVu Sans, Arial, sans-serif;background:#f4f6f9;margin:0;padding:20px;color:#17202a}
    .invoice{max-width:900px;margin:0 auto;background:#fff;border-radius:10px;padding:28px;box-shadow:0 10px 25px rgba(16,24,40,.10)}
    .header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;border-bottom:2px solid #e5e7eb;padding-bottom:18px;margin-bottom:18px}
    .logo{height:66px;max-width:170px;object-fit:contain}
    .company{font-size:13px;color:#667085;line-height:1.5;margin-top:8px}
    .title{text-align:right}
    .title h1{margin:0;color:#dc3545;font-size:30px;letter-spacing:1px}
    .title div{font-size:13px;color:#344054;line-height:1.6}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px}
    .box{border:1px solid #e5e7eb;border-radius:8px;padding:14px;background:#fbfcfd}
    .box h2{font-size:13px;text-transform:uppercase;color:#667085;letter-spacing:.06em;margin:0 0 8px}
    .box p{margin:0;line-height:1.55}
    table{width:100%;border-collapse:collapse;margin-top:18px}
    th,td{border:1px solid #e5e7eb;padding:11px;text-align:left;font-size:13px}
    th{background:#f2f4f7;color:#344054;text-transform:uppercase;font-size:11px;letter-spacing:.05em}
    .text-end{text-align:right}
    .total{margin-top:18px;text-align:right;font-size:24px;font-weight:800;color:#dc3545}
    .summary{margin-left:auto;margin-top:16px;width:320px;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden}
    .summary-row{display:flex;justify-content:space-between;padding:9px 12px;border-bottom:1px solid #e5e7eb;font-size:13px}
    .summary-row:last-child{border-bottom:0}
    .summary-row.strong{font-weight:800;background:#f9fafb}
    .footer{margin-top:34px;text-align:center;color:#667085;font-size:12px;border-top:1px solid #e5e7eb;padding-top:16px}
    .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:22px}
    .btn{display:inline-block;border-radius:8px;padding:10px 14px;text-decoration:none;border:0;font-weight:700;cursor:pointer;font-size:14px}
    .btn-dark{background:#111827;color:#fff}
    .btn-red{background:#dc3545;color:#fff}
    .btn-muted{background:#6c757d;color:#fff}
    @media print{body{background:#fff;padding:0}.invoice{box-shadow:none;border-radius:0}.actions{display:none}}
    @media (max-width:700px){.header,.grid{display:block}.title{text-align:left;margin-top:16px}.invoice{padding:18px}}
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
      <h1>FATURA</h1>
      <div><strong>Nr:</strong> {{ $receiptCode }}</div>
      <div><strong>Data:</strong> {{ $purchases->first()?->purchased_at?->format('d.m.Y') ?? now()->format('d.m.Y') }}</div>
    </div>
  </div>

  @if(session('success') && !$isPdf)
    <div style="background:#ecfdf3;border:1px solid #abefc6;color:#067647;border-radius:8px;padding:10px 12px;margin-bottom:16px;font-weight:700">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid">
    <div class="box">
      <h2>Klienti</h2>
      <p>
        <strong>{{ $customer->name }}</strong><br>
        @if($customer->phone) Tel: {{ $customer->phone }}<br>@endif
        @if($customer->email) Email: {{ $customer->email }}<br>@endif
        @if($customer->address) Adresa: {{ $customer->address }}@if($customer->city), {{ $customer->city }}@endif @endif
      </p>
    </div>
    <div class="box">
      <h2>Detajet</h2>
      <p>
        Lloji: {{ $receipt?->order || $purchases->first()?->order ? 'Porosi online' : 'POS / shitje ne dyqan' }}<br>
        Artikuj: {{ $purchases->count() }}<br>
        Pagesa:
        @php
          $paymentLabels = ['cash' => 'Cash', 'card' => 'Kartel', 'bank' => 'Banke', 'mixed' => 'E perzier'];
          $statusLabels = ['paid' => 'Paguar', 'partial' => 'Paguar pjeserisht', 'unpaid' => 'Pa paguar'];
        @endphp
        {{ $receipt ? ($paymentLabels[$receipt->payment_method] ?? $receipt->payment_method) : 'Ne arkiv' }}<br>
        Statusi: {{ $receipt ? ($statusLabels[$receipt->payment_status] ?? $receipt->payment_status) : 'Paguar' }}
      </p>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:44px">#</th>
        <th>Produkti</th>
        <th>Dimensioni</th>
        <th class="text-end">Sasia</th>
        <th class="text-end">Cmimi</th>
        <th class="text-end">Totali</th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchases as $purchase)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $purchase->item_name }}</td>
          <td>{{ $purchase->size ?: '-' }}</td>
          <td class="text-end">{{ $purchase->quantity }}</td>
          <td class="text-end">{{ number_format((float) $purchase->unit_price, 2) }} EUR</td>
          <td class="text-end">{{ number_format((float) $purchase->total, 2) }} EUR</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="summary">
    <div class="summary-row"><span>Subtotal</span><strong>{{ number_format((float) ($receipt?->subtotal ?? $purchases->sum('total')), 2) }} EUR</strong></div>
    <div class="summary-row"><span>Zbritje</span><strong>{{ number_format((float) ($receipt?->discount ?? 0), 2) }} EUR</strong></div>
    <div class="summary-row strong"><span>Total</span><strong>{{ number_format((float) $total, 2) }} EUR</strong></div>
    <div class="summary-row"><span>Paguar</span><strong>{{ number_format((float) ($receipt?->paid_amount ?? $total), 2) }} EUR</strong></div>
    <div class="summary-row"><span>Mbetur</span><strong>{{ number_format((float) ($receipt?->balance ?? 0), 2) }} EUR</strong></div>
  </div>

  <div class="total">TOTAL: {{ number_format((float) $total, 2) }} EUR</div>

  @if(!$isPdf)
    <div class="actions">
      <button class="btn btn-dark" onclick="window.print()">Printo</button>
      <a class="btn btn-red" href="{{ route('admin.customers.invoice.pdf', [$customer, $receiptCode]) }}">Shkarko PDF</a>
      <a class="btn btn-muted" href="{{ route('admin.customers.edit', $customer) }}">Kthehu te klienti</a>
    </div>
  @endif

  <div class="footer">
    Faleminderit per besimin. Brillant
  </div>
</div>
</body>
</html>
