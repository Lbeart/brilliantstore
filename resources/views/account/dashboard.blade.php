<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Llogaria ime - Brillant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">

  <style>
    :root{
      --brand:#dc3545;
      --brand-dark:#b52a37;
      --ink:#111827;
      --muted:#6b7280;
      --line:#e5e7eb;
      --soft:#f7f8fb;
      --shadow:0 18px 45px rgba(15,23,42,.10);
      --radius:18px;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      min-height:100vh;
      font-family:"Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      color:var(--ink);
      background:
        radial-gradient(900px 420px at 0% 0%, rgba(220,53,69,.12), transparent 55%),
        radial-gradient(900px 420px at 100% 0%, rgba(255,193,7,.10), transparent 55%),
        var(--soft);
    }

    a{ text-decoration:none; }
    .page-wrap{ max-width:1180px; }
    .topbar{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:16px;
      padding:24px 0 18px;
    }
    .brand{
      display:flex;
      align-items:center;
      gap:12px;
      color:var(--ink);
      font-weight:900;
    }
    .brand img{
      width:52px;
      height:52px;
      object-fit:contain;
      background:#fff;
      border-radius:14px;
      padding:6px;
      box-shadow:0 10px 24px rgba(15,23,42,.08);
    }
    .top-actions{ display:flex; flex-wrap:wrap; gap:10px; justify-content:flex-end; }
    .hero{
      border-radius:28px;
      padding:28px;
      color:#fff;
      background:
        linear-gradient(135deg, rgba(15,23,42,.92), rgba(15,23,42,.55)),
        url("{{ asset('slider/raffaello.jpg') }}") center/cover no-repeat;
      box-shadow:var(--shadow);
      overflow:hidden;
    }
    .hero h1{
      margin:0;
      font-size:clamp(1.8rem, 4vw, 3.1rem);
      font-weight:900;
      letter-spacing:0;
      line-height:1.08;
    }
    .hero p{
      margin:.75rem 0 0;
      max-width:720px;
      color:rgba(255,255,255,.86);
      line-height:1.7;
      font-weight:500;
    }
    .card-soft{
      background:#fff;
      border:1px solid rgba(17,24,39,.06);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
    }
    .stat-card{
      height:100%;
      padding:18px;
    }
    .stat-icon{
      width:42px;
      height:42px;
      display:grid;
      place-items:center;
      border-radius:14px;
      color:var(--brand);
      background:rgba(220,53,69,.09);
      font-size:1.2rem;
    }
    .stat-label{
      color:var(--muted);
      font-size:.86rem;
      font-weight:700;
      margin-top:14px;
    }
    .stat-value{
      font-size:1.55rem;
      font-weight:900;
      line-height:1.1;
      margin-top:4px;
    }
    .section-title{
      font-weight:900;
      margin:0;
    }
    .muted{ color:var(--muted); }
    .order-card{
      padding:18px;
      border-bottom:1px solid var(--line);
    }
    .order-card:last-child{ border-bottom:0; }
    .order-head{
      display:flex;
      justify-content:space-between;
      align-items:flex-start;
      gap:16px;
      margin-bottom:14px;
    }
    .status-badge{
      display:inline-flex;
      align-items:center;
      gap:6px;
      border-radius:999px;
      padding:7px 11px;
      font-size:.78rem;
      font-weight:900;
      text-transform:uppercase;
      white-space:nowrap;
    }
    .status-new{ color:#1d4ed8; background:#dbeafe; }
    .status-processing{ color:#92400e; background:#fef3c7; }
    .status-completed{ color:#166534; background:#dcfce7; }
    .status-canceled{ color:#6b7280; background:#f3f4f6; }
    .item-row{
      display:flex;
      gap:12px;
      align-items:center;
      padding:10px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fafafa;
      margin-top:10px;
    }
    .item-thumb{
      width:58px;
      height:58px;
      border-radius:12px;
      object-fit:cover;
      background:#eef0f4;
      flex:0 0 auto;
    }
    .item-name{
      font-weight:800;
      margin-bottom:2px;
    }
    .money{ color:var(--brand); font-weight:900; }
    .profile-line{
      display:flex;
      justify-content:space-between;
      gap:14px;
      padding:13px 0;
      border-bottom:1px solid var(--line);
    }
    .profile-line:last-child{ border-bottom:0; }
    .form-control{
      min-height:48px;
      border-radius:13px;
      border-color:var(--line);
      font-weight:600;
    }
    .form-control:focus{
      border-color:rgba(220,53,69,.6);
      box-shadow:0 0 0 4px rgba(220,53,69,.12);
    }
    .btn-brand{
      border:0;
      border-radius:13px;
      background:linear-gradient(135deg, var(--brand), var(--brand-dark));
      color:#fff;
      font-weight:900;
      min-height:48px;
      box-shadow:0 12px 24px rgba(220,53,69,.22);
    }
    .btn-brand:hover{ color:#fff; filter:brightness(.98); }
    .empty-state{
      padding:34px 18px;
      text-align:center;
      color:var(--muted);
    }
    .empty-state i{
      width:58px;
      height:58px;
      display:grid;
      place-items:center;
      margin:0 auto 12px;
      border-radius:18px;
      color:var(--brand);
      background:rgba(220,53,69,.09);
      font-size:1.6rem;
    }

    @media (max-width:767.98px){
      .topbar{ align-items:flex-start; flex-direction:column; }
      .top-actions{ width:100%; justify-content:stretch; }
      .top-actions .btn, .top-actions form{ flex:1; }
      .top-actions form .btn{ width:100%; }
      .hero{ padding:22px; border-radius:22px; }
      .order-head{ flex-direction:column; }
      .profile-line{ flex-direction:column; gap:4px; }
    }
  </style>
</head>
<body>
@php
  $statusMap = [
    'new' => ['label' => 'E re', 'class' => 'status-new', 'icon' => 'bi-stars'],
    'processing' => ['label' => 'Në proces', 'class' => 'status-processing', 'icon' => 'bi-hourglass-split'],
    'completed' => ['label' => 'E përfunduar', 'class' => 'status-completed', 'icon' => 'bi-check-circle'],
    'canceled' => ['label' => 'E anuluar', 'class' => 'status-canceled', 'icon' => 'bi-x-circle'],
  ];

  $imgUrl = function($raw){
    $placeholder = asset('images/placeholder-product.png');
    if (empty($raw)) return $placeholder;
    if (is_array($raw)) $raw = $raw[0] ?? null;
    if (empty($raw)) return $placeholder;

    $raw = trim((string) $raw);
    if (str_starts_with($raw, '[')) {
      $decoded = json_decode($raw, true);
      if (is_array($decoded) && !empty($decoded)) $raw = $decoded[0];
    }
    if (preg_match('#^https?://#i', $raw)) return $raw;

    $clean = ltrim($raw, '/');
    $clean = preg_replace('#^(storage|public)/#', '', $clean);
    if (str_starts_with($clean, 'images/')) return asset($clean);
    if (str_starts_with($clean, 'products/')) return asset('images/'.$clean);

    return asset('images/products/'.$clean);
  };
@endphp

<main class="container page-wrap pb-5">
  <div class="topbar">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('images/llogo.png') }}" alt="Brillant">
      <span>Brillant</span>
    </a>

    <div class="top-actions">
      <a href="{{ route('home') }}" class="btn btn-outline-dark">
        <i class="bi bi-house me-1"></i> Ballina
      </a>
      <a href="{{ route('cart.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-bag me-1"></i> Shporta
      </a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-dark" type="submit">
          <i class="bi bi-box-arrow-right me-1"></i> Dil
        </button>
      </form>
    </div>
  </div>

  <section class="hero mb-4">
    <h1>Llogaria ime</h1>
    <p>Mirë se erdhe, {{ $user->name }}. Këtu i sheh porositë, statusin, kodin e gjurmimit dhe mund ta ndryshosh fjalëkalimin.</p>
  </section>

  @if(session('password_success'))
    <div class="alert alert-success card-soft">{{ session('password_success') }}</div>
  @endif

  <section class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="card-soft stat-card">
        <div class="stat-icon"><i class="bi bi-receipt"></i></div>
        <div class="stat-label">Porosi gjithsej</div>
        <div class="stat-value">{{ $stats['orders_count'] }}</div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-soft stat-card">
        <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-label">Vlera totale</div>
        <div class="stat-value">{{ number_format((float) $stats['orders_total'], 2) }} €</div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-soft stat-card">
        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
        <div class="stat-label">Produkte të porositura</div>
        <div class="stat-value">{{ (int) $stats['items_count'] }}</div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card-soft stat-card">
        <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
        <div class="stat-label">Porosia e fundit</div>
        <div class="stat-value" style="font-size:1.05rem;">
          {{ $stats['last_order_at'] ? $stats['last_order_at']->format('d.m.Y') : '—' }}
        </div>
      </div>
    </div>
  </section>

  <div class="row g-4">
    <div class="col-lg-8">
      <section class="card-soft">
        <div class="p-3 p-md-4 border-bottom">
          <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
              <h2 class="section-title h4">Porositë e mia</h2>
              <div class="muted small">Shfaqen porositë e lidhura me llogarinë ose emailin tënd.</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
              @foreach($byStatus as $status => $count)
                @php $meta = $statusMap[$status] ?? ['label' => $status, 'class' => 'status-canceled', 'icon' => 'bi-circle']; @endphp
                <span class="status-badge {{ $meta['class'] }}">
                  {{ $meta['label'] }}: {{ $count }}
                </span>
              @endforeach
            </div>
          </div>
        </div>

        @forelse($orders as $order)
          @php $meta = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'status-canceled', 'icon' => 'bi-circle']; @endphp
          <article class="order-card">
            <div class="order-head">
              <div>
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                  <h3 class="h5 fw-black mb-0" style="font-weight:900;">Porosia #{{ $order->id }}</h3>
                  <span class="status-badge {{ $meta['class'] }}">
                    <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                  </span>
                </div>
                <div class="muted small">
                  {{ $order->created_at->format('d.m.Y H:i') }}
                  @if($order->tracking_code)
                    <span class="mx-1">•</span>
                    Kodi: <strong>{{ $order->tracking_code }}</strong>
                  @endif
                </div>
              </div>
              <div class="text-lg-end">
                <div class="muted small">Totali</div>
                <div class="money fs-5">{{ number_format((float) $order->total, 2) }} €</div>
                @if($order->tracking_code)
                  <a href="{{ route('track.show', $order->tracking_code) }}" class="btn btn-outline-danger btn-sm mt-2">
                    <i class="bi bi-geo-alt me-1"></i> Gjurmo
                  </a>
                @endif
              </div>
            </div>

            @foreach($order->items as $item)
              <div class="item-row">
                <img
                  class="item-thumb"
                  src="{{ $imgUrl($item->image) }}"
                  alt="{{ $item->name }}"
                  onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                <div class="flex-grow-1">
                  <div class="item-name">{{ $item->name }}</div>
                  @if($item->size)
                    <div class="muted small" style="white-space:pre-line;">{{ $item->size }}</div>
                  @endif
                  <div class="muted small">Sasia: {{ $item->qty }} • Çmimi: {{ number_format((float) $item->price, 2) }} €</div>
                </div>
                <div class="money text-end">{{ number_format((float) $item->price * (int) $item->qty, 2) }} €</div>
              </div>
            @endforeach
          </article>
        @empty
          <div class="empty-state">
            <i class="bi bi-bag"></i>
            <h3 class="h5 fw-bold text-dark">Ende nuk ke porosi</h3>
            <p class="mb-3">Kur bën porosi me këtë llogari ose me këtë email, ato shfaqen këtu.</p>
            <a href="{{ route('home') }}" class="btn btn-brand px-4">Shiko produktet</a>
          </div>
        @endforelse

        @if($orders->hasPages())
          <div class="p-3 p-md-4 border-top">
            {{ $orders->links('pagination::bootstrap-5') }}
          </div>
        @endif
      </section>
    </div>

    <div class="col-lg-4">
      <aside class="card-soft p-3 p-md-4 mb-4">
        <h2 class="section-title h5 mb-3">Profili</h2>
        <div class="profile-line">
          <span class="muted">Emri</span>
          <strong>{{ $user->name }}</strong>
        </div>
        <div class="profile-line">
          <span class="muted">Email</span>
          <strong class="text-break">{{ $user->email }}</strong>
        </div>
        <div class="profile-line">
          <span class="muted">Llogaria</span>
          <strong>{{ $user->created_at->format('d.m.Y') }}</strong>
        </div>
      </aside>

      <aside class="card-soft p-3 p-md-4">
        <h2 class="section-title h5 mb-1">Ndrysho fjalëkalimin</h2>
        <p class="muted small mb-3">Përdor fjalëkalim të ri me së paku 6 karaktere.</p>

        <form action="{{ route('account.password.update') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="current_password" class="form-label fw-bold">Fjalëkalimi aktual</label>
            <input
              type="password"
              id="current_password"
              name="current_password"
              class="form-control @error('current_password') is-invalid @enderror"
              autocomplete="current-password"
              required>
            @error('current_password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Fjalëkalimi i ri</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control @error('password') is-invalid @enderror"
              autocomplete="new-password"
              required>
            @error('password')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Konfirmo fjalëkalimin</label>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              class="form-control"
              autocomplete="new-password"
              required>
          </div>

          <button class="btn btn-brand w-100" type="submit">
            <i class="bi bi-shield-lock me-1"></i> Ruaj fjalëkalimin
          </button>
        </form>
      </aside>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
