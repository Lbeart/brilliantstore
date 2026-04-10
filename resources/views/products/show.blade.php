<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>{{ $product->name }} – Detaje</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  

  @php
    $isCurtain = str_contains(strtolower($product->category ?? ''), 'perde');
  @endphp

  @php
    // ✅ IMAGES: image_path mund të jetë JSON array ose string e vjetër
    $imgs = [];
    if (!empty($product->image_path)) {
      $d = json_decode($product->image_path, true);
      $imgs = is_array($d) ? $d : [$product->image_path];
    }
    $mainImg = $imgs[0] ?? null;

    $metaDesc = Str::limit(strip_tags($product->description ?? $product->name), 160);
  @endphp

  <meta name="description" content="{{ $metaDesc }}">
  <meta property="og:title" content="{{ $product->name }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:description" content="{{ $metaDesc }}">

  {{-- ✅ OG IMAGE: merre foton e parë --}}
  @if($mainImg)
    <meta property="og:image" content="{{ asset('storage/'.$mainImg) }}">
  @endif

  <style>
    :root{
      --card-radius:14px;
      --shadow-sm:0 4px 14px rgba(0,0,0,.08);
      --shadow-lg:0 12px 30px rgba(0,0,0,.10);
      --brand:#dc3545;
      --dark:#0f172a;
    }

    html,body{max-width:100%;overflow-x:hidden}
    *,*::before,*::after{box-sizing:border-box}
    img{max-width:100%;height:auto;display:block}

    body{
      background: radial-gradient(circle at top, #fef2f2 0, #f9fafb 40%, #f3f4f6 100%);
      font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif;
      padding-top:92px
    }

    /* NAVBAR */
    .navbar-custom{
      position:fixed;top:12px;left:50%;transform:translateX(-50%);
      width:min(1150px,94%);
      background:linear-gradient(135deg,#020617 0%,#111827 40%,#1f2937 100%);
      border-radius:18px;
      box-shadow:var(--shadow-sm);
      z-index:1000;
      padding:.65rem .9rem
    }
    .navbar-brand img{height:44px}
    .navbar-custom .nav-link{color:#fff!important;font-weight:600;letter-spacing:.2px}
    .navbar-custom .nav-link:hover{color:#e5e7eb!important}
    .dropdown-menu{
      border:0;border-radius:14px;padding:.5rem;
      box-shadow:var(--shadow-lg);background:#fff
    }
    .dropdown-item{border-radius:8px}
    .dropdown-item:hover{background:#f3f4f6}

    /* BACK BUTTON */
    .back-btn{
      position:fixed;top:90px;left:24px;z-index:1100;
      border:none;border-radius:999px;padding:.5rem .9rem;
      background:#fff;
      box-shadow:0 6px 20px rgba(0,0,0,.08);
      display:flex;align-items:center;gap:.4rem;
      color:#111827;font-size:.85rem
    }
    .back-btn:hover{background:#f7f7f7}

    /* HERO IMAGE */
    .product-hero{
      background:#fff;border-radius:16px;
      box-shadow:var(--shadow-sm);
      padding:16px;
      display:flex;align-items:center;justify-content:center;
      min-height:320px;position:relative
    }
    .product-hero img{
      width:100%;max-height:720px;
      object-fit:contain;border-radius:12px;
      user-select:none;-webkit-user-drag:none;
      touch-action: none;
    }
    .zoom-lens{
      position:absolute;display:none;width:180px;height:180px;
      border:1px solid rgba(0,0,0,.15);
      background:rgba(255,255,255,.18);
      backdrop-filter:blur(1px);
      border-radius:10px;pointer-events:none;
      box-shadow:0 6px 18px rgba(0,0,0,.08);
      cursor:crosshair
    }
    .zoom-pane{
      position:absolute;display:none;top:0;left:100%;margin-left:16px;
      width:380px;height:380px;border:1px solid #eee;
      border-radius:12px;background:#fff;
      box-shadow:var(--shadow-lg);background-repeat:no-repeat;
      overflow:hidden
    }
    @media (min-width:1400px){
      .zoom-pane{width:420px;height:420px}
    }

    /* ✅ THUMBNAILS */
    .thumb-row{
      display:flex;
      flex-wrap:wrap;
      gap:.55rem;
      margin-top:12px;
    }
    .thumb-btn{
      width:82px;
      height:82px;
      border:1px solid #e5e7eb;
      border-radius:12px;
      overflow:hidden;
      padding:0;
      background:#fff;
      box-shadow:0 3px 10px rgba(0,0,0,.04);
      transition:all .15s ease;
    }
    .thumb-btn img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }
    .thumb-btn:hover{transform:translateY(-1px); border-color:#d1d5db}
    .thumb-btn.active{
      border-color:rgba(220,53,69,.45);
      box-shadow:0 10px 22px rgba(220,53,69,.10);
    }

    /* PRODUCT INFO SIDE */
    h1,h2{color:#111827;font-weight:800}
    .bf-chip{
      display:inline-flex;
      align-items:center;
      gap:.35rem;
      font-size:.75rem;
      text-transform:uppercase;
      letter-spacing:.14em;
      background:#fee2e2;
      color:#7f1d1d;
      padding:.18rem .8rem;
      border-radius:999px;
      font-weight:700;
      margin-bottom:.5rem;
    }
    .bf-chip i{font-size:.9rem}

    .price-block{
      background:#fff;
      border-radius:14px;
      box-shadow:var(--shadow-sm);
      padding:12px 14px;
      margin-bottom:10px;
    }
    .price-now{color:var(--brand);font-weight:800;font-size:1.55rem}
    .price-old{
      color:#9ca3af;
      text-decoration:line-through;
      font-size:.9rem;
    }
    .price-badge{
      font-size:.7rem;
      text-transform:uppercase;
      letter-spacing:.12em;
      background:#e0f2fe;
      color:#075985;
      padding:.15rem .7rem;
      border-radius:999px;
      font-weight:700;
    }

    .stock-row{
      display:flex;
      align-items:center;
      gap:.5rem;
      font-size:.9rem;
      margin-bottom:12px;
    }
    .stock-label{
      font-weight:600;
      padding:.2rem .65rem;
      border-radius:999px;
      font-size:.8rem;
    }
    .stock.in{color:#198754;font-weight:600}
    .stock.out{color:#dc3545;font-weight:600}
    .stock-pill-in{background:#dcfce7;color:#166534}
    .stock-pill-out{background:#fee2e2;color:#991b1b}

    .section-card{
      background:#fff;
      border-radius:16px;
      box-shadow:var(--shadow-sm);
      padding:18px;
    }

    /* ✅ DIMENSION PILLS (si ne foto) */
    .dim-title{
      font-weight:800;
      color:#111827;
      margin:0 0 .5rem 0;
      font-size:.95rem;
    }
    .size-grid{
      display:flex;
      flex-wrap:wrap;
      gap:.55rem;
      align-items:center;
    }
    .size-pill{
      border:1px solid #e5e7eb;
      background:#fff;
      border-radius:999px;
      padding:.55rem .9rem;
      font-weight:700;
      font-size:.9rem;
      color:#111827;
      box-shadow:0 3px 10px rgba(0,0,0,.04);
      transition:all .15s ease;
      cursor:pointer;
      user-select:none;
      line-height:1;
      display:inline-flex;
      align-items:center;
      gap:.45rem;
    }
    .size-pill:hover{transform:translateY(-1px); border-color:#d1d5db}
    .size-pill.active{
      border-color:rgba(220,53,69,.35);
      background:rgba(220,53,69,.06);
      box-shadow:0 10px 22px rgba(220,53,69,.10);
    }
    .size-pill .dot{
      width:8px;height:8px;border-radius:50%;
      background:#e5e7eb;
      display:inline-block;
    }
    .size-pill.active .dot{ background:var(--brand); }
    .size-pill[disabled]{
      opacity:.55;
      cursor:not-allowed;
      text-decoration:line-through;
      box-shadow:none;
      transform:none;
    }

    /* ✅ Shipping / Payment info (si ne foto) */
    .info-list{
      margin:0;
      padding:0;
      list-style:none;
      display:grid;
      gap:.5rem;
    }
    .info-list li{
      display:flex;
      align-items:center;
      gap:.55rem;
      color:#111827;
      font-weight:600;
      font-size:.92rem;
    }
    .info-list i{
      color:#111827;
      opacity:.85;
    }
    .green-title{
      color:#16a34a;
      font-weight:900;
      margin-bottom:.6rem;
      font-size:1rem;
    }

    /* QTY & BUTTONS */
    .qty-btn{
      width:40px;height:40px;
      border:1px solid #dee2e6;
      background:#fff;border-radius:.375rem;
    }
    .qty-input{
      width:60px;height:40px;
      text-align:center;
      border:1px solid #dee2e6;border-radius:.375rem;
    }

    .btn-whatsapp{
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      background:#16a34a;
      border-color:#16a34a;
    }
    .btn-whatsapp:hover{
      background:#15803d;
      border-color:#15803d;
    }

    /* FULLSCREEN IMAGE MODAL */
    .img-modal{
      position:fixed;inset:0;
      background:rgba(0,0,0,.88);
      display:none;z-index:2000;
      align-items:center;justify-content:center
    }
    .img-modal.open{display:flex}
    .img-modal img{
      max-width:100%;max-height:100%;
      object-fit:contain;touch-action:pan-x pan-y;
      position:relative;z-index:2000
    }
    .img-modal .close-btn{
      position:absolute;top:14px;right:14px;
      background:#fff;border:none;border-radius:999px;
      padding:.55rem .75rem;
      box-shadow:0 6px 18px rgba(0,0,0,.25);
      display:flex;align-items:center;justify-content:center;
      z-index:2100;
    }

    /* RESPONSIVE */
    @media (max-width:991.98px){
      body{padding-top:86px}
      .navbar-custom{
        left:auto;right:auto;transform:none;
        inset:12px 8px auto 8px;width:auto;
        border-radius:12px;padding:.55rem .7rem
      }
      .navbar-brand img{height:38px}
      .container{padding-left:12px;padding-right:12px}
      .product-hero{padding:10px;min-height:auto}
      .product-hero img{max-height:420px;cursor:zoom-in}
      .zoom-pane,.zoom-lens{display:none!important}
      .back-btn{
        top:78px;left:8px;
        padding:.4rem .7rem;font-size:14px
      }
      .section-card{padding:14px}
      .size-pill{font-size:.88rem;padding:.52rem .85rem}
      .thumb-btn{width:70px;height:70px}
    }
    @media (max-width:576px){
      h1,h2,.h2{font-size:1.25rem}
      .price-now{font-size:1.25rem}
      .qty-btn,.qty-input{width:36px;height:36px;font-size:14px}
      .qty-input{width:50px}
      .btn{padding:.45rem .85rem;font-size:14px}
      .thumb-btn{width:64px;height:64px}
    }
    @media (max-width:991.98px){
      .zoom-pane{
        left:8px;
        right:8px;
        top:8px;
        width:auto;
        height:260px;
        margin:0;
        z-index:20;
        display:none;
      }

      .zoom-lens{
        width:120px;
        height:120px;
        border-radius:50%;
        display:none;
      }
    }

    .similar-box{
      background:#fff;
      border:1px solid #e5e7eb;
      border-radius:16px;
      padding:28px;
    }

    .similar-title{
      font-size:34px;
      font-weight:800;
      color:#111827;
      margin:0 0 22px 0;
    }

    .similar-grid{
      display:grid;
      grid-template-columns:repeat(5, minmax(0, 1fr));
      gap:22px;
    }

    /* karta */
    .similar-card{
      display:block;
      text-decoration:none;
      color:inherit;
      background:#fff;
      border:1px solid #e5e7eb;
      border-radius:14px;
      overflow:hidden;
    }

    .similar-card-inner{
      padding:16px;
      display:flex;
      flex-direction:column;
      height:100%;
    }

    /* image square */
    .similar-img{
      width:100%;
      aspect-ratio:1/1;
      border-radius:12px;
      overflow:hidden;
      background:#fff;
    }

    .similar-img img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    /* text */
    .similar-name{
      margin-top:14px;
      font-size:20px;
      font-weight:700;
      color:#111827;
      line-height:1.2;
    }

    .similar-price{
      margin-top:12px;
      font-size:24px;
      font-weight:900;
      color:#111827;
    }

    /* responsive si zakonisht */
    @media (max-width:1200px){
      .similar-grid{ grid-template-columns:repeat(4, minmax(0, 1fr)); }
    }
    @media (max-width:992px){
      .similar-grid{ grid-template-columns:repeat(3, minmax(0, 1fr)); }
      .similar-title{ font-size:28px; }
    }
    @media (max-width:576px){
      .similar-grid{ grid-template-columns:repeat(2, minmax(0, 1fr)); gap:14px; }
      .similar-box{ padding:16px; }
      .similar-title{ font-size:22px; margin-bottom:16px; }
      .similar-name{ font-size:16px; }
      .similar-price{ font-size:18px; }
    }

    .brillant-footer{
      width:100%;
      background: #0b1220;
      padding:58px 0 22px;
      color: rgba(255,255,255,.88);
    }

    .brillant-footer .footer-inner{
      max-width:1200px;
      margin:0 auto;
      padding:0 22px;
    }

    .footer-grid{
      display:grid;
      grid-template-columns: 1.2fr 1fr 1fr 0.7fr;
      gap:46px;
      align-items:start;
    }

    /* LEFT brand */
    .footer-brand{
      display:flex;
      flex-direction:column;
      gap:16px;
    }

    /* logo fix */
    .footer-logo-wrap{
      width: 220px;
      height: 110px;
      display:flex;
      align-items:center;
      justify-content:flex-start;
      padding: 0;
      background: transparent;
      border-radius: 0;
      box-shadow: none;
    }

    .footer-logo{
      max-width: 220px;
      max-height: 110px;
      width: auto;
      height: auto;
      object-fit: contain;
      display:block;
    }

    .footer-brand small{
      color: rgba(255,255,255,.75);
      font-weight:500;
    }
    .footer-brand .brand-name{
      font-weight:900;
      font-size:34px;
      color:#ffffff;
      line-height:1;
    }

    /* columns */
    .footer-col h4{
      font-size:15px;
      font-weight:900;
      letter-spacing:.08em;
      color:#ffffff;
      margin:0 0 14px 0;
    }

    .footer-links{
      list-style:none;
      padding:0;
      margin:0;
      display:grid;
      gap:8px;
    }

    .footer-links a{
      color: rgba(255,255,255,.82);
      text-decoration:none;
      font-weight:500;
    }
    .footer-links a:hover{
      color:#ffffff;
      text-decoration:underline;
    }

    /* socials */
    .footer-social{
      margin-top:28px;
      display:flex;
      gap:16px;
      align-items:center;
    }
    .footer-social a{
      color:#ffffff;
      font-size:26px;
      text-decoration:none;
      opacity:.9;
    }
    .footer-social a:hover{opacity:.7;}

    /* bottom */
    .footer-bottom{
      margin-top:34px;
      padding-top:16px;
      border-top: 1px solid rgba(255,255,255,.10);
      display:grid;
      grid-template-columns: 1fr 1fr 1fr;
      align-items:center;
      font-weight:500;
      color: rgba(255,255,255,.65);
      font-size:14px;
    }
    .footer-bottom .center{ text-align:center; }
    .footer-bottom .right{ text-align:right; }

    /* responsive */
    @media (max-width:992px){
      .footer-grid{
        grid-template-columns: 1fr 1fr;
        gap:28px;
      }
      .footer-bottom{
        grid-template-columns:1fr;
        gap:8px;
        text-align:center;
      }
      .footer-bottom .right{ text-align:center; }
    }
    @media (max-width:576px){
      .brillant-footer{ padding:40px 0 16px; }
      .footer-grid{ grid-template-columns: 1fr; }
      .footer-logo-wrap{ width:110px; height:110px; }
    }

    .fold-grid{
      display:grid;
      grid-template-columns:repeat(4, minmax(0,1fr));
      gap:12px;
      padding:12px;
      border:1px solid #e5e7eb;
      border-radius:12px;
      background:#fff;
    }
    .fold-item{ position:relative; }
    .fold-radio{ position:absolute; opacity:0; pointer-events:none; }
    .fold-card{
      display:block;
      cursor:pointer;
      border:1px solid #e5e7eb;
      border-radius:12px;
      padding:10px;
      background:#fff;
      transition:all .15s ease;
      height:100%;
    }
    .fold-img{
      width:100%;
      aspect-ratio:1/1;
      border-radius:10px;
      overflow:hidden;
      background:#f3f4f6;
    }
    .fold-img img{ width:100%; height:100%; object-fit:cover; display:block; }
    .fold-name{ margin-top:10px; font-weight:800; font-size:13px; color:#111827; line-height:1.15; }
    .fold-extra{ margin-top:4px; font-size:12px; color:#b45309; font-weight:700; }

    .fold-card:hover{ border-color:#d1d5db; transform:translateY(-1px); }
    .fold-radio:checked + .fold-card{
      border-color:rgba(220,53,69,.55);
      box-shadow:0 12px 26px rgba(220,53,69,.12);
      transform:translateY(-2px);
    }

    @media(max-width:992px){ .fold-grid{ grid-template-columns:repeat(3, 1fr);} }
    @media(max-width:576px){ .fold-grid{ grid-template-columns:repeat(2, 1fr); gap:10px; } }
  </style>
  <script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "Product",
 "name": "{{ $product->name }}",
 "image": "{{ $mainImg ? asset('storage/'.$mainImg) : '' }}",
 "description": "{{ $metaDesc }}",
 "offers": {
   "@type": "Offer",
   "price": "{{ $product->price }}",
   "priceCurrency": "EUR",
   "availability": "https://schema.org/{{ ($product->stock ?? 0) > 0 ? 'InStock' : 'OutOfStock' }}"
 }
}
</script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Kryemeny">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
    </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

        <li class="nav-item">
          @php
            $rawcat = strtolower($product->category ?? '');
            $cat = str_replace([' ', '_'], '-', $rawcat);
            $map = [
              'tepiha'         => 'products.tepiha',
              'mbulesa'        => 'products.mbulesa',
              'perde-ditore'   => 'products.perdeDitore',
              'perde-anesore'  => 'products.anesore',
              'jastekdekorues' => 'products.jastekdekorues',
              'postava'        => 'products.postava',
              'garnishte'      => 'products.garnishte',
              'tepihebanjo'    => 'products.tepihebanjo',
              'batanije'       => 'products.batanije',
            ];
          @endphp
          @if(isset($map[$cat]))
            <a class="nav-link" href="{{ route($map[$cat]) }}">{{ ucwords(str_replace(['-', '_'], ' ', $cat)) }}</a>
          @else
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          @endif
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>

        @auth
          <li class="nav-item dropdown ms-lg-2">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
               href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
              <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              @if(auth()->user()->role === 'admin')
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li><hr class="dropdown-divider"></li>
              @endif
              <li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">Log out</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-lg-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Log in</a>
          </li>
        @endauth

        {{-- Shporta + Gjurmo --}}
        <li class="nav-item dropdown ms-lg-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
             href="#" id="cartDropdown" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bag"></i> Shporta
            <span class="badge bg-danger rounded-pill ms-1 cart-badge">
              {{ session('cart_total_qty', 0) }}
            </span>
          </a>

          <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="cartDropdown" style="min-width: 320px;">
            <div class="small text-muted mb-2">Gjurmo porosinë</div>
            <form class="d-flex align-items-stretch gap-2"
                  onsubmit="event.preventDefault();
                            const el=this.querySelector('#trackCodeNav');
                            const v=(el?.value||'').trim();
                            if(v){ window.location='{{ url('/track') }}/'+encodeURIComponent(v); }">
              <div class="input-group input-group-sm">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input id="trackCodeNav" type="text" class="form-control"
                       placeholder="p.sh. BRL-LKNJ-0YXN" autocomplete="off" required>
                <button class="btn btn-danger" type="submit">Gjurmo</button>
              </div>
            </form>

            <div class="mt-3 d-grid">
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('cart.index') }}">
                <i class="bi bi-bag"></i> Shiko shportën
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<button class="back-btn" type="button" onclick="history.back()">
  <i class="bi bi-arrow-left"></i> Kthehu prapa
</button>

<div class="container mt-4 mb-5">
  <div class="row g-4 align-items-start">
    <!-- FOTO -->
    <div class="col-lg-7">
  <div class="product-hero" id="heroWrap">
    @php
      $path = $mainImg;
      if($path && str_starts_with($path, 'products/')){
          $path = 'images/'.$path;
      } elseif($path && !str_starts_with($path, 'images/')){
          $path = 'images/products/'.$path;
      }
    @endphp

    <!-- SWIPE CONTAINER -->
    <div id="swipeTrack" style="display:flex;width:100%;overflow:hidden;touch-action:pan-y;">
      @php
        $allImgs = $imgs;
        if(empty($allImgs)) $allImgs = [$mainImg];
      @endphp
      @foreach($allImgs as $i => $imgPath)
        @php
          $p = $imgPath;
          if($p && str_starts_with($p, 'products/')) $p = 'images/'.$p;
          elseif($p && !str_starts_with($p, 'images/')) $p = 'images/products/'.$p;
        @endphp
        <div class="swipe-slide" style="min-width:100%;display:flex;align-items:center;justify-content:center;">
          <img
            src="{{ $p ? asset($p) : asset('images/placeholder-product.png') }}"
            alt="{{ $product->name }}"
            style="width:100%;max-height:520px;object-fit:contain;border-radius:12px;user-select:none;-webkit-user-drag:none;">
        </div>
      @endforeach
    </div>

    <!-- DOTS (nëse ka më shumë se 1 foto) -->
    @if(count($allImgs) > 1)
      <div id="slideDots" style="position:absolute;bottom:10px;left:50%;transform:translateX(-50%);display:flex;gap:6px;z-index:5;">
        @foreach($allImgs as $i => $imgPath)
          <span class="sdot {{ $i===0?'active':'' }}" data-i="{{ $i }}"
            style="width:8px;height:8px;border-radius:50%;background:{{ $i===0?'#dc3545':'#d1d5db' }};cursor:pointer;transition:background .2s;display:block;"></span>
        @endforeach
      </div>
    @endif

    <!-- ZOOM desktop -->
    <div class="zoom-lens" id="zoomLens" aria-hidden="true"></div>
    <div class="zoom-pane" id="zoomPane" aria-hidden="true"></div>
  </div>

  <!-- THUMBNAILS -->
  @if(count($allImgs) > 1)
    <div class="thumb-row" aria-label="Fotot e produktit">
      @foreach($allImgs as $i => $imgPath)
        @php
          $p = $imgPath;
          if($p && str_starts_with($p, 'products/')) $p = 'images/'.$p;
          elseif($p && !str_starts_with($p, 'images/')) $p = 'images/products/'.$p;
        @endphp
        <button type="button"
          class="thumb-btn {{ $i===0?'active':'' }}"
          onclick="goToSlide({{ $i }})">
          <img src="{{ $p ? asset($p) : asset('images/placeholder-product.png') }}" alt="thumb {{ $i+1 }}">
        </button>
      @endforeach
    </div>
  @endif
</div>

    <!-- INFO -->
    <div class="col-lg-5">
      <span class="bf-chip">
        <i class="bi bi-stars"></i>
        OFERTË SPECIALE
      </span>

      <h1 class="h2 mb-2">{{ $product->name }}</h1>

      @php
        $basePrice = (float)$product->price;
        $oldBase   = $basePrice ? round($basePrice * 1.25, 2) : null;
        $discount  = ($oldBase && $basePrice && $oldBase > $basePrice)
          ? round(100 - ($basePrice / $oldBase * 100))
          : 20;

        $sizes=[];
        if(!empty($product->sizes)){
          $decoded=json_decode($product->sizes,true);
          if(is_array($decoded)) $sizes=$decoded;
        }

        // zgjedh default: e para qe ka stok, nese s'ka, e para fare
        $defaultIndex = 0;
        if(count($sizes)>0){
          foreach($sizes as $i => $sz){
            if(((int)($sz['stock'] ?? 0)) > 0){ $defaultIndex = $i; break; }
          }
        }
      @endphp

      <div id="priceContainer" class="price-block mb-2">
        <div class="d-flex align-items-baseline flex-wrap gap-2">
          <div class="price-now">{{ number_format($basePrice, 2) }} €</div>
          @if($oldBase)
            <div class="price-old">{{ number_format($oldBase, 2) }} €</div>
          @endif
          <span class="price-badge">-{{ $discount }}% Zbritje</span>
        </div>
      </div>

      <div id="stockContainer" class="stock-row mb-3">
        @php $inStock = ($product->stock ?? 0) > 0; @endphp
        <span class="stock-label {{ $inStock ? 'stock-pill-in' : 'stock-pill-out' }}">
          {{ $inStock ? 'Në stok' : 'S’ka në stok' }}
        </span>
        <span class="stock {{ $inStock ? 'in' : 'out' }}">
          {{ $inStock ? (int)$product->stock . ' copë' : 'Momentalisht pa stok' }}
        </span>
      </div>

      {{-- ✅ DIMENSIONET si pills --}}
      @if(count($sizes)>0)
        <div class="section-card mb-3">
          <div class="dim-title">Dimensionet</div>
          <div class="size-grid" id="sizePills" role="radiogroup" aria-label="Zgjidh dimensionin">
            @foreach($sizes as $i => $size)
              @php
                $p = (float)($size['price'] ?? $product->price);
                $st = (int)($size['stock'] ?? 0);
                $label = (string)($size['label'] ?? '');
                $isActive = ($i === $defaultIndex);
              @endphp
              <button
                type="button"
                class="size-pill {{ $isActive ? 'active' : '' }}"
                data-label="{{ $label }}"
                data-price="{{ $p }}"
                data-stock="{{ $st }}"
                aria-checked="{{ $isActive ? 'true' : 'false' }}"
                {{ $st <= 0 ? 'disabled' : '' }}
              >
                <span class="dot" aria-hidden="true"></span>
                <span>{{ $label }}</span>
              </button>
            @endforeach
          </div>
          <div class="small text-muted mt-2">
            * Dimensionet pa stok janë të çaktivizuara.
          </div>
        </div>
      @endif

      {{-- ✅ Transporti & Pagesa --}}
      <div class="section-card mb-3">
        <div class="green-title">Transporti falas brenda Kosovës</div>
        <ul class="info-list">
          <li><i class="bi bi-truck"></i> Caktohet pas konfirmimit të porosisë</li>
          <li><i class="bi bi-cash-coin"></i> Paguj me para në dorë ose kartelë</li>
          <li><i class="bi bi-credit-card"></i> Paguj Online</li>
        </ul>
      </div>

      <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-2">
          <button class="qty-btn" id="qtyMinus" type="button" aria-label="Zvogëlo">−</button>
          <input class="qty-input" id="qty" type="number" min="1" value="1" aria-label="Sasia">
          <button class="qty-btn" id="qtyPlus" type="button" aria-label="Rrit">+</button>
        </div>

        @php
          $waBase='https://wa.me/38344960661';
          $msg=rawurlencode("Përshëndetje! Dua ta porosis produktin:\n- {$product->name}\n- Dimensioni: \n- Çmimi: ".number_format($product->price,2)." €\n- Sasia: ");
        @endphp
        <a id="waBtn" class="btn btn-whatsapp px-4 text-white" target="_blank" rel="noopener"
           href="{{ $waBase }}?text={{ $msg }}1">
          <i class="bi bi-whatsapp"></i> KONTAKTO
        </a>
      </div>

      {{-- ✅ PERDE: form special --}}
      @if($isCurtain)
        <form action="{{ route('cart.addCurtain') }}" method="POST" id="curtainForm" class="mt-4">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">

          <div class="section-card mb-3">
            <h5 class="mb-3">Përmasa</h5>

            <div class="row">
              <div class="col-6">
                <label class="form-label">Width (m)</label>
                <input type="number" step="0.1" name="width" class="form-control" required>
              </div>
              <div class="col-6">
                <label class="form-label">Height (m)</label>
                <input type="number" step="0.1" name="height" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="section-card mb-3">
            <h5 class="mb-3">Folding System</h5>

            <div class="fold-grid">
              @php
                $folds = [
                  ['value'=>'fold1','name'=>'Fold 1 (1:2)','ratio'=>2,'extra'=>0,'img'=>'fold1.png'],
                  ['value'=>'fold2','name'=>'Fold 2 (1:2.5)','ratio'=>2.5,'extra'=>0,'img'=>'fold2.png'],
                  ['value'=>'fold3','name'=>'Fold 3 (1:3)','ratio'=>3,'extra'=>0,'img'=>'fold3.png'],
                  ['value'=>'grommet','name'=>'Grommet','ratio'=>2.5,'rings'=>5,'ring_price'=>1,'img'=>'rrumbu.jpg'],
                  ['value'=>'pencil','name'=>'Pencil Pleat (1:1.5)','ratio'=>1.5,'extra'=>0,'img'=>'shiriti.png'],
                  ['value'=>'swave','name'=>'S-Wave','ratio'=>2.8,'extra'=>2.5,'img'=>'amerikan.png'],
                ];
              @endphp

              @foreach($folds as $i => $f)
                <label class="fold-item">
                  <input type="radio"
                         name="fold_type"
                         value="{{ $f['value'] }}"
                         data-ratio="{{ $f['ratio'] }}"
                         data-extra="{{ $f['extra'] ?? 0 }}"
                         data-rings="{{ $f['rings'] ?? 0 }}"
                         data-ringprice="{{ $f['ring_price'] ?? 0 }}"
                         class="fold-radio"
                         {{ $loop->first ? 'checked' : '' }}
                         required>

                  <div class="fold-card">
                    <div class="fold-img">
                      <img src="{{ asset('images/folds/'.$f['img']) }}" alt="{{ $f['name'] }}">
                    </div>

                    <div class="fold-name">{{ $f['name'] }}</div>

                    @if(isset($f['extra']) && $f['extra'] > 0)
                      <div class="fold-extra">
                        +{{ number_format($f['extra'],2) }} € / meter
                      </div>
                    @endif
                  </div>
                </label>
              @endforeach
            </div>
          </div>

          <div class="section-card mb-3">
            <strong>Total: <span id="totalPrice">0.00</span> €</strong>
            <div class="small text-muted">Meters: <span id="totalMeters">0</span></div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-danger px-4 w-100">
              <i class="bi bi-bag-plus"></i> Shto në shportë
            </button>
          </div>
        </form>
      @else
        {{-- ✅ PRODUKTE TJERA: butoni normal --}}
        <button type="button" id="addToCartBtn" class="btn btn-danger w-100 py-2 mt-4">
          <i class="bi bi-bag-plus"></i> Shto në shportë
        </button>
      @endif

      @if($product->description)
        <div class="section-card mt-4" id="desc">
          <h2 class="h5 mb-2">Përshkrimi</h2>
          <p class="mb-0">{{ $product->description }}</p>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- PRODUKTE TE NGJASHME --}}
@if(isset($similarProducts) && $similarProducts->count())
  <div class="container mb-5">
    <div class="similar-box">
      <h2 class="similar-title">Produkte të ngjashme</h2>

      <div class="similar-grid">
        @foreach($similarProducts as $p)
          @php
            // price range nga sizes nese ka
            $minPrice = (float)$p->price;
            $maxPrice = (float)$p->price;

            if(!empty($p->sizes)){
              $sz = json_decode($p->sizes, true);
              if(is_array($sz) && count($sz)){
                $prices = collect($sz)->pluck('price')->filter()->map(fn($v)=>(float)$v)->values();
                if($prices->count()){
                  $minPrice = $prices->min();
                  $maxPrice = $prices->max();
                }
              }
            }

            // ✅ image_path JSON ose string
            $simImg = null;
            if(!empty($p->image_path)){
              $d = json_decode($p->image_path, true);
              $arr = is_array($d) ? $d : [$p->image_path];
              $simImg = $arr[0] ?? null;
            }
          @endphp

          <a class="similar-card" href="{{ route('products.show', $p) }}">
            <div class="similar-card-inner">
              <div class="similar-img">
                @php
  $path = $simImg;

  if($path && str_starts_with($path, 'products/')){
      $path = 'images/'.$path;
  } elseif($path && !str_starts_with($path, 'images/')){
      $path = 'images/products/'.$path;
  }
@endphp

<img
  src="{{ $path ? asset($path) : asset('images/placeholder-product.png') }}"
  alt="{{ $p->name }}"
  loading="lazy"
/>
              </div>

              <div class="similar-name">{{ $p->name }}</div>

              <div class="similar-price">
                @if($minPrice == $maxPrice)
                  {{ number_format($minPrice, 2) }} €
                @else
                  {{ number_format($minPrice, 2) }} € – {{ number_format($maxPrice, 2) }} €
                @endif
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endif

<br><br><br>

<footer class="brillant-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      {{-- LEFT: LOGO + BRAND --}}
      <div class="footer-brand">
        <div class="footer-logo-wrap">
          <img class="footer-logo" src="{{ asset('images/brillant.png') }}" alt="Brillant" loading="lazy">
        </div>

        <div>
          <small>Salloni i Perdeve, Tepiha</small>
          <div class="brand-name">BRILLANT</div>
        </div>

        <div class="footer-social">
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://wa.me/38344960661" target="_blank" rel="noopener" aria-label="WhatsApp">
            <i class="bi bi-whatsapp"></i>
          </a>
        </div>
      </div>

      {{-- PRODUCTS --}}
      <div class="footer-col">
        <h4>PRODUCTS</h4>
        <ul class="footer-links">
          <li><a href="{{ route('products.tepiha') }}">Carpet & Rugs</a></li>
          <li><a href="{{ route('products.tepiha') }}">Decorative Carpets</a></li>
          <li><a href="{{ route('products.tepihebanjo') }}">Bath Mats & Rugs</a></li>
          <li><a href="{{ route('products.mbulesa') }}">Sofa Covers</a></li>
          <li><a href="{{ route('products.postava') }}">Bed Sheets</a></li>
          <li><a href="{{ route('products.batanije') }}">Blankets</a></li>
        </ul>
      </div>

      {{-- INFORMATION --}}
      <div class="footer-col">
        <h4>INFORMATION</h4>
        <ul class="footer-links">
          <li><a href="{{ url('/products') }}">Products</a></li>
          <li><a href="{{ url('/catalogues') }}">Catalogues</a></li>
          <li><a href="{{ url('/manufacturing') }}">Manufacturing</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
        </ul>
      </div>

      {{-- FIND US --}}
      <div class="footer-col">
        <h4>FIND US</h4>
        <ul class="footer-links">
          <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div></div>
      <div class="center">crafted by RDR Digital L.L.C</div>
      <div class="right">Copyright © {{ now()->year }} Brillant</div>
    </div>
  </div>
</footer>

<!-- Fullscreen modal (e lejmë në HTML siç e ke, por s’e përdorim) -->
<div class="img-modal" id="imgModal" aria-hidden="true">
  <button class="close-btn" type="button" id="modalClose" aria-label="Mbyll">
    <i class="bi bi-x-lg"></i>
  </button>
  <img id="modalImg" alt="Zoom">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
(() => {
  const track = document.getElementById('swipeTrack');
  const dots = document.querySelectorAll('.sdot');
  const thumbBtns = document.querySelectorAll('.thumb-btn');
  const totalSlides = track ? track.querySelectorAll('.swipe-slide').length : 0;

  let current = 0;
  let startX = 0, isDragging = false;
  let curScale = 1, lastScale = 1;
  let panX = 0, panY = 0, startPanX = 0, startPanY = 0;
  let initDist = 0, startMidX = 0, startMidY = 0;
  let isPinching = false;
  let lastTap = 0;

  /* ---- helpers ---- */
  function getCurrentImg() {
    if (!track) return null;
    const slide = track.querySelectorAll('.swipe-slide')[current];
    return slide ? slide.querySelector('img') : null;
  }

  function applyTransform(img, scale, tx, ty, anim) {
    if (!img) return;
    img.style.transition = anim || 'none';
    img.style.transform = `translate(${tx}px,${ty}px) scale(${scale})`;
    img.style.transformOrigin = 'center center';
  }

  function resetZoom() {
    curScale = 1; lastScale = 1; panX = 0; panY = 0;
    const img = getCurrentImg();
    if (img) applyTransform(img, 1, 0, 0, 'transform .25s ease');
  }

  function dist(t) {
    const dx = t[0].clientX - t[1].clientX;
    const dy = t[0].clientY - t[1].clientY;
    return Math.sqrt(dx * dx + dy * dy);
  }

  /* ---- slide ---- */
  function goToSlide(n) {
    if (!track) return;
    current = Math.max(0, Math.min(n, totalSlides - 1));
    track.style.transition = 'transform .3s ease';
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((d, i) => {
      d.style.background = i === current ? '#dc3545' : '#d1d5db';
    });
    thumbBtns.forEach((b, i) => b.classList.toggle('active', i === current));
    resetZoom();
  }
  window.goToSlide = goToSlide;

  /* ---- touch ---- */
  if (track) {
    track.addEventListener('touchstart', (e) => {
      if (e.touches.length === 2) {
        isPinching = true;
        isDragging = false;
        initDist = dist(e.touches);
        lastScale = curScale;
        startPanX = panX;
        startPanY = panY;
        startMidX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
        startMidY = (e.touches[0].clientY + e.touches[1].clientY) / 2;
        e.preventDefault();
      } else if (e.touches.length === 1 && !isPinching) {
        startX = e.touches[0].clientX;
        startPanX = panX;
        startPanY = panY;
        isDragging = true;
        if (curScale <= 1) track.style.transition = 'none';
      }
    }, { passive: false });

    track.addEventListener('touchmove', (e) => {
      if (e.touches.length === 2 && isPinching) {
        let scale = lastScale * (dist(e.touches) / initDist);
        scale = Math.max(1, Math.min(scale, 5));
        curScale = scale;
        const midX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
        const midY = (e.touches[0].clientY + e.touches[1].clientY) / 2;
        panX = startPanX + (midX - startMidX);
        panY = startPanY + (midY - startMidY);
        applyTransform(getCurrentImg(), curScale, panX, panY, 'none');
        e.preventDefault();
      } else if (e.touches.length === 1 && isDragging) {
        const dx = e.touches[0].clientX - startX;
        const dy = e.touches[0].clientY - (startPanY + panY); // unused but kept
        if (curScale > 1) {
          panX = startPanX + dx;
          panY = startPanY + (e.touches[0].clientY - (e.touches[0].clientY)); 
          // re-calc Y properly:
          panY = startPanY + (e.touches[0].clientY - (startPanY === panY ? e.touches[0].clientY : startPanY));
          applyTransform(getCurrentImg(), curScale, panX, panY, 'none');
          e.preventDefault();
        } else {
          if (Math.abs(dx) > 8) {
            e.preventDefault();
            track.style.transform = `translateX(${-(current * 100) + (dx / track.offsetWidth * 100)}%)`;
          }
        }
      }
    }, { passive: false });

    track.addEventListener('touchend', (e) => {
      if (e.touches.length < 2 && isPinching) {
        isPinching = false;
        if (curScale < 1.1) resetZoom();
        lastScale = curScale;
        return;
      }
      if (!isDragging) return;
      isDragging = false;
      if (curScale > 1) return;

      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > track.offsetWidth * 0.2) {
        if (dx < 0 && current < totalSlides - 1) goToSlide(current + 1);
        else if (dx > 0 && current > 0) goToSlide(current - 1);
        else goToSlide(current);
      } else {
        goToSlide(current);
      }

      // double-tap
      const now = Date.now();
      if (now - lastTap < 280) {
        curScale > 1 ? resetZoom() : (() => {
          curScale = 2.5; lastScale = 2.5; panX = 0; panY = 0;
          applyTransform(getCurrentImg(), 2.5, 0, 0, 'transform .25s ease');
        })();
      }
      lastTap = now;
    }, { passive: true });

    dots.forEach((d, i) => d.addEventListener('click', () => goToSlide(i)));
  }

  /* ---- desktop zoom (hover) ---- */
  const lens = document.getElementById('zoomLens');
  const pane = document.getElementById('zoomPane');
  const hero = document.getElementById('heroWrap');
  const isDesktop = () => window.matchMedia('(min-width:992px)').matches;
  let natW = 0, natH = 0;
  const ZOOM = 1.5;

  function initZoom() {
    const img = getCurrentImg();
    if (!img || !pane) return;
    pane.style.backgroundImage = `url('${img.src}')`;
    const im = new Image();
    im.onload = () => {
      natW = im.naturalWidth; natH = im.naturalHeight;
      pane.style.backgroundRepeat = 'no-repeat';
      pane.style.backgroundSize = `${natW * ZOOM}px ${natH * ZOOM}px`;
    };
    im.src = img.src;
  }

  function moveZoom(e) {
    const img = getCurrentImg();
    if (!img || !lens || !pane) return;
    const r = img.getBoundingClientRect();
    let L = e.clientX - r.left - lens.offsetWidth / 2;
    let T = e.clientY - r.top - lens.offsetHeight / 2;
    L = Math.max(0, Math.min(L, img.clientWidth - lens.offsetWidth));
    T = Math.max(0, Math.min(T, img.clientHeight - lens.offsetHeight));
    lens.style.left = L + 'px';
    lens.style.top = T + 'px';
    pane.style.backgroundPosition = `${-(L * natW / img.clientWidth) * ZOOM}px ${-(T * natH / img.clientHeight) * ZOOM}px`;
  }

  if (hero && lens && pane) {
    hero.addEventListener('mouseenter', () => {
      if (!isDesktop()) return;
      lens.style.setProperty('display', 'block', 'important');
      pane.style.setProperty('display', 'block', 'important');
      initZoom();
    });
    hero.addEventListener('mouseleave', () => {
      lens.style.setProperty('display', 'none', 'important');
      pane.style.setProperty('display', 'none', 'important');
    });
    hero.addEventListener('mousemove', (e) => {
      if (!isDesktop()) return;
      moveZoom(e);
    });
  }

  window.setMainImg = (src, el) => {
    const img = getCurrentImg();
    if (img) img.src = src;
    document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
    if (el) el.classList.add('active');
    setTimeout(initZoom, 50);
  };

  window.addEventListener('resize', initZoom);
  setTimeout(initZoom, 100);
})();
</script>

<script>
// ---- CART ----
const addBtn = document.getElementById('addToCartBtn');

function currentSizeLabel(){
  const wrap = document.getElementById('sizePills');
  if(!wrap) return null;
  const active = wrap.querySelector('.size-pill.active');
  return active ? (active.dataset.label || '') : null;
}

function currentPrice(){
  const wrap = document.getElementById('sizePills');
  if(!wrap) return parseFloat({{ json_encode((float)$product->price) }});
  const active = wrap.querySelector('.size-pill.active');
  return active ? parseFloat(active.dataset.price) : parseFloat({{ json_encode((float)$product->price) }});
}

addBtn?.addEventListener('click', async () => {
  const payload = {
    product_id: {{ $product->id }},
    qty: parseInt(document.getElementById('qty').value || '1', 10),
    size: currentSizeLabel(),
    price: currentPrice()
  };

  try {
    const res = await fetch(`{{ route('cart.add') }}`, {
      method: 'POST',
      headers: {
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(payload)
    });

    const data = await res.json(); // ✅ FIX: kjo mungonte

    if(data.ok){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = data.totalQty);
      document.dispatchEvent(new CustomEvent('cart:updated', { detail: { totalQty: data.totalQty }}));
      showToast(data.message || 'U shtua në shportë');
    } else {
      showToast(data.message || 'Diçka shkoi keq', true);
    }
  } catch (e) {
    showToast('Gabim lidhjeje', true);
  }
});

function showToast(text, isErr){
  let el = document.getElementById('cartToast');
  if(!el){
    el = document.createElement('div');
    el.id='cartToast';
    el.className='toast align-items-center text-bg-' + (isErr?'danger':'success');
    el.role='alert'; el.ariaLive='assertive'; el.ariaAtomic='true';
    el.style.position='fixed'; el.style.bottom='16px'; el.style.right='16px'; el.style.zIndex='3000';
    el.innerHTML=`<div class="d-flex"><div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>`;
    document.body.appendChild(el);
  }
  el.querySelector('.toast-body').textContent = text;
  const t = new bootstrap.Toast(el, { delay: 1800 });
  t.show();
}
</script>

<script>
@if($isCurtain)

const pricePerMeter = {{ (float)$product->price }};

function calculateCurtain() {

    let width = parseFloat(document.querySelector('[name="width"]').value) || 0;

    let selectedFold = document.querySelector('[name="fold_type"]:checked');

    let ratio = parseFloat(selectedFold.dataset.ratio || 1);
    let extra = parseFloat(selectedFold.dataset.extra || 0);
    let ringsPerMeter = parseFloat(selectedFold.dataset.rings || 0);
    let ringPrice = parseFloat(selectedFold.dataset.ringprice || 0);

    // MATERIAL
    let meters = width * ratio;
    let fabricTotal = meters * pricePerMeter;

    // SHIRIT (S-Wave)
    let extraTotal = meters * extra;

    // RRUMBULLAKA (Grommet)
    let rings = Math.ceil(meters * ringsPerMeter);
    let ringsTotal = rings * ringPrice;

    // TOTAL
    let total = fabricTotal + extraTotal + ringsTotal;

    document.getElementById("totalMeters").innerText = meters.toFixed(2);
    document.getElementById("totalPrice").innerText = total.toFixed(2);
}

document.querySelectorAll('#curtainForm input')
    .forEach(el => el.addEventListener('input', calculateCurtain));

@endif
@if($isCurtain)

function updateCurtainWhatsapp(){

    let width = parseFloat(document.querySelector('[name="width"]').value) || 0;
    let height = parseFloat(document.querySelector('[name="height"]').value) || 0;
    let fold = document.querySelector('[name="fold_type"]:checked');

    if(!fold) return;

    let ratio = parseFloat(fold.dataset.ratio || 1);
    let extra = parseFloat(fold.dataset.extra || 0);
    let ringsPerMeter = parseFloat(fold.dataset.rings || 0);
    let ringPrice = parseFloat(fold.dataset.ringprice || 0);

    let pricePerMeter = {{ (float)$product->price }};

    let meters = width * ratio;
    let fabricTotal = meters * pricePerMeter;
    let extraTotal = meters * extra;
    let rings = Math.ceil(meters * ringsPerMeter);
    let ringsTotal = rings * ringPrice;
    let total = fabricTotal + extraTotal + ringsTotal;

    let message = `
Përshëndetje 👋

Dua të porosis këtë perde:

Produkti: {{ addslashes($product->name) }}
Gjerësia: ${width} m
Lartësia: ${height} m
Sistemi: ${fold.value}

Metra material: ${meters.toFixed(2)} m
Totali i llogaritur: ${total.toFixed(2)} €

Ju lutem më konfirmoni porosinë 🙏
`;

    document.getElementById("waBtn").href =
        "https://wa.me/38344960661?text=" + encodeURIComponent(message);
}

document.querySelectorAll('#curtainForm input')
    .forEach(el => el.addEventListener('input', updateCurtainWhatsapp));

updateCurtainWhatsapp();

@endif
</script>
</body>
</html>