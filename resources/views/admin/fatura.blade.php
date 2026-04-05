<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
body {
    font-family: DejaVu Sans;
    font-size: 13px;
    color: #333;
}

/* HEADER */
.header { width:100%; margin-bottom:20px; }
.logo { width:150px; }
.right { text-align:right; }

.title {
    font-size: 24px;
    font-weight: bold;
    color: #e60023;
}

/* TABLE */
.table {
    width:100%;
    border-collapse: collapse;
    margin-top:20px;
}

.table th {
    background:#e60023;
    color:#fff;
    padding:10px;
    border:1px solid #ddd;
}

.table td {
    padding:10px;
    border:1px solid #ddd;
}

/* TOTAL */
.total {
    text-align:right;
    margin-top:20px;
    font-size:18px;
    font-weight:bold;
}

/* BUTTONS (vetëm për browser) */
.actions {
    margin-top:30px;
}

.btn {
    padding:10px 15px;
    text-decoration:none;
    border-radius:5px;
    margin-right:5px;
    color:#fff;
}

.print{ background:black; }
.back{ background:gray; }
.pdf{ background:red; }
.email{ background:green; }

/* PDF HIDE BUTTONS */
@media print {
    .actions { display:none; }
}
</style>
</head>

<body>

<!-- HEADER -->
<table class="header">
<tr>
<td>
<img src="{{ public_path('images/llogo.png') }}" class="logo">

<div>
Brillant<br>
Rruga Gjergj Fishta, Lipjan<br>
044 996 926
</div>
</td>

<td class="right">
<div class="title">FATURA</div>
<div>Nr: BRL-{{ $order->id }}</div>
<div>Data: {{ optional($order->created_at)->format('d.m.Y') }}</div>
</td>
</tr>
</table>

<hr>

<h4>Klienti:</h4>
<p>
{{ $order->name ?? '' }}<br>
{{ $order->phone ?? '' }}<br>
{{ $order->email ?? '' }}
</p>

<table class="table">
<tr>
<th>Produkti</th>
<th>Sasia</th>
<th>Çmimi</th>
<th>Total</th>
</tr>

@foreach($order->items ?? [] as $item)
<tr>
<td>{{ $item->name ?? '' }}</td>
<td>{{ $item->qty ?? 0 }}</td>
<td>{{ number_format($item->price ?? 0,2) }} €</td>
<td>{{ number_format(($item->price ?? 0)*($item->qty ?? 0),2) }} €</td>
</tr>
@endforeach

</table>

<div class="total">
TOTAL: {{ number_format($order->total ?? 0,2) }} €
</div>

<!-- BUTTONS -->
<div class="actions">

<button class="btn print" onclick="window.print()">🖨️ Printo</button>

<a href="{{ route('admin.orders.index') }}" class="btn back">
⬅️ Kthehu
</a>

<a href="{{ route('admin.orders.invoice.pdf',$order->id) }}" class="btn pdf">
📥 PDF
</a>

<form method="POST" action="{{ route('admin.orders.sendInvoice',$order->id) }}" style="display:inline;">
@csrf
<button class="btn email">
📧 Email
</button>
</form>

</div>

</body>
</html>