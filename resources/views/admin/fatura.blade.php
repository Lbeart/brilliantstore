<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fatura #{{ $order->id }}</title>

<style>
body{
    font-family: DejaVu Sans, Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:20px;
    color:#333;
}

.container{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.logo img{
    height:60px;
}

.company{
    font-size:14px;
    color:#666;
}

.invoice-info{
    text-align:right;
}

.title{
    font-size:28px;
    font-weight:bold;
    color:#e60023;
}

/* CLIENT BOX */
.box{
    background:#f9f9f9;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th, td{
    border:1px solid #ddd;
    padding:12px;
    text-align:left;
}

th{
    background:#f2f2f2;
}

tr:hover{
    background:#fafafa;
}

/* TOTAL */
.total{
    text-align:right;
    font-size:22px;
    font-weight:bold;
    margin-top:20px;
    color:#e60023;
}

/* BUTTONS */
.actions{
    margin-top:20px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 15px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:14px;
    text-decoration:none;
}

.print{ background:#000; color:#fff; }
.back{ background:#6c757d; color:#fff; }
.pdf{ background:#dc3545; color:#fff; }
.email{ background:#28a745; color:#fff; }

/* FOOTER */
.footer{
    margin-top:40px;
    text-align:center;
    font-size:13px;
    color:#777;
}

/* RESPONSIVE */
@media(max-width:600px){
    .header{
        flex-direction:column;
        align-items:flex-start;
    }

    .invoice-info{
        text-align:left;
        margin-top:10px;
    }

    table{
        font-size:13px;
    }
}
</style>
</head>

<body>

<div class="container">

<!-- HEADER -->
<div class="header">
    <div>
        <div class="logo">
            <img src="{{ asset('images/llogo.png') }}" alt="Logo">
        </div>
        <div class="company">
            Rruga Gjergj Fishta, Lipjan<br>
            📞 044 996 926
        </div>
    </div>

    <div class="invoice-info">
        <div class="title">FATURA</div>
        <div><strong>Nr:</strong> BRL-{{ $order->id }}</div>
        <div><strong>Data:</strong> {{ optional($order->created_at)->format('d.m.Y') }}</div>
    </div>
</div>

<hr>

<!-- CLIENT -->
<div class="box">
    <strong>Klienti:</strong><br>
    {{ $order->name ?? '' }} <br>
    📞 {{ $order->phone ?? '' }} <br>
    ✉️ {{ $order->email ?? '' }}
</div>

<!-- TABLE -->
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

<!-- TOTAL -->
<div class="total">
TOTAL: {{ number_format($order->total ?? 0,2) }} €
</div>

<!-- ACTION BUTTONS -->
<div class="actions">

    <button class="btn print" onclick="window.print()">🖨️ Printo</button>

    <a href="{{ route('admin.orders.index') }}" class="btn back">
        ⬅️ Kthehu
    </a>

    <a href="{{ route('admin.orders.invoice.pdf',$order->id) }}" class="btn pdf">
        📥 Shkarko PDF
    </a>

    <form method="POST" action="{{ route('admin.orders.sendInvoice',$order->id) }}">
        @csrf
        <button class="btn email">
            📧 Dërgo në Email
        </button>
    </form>

</div>

<!-- FOOTER -->
<div class="footer">
    Faleminderit për besimin ❤️ – Brillant
</div>

</div>

</body>
</html>