<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fatura</title>

<style>
body{ font-family: DejaVu Sans; color:#333; }
.container{ max-width:800px; margin:auto; }

.header{ display:flex; justify-content:space-between; margin-bottom:20px; }
.logo{ font-size:22px; font-weight:bold; color:#e60023; }
.title{ font-size:26px; font-weight:bold; }

.box{ background:#f9f9f9; padding:10px; border-radius:8px; }

table{ width:100%; border-collapse:collapse; margin-top:20px; }
th, td{ border:1px solid #ddd; padding:10px; }
th{ background:#f2f2f2; }

.total{ text-align:right; font-size:20px; font-weight:bold; margin-top:20px; }

.footer{ margin-top:40px; font-size:12px; text-align:center; color:#777; }

.btn{ padding:8px 12px; border:none; cursor:pointer; margin-top:10px; }
.print{ background:black; color:white; }
</style>
</head>

<body>
<div class="container">

<div class="header">
    <div>
        <div class="logo">BRILLANT</div>
        <div>Rruga Gjergj Fishta, Lipjan</div>
        <div>📞 044 996 926</div>
    </div>

    <div>
        <div class="title">FATURA</div>
        <div><strong>Nr:</strong> BRL-{{ $order->id }}</div>
        <div><strong>Data:</strong> {{ optional($order->created_at)->format('d.m.Y') }}</div>
    </div>
</div>

<hr>

<div class="box">
<strong>Klienti:</strong><br>
{{ $order->name ?? '' }} <br>
📞 {{ $order->phone ?? '' }} <br>
✉️ {{ $order->email ?? '' }}
</div>

<table>
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

<button class="btn print" onclick="window.print()">🖨️ Printo</button>

<div class="footer">
Faleminderit për besimin ❤️ – Brillant
</div>

</div>
</body>
</html>