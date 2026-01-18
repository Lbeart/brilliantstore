<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brillant Tepiha & Perde | b-brillant.com</title>
  <meta name="description" content="Tepiha moderne, perde, set qarqafësh, mbulesa, jastakë dekorues dhe tepiha për banjo. Cilësi dhe dizajn për shtëpinë tuaj në Lipjan.">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* =========================================================
      Brillant Home – Pro CSS (structured, responsive, modern)
    ========================================================== */
    :root{
      --bg: #0b1020;
      --surface: #0f172a;
      --surface-2:#111827;
      --card:#ffffff;
      --muted:#6b7280;
      --text:#111827;
      --light:#f8fafc;
      --brand:#dc3545;          /* red */
      --brand-2:#ffc107;        /* gold */
      --ring: rgba(220,53,69,.28);
      --shadow: 0 18px 45px rgba(2,6,23,.12);
      --shadow-soft: 0 10px 28px rgba(2,6,23,.10);
      --radius: 18px;
      --radius-lg: 24px;
    }

    *{ box-sizing:border-box; }
    html, body{ height:100%; }
    html, body, .navbar-custom, .navbar-custom .nav-link, .dropdown-menu, .dropdown-item{
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: optimizeLegibility;
    }

    body{
      margin:0;
      font-family:'Poppins',sans-serif;
      background:
        radial-gradient(1200px 700px at 10% -10%, rgba(220,53,69,.18), transparent 55%),
        radial-gradient(900px 500px at 90% 0%, rgba(255,193,7,.14), transparent 55%),
        #f6f7fb;
      color:var(--text);
    }

    /* ===== Helpers ===== */
    .section-pad{ padding: 4rem 0; }
    .soft-card{
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(17,24,39,.06);
      box-shadow: var(--shadow-soft);
      border-radius: var(--radius-lg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .pill{
      border-radius: 999px !important;
    }
    .btn-brand{
      background: var(--brand);
      border-color: var(--brand);
      color: #fff;
      box-shadow: 0 10px 24px rgba(220,53,69,.22);
    }
    .btn-brand:hover{
      filter: brightness(.98);
      box-shadow: 0 14px 30px rgba(220,53,69,.28);
    }

    /* =========================
       NAVBAR (New look)
    ========================== */
    .navbar-custom{
      position: sticky;
      top:0;
      z-index: 1000;
      padding: .75rem 0;
      background: linear-gradient(90deg, rgba(15,23,42,.92), rgba(17,24,39,.92));
      border-bottom: 1px solid rgba(255,255,255,.08);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    .navbar-custom .navbar-brand img{
      height: 46px;
      filter: drop-shadow(0 8px 14px rgba(0,0,0,.20));
    }

    .navbar-custom .nav-link{
      color: rgba(248,250,252,.92) !important;
      font-weight: 500;
      font-size: .95rem;
      padding: .55rem .85rem;
      border-radius: 999px;
      transition: background .2s ease, color .2s ease, transform .2s ease;
    }
    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus{
      color: #fff !important;
      background: rgba(255,255,255,.08);
      transform: translateY(-1px);
    }

    .navbar-custom .navbar-toggler{
      border-color: rgba(255,255,255,.28);
      border-radius: 12px;
      padding: .45rem .6rem;
    }
    .navbar-custom .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28 255, 255, 255, 0.85 %29)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu{
      border: 1px solid rgba(2,6,23,.08);
      border-radius: 14px;
      box-shadow: 0 18px 50px rgba(2,6,23,.18);
      padding: .55rem;
    }
    .dropdown-item{
      border-radius: 12px;
      padding: .55rem .75rem;
      font-weight: 500;
    }
    .dropdown-item:hover{
      background: rgba(220,53,69,.08);
      color: var(--brand);
    }

    .dropdown-submenu .submenu{
      display:none;
      position:absolute;
      top:0;
      left:100%;
      margin-left:.25rem;
      min-width: 190px;
      border-radius: 14px;
    }
    .dropdown-submenu:hover .submenu{ display:block; }

    /* Navbar right small button */
    .nav-login-btn{
      border: 1px solid rgba(255,255,255,.28);
      color: rgba(255,255,255,.92);
      background: rgba(255,255,255,.06);
      border-radius: 999px;
      padding: .45rem .85rem;
      font-weight: 600;
    }
    .nav-login-btn:hover{
      background: rgba(255,255,255,.10);
      color:#fff;
    }

    /* Mobile navbar dropdown */
    @media (max-width: 992px){
      .navbar-custom .dropdown-menu{
        background: rgba(17,24,39,.98);
        border-color: rgba(255,255,255,.10);
        box-shadow: none;
      }
      .navbar-custom .dropdown-item{
        color: rgba(248,250,252,.92);
      }
      .navbar-custom .dropdown-item:hover{
        background: rgba(255,255,255,.06);
        color: var(--brand-2);
      }
      .dropdown-submenu .submenu{
        position: static;
        display: block;
        margin-left: 0;
        padding-left: 1rem;
        background: transparent;
        border: none;
      }
    }

    /* =========================
       TOP ACTION BAR (NEW)
       - search moved "mas mirti"
    ========================== */
    .topbar{
      margin-top: 18px;
    }
    .topbar-inner{
      padding: 14px;
      border-radius: var(--radius-lg);
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(17,24,39,.06);
      box-shadow: var(--shadow-soft);
    }

    .chip{
      display:inline-flex;
      align-items:center;
      gap:.5rem;
      padding:.55rem .85rem;
      border-radius: 999px;
      background: rgba(17,24,39,.04);
      border: 1px solid rgba(17,24,39,.06);
      font-weight: 600;
      color: #0f172a;
      text-decoration:none;
      transition: transform .18s ease, background .18s ease;
      white-space: nowrap;
    }
    .chip:hover{
      background: rgba(220,53,69,.08);
      transform: translateY(-1px);
      color: var(--brand);
    }
    .chip i{ opacity:.9; }

    /* Search */
    .search-pro{
      position: relative;
    }
    .search-pro input{
      height: 50px;
      border-radius: 999px;
      padding-left: 48px;
      padding-right: 120px;
      border: 1px solid rgba(17,24,39,.10);
      box-shadow: 0 10px 28px rgba(2,6,23,.08);
      outline: none;
    }
    .search-pro input:focus{
      border-color: rgba(220,53,69,.35);
      box-shadow: 0 0 0 5px var(--ring), 0 12px 28px rgba(2,6,23,.10);
    }
    .search-pro .icon{
      position:absolute;
      top:50%;
      left: 16px;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 1.05rem;
    }
    .search-pro .btn{
      position:absolute;
      top:50%;
      right: 6px;
      transform: translateY(-50%);
      border-radius: 999px;
      padding: .55rem 1rem;
      font-weight: 700;
    }

    /* WhatsApp */
    .wa-btn{
      background: #16a34a;
      border: 1px solid rgba(22,163,74,.25);
      color: #fff;
      border-radius: 999px;
      padding: .6rem 1rem;
      font-weight: 700;
      box-shadow: 0 10px 26px rgba(22,163,74,.18);
      white-space: nowrap;
    }
    .wa-btn:hover{
      filter: brightness(.98);
      color:#fff;
      box-shadow: 0 14px 34px rgba(22,163,74,.22);
    }

    /* =========================
       HERO (New layout)
    ========================== */
    .hero{
      margin-top: 18px;
      border-radius: 32px;
      overflow: hidden;
      position: relative;
      background:
        radial-gradient(900px 500px at 20% 20%, rgba(255,193,7,.18), transparent 55%),
        radial-gradient(900px 500px at 80% 40%, rgba(220,53,69,.22), transparent 60%),
        linear-gradient(180deg, rgba(15,23,42,.92), rgba(2,6,23,.92));
      color: #fff;
      box-shadow: 0 30px 80px rgba(2,6,23,.25);
    }

    .hero-bg{
      position:absolute;
      inset:0;
      background: url('{{ asset('slider/foto1.jpg') }}') center/cover no-repeat;
      filter: brightness(.45) saturate(1.05);
      transform: scale(1.03);
      z-index: 0;
    }
    .hero::after{
      content:"";
      position:absolute;
      inset:0;
      background: linear-gradient(90deg, rgba(2,6,23,.70), rgba(2,6,23,.30) 55%, rgba(2,6,23,.70));
      z-index: 1;
    }

    .hero-content{
      position: relative;
      z-index: 2;
      padding: 3.2rem 1.5rem;
    }
    .hero-badge{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.35rem .85rem;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.14);
      font-size: .82rem;
      text-transform: uppercase;
      letter-spacing: .12em;
    }
    .hero-badge span{
      background: var(--brand-2);
      color: #111;
      padding: .12rem .55rem;
      border-radius: 999px;
      font-weight: 800;
      letter-spacing: .10em;
    }

    .hero-title{
      font-weight: 800;
      line-height: 1.06;
      margin-top: 1rem;
      font-size: clamp(2.05rem, 4.2vw, 3.35rem);
    }
    .hero-title em{
      font-style: normal;
      color: var(--brand-2);
    }
    .hero-sub{
      margin-top: 1rem;
      max-width: 560px;
      color: rgba(248,250,252,.92);
      font-size: 1.02rem;
      line-height: 1.65;
    }

    .hero-actions{
      margin-top: 1.4rem;
      display:flex;
      gap:.75rem;
      flex-wrap: wrap;
    }
    .hero-actions .btn{
      border-radius: 999px;
      padding: .72rem 1.35rem;
      font-weight: 800;
    }
    .hero-actions .btn-outline-light{
      border-width: 2px;
    }

    .hero-stats{
      margin-top: 1.7rem;
      display:flex;
      gap: 14px;
      flex-wrap: wrap;
    }
    .stat{
      padding: .75rem .95rem;
      border-radius: 16px;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.12);
      min-width: 175px;
    }
    .stat .n{
      font-size: 1.35rem;
      font-weight: 900;
      color: var(--brand-2);
      line-height: 1;
    }
    .stat .t{
      font-size: .9rem;
      color: rgba(248,250,252,.88);
      margin-top: .3rem;
    }

    /* Weekly offers card */
    .weekly-card{
      border-radius: 26px;
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(255,255,255,.16);
      box-shadow: 0 18px 55px rgba(2,6,23,.24);
      overflow: hidden;
    }
    .weekly-card .head{
      padding: 1rem 1.1rem .3rem;
    }
    .weekly-card .kicker{
      font-size: .78rem;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: rgba(2,6,23,.55);
      margin-bottom: .35rem;
      font-weight: 800;
    }
    .weekly-card .title{
      font-weight: 900;
      margin:0;
      color: #0f172a;
    }
    .weekly-item{
      padding: .9rem 1.1rem;
      border-top: 1px solid rgba(2,6,23,.06);
    }
    .weekly-item img{
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: 0 10px 22px rgba(2,6,23,.12);
    }
    .price{
      font-weight: 900;
      color: var(--brand);
    }
    .old{
      color: rgba(2,6,23,.45);
      text-decoration: line-through;
      font-size: .9rem;
    }

    /* =========================
       SECTIONS
    ========================== */
    .section-title{
      text-align:center;
      margin-bottom: 2.25rem;
    }
    .section-title .k{
      display:inline-block;
      font-size: .82rem;
      font-weight: 900;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--brand);
      background: rgba(220,53,69,.08);
      border: 1px solid rgba(220,53,69,.14);
      padding: .35rem .8rem;
      border-radius: 999px;
    }
    .section-title h2{
      margin-top: .85rem;
      font-weight: 900;
      color: #0f172a;
    }
    .section-title p{
      margin: .55rem auto 0;
      max-width: 680px;
      color: var(--muted);
    }

    /* Category cards */
    .cat-card{
      height: 100%;
      border-radius: 22px;
      background: #fff;
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow-soft);
      overflow:hidden;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .cat-card:hover{
      transform: translateY(-5px);
      box-shadow: 0 22px 55px rgba(2,6,23,.14);
    }
    .cat-media{
      position: relative;
      overflow: hidden;
    }
    .cat-media img{
      width:100%;
      height: 220px;
      object-fit: cover;
      transition: transform .45s ease;
    }
    .cat-card:hover .cat-media img{
      transform: scale(1.06);
    }
    .cat-badge{
      position:absolute;
      top: 12px;
      left: 12px;
      background: rgba(2,6,23,.72);
      color:#fff;
      padding: .25rem .7rem;
      border-radius: 999px;
      font-size: .76rem;
      font-weight: 800;
      letter-spacing: .06em;
    }
    .cat-body{
      padding: 1rem 1.1rem 1.2rem;
    }
    .cat-body h5{
      font-weight: 800;
      margin-bottom: .35rem;
    }
    .cat-body p{
      color: var(--muted);
      font-size: .93rem;
      margin-bottom: .8rem;
    }
    .cat-link{
      display:inline-flex;
      align-items:center;
      gap:.45rem;
      text-decoration: none;
      font-weight: 900;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-size: .82rem;
      color: var(--brand);
    }

    /* Rugs carousel title */
    .rugs-head .k{
      font-size: .82rem;
      font-weight: 900;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: rgba(2,6,23,.55);
    }
    .rugs-head h2{
      font-weight: 900;
      margin: .35rem 0;
    }

    /* Product cards */
    .product-card{
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 22px;
      overflow:hidden;
      box-shadow: var(--shadow-soft);
      height:100%;
      background:#fff;
    }
    .product-card img{
      height: 260px;
      width:100%;
      object-fit: cover;
    }
    .product-card .card-body{
      padding: 1rem 1.1rem 1.2rem;
    }

    /* Why choose us block */
    .why-wrap{
      background: rgba(255,255,255,.78);
      border: 1px solid rgba(17,24,39,.06);
      border-radius: 28px;
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .why-wrap .why-side{
      padding: 2rem;
      background: linear-gradient(180deg, rgba(220,53,69,.08), rgba(255,255,255,0));
    }
    .why-wrap .why-points{
      padding: 2rem;
    }
    .why-bullet h5{
      font-weight: 900;
      font-size: 1rem;
      margin-bottom: .25rem;
    }
    .why-bullet p{
      color: var(--muted);
      margin-bottom: 0;
      font-size: .95rem;
      line-height: 1.6;
    }
    .why-bullet{
      padding: .95rem 1rem;
      border-radius: 18px;
      border: 1px solid rgba(2,6,23,.06);
      background: rgba(255,255,255,.70);
      box-shadow: 0 10px 26px rgba(2,6,23,.07);
      margin-bottom: .85rem;
    }

    /* SEO text */
    .seo-text{
      font-size: .98rem;
      line-height: 1.75;
      color: rgba(2,6,23,.78);
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(17,24,39,.06);
      border-radius: 22px;
      padding: 1.6rem;
      box-shadow: var(--shadow-soft);
    }
    .seo-text h2{
      font-weight: 900;
      margin-bottom: .85rem;
    }

    /* Footer */
    footer{
      font-size: .92rem;
      background: rgba(255,255,255,.75) !important;
      border-top: 1px solid rgba(17,24,39,.08) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    /* =========================
       Responsive tweaks
    ========================== */
    @media (max-width: 992px){
      .hero-content{ padding: 2.5rem 1.1rem; }
      .weekly-card{ margin-top: 16px; }
      .search-pro input{ padding-right: 110px; }
    }
    @media (max-width: 768px){
      .topbar{ margin-top: 12px; }
      .hero-content{ padding: 2.2rem 1rem; }
      .hero-sub{ font-size: .98rem; }
      .hero-stats{ justify-content: center; }
      .stat{ min-width: 160px; }
      .search-pro input{ height: 52px; }
    }
    @media (max-width: 576px){
      .search-pro input{ padding-right: 100px; }
      .hero-actions .btn{ width: 100%; }
      .weekly-item img{ width: 92px; height: 92px; }
    }
    .chips-2rows{
  display:grid;
  grid-template-columns:repeat(3, minmax(0, 1fr));
  gap:12px;
}

/* Me i bo chips me i mbush kolonen (mos me u prish layout) */
.chips-2rows .chip{
  width:100%;
  justify-content:center; /* nese chip eshte display:flex */
  text-align:center;
  white-space:nowrap;
}

/* Tablet: 2 ne rresht */
@media (max-width: 991.98px){
  .chips-2rows{
    grid-template-columns:repeat(2, minmax(0, 1fr));
  }
}

/* Mobile: 1 ne rresht */
@media (max-width: 575.98px){
  .chips-2rows{
    grid-template-columns:1fr;
  }
}
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant Logo">
      </a>

      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarContent" aria-controls="navbarContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-lg-center gap-lg-1 me-lg-2">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="catalogDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Products
            </a>
            <ul class="dropdown-menu" aria-labelledby="catalogDropdown">
              <li><a class="dropdown-item" href="/tepiha">Tepiha</a></li>

              <li class="dropdown-submenu position-relative">
                <a class="dropdown-item dropdown-toggle" href="#">Perde</a>
                <ul class="dropdown-menu submenu shadow">
                  <li><a class="dropdown-item" href="/anesore">Perde Anësore</a></li>
                  <li><a class="dropdown-item" href="/perde-ditore">Perde Ditore</a></li>
                </ul>
              </li>

              <li><a class="dropdown-item" href="/jastekdekorues">JastekDekorues</a></li>
              <li><a class="dropdown-item" href="/postava">Set çarçafesh</a></li>
              <li><a class="dropdown-item" href="/mbulesa">Mbulesa</a></li>
              <li><a class="dropdown-item" href="/batanije">Batanije</a></li>
              <li><a class="dropdown-item" href="/tepihebanjo">Tepiha për Banjo</a></li>
              <li><a class="dropdown-item" href="/posteqia">Lekur Pelushi</a></li>
              <li><a class="dropdown-item" href="/garnishte">Garnishte</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}">Contact us</a>
          </li>

          @auth
            <li class="nav-item dropdown">
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
            <li class="nav-item ms-lg-1">
              <a href="{{ route('login') }}" class="nav-login-btn btn btn-sm">Log in</a>
            </li>
          @endauth

          <!-- CART / TRACK -->
          <li class="nav-item dropdown ms-lg-1">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
               href="#" id="cartDropdown" role="button"
               data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
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

  <!-- TOPBAR: categories + NEW SEARCH + WhatsApp -->
  <div class="container topbar">
  <div class="topbar-inner">
    <div class="row g-3 align-items-center">

      <div class="col-lg-4">
        <div class="chips-2rows">
          <!-- RRESHTI 1 -->
          <a class="chip" href="/tepiha"><i class="bi bi-grid"></i> Tepiha</a>
          <a class="chip" href="/mbulesa"><i class="bi bi-house"></i> Mbulesa</a>
          <a class="chip" href="/anesore"><i class="bi bi-layout-text-window"></i> Perde</a>

          <!-- RRESHTI 2 -->
          <a class="chip" href="/garnishte"><i class="bi bi-layout-text-window"></i> Garnishte</a>
          <a class="chip" href="/batanije"><i class="bi bi-snow"></i> Batanije</a>
          <a class="chip" href="/postava"><i class="bi bi-bag-check"></i> Set çarçafesh</a>
        </div>
      </div>

      <div class="col-lg-5">
        <form action="{{ route('search') }}" method="GET" class="search-pro">
          <i class="bi bi-search icon"></i>
          <input type="text" name="q" class="form-control"
                 placeholder="Kërko produktin:"
                 value="{{ request('q') }}" required>
          <button class="btn btn-brand" type="submit">Kërko</button>
        </form>
      </div>

      <div class="col-lg-3 text-lg-end">
        <a href="https://wa.me/38344960661" target="_blank" class="wa-btn d-inline-flex align-items-center gap-2">
          <i class="bi bi-whatsapp"></i> Chat
        </a>
      </div>

    </div>
  </div>
</div>

  <!-- HERO -->
  <section class="container mt-3">
    <div class="hero">
      <div class="hero-bg"></div>

      <div class="hero-content">
        <div class="row align-items-center gy-4">
          <div class="col-lg-7">
            <div class="hero-badge">
              <span>KOLEKSION I RI</span> Tepiha & perde për çdo ambient
            </div>

            <h1 class="hero-title">
              Tepiha & perde <em>premium</em> për shtëpi moderne.
            </h1>

            <p class="hero-sub">
              Zgjidh dizajnin ideal për sallon, dhomë gjumi apo zyrë.
              Tekstura cilësore, ngjyra që nuk zbehen dhe shërbim profesional nga Brillant në Lipjan.
            </p>

            <div class="hero-actions">
              <a href="/tepiha" class="btn btn-brand">
                Shiko tepihat
              </a>
              <a href="/anesore" class="btn btn-outline-light">
                Shiko perdet
              </a>
            </div>

            <div class="hero-stats">
              <div class="stat">
                <div class="n">3000+</div>
                <div class="t">Klientë të kënaqur në Kosovë</div>
              </div>
              <div class="stat">
                <div class="n">15+ vjet</div>
                <div class="t">Përvojë në tekstile shtëpie</div>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="weekly-card">
              <div class="head">
                <div class="kicker">ZBRITJE SEZONALE</div>
                <h5 class="title">Oferta e javës</h5>
              </div>

              <div id="weeklyOffersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">

                  <!-- Slide 1 -->
                  <div class="carousel-item active">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('slider/side.bmp') }}" alt="Tepiha Modern 150x230">
                        <div class="flex-grow-1">
                          <span class="badge bg-danger-subtle text-danger border border-danger mb-2">Tepiha</span>
                          <div class="fw-bold">Tepiha Modern 150x230 cm</div>
                          <div class="small text-muted">Antibakterial, Akrill, lehtë për pastrim.</div>
                          <div class="d-flex align-items-baseline gap-2 mt-2">
                            <span class="price">€75.00</span>
                            <span class="old">€95.00</span>
                          </div>
                          <a href="/tepiha" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-2">
                            Shko te tepihat <i class="bi bi-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Slide 2 -->
                  <div class="carousel-item">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha Hali 200x300">
                        <div class="flex-grow-1">
                          <span class="badge bg-danger-subtle text-danger border border-danger mb-2">Tepiha</span>
                          <div class="fw-bold">Tepiha Hali 200x300 cm</div>
                          <div class="small text-muted">Rezistent, me fibra cilësore për sallon.</div>
                          <div class="d-flex align-items-baseline gap-2 mt-2">
                            <span class="price">€95.00</span>
                            <span class="old">€120.00</span>
                          </div>
                          <a href="/tepiha" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-2">
                            Shiko modelet Hali <i class="bi bi-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Slide 3 -->
                  <div class="carousel-item">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh">
                        <div class="flex-grow-1">
                          <span class="badge bg-warning-subtle text-warning border border-warning mb-2">Set çarçafësh</span>
                          <div class="fw-bold">Set çarçafësh pambuk</div>
                          <div class="small text-muted">I butë, ngjyra që nuk zbehen, ideal për përdorim ditor.</div>
                          <div class="d-flex align-items-baseline gap-2 mt-2">
                            <span class="price">€25.00</span>
                            <span class="old">€59.00</span>
                          </div>
                          <a href="/postava" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-2">
                            Shko te setet <i class="bi bi-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <div class="p-3 pt-2">
                <a href="/tepiha" class="btn btn-outline-dark w-100 pill btn-sm">
                  Shiko të gjitha ofertat
                </a>
              </div>
            </div>
          </div>

        </div><!-- row -->
      </div><!-- hero-content -->
    </div><!-- hero -->
  </section>

  <!-- MAIN -->
  <main class="section-pad">
    <div class="container">

      <!-- Categories -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">KATEGORITË KRYESORE</span>
          <h2>Çfarë po kërkon sot?</h2>
          <p>Zgjidh një kategori dhe shiko modelet më të kërkuara në Brillant.</p>
        </div>

        <div class="row g-4">
          <div class="col-md-3 col-sm-6">
            <a href="/tepiha" class="text-decoration-none text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha">
                  <span class="cat-badge">Tepiha</span>
                </div>
                <div class="cat-body">
                  <h5>Tepiha modern & klasik</h5>
                  <p>Modele për sallon, korridor, dhoma fëmijësh dhe banjo.</p>
                  <span class="cat-link">Shiko tepihat <i class="bi bi-arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/anesore" class="text-decoration-none text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img src="{{ asset('slider/raffaello.jpg') }}" alt="Perde">
                  <span class="cat-badge">Perde</span>
                </div>
                <div class="cat-body">
                  <h5>Perde anësore & ditore</h5>
                  <p>Tekstile cilësore me sisteme amerikane dhe dizajn modern.</p>
                  <span class="cat-link">Shiko perdet <i class="bi bi-arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/postava" class="text-decoration-none text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh">
                  <span class="cat-badge">Shtrat</span>
                </div>
                <div class="cat-body">
                  <h5>Set çarçafësh & kompleta krevati</h5>
                  <p>Material i butë, i qëndrueshëm dhe ngjyra që nuk zbehen.</p>
                  <span class="cat-link">Shiko setet <i class="bi bi-arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/mbulesa" class="text-decoration-none text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa & batanije">
                  <span class="cat-badge">Komfor</span>
                </div>
                <div class="cat-body">
                  <h5>Mbulesa & batanije</h5>
                  <p>Batanije të ngrohta, mbulesa karrigesh dhe garnishte dekoruese.</p>
                  <span class="cat-link">Shiko mbulesat <i class="bi bi-arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

        </div>
      </section>

      <!-- Modern rugs carousel -->
      <section class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-3 rugs-head">
          <div>
            <div class="k">TEPIHA MODERN</div>
            <h2 class="mb-1">Tepiha moderne në ofertë</h2>
            <p class="text-muted small mb-0">Modele të zgjedhura nga koleksioni ynë.</p>
          </div>
          <a href="/tepiha" class="btn btn-brand btn-sm pill mt-3 mt-md-0">Shiko katalogun e tepihave</a>
        </div>

        <div class="soft-card p-3 p-md-4">
          <div id="modernRugsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
            <div class="carousel-inner">
              @php
                $rugs = [
                  ['side.bmp',  'Modern Rose 120x170 cm',  '€45.00'],
                  ['hali4.jpg', 'Modern Hali 300x200 cm',  '€95.00'],
                  ['gold.bmp',  'Modern Gold 300x200 cm',  '€55.00'],
                  ['gold1.bmp', 'Modern Gold 300x200 cm',  '€55.00'],
                  ['gold2.bmp', 'Modern Gold 300x200 cm',  '€55.00'],
                  ['rose1.jpg', 'rose 300x200 cm',         '€105.00'],
                  ['rose2.bmp', 'rose 150x230 cm',         '€75.00'],
                  ['rose3.bmp', 'rose 150x230 cm',         '€75.00'],
                  ['hali5.jpg', 'hali 150x230 cm',         '€65.00'],
                  ['hali3.jpg', 'hali 150x230 cm',         '€65.00'],
                ];
                $chunks = collect($rugs)->chunk(5);
              @endphp

              @foreach($chunks as $i => $group)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                  <div class="row gx-3 justify-content-center">
                    @foreach($group as $item)
                      <div class="col-6 col-sm-4 col-md-2 text-center mb-3">
                        <div class="small text-success mb-1">
                          <i class="bi bi-check-circle-fill"></i> In stock
                        </div>
                        <img
                          src="{{ asset('slider/'.$item[0]) }}"
                          alt="{{ $item[1] }}"
                          class="img-fluid rounded-4 shadow-sm mb-2"
                          style="height: 200px; width: auto; object-fit: contain;">
                        <p class="small mb-1">{{ $item[1] }}</p>
                        <h6 class="fw-bold mb-0">{{ $item[2] }}</h6>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#modernRugsCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#modernRugsCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </section>

      <!-- Latest products -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">PRODUKTET E FUNDIT</span>
          <h2>Zbuloni çfarë ka ardhur rishtazi</h2>
          <p>Produktet e reja që janë shtuar së fundmi në katalog.</p>
        </div>

        <div class="row g-4">
          @if(isset($items) && $items->count())
            @foreach($items->take(3) as $item)
              <div class="col-md-4">
                <div class="card product-card">
                  @if($item->image_path)
                    <img src="{{ asset('storage/'.$item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                  @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:260px;">
                      <span class="text-white">Pa foto</span>
                    </div>
                  @endif

                  <div class="card-body">
                    <h5 class="card-title fw-bold text-danger mb-1">{{ $item->name }}</h5>
                    <p class="card-text text-muted mb-0">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </section>

      <!-- Why choose us -->
      <section class="why-wrap mb-5">
        <div class="row g-0 align-items-stretch">
          <div class="col-md-5 why-side">
            <div class="section-title text-md-start text-center mb-3 mb-md-0">
              <span class="k">PSE BRILLANT?</span>
              <h2 class="mt-3">Tekstil i zgjedhur, shërbim i kujdesshëm.</h2>
              <p class="mt-2 text-muted">Matje, konsulencë dhe qepje profesionale – me fokus në cilësi dhe kënaqësi.</p>
            </div>
            <img src="{{ asset('slider/raffaello.jpg') }}" class="img-fluid rounded-4 shadow-sm mt-3" alt="Why Choose Us">
          </div>

          <div class="col-md-7 why-points">
            <div class="why-bullet">
              <h5>American System Curtains</h5>
              <p>Perde me sistem amerikan, montim i lehtë dhe pamje elegante për çdo ambient modern.</p>
            </div>
            <div class="why-bullet">
              <h5>Antibacterial Acrylic Rugs</h5>
              <p>Tepiha akrilik me mbrojtje antibakteriale, rezistent ndaj shtypjes dhe i lehtë për t’u pastruar.</p>
            </div>
            <div class="why-bullet">
              <h5>Plush bed covers & sheets</h5>
              <p>Mbulesa dhe çarçafë pelushi të butë, të rehatshëm dhe miqësorë me mjedisin.</p>
            </div>
            <div class="why-bullet mb-0">
              <h5>Shërbim profesional në Lipjan</h5>
              <p>Matje në terren, konsulencë për modelin dhe qepje profesionale – gjithçka në një vend.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- SEO -->
      <section class="seo-text">
        <h2>Brillant – Tepiha, Perde dhe Dekorime për Shtëpi</h2>
        <p>Brillant është destinacioni juaj i besueshëm për tepiha modern, perde cilësore, mbulesa të bukura dhe dekorime për shtëpi. Me përvojë shumëvjeçare, synimi ynë është t’ju ofrojmë produkte të cilësisë së lartë që i bëjnë ambientet tuaja më të bukura, më komode dhe më funksionale.</p>

        <p>Koleksioni ynë i tapetave përfshin tepihë modern, tepihë klasik, tepihë rrethor, tepihë për sallon dhe tapeta për banjo – të përzgjedhur me kujdes për të garantuar dizajn, qëndrueshmëri dhe cilësi të lartë. Për më shumë ngrohtësi dhe stil, ofrojmë edhe batanije premium, kompleta krevati dhe sete qarqafësh.</p>

        <p>Në kategorinë e perdeve dhe mbulesave, do të gjeni materiale të cilësisë së lartë, ngjyra që nuk zbehen dhe dizajne elegante që i përshtaten çdo ambienti. Po ashtu, ofrojmë jastëkë dekorues, garnishte dhe shumë produkte të tjera që e kompletojnë dekorimin e shtëpisë.</p>

        <p>Brillant – cilësi, stil dhe shërbim profesional në Lipjan. Porosit online lehtë dhe shpejt, me dërgesë të sigurt në gjithë Kosovën.</p>
      </section>

    </div>
  </main>

  <!-- Footer -->
  <footer class="text-dark pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
          <img src="{{ asset('images/llogo.png') }}" alt="brillant" width="150" class="mb-2">
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <h6 class="text-uppercase fw-bold mb-3">Products</h6>
          <ul class="list-unstyled">
            <li><a href="/tepiha" class="text-dark text-decoration-none">Carpet & Rugs</a></li>
            <li><a href="/tepiha" class="text-dark text-decoration-none">Decorative Carpets</a></li>
            <li><a href="/tepihebanjo" class="text-dark text-decoration-none">Bath Mats & Rugs</a></li>
            <li><a href="/mbulesa" class="text-dark text-decoration-none">Sofa Covers</a></li>
            <li><a href="/postava" class="text-dark text-decoration-none">Bed Sheets</a></li>
            <li><a href="/batanije" class="text-dark text-decoration-none">Blankets</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <h6 class="text-uppercase fw-bold mb-3">Information</h6>
          <ul class="list-unstyled">
            <li><a href="/tepiha" class="text-dark text-decoration-none">Products</a></li>
            <li><a href="#" class="text-dark text-decoration-none">Catalogues</a></li>
            <li><a href="#" class="text-dark text-decoration-none">Manufacturing</a></li>
            <li><a href="{{ route('about') }}" class="text-dark text-decoration-none">About Us</a></li>
          </ul>
        </div>
        <div class="col-md-3 text-center text-md-start">
          <h6 class="text-uppercase fw-bold mb-3">Find Us</h6>
          <ul class="list-unstyled">
            <li><a href="{{ route('contact') }}" class="text-dark text-decoration-none">Contact</a></li>
          </ul>
        </div>
      </div>

      <div class="row mt-4 align-items-center">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          <a href="#" class="text-dark me-3 fs-4"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-dark fs-4"><i class="bi bi-whatsapp"></i></a>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <small class="text-muted">Copyright © {{ date('Y') }} Brillant</small>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col text-center">
          <small class="text-muted">crafted by RDR Digital L.L.C</small>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // përditëso badge në të gjitha menutë
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };

    // dëgjo event-in global kur ndryshon shporta
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });
  </script>
</body>
</html>
