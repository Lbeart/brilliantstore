<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
body {
    font-family: DejaVu Sans;
    font-size: 13px;
    color: #333;
    margin: 0;
    padding: 0;
}

/* CONTAINER */
.container {
    width: 100%;
    padding: 20px;
}

/* HEADER */
.header {
    width: 100%;
    border-bottom: 2px solid #e60023;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.logo {
    width: 160px;
}

.company-info {
    font-size: 12px;
    color: #555;
}

.right {
    text-align: right;
}

.title {
    font-size: 26px;
    font-weight: bold;
    color: #e60023;
}

/* BOXES */
.box {
    width: 100%;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th {
    background: #e60023;
    color: #fff;
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 13px;
}

.table td {
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 13px;
}

/* TOTAL */
.total-box {
    margin-top: 20px;
    width: 100%;
}

.total-table {
    width: 300px;
    float: right;
    border-collapse: collapse;
}

.total-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.total-final {
    font-size: 18px;
    font-weight: bold;
    background: #f2f2f2;
}

/* FOOTER */
.footer {
    margin-top: 60px;
    border-top: 1px solid #ddd;
    padding-top: 10px;
    text-align: center;
    font-size: 12px;
    color: #777;
}

/* EXTRA */
.note {
    margin-top: 30px;
    font-size: 12px;
}

.clearfix {
    clear: both;
}
</style>
</head>

<body>

<div class="container">

<!-- HEADER -->
<table class="header">
<tr>
<td width="60%">
    <img src="{{ public_path('images/llogo.png') }}" class="logo"><br>

    <div class="company-info">
        <strong>Brillant</strong><br>
        Rruga Gjergj Fishta, Lipjan<br>
        📞 044 996 926<br>
        ✉️ info@brillant.com
    </div>
</td>

<td class="right">
    <div class="title">FATURA</div>
    <div><strong>Nr:</strong> BRL-{{ $order->id }}</div>
    <div><strong>Data:</strong> {{ optional($order->created_at)->format('d.m.Y') }}</div>
</td>
</tr>
</table>

<!-- CLIENT -->
<div class="box">
<strong>Klienti:</strong><br><br>
Emri: {{ $order->name ?? '' }}<br>
Telefoni: {{ $order->phone ?? '' }}<br>
Email: {{ $order->email ?? '' }}
</div>

<!-- TABLE -->
<table class="table">
<thead>
<tr>
<th>#</th>
<th>Produkti</th>
<th>Sasia</th>
<th>Çmimi (€)</th>
<th>Total (€)</th>
</tr>
</thead>

<tbody>
@php $i = 1; @endphp
@foreach($order->items ?? [] as $item)
<tr>
<td>{{ $i++ }}</td>
<td>{{ $item->name ?? '' }}</td>
<td>{{ $item->qty ?? 0 }}</td>
<td>{{ number_format($item->price ?? 0,2) }}</td>
<td>{{ number_format(($item->price ?? 0)*($item->qty ?? 0),2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<!-- TOTAL -->
<div class="total-box">

<table class="total-table">
<tr>
<td><strong>Nëntotali</strong></td>
<td>{{ number_format($order->total ?? 0,2) }} €</td>
</tr>

<tr>
<td><strong>TVSH (0%)</strong></td>
<td>0.00 €</td>
</tr>

<tr class="total-final">
<td><strong>TOTAL</strong></td>
<td>{{ number_format($order->total ?? 0,2) }} €</td>
</tr>
</table>

<div class="clearfix"></div>
</div>

<!-- NOTE -->
<div class="note">
<strong>Shënim:</strong><br>
Kjo faturë është gjeneruar automatikisht nga sistemi.<br>
Faleminderit për besimin tuaj!
</div>

<!-- FOOTER -->
<div class="footer">
© {{ date('Y') }} Brillant — Të gjitha të drejtat e rezervuara.
</div>

</div>

</body>
</html>