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
    .hero-actions{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      margin-top:18px;
    }
    .hero-actions .btn{
      border-radius:13px;
      font-weight:800;
      min-height:44px;
      display:inline-flex;
      align-items:center;
      gap:7px;
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
    .quick-card{
      height:100%;
      padding:18px;
      display:flex;
      align-items:center;
      gap:14px;
      color:var(--ink);
      transition:transform .18s ease, box-shadow .18s ease;
    }
    .quick-card:hover{
      transform:translateY(-2px);
      color:var(--ink);
      box-shadow:0 22px 55px rgba(15,23,42,.13);
    }
    .quick-icon{
      width:46px;
      height:46px;
      border-radius:15px;
      display:grid;
      place-items:center;
      color:var(--brand);
      background:rgba(220,53,69,.09);
      flex:0 0 auto;
      font-size:1.2rem;
    }
    .filter-form{
      display:grid;
      grid-template-columns:minmax(0, 1fr) auto auto;
      gap:10px;
      margin-top:16px;
    }
    .filter-pills{
      display:flex;
      flex-wrap:wrap;
      gap:8px;
      margin-top:14px;
    }
    .filter-pill{
      border:1px solid var(--line);
      border-radius:999px;
      padding:7px 12px;
      color:#374151;
      background:#fff;
      font-size:.84rem;
      font-weight:800;
    }
    .filter-pill.active{
      color:#fff;
      background:var(--brand);
      border-color:var(--brand);
    }
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
    .timeline{
      display:grid;
      grid-template-columns:repeat(4, minmax(0, 1fr));
      gap:8px;
      margin:14px 0 2px;
    }
    .timeline-step{
      min-height:54px;
      padding:10px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fff;
      color:var(--muted);
      font-size:.76rem;
      font-weight:800;
    }
    .timeline-step.done{
      border-color:rgba(22,101,52,.18);
      background:#f0fdf4;
      color:#166534;
    }
    .timeline-step.active{
      border-color:rgba(220,53,69,.25);
      background:rgba(220,53,69,.08);
      color:var(--brand);
    }
    .timeline-dot{
      width:22px;
      height:22px;
      display:inline-grid;
      place-items:center;
      margin-right:6px;
      border-radius:999px;
      background:#eef0f4;
    }
    .timeline-step.done .timeline-dot,
    .timeline-step.active .timeline-dot{
      color:#fff;
      background:currentColor;
    }
    .timeline-step.done .timeline-dot i,
    .timeline-step.active .timeline-dot i{ color:#fff; }
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
    .mini-list{ display:grid; gap:10px; }
    .mini-item{
      display:flex;
      justify-content:space-between;
      gap:12px;
      padding:12px;
      border:1px solid var(--line);
      border-radius:14px;
      background:#fafafa;
    }
    .service-list{
      display:grid;
      gap:10px;
      margin:0;
      padding:0;
      list-style:none;
    }
    .service-list li{
      display:flex;
      gap:10px;
      color:#374151;
      font-weight:600;
    }
    .service-list i{ color:var(--brand); margin-top:2px; }

    @media (max-width:767.98px){
      .topbar{ align-items:flex-start; flex-direction:column; }
      .top-actions{ width:100%; justify-content:stretch; }
      .top-actions .btn, .top-actions form{ flex:1; }
      .top-actions form .btn{ width:100%; }
      .hero{ padding:22px; border-radius:22px; }
      .hero-actions .btn{ width:100%; justify-content:center; }
      .order-head{ flex-direction:column; }
      .profile-line{ flex-direction:column; gap:4px; }
      .filter-form{ grid-template-columns:1fr; }
      .timeline{ grid-template-columns:1fr 1fr; }
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
  $statusSteps = [
    'new' => ['label' => 'Pranuar', 'icon' => 'bi-receipt'],
    'processing' => ['label' => 'Në proces', 'icon' => 'bi-hourglass-split'],
    'completed' => ['label' => 'Përfunduar', 'icon' => 'bi-check2-circle'],
    'canceled' => ['label' => 'Anuluar', 'icon' => 'bi-x-circle'],
  ];

  $imgUrl = function($raw){
    $placeholder = asset('images/placeholder-product.png');
    if (empty($raw)) return $placeholder;
    if (is_array($raw)) $raw = $raw[0] ?? null;
    if (empty($raw)) return $placeholder;

    $raw = trim((string) $raw);
    $raw = urldecode($raw);
    if (preg_match('/\[[^\]]+\]/', $raw, $match)) {
      $decoded = json_decode($match[0], true);
      if (is_array($decoded) && !empty($decoded)) $raw = $decoded[0];
    }
    if (str_starts_with($raw, '[')) {
      $decoded = json_decode($raw, true);
      if (is_array($decoded) && !empty($decoded)) $raw = $decoded[0];
    }

    $raw = trim((string) $raw, " \t\n\r\0\x0B\"'");

    if (preg_match('#^https?://#i', $raw)) {
      if (str_contains($raw, '/storage/images/')) {
        return str_replace('/storage/images/', '/images/', $raw);
      }

      return $raw;
    }

    $clean = ltrim($raw, '/');
    $clean = preg_replace('#^(storage|public)/#', '', $clean);
    if (str_starts_with($clean, 'images/')) return asset($clean);
    if (str_starts_with($clean, 'products/')) return asset('images/'.$clean);

    return asset('images/products/'.$clean);
  };

  $progressIndex = function($orderStatus){
    return match ($orderStatus) {
      'new' => 0,
      'processing' => 1,
      'completed' => 2,
      'canceled' => 3,
      default => 0,
    };
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
    <div class="hero-actions">
      <a href="{{ route('home') }}" class="btn btn-light">
        <i class="bi bi-shop"></i> Vazhdo blerjet
      </a>
      <a href="{{ route('track.form') }}" class="btn btn-outline-light">
        <i class="bi bi-geo-alt"></i> Gjurmo porosi
      </a>
      <a href="https://wa.me/38344960661?text={{ urlencode('Pershendetje Brillant! Kam pyetje rreth llogarise/porosise sime.') }}" target="_blank" rel="noopener" class="btn btn-outline-light">
        <i class="bi bi-whatsapp"></i> WhatsApp
      </a>
    </div>
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

  <section class="row g-3 mb-4">
    <div class="col-md-4">
      <a class="card-soft quick-card" href="{{ route('cart.index') }}">
        <span class="quick-icon"><i class="bi bi-bag-check"></i></span>
        <span>
          <strong class="d-block">Shporta ime</strong>
          <small class="muted">Vazhdo porosinë aty ku e le.</small>
        </span>
      </a>
    </div>
    <div class="col-md-4">
      <a class="card-soft quick-card" href="{{ route('track.form') }}">
        <span class="quick-icon"><i class="bi bi-truck"></i></span>
        <span>
          <strong class="d-block">Gjurmo porosinë</strong>
          <small class="muted">Kontrollo statusin me kod.</small>
        </span>
      </a>
    </div>
    <div class="col-md-4">
      <a class="card-soft quick-card" href="{{ route('contact') }}">
        <span class="quick-icon"><i class="bi bi-headset"></i></span>
        <span>
          <strong class="d-block">Ndihmë & kontakt</strong>
          <small class="muted">Pyetje për produkt ose porosi.</small>
        </span>
      </a>
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
              @foreach($byStatus as $statusKey => $count)
                @php $meta = $statusMap[$statusKey] ?? ['label' => $statusKey, 'class' => 'status-canceled', 'icon' => 'bi-circle']; @endphp
                <span class="status-badge {{ $meta['class'] }}">
                  {{ $meta['label'] }}: {{ $count }}
                </span>
              @endforeach
            </div>
          </div>

          <form class="filter-form" method="GET" action="{{ route('account.dashboard') }}">
            <input
              type="search"
              name="q"
              value="{{ $search }}"
              class="form-control"
              placeholder="Kërko me numër porosie, kod gjurmimi, emër ose telefon">
            @if($status)
              <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <button class="btn btn-dark" type="submit">
              <i class="bi bi-search me-1"></i> Kërko
            </button>
            <a class="btn btn-outline-secondary" href="{{ route('account.dashboard') }}">Pastro</a>
          </form>

          <div class="filter-pills">
            <a class="filter-pill {{ !$status ? 'active' : '' }}" href="{{ route('account.dashboard', ['q' => $search ?: null]) }}">Të gjitha</a>
            @foreach($statusMap as $key => $meta)
              <a class="filter-pill {{ $status === $key ? 'active' : '' }}" href="{{ route('account.dashboard', ['status' => $key, 'q' => $search ?: null]) }}">
                {{ $meta['label'] }} ({{ $byStatus[$key] ?? 0 }})
              </a>
            @endforeach
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

            @php $currentIndex = $progressIndex($order->status); @endphp
            <div class="timeline">
              @foreach($statusSteps as $stepKey => $step)
                @php
                  $stepIndex = $progressIndex($stepKey);
                  $stepClass = $order->status === 'canceled'
                    ? ($stepKey === 'canceled' ? 'active' : '')
                    : ($stepIndex < $currentIndex ? 'done' : ($stepIndex === $currentIndex ? 'active' : ''));
                @endphp
                <div class="timeline-step {{ $stepClass }}">
                  <span class="timeline-dot"><i class="bi {{ $step['icon'] }}"></i></span>
                  {{ $step['label'] }}
                </div>
              @endforeach
            </div>

            @foreach($order->items as $item)
              <div class="item-row">
                <img
                  class="item-thumb"
                  src="{{ $imgUrl($item->image ?: optional($item->product)->image_path) }}"
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

            <div class="d-flex flex-wrap gap-2 mt-3">
              <a href="https://wa.me/38344960661?text={{ urlencode('Pershendetje! Kam pyetje per porosine #'.$order->id.' - Kodi: '.($order->tracking_code ?? '-')) }}" target="_blank" rel="noopener" class="btn btn-success btn-sm">
                <i class="bi bi-whatsapp me-1"></i> Pyet për porosinë
              </a>
              @if($order->tracking_code)
                <a href="{{ route('track.show', $order->tracking_code) }}" class="btn btn-outline-dark btn-sm">
                  <i class="bi bi-truck me-1"></i> Status i plotë
                </a>
              @endif
              <a href="{{ route('home') }}" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-arrow-repeat me-1"></i> Porosit prapë
              </a>
            </div>
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
        <h2 class="section-title h5 mb-3">Adresa e fundit</h2>
        @if($lastOrder)
          <div class="profile-line">
            <span class="muted">Klienti</span>
            <strong>{{ $lastOrder->name }}</strong>
          </div>
          <div class="profile-line">
            <span class="muted">Telefoni</span>
            <strong>{{ $lastOrder->phone }}</strong>
          </div>
          <div class="profile-line">
            <span class="muted">Adresa</span>
            <strong class="text-end">{{ $lastOrder->address }}@if($lastOrder->city), {{ $lastOrder->city }}@endif</strong>
          </div>
        @else
          <p class="muted mb-0">Adresa shfaqet pasi të bësh porosinë e parë.</p>
        @endif
      </aside>

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

      <aside class="card-soft p-3 p-md-4 mb-4">
        <h2 class="section-title h5 mb-3">Produktet e fundit</h2>
        @if($recentItems->count())
          <div class="mini-list">
            @foreach($recentItems as $recent)
              <div class="mini-item">
                <div>
                  <strong>{{ $recent->name }}</strong>
                  <div class="muted small">Sasia: {{ $recent->qty }}</div>
                </div>
                <span class="money">{{ number_format((float) $recent->price, 2) }} €</span>
              </div>
            @endforeach
          </div>
        @else
          <p class="muted mb-0">Sapo të porosisësh, produktet e fundit dalin këtu.</p>
        @endif
      </aside>

      <aside class="card-soft p-3 p-md-4 mb-4">
        <h2 class="section-title h5 mb-3">Më të porositurat</h2>
        @if($topItems->count())
          <div class="mini-list">
            @foreach($topItems as $top)
              <div class="mini-item">
                <strong>{{ $top->name }}</strong>
                <span class="status-badge status-completed">{{ $top->qty }} copë</span>
              </div>
            @endforeach
          </div>
        @else
          <p class="muted mb-0">Këtu dalin produktet që i blen më shpesh.</p>
        @endif
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

      <aside class="card-soft p-3 p-md-4 mt-4">
        <h2 class="section-title h5 mb-3">Shërbime për klient</h2>
        <ul class="service-list">
          <li><i class="bi bi-check-circle"></i> Gjurmo çdo porosi me kodin unik.</li>
          <li><i class="bi bi-check-circle"></i> Kontakto shpejt në WhatsApp për ndryshime.</li>
          <li><i class="bi bi-check-circle"></i> Shiko historikun dhe totalet e blerjeve.</li>
          <li><i class="bi bi-check-circle"></i> Ndrysho fjalëkalimin pa kontaktuar adminin.</li>
        </ul>
      </aside>
    </div>
  </div>
</main>

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
