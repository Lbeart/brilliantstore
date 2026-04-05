<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Porosia #{{ $order->id }} – Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa}
    .card-soft{background:#fff;border:0;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.06)}
    .summary-thumb{width:56px;height:56px;border-radius:8px;object-fit:cover;background:#f1f2f6}
    .badge-status{font-size:.8rem}
  </style>
</head>
<body>

@php
  $order_item_img_url = function($raw){
    $placeholder = asset('images/placeholder-product.png');
    if (empty($raw)) return $placeholder;

    if (is_array($raw)) {
        $raw = collect($raw)->first(fn($x)=>!empty($x)) ?? null;
        if (empty($raw)) return $placeholder;
    }

    $raw = trim((string)$raw);
    $decodedRaw = urldecode($raw);

    if (preg_match('/\[[^\]]+\]/', $decodedRaw, $m)) {
        $arr = json_decode($m[0], true);
        if ($arr && !empty($arr)) $decodedRaw = $arr[0];
    } elseif (str_starts_with($decodedRaw, '[')) {
        $arr = json_decode($decodedRaw, true);
        if ($arr && !empty($arr)) $decodedRaw = $arr[0];
    }

    $decodedRaw = trim((string)$decodedRaw, " \t\n\r\0\x0B\"'");

    if (empty($decodedRaw)) return $placeholder;

    if (str_contains($decodedRaw, '/storage/images/')) {
        $decodedRaw = str_replace('/storage/images/', '/images/', $decodedRaw);
        return $decodedRaw;
    }

    if (preg_match('#^https?://#i', $decodedRaw)) return $decodedRaw;

    if (str_starts_with($decodedRaw, 'images/')) return asset($decodedRaw);

    return asset('images/products/'.$decodedRaw);
};
@endphp

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h5 m-0">Porosia #{{ $order->id }}</h1>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.orders.index') }}">⟵ Kthehu te Porositë</a>
  </div>

  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

  <div class="row g-3">
    <!-- Artikujt -->
    <div class="col-lg-7">
      <div class="card-soft p-3">
        <h6 class="mb-3">Artikujt</h6>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Produkti</th>
                <th>Dimensioni</th>
                <th style="width:80px">Sasia</th>
                <th style="width:120px">Çmimi</th>
                <th style="width:120px">Totali</th>
              </tr>
            </thead>

            <tbody>
            @foreach($order->items ?? [] as $it)
              @php
                $line = (float)($it->price ?? 0) * (int)($it->qty ?? 0);
                $imgSrc = $order_item_img_url($it->image ?? $it->image_path ?? null);

                $curtain = null;
                if(isset($it->curtain) && !empty($it->curtain)){
                    $curtain = is_array($it->curtain)
                        ? $it->curtain
                        : json_decode($it->curtain, true);

                    if(!is_array($curtain)) $curtain = null;
                }
              @endphp

              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img
                      src="{{ $imgSrc }}"
                      class="summary-thumb"
                      alt="{{ $it->name ?? '' }}"
                      onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                    <div class="fw-semibold">{{ $it->name ?? '' }}</div>
                  </div>
                </td>

                <td>
                  @if($curtain)
                    <div class="small">
                      <strong>Gjerësia:</strong> {{ $curtain['width'] ?? '-' }} m<br>
                      <strong>Lartësia:</strong> {{ $curtain['height'] ?? '-' }} m<br>
                      <strong>Metra:</strong> {{ $curtain['meters'] ?? '-' }} m<br>
                      <strong>Multiplier:</strong> {{ $curtain['multiplier'] ?? '-' }} x<br>
                      <strong>Sistemi:</strong> {{ $curtain['fold_label'] ?? ($curtain['fold_type'] ?? '-') }}
                    </div>
                  @else
                    {{ $it->size ?? '—' }}
                  @endif
                </td>

                <td>{{ $it->qty ?? 0 }}</td>
                <td>{{ number_format($it->price ?? 0,2) }} €</td>
                <td>{{ number_format($line,2) }} €</td>
              </tr>
            @endforeach
            </tbody>

          </table>
        </div>
      </div>
    </div>

    <!-- Klienti -->
    <div class="col-lg-5">
      <div class="card-soft p-3 mb-3">
        <h6 class="mb-3">Klienti</h6>
        <div><strong>{{ $order->name ?? '' }}</strong></div>
        <div class="small">📞 {{ $order->phone ?? '' }} @if($order->email) | ✉️ {{ $order->email }} @endif</div>
      </div>

      <div class="card-soft p-3 mb-3">
        <h6 class="mb-3">Pagesa & Totali</h6>
        <div class="d-flex justify-content-between">
          <span>Totali</span>
          <span class="fw-bold">{{ number_format($order->total ?? 0,2) }} €</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Krijuar më</span>
          <span class="text-muted">{{ optional($order->created_at)->format('d.m.Y H:i') }}</span>
        </div>
      </div>

      <div class="card-soft p-3">
        <form method="POST" action="{{ route('admin.orders.status',$order) }}">
          @csrf
          <button class="btn btn-danger">Ruaj</button>

          <a href="{{ route('admin.orders.invoice', $order) }}"
             target="_blank"
             class="btn btn-dark btn-sm">
             🧾 Fatura
          </a>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>