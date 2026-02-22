<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Brillant Tepiha & Perde | Lipjan – Porosit Online</title>

  <!-- ====== SEO CORE ====== -->
  <meta name="description" content="Tepiha moderne & klasik, perde anësore/ditore, set çarçafësh, mbulesa, batanije, jastakë dekorues dhe tepiha për banjo. Porosit online – Brillant Lipjan.">
  <meta name="keywords" content="tepiha, perde, set çarçafësh, mbulesa, batanije, garnishte, jastak dekorues, tepiha banjo, lipjan, kosovë, brilllant, b-brillant">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="author" content="Brillant">
  <meta name="theme-color" content="#dc3545">

  <!-- Canonical (ndrysho domain nëse e ki tjetër) -->
  <link rel="canonical" href="https://b-brillant.com/">

  <!-- OpenGraph -->
  <meta property="og:type" content="website">
  <meta property="og:locale" content="sq_AL">
  <meta property="og:site_name" content="Brillant">
  <meta property="og:title" content="Brillant – Tepiha & Perde | Porosit Online">
  <meta property="og:description" content="Tepiha, perde, set çarçafësh, mbulesa, batanije dhe dekorime për shtëpi. Shërbim profesional në Lipjan + dërgesë në gjithë Kosovën.">
  <meta property="og:url" content="https://b-brillant.com/">
  <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Brillant – Tepiha & Perde | Porosit Online">
  <meta name="twitter:description" content="Tepiha, perde, set çarçafësh, mbulesa, batanije dhe dekorime për shtëpi. Dërgesë në gjithë Kosovën.">
  <meta name="twitter:image" content="{{ asset('images/og-cover.jpg') }}">

  <!-- Performance hints -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ====== STRUCTURED DATA (JSON-LD) ====== -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "Brillant Tepiha & Perde",
    "url": "https://b-brillant.com/",
    "logo": "{{ asset('images/llogo.png') }}",
    "image": "{{ asset('images/og-cover.jpg') }}",
    "telephone": "+38344960661",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Lipjan",
      "addressCountry": "XK"
    },
    "areaServed": "XK",
    "sameAs": [
      "https://www.instagram.com/"
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Brillant",
    "url": "https://b-brillant.com/",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://b-brillant.com/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <style>
    :root{
      --bg: #f6f7fb;
      --text: #0f172a;
      --muted:#64748b;
      --brand:#dc3545;
      --brand2:#ffc107;
      --card:#ffffff;
      --ring: rgba(220,53,69,.22);
      --shadow: 0 18px 45px rgba(2,6,23,.10);
      --shadow2: 0 10px 30px rgba(2,6,23,.08);
      --radius: 18px;
      --radius2: 26px;
    }

    *{ box-sizing:border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family:'Poppins',sans-serif;
      color: var(--text);
      background:
        radial-gradient(1200px 700px at 10% -10%, rgba(220,53,69,.16), transparent 55%),
        radial-gradient(900px 500px at 90% 0%, rgba(255,193,7,.12), transparent 55%),
        var(--bg);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: optimizeLegibility;
    }

    a{ text-decoration:none; }
    .section-pad{ padding: 4rem 0; }
    .soft-card{
      background: rgba(255,255,255,.78);
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
      border-radius: var(--radius2);
      backdrop-filter: blur(10px);
    }
    .pill{ border-radius: 999px !important; }

    /* ===== NAVBAR ===== */
    .navbar-custom{
      position: sticky;
      top:0;
      z-index: 1000;
      padding: .75rem 0;
      background: rgba(15,23,42,.88);
      border-bottom: 1px solid rgba(255,255,255,.08);
      backdrop-filter: blur(14px);
    }
    .navbar-custom .navbar-brand img{
      height: 44px;
      filter: drop-shadow(0 10px 18px rgba(0,0,0,.20));
    }
    .navbar-custom .nav-link{
      color: rgba(248,250,252,.92) !important;
      font-weight: 600;
      font-size: .95rem;
      padding: .55rem .85rem;
      border-radius: 999px;
      transition: all .2s ease;
    }
    .navbar-custom .nav-link:hover{
      background: rgba(255,255,255,.10);
      transform: translateY(-1px);
      color:#fff !important;
    }
    .navbar-custom .navbar-toggler{
      border-color: rgba(255,255,255,.25);
      border-radius: 14px;
      padding: .45rem .6rem;
    }
    .navbar-custom .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu{
      border: 1px solid rgba(2,6,23,.08);
      border-radius: 16px;
      box-shadow: 0 22px 60px rgba(2,6,23,.18);
      padding: .6rem;
    }
    .dropdown-item{
      border-radius: 12px;
      padding: .55rem .75rem;
      font-weight: 600;
    }
    .dropdown-item:hover{
      background: rgba(220,53,69,.10);
      color: var(--brand);
    }

    .dropdown-submenu .submenu{
      display:none;
      position:absolute;
      top:0;
      left:100%;
      margin-left:.25rem;
      min-width: 210px;
      border-radius: 16px;
    }
    .dropdown-submenu:hover .submenu{ display:block; }

    .nav-login-btn{
      border: 1px solid rgba(255,255,255,.28);
      color: rgba(255,255,255,.92);
      background: rgba(255,255,255,.06);
      border-radius: 999px;
      padding: .45rem .9rem;
      font-weight: 800;
    }
    .nav-login-btn:hover{ background: rgba(255,255,255,.10); color:#fff; }

    @media (max-width: 992px){
      .navbar-custom .dropdown-menu{
        background: rgba(17,24,39,.98);
        border-color: rgba(255,255,255,.10);
        box-shadow: none;
      }
      .navbar-custom .dropdown-item{ color: rgba(248,250,252,.92); }
      .navbar-custom .dropdown-item:hover{ background: rgba(255,255,255,.08); color: var(--brand2); }
      .dropdown-submenu .submenu{
        position: static;
        display: block;
        margin-left: 0;
        padding-left: 1rem;
        background: transparent;
        border: none;
      }
    }

    /* ===== TOPBAR ===== */
    .topbar{ margin-top: 16px; }
    .topbar-inner{
      padding: 14px;
      border-radius: var(--radius2);
      background: rgba(255,255,255,.78);
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
    }

    .chips{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 10px;
    }
    .chip{
      width:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      padding: 10px 12px;
      border-radius: 999px;
      background: rgba(2,6,23,.04);
      border: 1px solid rgba(2,6,23,.06);
      font-weight: 800;
      color: #0f172a;
      transition: all .18s ease;
      font-size: 14px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .chip:hover{ background: rgba(220,53,69,.10); color: var(--brand); transform: translateY(-1px); }

    .search-pro{ position: relative; }
    .search-pro input{
      height: 54px;
      border-radius: 999px;
      padding-left: 48px;
      padding-right: 125px;
      border: 1px solid rgba(2,6,23,.10);
      box-shadow: 0 12px 30px rgba(2,6,23,.08);
      outline:none;
    }
    .search-pro input:focus{
      border-color: rgba(220,53,69,.40);
      box-shadow: 0 0 0 6px var(--ring), 0 12px 32px rgba(2,6,23,.10);
    }
    .search-pro .icon{
      position:absolute;
      top:50%;
      left: 18px;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 1.05rem;
    }
    .btn-brand{
      background: var(--brand);
      border-color: var(--brand);
      color:#fff;
      font-weight: 900;
      box-shadow: 0 14px 34px rgba(220,53,69,.22);
    }
    .btn-brand:hover{ filter: brightness(.98); color:#fff; box-shadow: 0 18px 44px rgba(220,53,69,.28); }

    .search-pro .btn{
      position:absolute;
      top:50%;
      right: 6px;
      transform: translateY(-50%);
      border-radius: 999px;
      padding: .65rem 1.05rem;
      font-weight: 900;
    }

    .wa-btn{
      background: #16a34a;
      border: 1px solid rgba(22,163,74,.25);
      color:#fff;
      border-radius: 999px;
      padding: .75rem 1.05rem;
      font-weight: 900;
      box-shadow: 0 14px 34px rgba(22,163,74,.18);
      white-space: nowrap;
    }
    .wa-btn:hover{ filter: brightness(.98); color:#fff; box-shadow: 0 18px 44px rgba(22,163,74,.22); }

    /* ===== HERO ===== */
    .hero{
      margin-top: 16px;
      border-radius: 34px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 32px 90px rgba(2,6,23,.20);
      background: linear-gradient(180deg, rgba(15,23,42,.92), rgba(2,6,23,.92));
      color:#fff;
    }
    .hero-bg{
      position:absolute;
      inset:0;
      background: url('{{ asset('slider/foto1.jpg') }}') center/cover no-repeat;
      filter: brightness(.45) saturate(1.05);
      transform: scale(1.03);
    }
    .hero::after{
      content:"";
      position:absolute;
      inset:0;
      background:
        radial-gradient(900px 500px at 20% 20%, rgba(255,193,7,.18), transparent 55%),
        radial-gradient(900px 500px at 80% 40%, rgba(220,53,69,.22), transparent 60%),
        linear-gradient(90deg, rgba(2,6,23,.72), rgba(2,6,23,.32) 60%, rgba(2,6,23,.70));
    }
    .hero-content{
      position:relative;
      z-index:2;
      padding: 3.2rem 1.6rem;
    }
    .hero-badge{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.4rem .9rem;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.16);
      font-size: .82rem;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-weight: 800;
    }
    .hero-badge span{
      background: var(--brand2);
      color: #111;
      padding: .12rem .6rem;
      border-radius: 999px;
      font-weight: 900;
      letter-spacing: .10em;
    }
    .hero-title{
      margin-top: 1rem;
      font-weight: 900;
      line-height: 1.06;
      font-size: clamp(2.05rem, 4.4vw, 3.45rem);
    }
    .hero-title em{ font-style: normal; color: var(--brand2); }
    .hero-sub{
      margin-top: 1rem;
      max-width: 600px;
      color: rgba(248,250,252,.92);
      line-height: 1.75;
      font-size: 1.02rem;
    }
    .hero-actions{
      margin-top: 1.35rem;
      display:flex;
      gap:.75rem;
      flex-wrap: wrap;
    }
    .hero-actions .btn{
      border-radius: 999px;
      padding: .78rem 1.45rem;
      font-weight: 900;
    }
    .trust-row{
      margin-top: 1.25rem;
      display:flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .trust{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding: .6rem .85rem;
      border-radius: 16px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.14);
      font-weight: 800;
      color: rgba(248,250,252,.95);
      font-size: .92rem;
    }
    .trust i{ color: var(--brand2); }

    /* Weekly card */
    .weekly-card{
      border-radius: 26px;
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(255,255,255,.18);
      box-shadow: 0 18px 55px rgba(2,6,23,.24);
      overflow:hidden;
    }
    .weekly-card .head{ padding: 1rem 1.1rem .3rem; }
    .weekly-card .kicker{
      font-size: .78rem;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: rgba(2,6,23,.55);
      margin-bottom: .35rem;
      font-weight: 900;
    }
    .weekly-card .title{ font-weight: 900; margin:0; color:#0f172a; }
    .weekly-item{ padding: .9rem 1.1rem; border-top: 1px solid rgba(2,6,23,.06); }
    .weekly-item img{
      width: 112px; height: 112px; object-fit: cover; border-radius: 16px;
      box-shadow: 0 12px 26px rgba(2,6,23,.12);
    }
    .price{ font-weight: 900; color: var(--brand); }
    .old{ color: rgba(2,6,23,.45); text-decoration: line-through; font-size: .9rem; }

    /* ===== Sections ===== */
    .section-title{ text-align:center; margin-bottom: 2.2rem; }
    .section-title .k{
      display:inline-block;
      font-size: .82rem;
      font-weight: 900;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--brand);
      background: rgba(220,53,69,.08);
      border: 1px solid rgba(220,53,69,.14);
      padding: .38rem .85rem;
      border-radius: 999px;
    }
    .section-title h2{ margin-top:.85rem; font-weight: 900; color:#0f172a; }
    .section-title p{ margin: .55rem auto 0; max-width: 720px; color: var(--muted); }

    /* Category cards */
    .cat-card{
      height:100%;
      border-radius: 22px;
      background:#fff;
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
      overflow:hidden;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .cat-card:hover{ transform: translateY(-6px); box-shadow: 0 26px 70px rgba(2,6,23,.14); }
    .cat-media{ position:relative; overflow:hidden; }
    .cat-media img{ width:100%; height: 220px; object-fit: cover; transition: transform .5s ease; }
    .cat-card:hover .cat-media img{ transform: scale(1.07); }
    .cat-badge{
      position:absolute; top: 12px; left: 12px;
      background: rgba(2,6,23,.78);
      color:#fff;
      padding: .28rem .75rem;
      border-radius: 999px;
      font-size: .76rem;
      font-weight: 900;
      letter-spacing:.06em;
    }
    .cat-body{ padding: 1rem 1.1rem 1.2rem; }
    .cat-body h5{ font-weight: 900; margin-bottom: .35rem; }
    .cat-body p{ color: var(--muted); font-size: .93rem; margin-bottom: .9rem; }
    .cat-link{
      display:inline-flex; align-items:center; gap:.45rem;
      font-weight: 900; letter-spacing:.12em; text-transform: uppercase;
      font-size: .82rem; color: var(--brand);
    }

    /* Product cards */
    .product-card{
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 22px;
      overflow:hidden;
      box-shadow: var(--shadow2);
      background:#fff;
      height:100%;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-card:hover{ transform: translateY(-5px); box-shadow: 0 24px 66px rgba(2,6,23,.14); }
    .product-card img{ height: 270px; width:100%; object-fit: cover; }
    .product-card .card-body{ padding: 1rem 1.1rem 1.2rem; }
    .tag{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: .25rem .6rem;
      border-radius: 999px;
      font-size: .78rem;
      font-weight: 900;
      background: rgba(220,53,69,.10);
      color: var(--brand);
      border: 1px solid rgba(220,53,69,.16);
    }

    /* Why choose us */
    .why-wrap{
      background: rgba(255,255,255,.82);
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 28px;
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .why-side{
      padding: 2rem;
      background: linear-gradient(180deg, rgba(220,53,69,.08), rgba(255,255,255,0));
    }
    .why-points{ padding: 2rem; }
    .why-bullet{
      padding: .95rem 1rem;
      border-radius: 18px;
      border: 1px solid rgba(2,6,23,.06);
      background: rgba(255,255,255,.78);
      box-shadow: 0 10px 26px rgba(2,6,23,.07);
      margin-bottom: .85rem;
    }
    .why-bullet h5{ font-weight: 900; font-size: 1rem; margin-bottom: .25rem; }
    .why-bullet p{ color: var(--muted); margin:0; font-size: .95rem; line-height: 1.6; }

    /* Newsletter */
    .newsletter{
      border-radius: 28px;
      background: linear-gradient(135deg, rgba(220,53,69,.10), rgba(255,193,7,.10));
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
      padding: 1.8rem;
    }
    .newsletter h3{ font-weight: 900; margin:0; }
    .newsletter p{ color: var(--muted); margin:.35rem 0 1rem; }
    .newsletter .form-control{
      height: 52px;
      border-radius: 999px;
      border: 1px solid rgba(2,6,23,.10);
    }

    /* SEO text */
    .seo-text{
      font-size: .98rem;
      line-height: 1.75;
      color: rgba(2,6,23,.78);
      background: rgba(255,255,255,.78);
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 22px;
      padding: 1.6rem;
      box-shadow: var(--shadow2);
    }
    .seo-text h2{ font-weight: 900; margin-bottom: .85rem; }

    /* Footer */
    footer{
      font-size:.92rem;
      background: rgba(255,255,255,.78) !important;
      border-top: 1px solid rgba(2,6,23,.08) !important;
      backdrop-filter: blur(12px);
    }

    /* Mobile CTA bar */
    .mobile-cta{
      display:none;
      position: fixed;
      left: 12px;
      right: 12px;
      bottom: 12px;
      z-index: 1200;
      background: rgba(15,23,42,.92);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 18px;
      padding: 10px;
      backdrop-filter: blur(14px);
      box-shadow: 0 18px 45px rgba(2,6,23,.22);
    }
    .mobile-cta a{
      flex:1;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      padding: 12px 10px;
      border-radius: 14px;
      font-weight: 900;
      color:#fff;
    }
    .mobile-cta a.call{ background: rgba(255,255,255,.10); }
    .mobile-cta a.wa{ background: #16a34a; }

    /* Responsive */
    @media (max-width: 992px){
      .hero-content{ padding: 2.6rem 1.1rem; }
      .weekly-card{ margin-top: 14px; }
      .search-pro input{ padding-right: 110px; }
    }
    @media (max-width: 768px){
      .section-pad{ padding: 3.2rem 0; }
      .hero-actions .btn{ width: 100%; }
      .trust-row{ justify-content:center; }
      .mobile-cta{ display:flex; gap:10px; }
      body{ padding-bottom: 84px; } /* space for mobile CTA */
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Main navigation">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/" aria-label="Brillant Home">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant Logo">
      </a>

      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarContent" aria-controls="navbarContent"
        aria-expanded="false" aria-label="Hap menynë">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-lg-center gap-lg-1 me-lg-2">

          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="catalogDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">Products</a>

            <ul class="dropdown-menu" aria-labelledby="catalogDropdown">
              <li><a class="dropdown-item" href="/tepiha">Tepiha</a></li>

              <li class="dropdown-submenu position-relative">
                <a class="dropdown-item dropdown-toggle" href="#" role="button">Perde</a>
                <ul class="dropdown-menu submenu shadow">
                  <li><a class="dropdown-item" href="/anesore">Perde Anësore</a></li>
                  <li><a class="dropdown-item" href="/perde-ditore">Perde Ditore</a></li>
                </ul>
              </li>

              <li><a class="dropdown-item" href="/jastekdekorues">Jastek Dekorues</a></li>
              <li><a class="dropdown-item" href="/postava">Set çarçafesh</a></li>
              <li><a class="dropdown-item" href="/mbulesa">Mbulesa</a></li>
              <li><a class="dropdown-item" href="/batanije">Batanije</a></li>
              <li><a class="dropdown-item" href="/tepihebanjo">Tepiha për Banjo</a></li>
              <li><a class="dropdown-item" href="/posteqia">Lëkurë Pelushi</a></li>
              <li><a class="dropdown-item" href="/garnishte">Garnishte</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>

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

  <!-- TOPBAR -->
  <div class="container topbar">
    <div class="topbar-inner">
      <div class="row g-3 align-items-center">
        <div class="col-lg-4">
          <div class="chips">
            <a class="chip" href="/tepiha"><i class="bi bi-grid"></i> Tepiha</a>
            <a class="chip" href="/mbulesa"><i class="bi bi-house"></i> Mbulesa</a>
            <a class="chip" href="/anesore"><i class="bi bi-layout-text-window"></i> Perde</a>
            <a class="chip" href="/garnishte"><i class="bi bi-stars"></i> Garnishte</a>
            <a class="chip" href="/batanije"><i class="bi bi-snow"></i> Batanije</a>
            <a class="chip" href="/postava"><i class="bi bi-bag-check"></i> Set çarçafesh</a>
          </div>
        </div>

        <div class="col-lg-5">
          <form action="{{ route('search') }}" method="GET" class="search-pro" role="search" aria-label="Kërko produkte">
            <i class="bi bi-search icon"></i>
            <input type="text" name="q" class="form-control"
                   placeholder="Kërko produktin (p.sh. tepiha 150x230, perde ditore...)"
                   value="{{ request('q') }}" required>
            <button class="btn btn-brand" type="submit">Kërko</button>
          </form>
          <div class="mt-2 small text-muted">
            Popullore: <a class="text-danger fw-bold" href="/tepiha">Tepiha</a> · <a class="text-danger fw-bold" href="/anesore">Perde</a> · <a class="text-danger fw-bold" href="/postava">Set çarçafesh</a>
          </div>
        </div>

        <div class="col-lg-3 text-lg-end">
          <a href="https://wa.me/38344960661" target="_blank" rel="noopener" class="wa-btn d-inline-flex align-items-center gap-2">
            <i class="bi bi-whatsapp"></i> Chat në WhatsApp
          </a>
          <div class="small text-muted mt-2">
            Për porosi / matje: <span class="fw-bold">+383 44 960 661</span>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- HERO -->
  <section class="container mt-3">
    <div class="hero">
      <div class="hero-bg" aria-hidden="true"></div>

      <div class="hero-content">
        <div class="row align-items-center gy-4">
          <div class="col-lg-7">
            <div class="hero-badge">
              <span>NEW</span> Koleksion i ri – dizajn modern & cilësi premium
            </div>

            <h1 class="hero-title">
              Tepiha & perde <em>premium</em> për shtëpi moderne.
            </h1>

            <p class="hero-sub">
              Zgjidh dizajnin ideal për sallon, dhomë gjumi apo zyrë.
              Ngjyra që nuk zbehen, teksturë cilësore dhe shërbim profesional nga Brillant në Lipjan.
            </p>

            <div class="hero-actions">
              <a href="/tepiha" class="btn btn-brand">
                <i class="bi bi-grid me-1"></i> Shiko tepihat
              </a>
              <a href="/anesore" class="btn btn-outline-light">
                <i class="bi bi-layout-text-window me-1"></i> Shiko perdet
              </a>
              <a href="{{ route('contact') }}" class="btn btn-light">
                <i class="bi bi-geo-alt me-1"></i> Na gjej
              </a>
            </div>

            <div class="trust-row">
              <div class="trust"><i class="bi bi-check-circle-fill"></i> Dërgesë në gjithë Kosovën</div>
              <div class="trust"><i class="bi bi-shield-check"></i> Cilësi & garanci</div>
              <div class="trust"><i class="bi bi-scissors"></i> Qepje & montim profesional</div>
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

                  <div class="carousel-item active">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img loading="lazy" src="{{ asset('slider/side.bmp') }}" alt="Tepiha Modern 150x230">
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

                  <div class="carousel-item">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img loading="lazy" src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha Hali 200x300">
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

                  <div class="carousel-item">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img loading="lazy" src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh pambuk">
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

        </div>
      </div>

    </div>
  </section>

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
                  <img loading="lazy" src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha">
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
                  <img loading="lazy" src="{{ asset('slider/raffaello.jpg') }}" alt="Perde">
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
                  <img loading="lazy" src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh">
                  <span class="cat-badge">Shtrat</span>
                </div>
                <div class="cat-body">
                  <h5>Set çarçafësh & kompleta</h5>
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
                  <img loading="lazy" src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa & batanije">
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

      <!-- Latest products (DB) -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">PRODUKTET E FUNDIT</span>
          <h2>Zbuloni çfarë ka ardhur rishtazi</h2>
          <p>Produktet e reja që janë shtuar së fundmi në katalog.</p>
        </div>

        <div class="row g-4">
          @if(isset($items) && $items->count())
            @foreach($items->take(6) as $item)
              <div class="col-md-4 col-sm-6">
                <div class="card product-card">
                  @if($item->image_path)
                    <img loading="lazy" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}">
                  @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:270px;">
                      <span class="text-white">Pa foto</span>
                    </div>
                  @endif

                  <div class="card-body">
                    <span class="tag"><i class="bi bi-fire"></i> Trending</span>
                    <h5 class="fw-bold text-danger mt-2 mb-1">{{ $item->name }}</h5>
                    <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit($item->description, 110) }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col-12">
              <div class="soft-card p-4 text-center">
                <h5 class="fw-bold mb-1">S’ka produkte për momentin</h5>
                <p class="text-muted mb-0">Shto produkte në admin dhe do dalin këtu automatikisht.</p>
              </div>
            </div>
          @endif
        </div>
      </section>

      <!-- Why choose us -->
      <section class="why-wrap mb-5">
        <div class="row g-0 align-items-stretch">
          <div class="col-md-5 why-side">
            <div class="text-md-start text-center">
              <span class="k">PSE BRILLANT?</span>
              <h2 class="mt-3 fw-bold">Tekstil i zgjedhur, shërbim i kujdesshëm.</h2>
              <p class="mt-2 text-muted">Matje, konsulencë dhe qepje profesionale – me fokus në cilësi dhe kënaqësi.</p>
            </div>
            <img loading="lazy" src="{{ asset('slider/raffaello.jpg') }}" class="img-fluid rounded-4 shadow-sm mt-3" alt="Perde cilësore Brillant">
          </div>

          <div class="col-md-7 why-points">
            <div class="why-bullet">
              <h5><i class="bi bi-check2-circle text-danger me-1"></i> Perde me sistem amerikan</h5>
              <p>Montim i lehtë dhe pamje elegante për çdo ambient modern.</p>
            </div>
            <div class="why-bullet">
              <h5><i class="bi bi-check2-circle text-danger me-1"></i> Tepiha antibakteriale (akrilik)</h5>
              <p>Rezistent ndaj shtypjes, i lehtë për pastrim dhe jetëgjatë.</p>
            </div>
            <div class="why-bullet">
              <h5><i class="bi bi-check2-circle text-danger me-1"></i> Set çarçafësh & mbulesa premium</h5>
              <p>Komoditet maksimal, material i butë dhe ngjyra që nuk zbehen.</p>
            </div>
            <div class="why-bullet mb-0">
              <h5><i class="bi bi-check2-circle text-danger me-1"></i> Shërbim profesional në Lipjan</h5>
              <p>Matje në terren + këshillim për modelin + qepje profesionale – gjithçka në një vend.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Newsletter -->
      <section class="newsletter mb-5">
        <div class="row align-items-center g-3">
          <div class="col-lg-6">
            <h3>Merre ofertën e javës në inbox ✨</h3>
            <p>Na lë email-in dhe t’i dërgojmë zbritjet / koleksionet e reja.</p>
          </div>
          <div class="col-lg-6">
            <form class="d-flex gap-2 flex-column flex-sm-row" onsubmit="event.preventDefault(); alert('Faleminderit!');">
              <input type="email" class="form-control" placeholder="Email-i yt..." required>
              <button class="btn btn-brand pill px-4" type="submit">Abonohu</button>
            </form>
          </div>
        </div>
      </section>

      <!-- SEO text -->
      <section class="seo-text">
        <h2>Brillant – Tepiha, Perde dhe Dekorime për Shtëpi</h2>
        <p>Brillant është destinacioni juaj i besueshëm për tepiha modern, perde cilësore, mbulesa të bukura dhe dekorime për shtëpi. Me përvojë shumëvjeçare, synimi ynë është t’ju ofrojmë produkte të cilësisë së lartë që i bëjnë ambientet tuaja më të bukura, më komode dhe më funksionale.</p>
        <p>Koleksioni ynë përfshin tepihë modern, tepihë klasik, tepihë rrethor, tepihë për sallon dhe tepiha për banjo. Ofruojmë gjithashtu batanije premium, kompleta krevati dhe sete çarçafësh për komoditet maksimal.</p>
        <p>Në kategorinë e perdeve, do të gjeni materiale të cilësisë së lartë dhe dizajne elegante që i përshtaten çdo ambienti. Brillant – cilësi, stil dhe shërbim profesional në Lipjan, me dërgesë të sigurt në gjithë Kosovën.</p>
      </section>

    </div>
  </main>

  <!-- Footer -->
  <footer class="text-dark pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <img src="{{ asset('images/llogo.png') }}" alt="Brillant" width="150" class="mb-2">
          <p class="text-muted mb-2">Tepiha · Perde · Set çarçafësh · Mbulesa · Batanije · Dekor</p>
          <div class="small">
            <div><i class="bi bi-geo-alt me-1 text-danger"></i> Lipjan, Kosovë</div>
            <div><i class="bi bi-telephone me-1 text-danger"></i> +383 44 960 661</div>
          </div>
        </div>

        <div class="col-md-2">
          <h6 class="text-uppercase fw-bold mb-3">Katalog</h6>
          <ul class="list-unstyled">
            <li><a href="/tepiha" class="text-dark">Tepiha</a></li>
            <li><a href="/anesore" class="text-dark">Perde</a></li>
            <li><a href="/postava" class="text-dark">Set çarçafësh</a></li>
            <li><a href="/mbulesa" class="text-dark">Mbulesa</a></li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6 class="text-uppercase fw-bold mb-3">Informata</h6>
          <ul class="list-unstyled">
            <li><a href="{{ route('about') }}" class="text-dark">About Us</a></li>
            <li><a href="{{ route('contact') }}" class="text-dark">Contact</a></li>
            <li><a href="/track" class="text-dark">Gjurmo porosinë</a></li>
            <li><a href="{{ route('cart.index') }}" class="text-dark">Shporta</a></li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6 class="text-uppercase fw-bold mb-3">Social</h6>
          <div class="d-flex gap-3">
            <a href="#" class="text-dark fs-4" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://wa.me/38344960661" target="_blank" rel="noopener" class="text-dark fs-4" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          </div>
          <div class="small text-muted mt-3">
            Porosi të shpejta në WhatsApp – përgjigje brenda ditës.
          </div>
        </div>
      </div>

      <hr class="my-4">

      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <small class="text-muted">Copyright © {{ date('Y') }} Brillant</small>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <small class="text-muted">crafted by RDR Digital L.L.C</small>
        </div>
      </div>
    </div>
  </footer>

  <!-- Mobile CTA -->
  <div class="mobile-cta" role="navigation" aria-label="Mobile actions">
    <a class="call" href="tel:+38344960661"><i class="bi bi-telephone"></i> Thirr</a>
    <a class="wa" href="https://wa.me/38344960661" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a>
  </div>

  <script>
    // përditëso badge në të gjitha menutë
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });
  </script>
</body>
</html>