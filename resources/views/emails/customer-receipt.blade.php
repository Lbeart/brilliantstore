<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Fatura {{ $receipt->code }}</title>
</head>
<body style="font-family:Arial,sans-serif;color:#17202a;line-height:1.5">
  <h2 style="color:#dc3545;margin-bottom:6px">Fatura {{ $receipt->code }}</h2>
  <p>Pershendetje {{ $customer->name }},</p>
  <p>Fatura juaj nga Brillant eshte gati.</p>
  <p>
    <strong>Totali:</strong> {{ number_format((float) $receipt->total, 2) }} EUR<br>
    <strong>Paguar:</strong> {{ number_format((float) $receipt->paid_amount, 2) }} EUR<br>
    <strong>Mbetur:</strong> {{ number_format((float) $receipt->balance, 2) }} EUR
  </p>
  <p>
    <a href="{{ $url }}" style="background:#dc3545;color:#fff;text-decoration:none;padding:10px 14px;border-radius:8px;display:inline-block;font-weight:bold">
      Hap faturen
    </a>
  </p>
  <p style="font-size:12px;color:#667085">Linku eshte i vlefshem per 30 dite.</p>
</body>
</html>
