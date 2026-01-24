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
  // ✅ FIX FOTO vetëm për këtë faqe (Admin Order Show) – s’prek sen tjetër
  $order_item_img_url = function($raw){
    $placeholder = asset('images/placeholder-product.png');
    if (empty($raw)) return $placeholder;

    // array -> merr të parën jo-bosh
    if (is_array($raw)) {
      $raw = collect($raw)->first(fn($x) => !empty($x)) ?? null;
      if (empty($raw)) return $placeholder;
    }

    $raw = trim((string)$raw);

    // ✅ 1) Nëse vjen URL me JSON mbrenda: .../storage/[...]
    if (preg_match('/\[[^\]]+\]/', $raw, $m)) {
      $json = str_replace(['\/','\\\/'], '/', $m[0]);  // unescape slashes
      $arr  = json_decode($json, true);
      if (is_array($arr) && !empty($arr)) {
        $raw = $arr[0];
      }
    }
    // ✅ 2) Nëse vjen JSON string direkt: ["a","b"]
    elseif (str_starts_with($raw, '[')) {
      $json = str_replace(['\/','\\\/'], '/', $raw);
      $arr  = json_decode($json, true);
      if (is_array($arr) && !empty($arr)) {
        $raw = $arr[0];
      }
    }

    if (empty($raw)) return $placeholder;

    // ✅ 3) Nëse është URL absolute e rregullt (pa JSON) – ktheje siç është
    // (tani JSON rastin e kemi kap më lart)
    if (preg_match('#^https?://#i', $raw)) {
      return $raw;
    }

    // ✅ 4) normalizo path
    $clean = ltrim($raw, '/');
    $clean = str_replace('\\', '/', $clean);

    // heq public/ nëse vjen
    $clean = preg_replace('#^(public/)+#', '', $clean);

    // nëse vjen storage/...
    if (str_starts_with($clean, 'storage/')) {
      // kjo kthen /storage/...
      return asset($clean);
    }

    // public/images/...
    if (str_starts_with($clean, 'images/')) {
      return asset($clean);
    }

    // nëse vjen si products/uuid.jpg (shumicën e rasteve)
    // ose çkado në disk 'public'
    return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
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
            @foreach($order->items as $it)
              @php
                $line = (float)$it->price * (int)$it->qty;

                // ✅ VETËM KJO: e nxjerr foton saktë
                $imgSrc = $order_item_img_url($it->image ?? $it->image_path ?? null);
              @endphp
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img
                      src="{{ $imgSrc }}"
                      class="summary-thumb"
                      alt="{{ $it->name }}"
                      onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                    <div class="fw-semibold">{{ $it->name }}</div>
                  </div>
                </td>
                <td>{{ $it->size ?? '—' }}</td>
                <td>{{ $it->qty }}</td>
                <td>{{ number_format($it->price,2) }} €</td>
                <td>{{ number_format($line,2) }} €</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Klienti + Pagesa + Statusi + Aksionet -->
    <div class="col-lg-5">
      <div class="card-soft p-3 mb-3">
        <h6 class="mb-3">Klienti</h6>
        <div><strong>{{ $order->name }}</strong></div>
        <div class="small">📞 {{ $order->phone }} @if($order->email) | ✉️ {{ $order->email }} @endif</div>
        <div class="small text-muted">
          {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif
        </div>
        @if($order->notes)
          <div class="small mt-2">📝 {{ $order->notes }}</div>
        @endif
      </div>

      <div class="card-soft p-3 mb-3">
        <h6 class="mb-3">Pagesa & Totali</h6>
        <div class="d-flex justify-content-between"><span>Mënyra</span><span class="text-uppercase">{{ $order->payment }}</span></div>
        <div class="d-flex justify-content-between"><span>Totali</span><span class="fw-bold">{{ number_format($order->total,2) }} €</span></div>
        <div class="d-flex justify-content-between"><span>Krijuar më</span><span class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</span></div>
      </div>

      <div class="card-soft p-3">
        <h6 class="mb-3">Verifiko / Ndrysho statusin</h6>
        @php $map=['new'=>'primary','processing'=>'warning','completed'=>'success','canceled'=>'secondary']; @endphp
        <div class="mb-2">
          Statusi aktual:
          <span class="badge bg-{{ $map[$order->status] ?? 'secondary' }} badge-status text-uppercase">
            {{ $order->status }}
          </span>
        </div>
        <form method="POST" action="{{ route('admin.orders.status',$order) }}" class="d-flex gap-2 flex-wrap">
          @csrf
          <select name="status" class="form-select" style="max-width:260px">
            @foreach(['new'=>'Të reja','processing'=>'Në proces','completed'=>'Përfunduara','canceled'=>'Anuluara'] as $k=>$v)
              <option value="{{ $k }}" @selected($order->status===$k)>{{ $v }}</option>
            @endforeach
          </select>
          <button class="btn btn-danger">Ruaj</button>
        </form>
      </div>

      <!-- Aksione: email konfirmimi, email "nisur", fshi -->
      <div class="card-soft p-3 mt-3">
        <h6 class="mb-3">Aksione</h6>
        <div class="d-flex flex-wrap gap-2">
          @if($order->email)
            <form method="POST" action="{{ route('admin.orders.email', $order) }}">
              @csrf
              <button class="btn btn-outline-primary">
                ✉️ Dërgo email konfirmimi
              </button>
            </form>

            <form method="POST" action="{{ route('admin.orders.email_shipped', $order) }}">
              @csrf
              <button class="btn btn-primary">
                📦 Njofto: Porosia është nisur
              </button>
            </form>
          @else
            <div class="alert alert-warning mb-0 w-100">
              Kjo porosi nuk ka email – nuk mund të dërgosh njoftime.
            </div>
          @endif

          <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                onsubmit="return confirm('A je i sigurt që do ta fshish këtë porosi (#{{ $order->id }})?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">
              🗑️ Fshi porosinë
            </button>
          </form>
        </div>
        @if($order->email)
          <div class="small text-muted mt-2">Email dërgohet te: {{ $order->email }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
