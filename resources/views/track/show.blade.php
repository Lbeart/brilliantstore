{{-- resources/views/track/show.blade.php --}}
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Statusi i Porosisë</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand:#dc3545;
      --ink:#111827;
      --muted:#6b7280;
      --radius:14px;
      --shadow:0 8px 24px rgba(0,0,0,.06);
      --ok:#16a34a;
      --warn:#f59e0b;
      --info:#0ea5e9;
    }
    body{ background:#f7f8fb; color:var(--ink) }
    .page-wrap{ max-width:1100px }
    .card-soft{ background:#fff;border:0;border-radius:var(--radius);box-shadow:var(--shadow) }
    .muted{ color:var(--muted) }
    .header-title{ display:flex; align-items:center; gap:.6rem }
    .header-title .dot{ width:10px;height:10px;border-radius:50%; background:var(--brand) }

    /* timeline */
    .step{ text-align:center; min-width:110px }
    .step .bubble{
      width:34px;height:34px;border-radius:50%;
      display:inline-flex;align-items:center;justify-content:center;
      background:#e5e7eb; color:#374151; font-weight:700
    }
    .step.active .bubble{ background:var(--brand); color:#fff }
    .step.done .bubble{ background:var(--ok); color:#fff }
    .step .label{ font-size:.85rem; margin-top:.35rem; color:#374151 }
    .divider{ height:2px; background:#e5e7eb; flex:1; margin:16px 0 0 0; border-radius:2px }
    .steps-wrap{ display:flex; align-items:flex-start; gap:8px; width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; padding-bottom:6px }

    /* tabela e artikujve */
    .thumb{ width:60px;height:60px;border-radius:10px;object-fit:cover;background:#f1f2f6 }
    .price{ font-weight:700 }

    @media (max-width: 575.98px){
      .header-grid{ grid-template-columns: 1fr !important }
      .table{ font-size:.925rem }
    }
  </style>
</head>
<body>

@php
  // ✅ FIX FOTO per ORDER ITEMS (track/show)
  $order_item_img = function($raw){
    $placeholder = asset('images/placeholder-product.png');
    if (empty($raw)) return $placeholder;

    // nese vjen array
    if (is_array($raw)) $raw = $raw[0] ?? null;
    if (empty($raw)) return $placeholder;

    $raw = trim((string)$raw);

    // JSON array string: ["a","b"]
    if (str_starts_with($raw, '[')) {
      $d = json_decode($raw, true);
      if (is_array($d) && !empty($d)) $raw = $d[0];
    }

    // URL që përmban JSON: https://domain.com/storage/[...]
    if (preg_match('/\[[^\]]+\]/', $raw, $m)) {
      $d = json_decode($m[0], true);
      if (is_array($d) && !empty($d)) $raw = $d[0];
    }

    if (empty($raw)) return $placeholder;

    // URL absolute
    if (preg_match('#^https?://#i', $raw)) {
      return $raw;
    }

    // normalizo path
    $clean = ltrim($raw, '/');
    $clean = preg_replace('#^(storage|public)/#', '', $clean);

    // nese është public/images/...
    if (str_starts_with($clean, 'images/')) return asset($clean);

    // default: storage public
    return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
  };
@endphp

<div class="container page-wrap py-4">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="header-title">
      <span class="dot"></span>
      <h1 class="h4 m-0">Statusi i Porosisë</h1>
    </div>
    <a class="btn btn-outline-secondary btn-sm" href="{{ url('/') }}">
      <i class="bi bi-arrow-left"></i> Kthehu te produktet
    </a>
  </div>

  {{-- Kartela e përmbledhjes së statusit --}}
  <div class="card-soft p-3 mb-3">
    <div class="row g-3 header-grid" style="display:grid;grid-template-columns:1.2fr 1fr;gap:12px">
      <div>
        <div class="mb-1">Kodi i gjurmimit:
          <strong>{{ $order->tracking_code ?? '—' }}</strong>
        </div>

        {{-- ✅ Numri unik i porosisë (me fallback te id/tracking_code) --}}
        @php
          $orderNumber = $order->order_number
                        ?? $order->number
                        ?? $order->reference
                        ?? $order->uuid
                        ?? $order->tracking_code
                        ?? $order->id;
        @endphp
        <div class="mb-1">Numri i porosisë: <strong>{{ $orderNumber }}</strong></div>

        <div class="mb-1">
          @php
            $raw = strtolower(trim((string)($order->status ?? '')));
            $aliases = [
              'pending'=>'pranuar','accepted'=>'pranuar','received'=>'pranuar','pranuar'=>'pranuar',
              'processing'=>'procesim','in_progress'=>'procesim','ne proces'=>'procesim','procesim'=>'procesim',
              'shipped'=>'derguar','sent'=>'derguar','derguar'=>'derguar',
              'delivered'=>'dorëzuar','completed'=>'dorëzuar','finished'=>'dorëzuar',
              'perfundoar'=>'dorëzuar','perfunduar'=>'dorëzuar','dorëzuar'=>'dorëzuar','dorezuar'=>'dorëzuar',
              'cancelled'=>'anuluar','canceled'=>'anuluar','anuluar'=>'anuluar',
            ];
            $status = $aliases[$raw] ?? ($raw ?: 'pranuar');
            $statusMap = [
              'pranuar'=>['txt'=>'Pranuar','class'=>'bg-info text-dark'],
              'procesim'=>['txt'=>'Në procesim','class'=>'bg-warning text-dark'],
              'derguar'=>['txt'=>'Dërguar','class'=>'bg-primary'],
              'dorëzuar'=>['txt'=>'Dorëzuar','class'=>'bg-success'],
              'anuluar'=>['txt'=>'Anuluar','class'=>'bg-danger'],
            ];
            $conf = $statusMap[$status] ?? ['txt'=>ucfirst($status),'class'=>'bg-secondary'];
          @endphp
          Statusi:
          <span class="badge {{ $conf['class'] }} text-uppercase">{{ $conf['txt'] }}</span>
        </div>

        <div class="text-muted small">
          Krijuar më: {{ optional($order->created_at)->format('d.m.Y H:i') }}
        </div>
      </div>

      {{-- Totalet --}}
      <div class="d-flex align-items-center justify-content-end gap-3">
        <div class="text-end">
          <div class="muted small">Totali</div>
          <div class="fs-4 fw-bold text-danger">€ {{ number_format($order->total ?? 0, 2) }}</div>
        </div>
      </div>
    </div>

    {{-- Timeline i statusit --}}
    @php
      $steps = ['Pranuar','Në procesim','Dërguar','Dorëzuar'];
      $index = match ($status) {
        'pranuar' => 0,
        'procesim' => 1,
        'derguar' => 2,
        'dorëzuar' => 3,
        default => 0
      };
    @endphp

    <div class="mt-3">
      <div class="steps-wrap">
        @for($i=0; $i<count($steps); $i++)
          <div class="step {{ $i < $index ? 'done' : ($i === $index ? 'active' : '') }}">
            <div class="bubble">{{ $i+1 }}</div>
            <div class="label">{{ $steps[$i] }}</div>
          </div>
          @if($i < count($steps)-1)
            <div class="divider {{ $i < $index ? 'active' : '' }}"></div>
          @endif
        @endfor
      </div>
    </div>
  </div>

  {{-- Artikujt e porosisë --}}
  <div class="card-soft p-3">
    <h6 class="fw-bold mb-3">Artikujt</h6>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr class="small text-uppercase text-muted">
            <th>Artikulli</th>
            <th>Dimensioni</th>
            <th class="text-end">Sasia</th>
            <th class="text-end">Çmimi</th>
            <th class="text-end">Totali</th>
          </tr>
        </thead>
        <tbody>
        @foreach($order->items as $it)
          @php
            $name  = $it->name ?? 'Produkt';
            $price = (float)($it->price ?? 0);
            $qty   = (int)($it->qty ?? 1);
            $size  = $it->size ?? '—';
            $line  = $price * $qty;

            // ✅ këtu e marrim foton
            $rawImg = $it->image ?? $it->image_path ?? null;
            $img = $order_item_img($rawImg);
          @endphp
          <tr>
            <td>
              <div class="d-flex align-items-center gap-2">
                <img class="thumb"
                     src="{{ $img }}"
                     alt="{{ $name }}"
                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                <div class="fw-semibold">{{ $name }}</div>
              </div>
            </td>
            <td class="text-muted">{{ $size }}</td>
            <td class="text-end">{{ $qty }}</td>
            <td class="text-end">€ {{ number_format($price, 2) }}</td>
            <td class="text-end price">€ {{ number_format($line, 2) }}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-end">Totali:</th>
            <th class="text-end price">€ {{ number_format($order->total ?? 0, 2) }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="d-flex justify-content-between mt-3">
    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Vazhdo blerjet
    </a>

    {{-- nëse e ki route për faturë, përdore kështu --}}
    {{-- <a href="{{ route('orders.invoice',$order) }}" class="btn btn-danger">
      <i class="bi bi-printer"></i> Printo faturën
    </a> --}}
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
