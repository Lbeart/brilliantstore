<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fatura</title>

    <style>
        body{ font-family: DejaVu Sans; }
        .header{ display:flex; justify-content:space-between; margin-bottom:20px; }
        .title{ font-size:24px; font-weight:bold; }
        table{ width:100%; border-collapse:collapse; margin-top:20px; }
        th, td{ border:1px solid #ddd; padding:8px; text-align:left; }
        th{ background:#f2f2f2; }
        .total{ text-align:right; font-size:18px; font-weight:bold; margin-top:20px; }
    </style>
</head>
<body>

<div class="header">
    <div>
        <div class="title">FATURA</div>
        <div>Nr: {{ $order->id }}</div>
        <div>Data: {{ $order->created_at->format('d.m.Y') }}</div>
    </div>

    <div>
        <strong>Brillant</strong><br>
        Rruga Gjergj Fishta, Lipjan<br>
        044 996 926
    </div>
</div>

<hr>

<h4>Klienti:</h4>
<p>
    {{ $order->name }} <br>
    {{ $order->phone }} <br>
    {{ $order->email }}
</p>

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
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ number_format($item->price,2) }} €</td>
            <td>{{ number_format($item->price * $item->qty,2) }} €</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="total">
    TOTAL: {{ number_format($order->total,2) }} €
</div>
<button onclick="window.print()">Printo</button>

</body>
</html>