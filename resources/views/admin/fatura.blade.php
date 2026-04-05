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

.header {
    width: 100%;
    margin-bottom: 20px;
}

.logo {
    width: 150px;
}

.right {
    text-align: right;
}

.title {
    font-size: 24px;
    font-weight: bold;
    color: #e60023;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th {
    background: #f2f2f2;
    padding: 10px;
    border: 1px solid #ddd;
}

.table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.total {
    text-align: right;
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
}

.footer {
    margin-top: 40px;
    text-align: center;
    font-size: 12px;
    color: #777;
}
</style>
</head>

<body>

<table class="header">
<tr>
<td>
    <img src="{{ public_path('images/llogo.png') }}" class="logo">
    <div>Rruga Gjergj Fishta, Lipjan</div>
    <div>044 996 926</div>
</td>

<td class="right">
    <div class="title">FATURA</div>
    <div><strong>Nr:</strong> BRL-{{ $order->id }}</div>
    <div><strong>Data:</strong> {{ optional($order->created_at)->format('d.m.Y') }}</div>
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
<thead>
<tr>
<th>Produkti</th>
<th>Sasia</th>
<th>Çmimi</th>
<th>Total</th>
</tr>
</thead>

<tbody>
@foreach($order->items ?? [] as $item)
<tr>
<td>{{ $item->name ?? '' }}</td>
<td>{{ $item->qty ?? 0 }}</td>
<td>{{ number_format($item->price ?? 0,2) }} €</td>
<td>{{ number_format(($item->price ?? 0)*($item->qty ?? 0),2) }} €</td>
</tr>
@endforeach
</tbody>
</table>

<div class="total">
TOTAL: {{ number_format($order->total ?? 0,2) }} €
</div>

<div class="footer">
Faleminderit për besimin ❤️ – Brillant
</div>

</body>
</html>