<!doctype html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Brillant Tepiha &amp; Perde | b-brillant.com</title>
  <meta name="description" content="Tepiha moderne, perde, set qarqafësh, mbulesa, jastakë dekorues dhe tepiha për banjo. Cilësi dhe dizajn për shtëpinë tuaj në Lipjan." />
  <meta name="theme-color" content="#dc3545" />
  <meta name="color-scheme" content="light" />

  <!-- Open Graph / Social -->
  <meta property="og:title" content="Brillant Tepiha & Perde" />
  <meta property="og:description" content="Tepiha & perde premium, sete çarçafësh, mbulesa dhe dekorime për shtëpi. Porosit online në Kosovë." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="{{ asset('images/llogo.png') }}" />

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}" />

  <style>
    /* =========================================================
      BRILLANT HOME — ULTRA RESPONSIVE PRO CSS (Mobile-First)
      - Rrugët e path-ve nuk janë prek
      - Shtuar: mobile dock, animacione ma smooth, layout ma clean
      - Bootstrap 5.3 compatible
    ========================================================== */

    :root{
      --bg: #f6f7fb;
      --text: #0b1220;
      --muted: #6b7280;
      --surface: rgba(255,255,255,.78);
      --surface-2: rgba(255,255,255,.92);
      --brand: #dc3545;
      --brand-2: #ffc107;
      --success: #16a34a;
      --ring: rgba(220,53,69,.25);

      --shadow: 0 22px 60px rgba(2,6,23,.12);
      --shadow-soft: 0 12px 30px rgba(2,6,23,.10);

      --radius: 18px;
      --radius-lg: 26px;

      --navH: 74px;            /* setohet edhe me JS */
      --dockH: 64px;           /* mobile bottom dock */
      --safeTop: env(safe-area-inset-top, 0px);
      --safeBottom: env(safe-area-inset-bottom, 0px);

      --containerPad: 16px;
    }

    *{ box-sizing: border-box; }
    html, body{ height: 100%; }
    html{ scroll-behavior: smooth; }
    body{
      margin: 0;
      font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:
        radial-gradient(1200px 700px at 10% -10%, rgba(220,53,69,.18), transparent 55%),
        radial-gradient(900px 500px at 90% 0%, rgba(255,193,7,.14), transparent 55%),
        var(--bg);
      color: var(--text);
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;

      /* mos u mshef content poshte mobile dock */
      padding-bottom: calc(var(--dockH) + var(--safeBottom));
    }

    a{ text-decoration: none; transition: transform .18s ease, opacity .18s ease, color .18s ease; }
    img{ max-width: 100%; height: auto; display: block; }

    ::selection{ background: rgba(220,53,69,.18); }

    :focus-visible{
      outline: none !important;
      box-shadow: 0 0 0 5px var(--ring) !important;
      border-color: rgba(220,53,69,.45) !important;
    }

    .container{ padding-left: var(--containerPad); padding-right: var(--containerPad); }

    /* ===== Helpers ===== */
    .section-pad{ padding: 3.25rem 0; }
    @media (min-width: 992px){
      .section-pad{ padding: 4.2rem 0; }
    }

    .soft-card{
      background: var(--surface);
      border: 1px solid rgba(17,24,39,.06);
      box-shadow: var(--shadow-soft);
      border-radius: var(--radius-lg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .pill{ border-radius: 999px !important; }

    .btn-brand{
      background: var(--brand);
      border-color: var(--brand);
      color: #fff;
      font-weight: 900;
      letter-spacing: .02em;
      box-shadow: 0 12px 28px rgba(220,53,69,.22);
      transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
    }
    .btn-brand:hover{
      filter: brightness(.98);
      transform: translateY(-1px);
      box-shadow: 0 16px 38px rgba(220,53,69,.28);
      color:#fff;
    }
    .btn-brand:active{ transform: translateY(0); }

    /* ========================= ANNOUNCEMENT BAR (NEW) ========================== */
    .announce{
      position: sticky;
      top: 0;
      z-index: 1200;
      padding-top: var(--safeTop);
      background: linear-gradient(90deg, rgba(220,53,69,.96), rgba(255,193,7,.92));
      color: #0b1220;
      border-bottom: 1px solid rgba(2,6,23,.06);
    }
    .announce .inner{
      display:flex;
      align-items:center;
      justify-content: center;
      gap: .6rem;
      padding: .55rem 0;
      font-weight: 800;
      font-size: .92rem;
      text-align: center;
    }
    .announce .inner i{ opacity: .95; }
    .announce a{
      color: #0b1220;
      text-decoration: underline;
      text-underline-offset: 3px;
      font-weight: 900;
    }
    @media (min-width: 992px){
      .announce .inner{ font-size: .95rem; }
    }

    /* ========================= NAVBAR ========================== */
    .navbar-custom{
      position: sticky;
      top: calc(0px + var(--safeTop));
      z-index: 1100;
      padding: .72rem 0;
      background: linear-gradient(90deg, rgba(15,23,42,.92), rgba(17,24,39,.92));
      border-bottom: 1px solid rgba(255,255,255,.08);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    .navbar-custom .navbar-brand img{
      height: 44px;
      filter: drop-shadow(0 10px 14px rgba(0,0,0,.22));
    }

    .navbar-custom .nav-link{
      color: rgba(248,250,252,.92) !important;
      font-weight: 700;
      font-size: .95rem;
      padding: .55rem .85rem;
      border-radius: 999px;
      transition: background .2s ease, transform .2s ease;
    }
    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus{
      background: rgba(255,255,255,.08);
      transform: translateY(-1px);
    }

    .navbar-custom .navbar-toggler{
      border-color: rgba(255,255,255,.30);
      border-radius: 14px;
      padding: .45rem .6rem;
    }
    .navbar-custom .navbar-toggler-icon{
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28 255, 255, 255, 0.90 %29)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu{
      border: 1px solid rgba(2,6,23,.08);
      border-radius: 16px;
      box-shadow: 0 20px 55px rgba(2,6,23,.18);
      padding: .6rem;
    }
    .dropdown-item{
      border-radius: 12px;
      padding: .6rem .8rem;
      font-weight: 700;
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
      min-width: 220px;
      border-radius: 16px;
    }
    .dropdown-submenu:hover .submenu{ display:block; }

    .nav-login-btn{
      border: 1px solid rgba(255,255,255,.28);
      color: rgba(255,255,255,.92);
      background: rgba(255,255,255,.06);
      border-radius: 999px;
      padding: .45rem .9rem;
      font-weight: 900;
      transition: transform .18s ease, background .18s ease;
    }
    .nav-login-btn:hover{
      background: rgba(255,255,255,.10);
      color:#fff;
      transform: translateY(-1px);
    }

    /* Mobile navbar dropdown */
    @media (max-width: 992px){
      .navbar-custom{ padding: .62rem 0; }
      .navbar-custom .navbar-brand img{ height: 40px; }

      .navbar-custom .dropdown-menu{
        background: rgba(17,24,39,.98);
        border-color: rgba(255,255,255,.10);
        box-shadow: none;
      }
      .navbar-custom .dropdown-item{ color: rgba(248,250,252,.92); }
      .navbar-custom .dropdown-item:hover{
        background: rgba(255,255,255,.06);
        color: var(--brand-2);
      }

      .dropdown-submenu .submenu{
        position: static;
        margin-left: 0;
        padding-left: .85rem;
        background: transparent;
        border: none;
        display:none;
      }
      .dropdown-submenu .submenu.show{ display:block; }
    }

    /* ========================= TOPBAR ========================== */
    .topbar{ margin-top: 14px; }
    .topbar-inner{
      padding: 14px;
      border-radius: var(--radius-lg);
      background: var(--surface);
      border: 1px solid rgba(17,24,39,.06);
      box-shadow: var(--shadow-soft);
    }

    /* sticky topbar ne mobile */
    @media (max-width: 992px){
      .topbar-inner{
        position: sticky;
        top: calc(var(--navH) + var(--safeTop));
        z-index: 1000;
      }
    }

    /* Chips grid */
    .chips-2rows{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 10px;
    }
    @media (max-width: 576px){
      .chips-2rows{ grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
    }

    .chip{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:.5rem;
      width: 100%;
      padding: .6rem .85rem;
      border-radius: 999px;
      background: rgba(17,24,39,.04);
      border: 1px solid rgba(17,24,39,.06);
      font-weight: 900;
      color: #0f172a;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      box-shadow: 0 10px 22px rgba(2,6,23,.06);
      transition: transform .18s ease, background .18s ease, box-shadow .18s ease;
    }
    .chip:hover{
      background: rgba(220,53,69,.08);
      transform: translateY(-2px);
      color: var(--brand);
      box-shadow: 0 16px 30px rgba(2,6,23,.10);
    }
    .chip i{ opacity:.9; }

    /* Search */
    .search-pro{ 
      position: relative;
      width: 100%;
    }
    .search-pro input{
      height: 54px;
      border-radius: 999px;
      padding-left: 46px;
      padding-right: 124px;
      border: 2px solid rgba(17,24,39,.12);
      box-shadow: 0 12px 30px rgba(2,6,23,.08);
      outline: none;
      font-weight: 700;
      font-size: 1rem;
      width: 100%;
      transition: all 0.3s ease;
      background: rgba(255,255,255,.96);
    }
    .search-pro input:hover {
      border-color: rgba(220,53,69,.2);
      box-shadow: 0 16px 40px rgba(2,6,23,.12);
    }
    .search-pro input:focus {
      border-color: var(--brand);
      box-shadow: 0 12px 30px rgba(220,53,69,.15);
    }
    .search-pro input::placeholder{ 
      color: rgba(107,114,128,.8);
      font-weight: 600;
    }
    .search-pro .icon{
      position:absolute;
      top:50%;
      left: 16px;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 1.1rem;
      pointer-events: none;
      z-index: 1;
    }
    .search-pro .btn{
      position:absolute;
      top: 5px;
      right: 6px;
      bottom: 5px;
      transform: none;
      border-radius: 999px;
      padding: 0.65rem 1.3rem;
      font-weight: 900;
      font-size: 0.95rem;
      letter-spacing: 0.02em;
      white-space: nowrap;
      background: var(--brand);
      border: none;
      color: #fff;
      height: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 8px 20px rgba(220,53,69,.2);
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: 2;
    }
    .search-pro .btn:hover {
      background: rgba(220,53,69,.92);
      transform: scale(1.03);
      box-shadow: 0 12px 30px rgba(220,53,69,.3);
    }
    .search-pro .btn:active {
      transform: scale(0.98);
    }

    /* WhatsApp */
    .wa-btn{
      background: var(--success);
      border: 1px solid rgba(22,163,74,.25);
      color: #fff;
      border-radius: 999px;
      padding: .75rem 1.1rem;
      font-weight: 900;
      box-shadow: 0 12px 30px rgba(22,163,74,.18);
      white-space: nowrap;
      transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
    }
    .wa-btn:hover{
      filter: brightness(.98);
      color:#fff;
      transform: translateY(-1px);
      box-shadow: 0 16px 40px rgba(22,163,74,.22);
    }

    /* Topbar mobile stacking */
    @media (max-width: 768px){
      .topbar-inner{ padding: 12px; }
      .search-pro input{ 
        height: 52px; 
        padding-right: 112px;
        font-size: 0.95rem;
      }
      .search-pro .btn {
        padding: 0.6rem 1.1rem;
        font-size: 0.9rem;
      }
    }
    @media (max-width: 576px){
      .topbar{ margin-top: 10px; }
      .search-pro input{ 
        height: 50px;
        padding-right: 110px;
        padding-left: 42px;
        font-size: 0.9rem;
      }
      .search-pro .icon {
        font-size: 1rem;
        left: 14px;
      }
      .search-pro .btn{ 
        padding: 0.55rem 0.95rem;
        font-size: 0.85rem;
        right: 5px;
      }
      .wa-btn{ width: 100%; justify-content: center; }
    }

    /* ========================= HERO ========================== */
    .hero{
      margin-top: 14px;
      border-radius: 32px;
      overflow: hidden;
      position: relative;
      background:
        radial-gradient(900px 500px at 20% 20%, rgba(255,193,7,.18), transparent 55%),
        radial-gradient(900px 500px at 80% 40%, rgba(220,53,69,.22), transparent 60%),
        linear-gradient(180deg, rgba(15,23,42,.92), rgba(2,6,23,.92));
      color: #fff;
      box-shadow: 0 32px 90px rgba(2,6,23,.26);
    }

    .hero-bg{
      position:absolute;
      inset:0;
      background: url("{{ asset('slider/foto1.jpg') }}") center/cover no-repeat;
      filter: brightness(.45) saturate(1.05);
      transform: scale(1.06);
      z-index: 0;
      transition: opacity .65s ease;
    }
    .hero-bg.bg-swap{ opacity: .92; }

    .hero::after{
      content:"";
      position:absolute;
      inset:0;
      background: linear-gradient(90deg, rgba(2,6,23,.74), rgba(2,6,23,.26) 55%, rgba(2,6,23,.74));
      z-index: 1;
    }

    .hero-content{
      position: relative;
      z-index: 2;
      padding: 2.2rem 1.15rem;
    }
    @media (min-width: 992px){
      .hero-content{ padding: 3.2rem 1.6rem; }
    }

    .hero-badge{
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.42rem .9rem;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.14);
      font-size: .82rem;
      text-transform: uppercase;
      letter-spacing: .12em;
      animation: fadeUp .7s ease both;
    }
    .hero-badge span{
      background: var(--brand-2);
      color: #111;
      padding: .14rem .55rem;
      border-radius: 999px;
      font-weight: 900;
      letter-spacing: .10em;
    }

    .hero-title{
      font-weight: 900;
      line-height: 1.06;
      margin-top: .95rem;
      font-size: clamp(1.95rem, 4.7vw, 3.35rem);
      animation: fadeUp .85s ease both;
      animation-delay: .06s;
    }
    .hero-title em{ font-style: normal; color: var(--brand-2); }

    .hero-sub{
      margin-top: .95rem;
      max-width: 600px;
      color: rgba(248,250,252,.92);
      font-size: 1rem;
      line-height: 1.7;
      animation: fadeUp .9s ease both;
      animation-delay: .10s;
    }

    .hero-actions{
      margin-top: 1.15rem;
      display:flex;
      gap:.75rem;
      flex-wrap: wrap;
      animation: fadeUp .95s ease both;
      animation-delay: .14s;
    }
    .hero-actions .btn{
      border-radius: 999px;
      padding: .82rem 1.35rem;
      font-weight: 900;
    }
    .hero-actions .btn:hover{ transform: translateY(-2px); }
    .hero-actions .btn-outline-light{ border-width: 2px; }

    /* HERO mobile: buttons full width */
    @media (max-width: 576px){
      .hero-actions .btn{ width: 100%; }
    }

    .hero-stats{
      margin-top: 1.25rem;
      display:flex;
      gap: 12px;
      flex-wrap: wrap;
      animation: fadeUp 1s ease both;
      animation-delay: .18s;
    }
    .stat{
      padding: .82rem 1rem;
      border-radius: 18px;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.12);
      min-width: 170px;
      box-shadow: 0 18px 36px rgba(2,6,23,.18);
      transition: transform .2s ease;
    }
    .stat:hover{ transform: translateY(-3px); }
    .stat .n{
      font-size: 1.35rem;
      font-weight: 900;
      color: var(--brand-2);
      line-height: 1;
    }
    .stat .t{
      font-size: .92rem;
      color: rgba(248,250,252,.88);
      margin-top: .3rem;
    }
    @media (max-width: 768px){
      .hero-stats{ justify-content: center; }
      .stat{ min-width: 155px; }
    }

    /* Weekly offers card */
    .weekly-card{
      border-radius: 26px;
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(255,255,255,.16);
      box-shadow: 0 20px 60px rgba(2,6,23,.24);
      overflow: hidden;
      transform: translateZ(0);
      animation: popIn .55s ease both;
    }
    .weekly-card .head{ padding: 1rem 1.1rem .35rem; }
    .weekly-card .kicker{
      font-size: .78rem;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: rgba(2,6,23,.55);
      margin-bottom: .35rem;
      font-weight: 900;
    }
    .weekly-card .title{ font-weight: 900; margin:0; color: #0f172a; }

    .weekly-item{
      padding: 1rem 1.1rem;
      border-top: 1px solid rgba(2,6,23,.06);
    }
    .weekly-item img{
      width: 112px;
      height: 112px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: 0 12px 26px rgba(2,6,23,.12);
      transition: transform .35s ease;
    }
    .carousel-item.active .weekly-item img{ transform: scale(1.02); }

    .price{ font-weight: 900; color: var(--brand); }
    .old{
      color: rgba(2,6,23,.45);
      text-decoration: line-through;
      font-size: .9rem;
    }

    /* Weekly mobile layout: img nalt, text poshte */
    @media (max-width: 576px){
      .weekly-item .d-flex{ flex-direction: column; align-items: flex-start !important; }
      .weekly-item img{ width: 100%; height: 160px; }
    }

    /* carousel controls */
    .carousel-control-prev,
    .carousel-control-next{ width: 48px; opacity: 1; }
    .carousel-control-prev-icon,
    .carousel-control-next-icon{
      filter: drop-shadow(0 12px 24px rgba(0,0,0,.28));
    }

    /* ========================= SECTION TITLES ========================== */
    .section-title{
      text-align:center;
      margin-bottom: 2.05rem;
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
      padding: .35rem .85rem;
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

    /* ========================= CATEGORY CARDS ========================== */
    .cat-card{
      height: 100%;
      border-radius: 22px;
      background: #fff;
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow-soft);
      overflow:hidden;
      transition: transform .22s ease, box-shadow .22s ease;
      transform: translateZ(0);
    }
    .cat-card:hover{
      transform: translateY(-6px);
      box-shadow: 0 26px 62px rgba(2,6,23,.14);
    }
    .cat-media{ position: relative; overflow: hidden; }
    .cat-media img{
      width:100%;
      height: 220px;
      object-fit: cover;
      transition: transform .55s ease;
    }
    .cat-card:hover .cat-media img{ transform: scale(1.08); }
    .cat-badge{
      position:absolute;
      top: 12px;
      left: 12px;
      background: rgba(2,6,23,.72);
      color:#fff;
      padding: .28rem .75rem;
      border-radius: 999px;
      font-size: .76rem;
      font-weight: 900;
      letter-spacing: .06em;
      box-shadow: 0 16px 28px rgba(2,6,23,.18);
    }
    .cat-body{ padding: 1rem 1.1rem 1.2rem; }
    .cat-body h5{ font-weight: 900; margin-bottom: .35rem; }
    .cat-body p{ color: var(--muted); font-size: .93rem; margin-bottom: .85rem; }
    .cat-link{
      display:inline-flex;
      align-items:center;
      gap:.45rem;
      font-weight: 900;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-size: .82rem;
      color: var(--brand);
    }

    /* ========================= RUGS CAROUSEL ========================== */
    .rugs-head .k{
      font-size: .82rem;
      font-weight: 900;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: rgba(2,6,23,.55);
    }
    .rugs-head h2{ font-weight: 900; margin: .35rem 0; }

    /* modern rugs: make images consistent + mobile */
    .rugs-img{
      height: 190px !important;
      width: 100% !important;
      object-fit: contain !important;
      background: rgba(2,6,23,.02);
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 18px;
      padding: 10px;
    }
    @media (max-width: 576px){
      .rugs-img{ height: 160px !important; }
    }

    /* ========================= PRODUCT CARDS ========================== */
    .product-card{
      border: 1px solid rgba(2,6,23,.06);
      border-radius: 22px;
      overflow:hidden;
      box-shadow: var(--shadow-soft);
      height:100%;
      background:#fff;
      transition: transform .22s ease, box-shadow .22s ease;
    }
    .product-card:hover{
      transform: translateY(-5px);
      box-shadow: 0 26px 62px rgba(2,6,23,.14);
    }
    .product-card img{
      height: 260px;
      width:100%;
      object-fit: cover;
      transition: transform .55s ease;
    }
    .product-card:hover img{ transform: scale(1.06); }
    .product-card .card-body{ padding: 1rem 1.1rem 1.2rem; }

    @media (max-width: 576px){
      .product-card img{ height: 240px; }
    }

    /* ========================= WHY CHOOSE US ========================== */
    .why-wrap{
      background: var(--surface);
      border: 1px solid rgba(17,24,39,.06);
      border-radius: 28px;
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .why-wrap .why-side{
      padding: 1.6rem;
      background: linear-gradient(180deg, rgba(220,53,69,.08), rgba(255,255,255,0));
    }
    .why-wrap .why-points{ padding: 1.6rem; }

    @media (min-width: 992px){
      .why-wrap .why-side{ padding: 2rem; }
      .why-wrap .why-points{ padding: 2rem; }
    }

    .why-bullet{
      padding: .95rem 1rem;
      border-radius: 18px;
      border: 1px solid rgba(2,6,23,.06);
      background: rgba(255,255,255,.70);
      box-shadow: 0 12px 30px rgba(2,6,23,.07);
      margin-bottom: .85rem;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .why-bullet:hover{
      transform: translateY(-3px);
      box-shadow: 0 20px 44px rgba(2,6,23,.10);
    }
    .why-bullet h5{ font-weight: 900; font-size: 1rem; margin-bottom: .25rem; }
    .why-bullet p{
      color: var(--muted);
      margin-bottom: 0;
      font-size: .95rem;
      line-height: 1.6;
    }

    /* ========================= TESTIMONIALS (NEW carousel) ========================== */
    .testi-wrap{
      border-radius: 26px;
      overflow: hidden;
      box-shadow: var(--shadow-soft);
      border: 1px solid rgba(2,6,23,.06);
      background: rgba(255,255,255,.86);
    }
    .testi-item{
      padding: 1.4rem 1.2rem;
    }
    .testi-quote{
      font-size: 1rem;
      line-height: 1.75;
      color: rgba(2,6,23,.78);
      margin: 0;
    }
    .testi-meta{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 10px;
      margin-top: 1rem;
      padding-top: .9rem;
      border-top: 1px solid rgba(2,6,23,.06);
    }
    .testi-name{
      font-weight: 900;
      color: #0f172a;
      margin: 0;
    }
    .stars i{ color: #f59e0b; }
    @media (max-width: 576px){
      .testi-item{ padding: 1.2rem 1rem; }
      .testi-meta{ flex-direction: column; align-items: flex-start; }
    }

    /* ========================= SEO TEXT ========================== */
    .seo-text{
      font-size: .98rem;
      line-height: 1.75;
      color: rgba(2,6,23,.78);
      background: rgba(255,255,255,.72);
      border: 1px solid rgba(17,24,39,.06);
      border-radius: 22px;
      padding: 1.35rem;
      box-shadow: var(--shadow-soft);
    }
    .seo-text h2{ font-weight: 900; margin-bottom: .85rem; }

    /* ========================= FOOTER ========================== */
    footer{
      font-size: .92rem;
      background: rgba(255,255,255,.75) !important;
      border-top: 1px solid rgba(17,24,39,.08) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    /* ========================= Floating actions ========================== */
    .floating-actions{
      position: fixed;
      right: 14px;
      bottom: calc(var(--dockH) + 14px + var(--safeBottom));
      z-index: 1200;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .fab{
      width: 52px;
      height: 52px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-decoration: none;
      box-shadow: 0 20px 44px rgba(2,6,23,.22);
      transition: transform .18s ease, filter .18s ease, opacity .18s ease;
    }
    .fab:hover{ transform: translateY(-2px); filter: brightness(.98); }
    .fab-whatsapp{ background: var(--success); }
    .fab-top{
      background: rgba(15,23,42,.92);
      border: 1px solid rgba(255,255,255,.14);
      opacity: 0;
      pointer-events:none;
    }
    .fab-top.show{ opacity: 1; pointer-events:auto; }

    /* ========================= Mobile Bottom Dock (NEW) ========================== */
    .mobile-dock{
      position: fixed;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 1300;
      padding-bottom: var(--safeBottom);
      background: rgba(255,255,255,.92);
      border-top: 1px solid rgba(2,6,23,.08);
      box-shadow: 0 -18px 45px rgba(2,6,23,.10);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      height: calc(var(--dockH) + var(--safeBottom));
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .dock-inner{
      width: min(520px, 100%);
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      padding: 8px 12px;
    }
    .dock-btn{
      display:flex;
      flex-direction: column;
      align-items:center;
      justify-content:center;
      gap: 4px;
      padding: 8px 8px;
      border-radius: 16px;
      color: rgba(2,6,23,.86);
      font-weight: 800;
      font-size: .72rem;
      position: relative;
      transition: transform .18s ease, background .18s ease;
    }
    .dock-btn i{ font-size: 1.22rem; }
    .dock-btn:hover{ background: rgba(220,53,69,.08); transform: translateY(-1px); color: var(--brand); }
    .dock-badge{
      position:absolute;
      top: 6px;
      right: 20%;
      transform: translateX(50%);
      font-size: .68rem;
      font-weight: 900;
      background: var(--brand);
      color: #fff;
      border-radius: 999px;
      padding: 2px 6px;
      box-shadow: 0 10px 22px rgba(220,53,69,.22);
    }
    @media (min-width: 992px){
      .mobile-dock{ display: none; }
      body{ padding-bottom: 0; }
    }

    /* ========================= Animations + Scroll reveal ========================== */
    @keyframes fadeUp{ from{ opacity:0; transform: translateY(14px); } to{ opacity:1; transform: translateY(0);} }
    @keyframes popIn{ from{ opacity:0; transform: scale(.97); } to{ opacity:1; transform: scale(1);} }

    .reveal{ opacity: 0; transform: translateY(14px); }
    .reveal.in{ opacity:1; transform: translateY(0); transition: opacity .7s ease, transform .7s ease; }

    @media (prefers-reduced-motion: reduce){
      *{ animation: none !important; transition: none !important; scroll-behavior: auto !important; }
      .reveal{ opacity:1 !important; transform:none !important; }
    }
    /* ========================= LATEST PRODUCTS (PRO) ========================= */
.latest-products .lp-grid{
  display:grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 18px;
}
@media (max-width: 992px){
  .latest-products .lp-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 576px){
  .latest-products .lp-grid{ grid-template-columns: 1fr; gap: 14px; }
}

.latest-products .lp-card{
  background:#fff;
  border: 1px solid rgba(2,6,23,.08);
  border-radius: 22px;
  overflow:hidden;
  box-shadow: var(--shadow-soft);
  transition: transform .22s ease, box-shadow .22s ease;
}
.latest-products .lp-card:hover{
  transform: translateY(-6px);
  box-shadow: 0 28px 70px rgba(2,6,23,.14);
}

.latest-products .lp-media{
  position:relative;
  background: linear-gradient(180deg, rgba(2,6,23,.03), rgba(2,6,23,.00));
  overflow:hidden;
}

.latest-products .lp-img{
  width:100%;
  height: 270px;
  object-fit: cover;
  object-position: center;
  display:block;
  transition: transform .6s ease;
}
.latest-products .lp-card:hover .lp-img{ transform: scale(1.04); }

/* ✅ Mobile: tepihu shihet komplet (mos u pre) */
@media (max-width: 576px){
  .latest-products .lp-img{
    height: 240px;
    object-fit: contain;
    padding: 10px;
    background: #f8fafc;
  }
}

.latest-products .lp-badge{
  position:absolute; top:12px; left:12px;
  background: rgba(255,193,7,.95);
  color:#111;
  padding:.32rem .7rem;
  border-radius:999px;
  font-size:.74rem;
  font-weight:900;
  letter-spacing:.10em;
  box-shadow: 0 16px 30px rgba(2,6,23,.18);
}
.latest-products .lp-stock{
  position:absolute; top:12px; right:12px;
  padding:.32rem .7rem;
  border-radius:999px;
  font-size:.74rem;
  font-weight:900;
  color:#fff;
  border:1px solid rgba(255,255,255,.18);
  background: rgba(15,23,42,.78);
  box-shadow: 0 16px 30px rgba(2,6,23,.18);
}
.latest-products .lp-stock.out{ background: rgba(220,53,69,.88); }

.latest-products .lp-body{ padding: 14px 14px 16px; }

.latest-products .lp-top{
  display:flex; justify-content:space-between; align-items:center; gap:10px;
  margin-bottom: 8px;
}
.latest-products .lp-cat{
  font-size:.78rem; font-weight:900; letter-spacing:.08em;
  color: rgba(2,6,23,.55);
}
.latest-products .lp-sku{ font-size:.78rem; font-weight:700; color: rgba(2,6,23,.45); }

.latest-products .lp-title{
  font-weight: 900;
  color:#0f172a;
  margin: 0 0 6px;
  line-height:1.2;
  font-size: 1.03rem;
  display:-webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow:hidden;
}
.latest-products .lp-desc{
  color: var(--muted);
  margin: 0 0 12px;
  font-size: .92rem;
  line-height: 1.6;
  display:-webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow:hidden;
}

.latest-products .lp-price-row{
  display:flex; justify-content:space-between; align-items:flex-end; gap:12px;
  padding-top: 10px;
  border-top: 1px solid rgba(2,6,23,.06);
}
.latest-products .lp-price-label{ font-size:.78rem; font-weight:700; color: rgba(2,6,23,.55); }
.latest-products .lp-price{
  font-size: 1.25rem;
  font-weight: 900;
  color: var(--brand);
  line-height: 1;
}

.latest-products .lp-actions{
  display:flex; gap:10px; margin-top: 12px;
}
.latest-products .lp-actions .btn{
  border-radius: 999px;
  font-weight: 900;
  min-height: 44px;
}
@media (max-width: 576px){
  .latest-products .lp-actions{ flex-direction: column; }
  .latest-products .lp-actions .btn{ width:100% !important; }
}
.latest-products .btn-wa{
  background:#16a34a;
  border:1px solid #16a34a;
  color:#fff;
}
.latest-products .btn-wa:hover{ color:#fff; filter: brightness(.98); }

/* ========================= ANIMATIONS ========================== */

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-40px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(40px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-8px);
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
}

@keyframes glow {
  0%, 100% {
    box-shadow: 0 0 20px rgba(220, 53, 69, 0.3);
  }
  50% {
    box-shadow: 0 0 40px rgba(220, 53, 69, 0.6);
  }
}

/* Apply animations to major sections */
.announce {
  animation: fadeInDown 0.8s ease-out;
}

.navbar-custom {
  animation: fadeInDown 0.9s ease-out 0.1s both;
}

.topbar {
  animation: fadeInUp 0.8s ease-out 0.2s both;
}

.hero {
  animation: scaleIn 1s ease-out 0.3s both;
}

.hero-content {
  animation: slideInLeft 1s ease-out 0.5s both;
}

.hero-btn {
  animation: fadeInUp 0.8s ease-out 0.7s both;
}

.chip {
  animation: fadeInUp 0.6s ease-out;
  transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
}

.chip:nth-child(1) {
  animation-delay: 0.1s;
}

.chip:nth-child(2) {
  animation-delay: 0.15s;
}

.chip:nth-child(3) {
  animation-delay: 0.2s;
}

.chip:nth-child(n+4) {
  animation-delay: 0.25s;
}

.latest-products {
  animation: fadeInUp 1s ease-out 0.6s both;
}

.latest-product-card {
  animation: fadeInUp 0.7s ease-out;
  transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
}

.latest-product-card:nth-child(1) {
  animation-delay: 0.7s;
}

.latest-product-card:nth-child(2) {
  animation-delay: 0.75s;
}

.latest-product-card:nth-child(3) {
  animation-delay: 0.8s;
}

.latest-product-card:nth-child(4) {
  animation-delay: 0.85s;
}

.latest-product-card:hover {
  transform: translateY(-12px) scale(1.02);
  animation: glow 2s ease-in-out infinite;
}

.latest-product-card img {
  transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.latest-product-card:hover img {
  transform: scale(1.08) rotate(1deg);
}

.product-img-container {
  overflow: hidden;
  border-radius: 14px;
}

/* Button hover animations */
.btn-brand {
  animation: fadeInUp 0.8s ease-out 0.8s both;
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease, filter 0.3s ease;
}

.btn-brand:hover {
  transform: translateY(-4px) scale(1.05);
}

.btn:active {
  transform: scale(0.98);
}

/* Links with underline animation */
a {
  position: relative;
}

a::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--brand);
  transition: width 0.3s ease;
}

.nav-link:hover::after,
.chip:hover::after {
  width: 100%;
}

/* Search button animation */
.search-pro .btn {
  animation: none;
}

/* WhatsApp button animation */
.wa-btn {
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease, filter 0.3s ease;
}

.wa-btn:hover {
  transform: translateY(-3px) scale(1.05);
}

/* Hero text animation */
.hero-title {
  animation: slideInLeft 1s ease-out 0.4s both;
}

.hero-desc {
  animation: slideInLeft 1.1s ease-out 0.5s both;
}

/* Stagger animations for lists */
.lp-title, .lp-desc, .lp-price {
  animation: fadeInUp 0.6s ease-out forwards;
  opacity: 0;
}

.latest-product-card:nth-child(1) .lp-title {
  animation-delay: 0.7s;
}

.latest-product-card:nth-child(1) .lp-desc {
  animation-delay: 0.75s;
}

.latest-product-card:nth-child(1) .lp-price {
  animation-delay: 0.8s;
}

/* Smooth page load */
body {
  animation: fadeInUp 0.6s ease-out;
}

/* Parallax effect on scroll (subtle) */
@media (min-width: 768px) {
  .hero-bg {
    animation: float 6s ease-in-out infinite;
  }
}
  </style>
</head>

<body>
  <!-- ANNOUNCEMENT (NEW) -->


  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" id="mainNav">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant Logo" />
      </a>

      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-lg-center gap-lg-1 me-lg-2">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="catalogDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
              <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="{{ route('account.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Llogaria ime</a></li>
              <li><hr class="dropdown-divider"></li>
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
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="cartDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
              <i class="bi bi-bag"></i> Shporta
              <span class="badge bg-danger rounded-pill ms-1 cart-badge">{{ session('cart_total_qty', 0) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="cartDropdown" style="min-width: 320px;">
              <div class="small text-muted mb-2">Gjurmo porosinë</div>
              <form class="d-flex align-items-stretch gap-2"
                onsubmit="event.preventDefault(); const el=this.querySelector('#trackCodeNav'); const v=(el?.value||'').trim(); if(v){ window.location='{{ url('/track') }}/'+encodeURIComponent(v); }">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input id="trackCodeNav" type="text" class="form-control" placeholder="p.sh. BRL-LKNJ-0YXN" autocomplete="off" required />
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
  <div class="container topbar" id="topbar">
    <div class="topbar-inner">
      <div class="row g-3 align-items-center">
        <div class="col-lg-4">
          <div class="chips-2rows">
            <a class="chip" href="/tepiha"><i class="bi bi-grid"></i> Tepiha</a>
            <a class="chip" href="/mbulesa"><i class="bi bi-house"></i> Mbulesa</a>
            <a class="chip" href="/perde-ditore"><i class="bi bi-layout-text-window"></i> Perde</a>

            <a class="chip" href="/garnishte"><i class="bi bi-layout-text-window"></i> Garnishte</a>
            <a class="chip" href="/batanije"><i class="bi bi-snow"></i> Batanije</a>
            <a class="chip" href="/postava"><i class="bi bi-bag-check"></i> Set çarçafesh</a>
          </div>
        </div>

        <div class="col-lg-5" id="searchSection">
          <form action="{{ route('search') }}" method="GET" class="search-pro" role="search" aria-label="Kërko produktet">
            <i class="bi bi-search icon" aria-hidden="true"></i>
            <input type="text" name="q" class="form-control" placeholder="Kërko produktin:" value="{{ request('q') }}" required />
            <button class="btn btn-brand" type="submit">Kërko</button>
          </form>
        </div>

        <div class="col-lg-3 text-lg-end">
          <a href="https://wa.me/38344960661" target="_blank" class="wa-btn d-inline-flex align-items-center justify-content-center gap-2">
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
              <span>KOLEKSION I RI</span> Tepiha &amp; perde për çdo ambient
             
            </div>

            <h1 class="hero-title">
              Tepiha &amp; perde <em>premium</em> për shtëpi moderne.
            </h1>

            <p class="hero-sub">
              Zgjidh dizajnin ideal për sallon, dhomë gjumi apo zyrë. Tekstura cilësore, ngjyra që nuk zbehen dhe shërbim profesional nga Brillant në Lipjan.
            </p>

            <div class="hero-actions">
              <a href="/tepiha" class="btn btn-brand">Shiko tepihat</a>
              <a href="/anesore" class="btn btn-outline-light">Shiko perdet</a>
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
                  <div class="carousel-item active">
                    <div class="weekly-item">
                      <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('slider/side.bmp') }}" alt="Tepiha Modern 150x230" loading="lazy" />
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
                        <img src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha Hali 200x300" loading="lazy" />
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
                        <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh" loading="lazy" />
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
                <a href="/tepiha" class="btn btn-outline-dark w-100 pill btn-sm">Shiko të gjitha ofertat</a>
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
                  <img src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha" loading="lazy" />
                  <span class="cat-badge">Tepiha</span>
                </div>
                <div class="cat-body">
                  <h5>Tepiha modern &amp; klasik</h5>
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
                  <img src="{{ asset('slider/raffaello.jpg') }}" alt="Perde" loading="lazy" />
                  <span class="cat-badge">Perde</span>
                </div>
                <div class="cat-body">
                  <h5>Perde anësore &amp; ditore</h5>
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
                  <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh" loading="lazy" />
                  <span class="cat-badge">Shtrat</span>
                </div>
                <div class="cat-body">
                  <h5>Set çarçafësh &amp; kompleta krevati</h5>
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
                  <img src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa & batanije" loading="lazy" />
                  <span class="cat-badge">Komfor</span>
                </div>
                <div class="cat-body">
                  <h5>Mbulesa &amp; batanije</h5>
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
                  ['side.bmp', 'Modern Rose 120x170 cm', '€45.00'],
                  ['hali4.jpg', 'Modern Hali 300x200 cm', '€95.00'],
                  ['gold.bmp', 'Modern Gold 300x200 cm', '€55.00'],
                  ['gold1.bmp', 'Modern Gold 300x200 cm', '€55.00'],
                  ['gold2.bmp', 'Modern Gold 300x200 cm', '€55.00'],
                  ['rose1.jpg', 'rose 300x200 cm', '€105.00'],
                  ['rose2.bmp', 'rose 150x230 cm', '€75.00'],
                  ['rose3.bmp', 'rose 150x230 cm', '€75.00'],
                  ['hali5.jpg', 'hali 150x230 cm', '€65.00'],
                  ['hali3.jpg', 'hali 150x230 cm', '€65.00'],
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
                        <img src="{{ asset('slider/'.$item[0]) }}" alt="{{ $item[1] }}"
                             class="img-fluid rugs-img shadow-sm mb-2" loading="lazy" />
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
     @php
  $latestProducts = \App\Models\Product::query()
      ->where('is_active', 1)
      ->orderByDesc('id')
      ->take(6)
      ->get();
@endphp

<section class="mb-5 latest-products">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-3">
    <div>
      <div class="k" style="font-weight:900; letter-spacing:.16em; text-transform:uppercase; color: var(--brand); background: rgba(220,53,69,.08); border:1px solid rgba(220,53,69,.14); padding:.35rem .8rem; border-radius:999px; display:inline-block;">
        PRODUKTET E FUNDIT
      </div>
      <h2 class="mt-3 mb-1" style="font-weight:900;">Zbuloni çfarë ka ardhur rishtazi</h2>
      <p class="text-muted mb-0">Produktet e reja që janë shtuar së fundmi në katalog.</p>
    </div>

    
  </div>

  @if($latestProducts->count())
    <div class="lp-grid">
      @foreach($latestProducts as $item)
        @php
          // ===== FOTO (image_path mundet me qenë JSON ose array) =====
          $imgs = $item->image_path;
          if (is_string($imgs)) {
            $decoded = json_decode($imgs, true);
            $imgs = is_array($decoded) ? $decoded : [];
          }
          if (!is_array($imgs)) $imgs = [];
          $img = $imgs[0] ?? null;

          // ===== SIZES (opsionale) -> min price =====
          $sizes = $item->sizes ?? null;
          if (is_string($sizes)) {
            $d = json_decode($sizes, true);
            $sizes = is_array($d) ? $d : [];
          }
          if (!is_array($sizes)) $sizes = [];

          $priceValue = $item->price;
          if (!empty($sizes)) {
            $prices = array_filter(array_map(fn($s) => $s['price'] ?? null, $sizes), fn($p) => $p !== null);
            if (!empty($prices)) $priceValue = min($prices);
          }
          $priceLabel = $priceValue !== null ? '€' . number_format((float)$priceValue, 2) : 'Në kërkesë';

          $inStock = (int)($item->stock ?? 0) > 0;

          $cat = $item->category ?? '';
          $sub = $item->subcategory ?? '';
          $catLabel = $cat ? strtoupper($cat) : 'PRODUKT';
          if ($cat === 'perde' && $sub) $catLabel = strtoupper($cat).' • '.strtoupper($sub);

          // ✅ Detaje sipas routes/web.php (me slug)
          $detailsUrl = $item->slug ? route('products.show', $item->slug) : route('products.index');
        @endphp

        <article class="lp-card latest-product-card">
          <div class="lp-media product-img-container">
            <a href="{{ $detailsUrl }}" class="lp-media d-block text-decoration-none" aria-label="Hap detajet: {{ $item->name }}">
@php
    $path = $img;

    if($path && str_starts_with($path, 'products/')){
        $path = 'images/'.$path; // → images/products/...
    } elseif($path && !str_starts_with($path, 'images/')){
        $path = 'images/products/'.$path;
    }
@endphp

<img class="lp-img" src="{{ $path ? asset($path) : asset('images/llogo.png') }}" alt="{{ $item->name }}">

  <span class="lp-badge">I RI</span>
  <span class="lp-stock {{ $inStock ? '' : 'out' }}">
    {{ $inStock ? 'IN STOCK' : 'S’KA STOCK' }}
  </span>
</a>
             
          </div>

          <div class="lp-body">
            <div class="lp-top">
              <div class="lp-cat">{{ $catLabel }}</div>
              @if(!empty($item->sku))
                <div class="lp-sku">SKU: {{ $item->sku }}</div>
              @endif
            </div>

            <h5 class="lp-title">{{ $item->name }}</h5>

            <p class="lp-desc">
              {{ $item->description ? \Illuminate\Support\Str::limit($item->description, 130) : 'Përshkrimi do të shtohet së shpejti.' }}
            </p>

            <div class="lp-price-row">
              <div>
                <div class="lp-price-label">Çmimi</div>
                <div class="lp-price">{{ $priceLabel }}</div>
              </div>
              <div class="small text-muted text-end">
                <i class="bi bi-shield-check"></i> Cilësi
              </div>
            </div>

            <div class="lp-actions">
              <a href="{{ $detailsUrl }}" class="btn btn-outline-dark w-50" style="border-width:2px;">
                Detaje
              </a>

              <a class="btn btn-wa w-50"
                 href="https://wa.me/38344960661?text={{ urlencode('Pershendetje! Jam i interesuar per: '.$item->name.' ('.$priceLabel.'). A ka ne stock?') }}"
                 target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @endif
</section>
      <!-- Testimonials (NEW Carousel) -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">VLERËSIMET</span>
          <h2>Klientët</h2>
          <p>Përvojë reale — cilësi, shërbim dhe kënaqësi.</p>
        </div>

        <div class="testi-wrap">
          <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="testi-item">
                  <p class="testi-quote">
                    “Perdet na dolën perfekt! Matja,  dhe montimi — krejt profesional. Shtëpia u ndryshua total.”
                  </p>
                  <div class="testi-meta">
                    <p class="testi-name mb-0">Kliente — Prishtinë</p>
                    <div class="stars" aria-label="5 yje">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="carousel-item">
                <div class="testi-item">
                  <p class="testi-quote">
                    “Tepihat janë super cilësi. Akrill dhe antibakterial. Dërgesa erdhi shpejt.”
                  </p>
                  <div class="testi-meta">
                    <p class="testi-name mb-0">Klient — Lipjan</p>
                    <div class="stars" aria-label="5 yje">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="carousel-item">
                <div class="testi-item">
                  <p class="testi-quote">
                    “Setet e çarçafëve ishin 100% Pambuk”
                  </p>
                  <div class="testi-meta">
                    <p class="testi-name mb-0">Kliente — Ferizaj</p>
                    <div class="stars" aria-label="5 yje">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
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
            <img src="{{ asset('slider/raffaello.jpg') }}" class="img-fluid rounded-4 shadow-sm mt-3" alt="Why Choose Us" loading="lazy" />
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
              <h5>Plush bed covers &amp; sheets</h5>
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
          <img src="{{ asset('images/llogo.png') }}" alt="brillant" width="150" class="mb-2" loading="lazy" />
        </div>

        <div class="col-md-3 mb-4 mb-md-0">
          <h6 class="text-uppercase fw-bold mb-3">Products</h6>
          <ul class="list-unstyled">
            <li><a href="/tepiha" class="text-dark text-decoration-none">Carpet &amp; Rugs</a></li>
            <li><a href="/tepiha" class="text-dark text-decoration-none">Decorative Carpets</a></li>
            <li><a href="/tepihebanjo" class="text-dark text-decoration-none">Bath Mats &amp; Rugs</a></li>
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

  <!-- Floating quick actions -->
  <div class="floating-actions">
    <a class="fab fab-whatsapp" href="https://wa.me/38344960661" target="_blank" aria-label="WhatsApp">
      <i class="bi bi-whatsapp fs-4"></i>
    </a>
    <button id="backToTop" class="fab fab-top" type="button" aria-label="Back to top">
      <i class="bi bi-arrow-up fs-4"></i>
    </button>
  </div>

  <!-- MOBILE BOTTOM DOCK (NEW) -->
  <nav class="mobile-dock d-lg-none" aria-label="Mobile quick navigation">
    <div class="dock-inner">
      <a class="dock-btn" href="/" aria-label="Home">
        <i class="bi bi-house"></i>
        <span>Home</span>
      </a>

      <a class="dock-btn" href="/tepiha" aria-label="Products">
        <i class="bi bi-grid"></i>
        <span>Products</span>
      </a>

      <a class="dock-btn" href="#searchSection" aria-label="Search">
        <i class="bi bi-search"></i>
        <span>Search</span>
      </a>

      <a class="dock-btn" href="{{ route('cart.index') }}" aria-label="Shporta">
        <i class="bi bi-bag"></i>
        <span>Shporta</span>
        <span class="dock-badge cart-badge">{{ session('cart_total_qty', 0) }}</span>
      </a>
    </div>
  </nav>

  <!-- Bootstrap JS (në fund për performancë) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // përditëso badge në të gjitha menutë (navbar + dock)
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };

    // dëgjo event-in global kur ndryshon shporta
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });

    (function(){
      const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;

      // Set dynamic nav height -> sticky topbar work perfect
      const nav = document.getElementById('mainNav');
      const setNavH = () => {
        if(!nav) return;
        const h = nav.getBoundingClientRect().height || 74;
        document.documentElement.style.setProperty('--navH', `${Math.round(h)}px`);
      };
      window.addEventListener('resize', setNavH, { passive: true });
      window.addEventListener('load', setNavH, { passive: true });
      setNavH();

      // mobile: open submenu with click
      document.querySelectorAll('.dropdown-submenu > a').forEach(a => {
        a.addEventListener('click', function(e){
          if(!isMobile()) return;
          e.preventDefault();
          const submenu = this.nextElementSibling;
          if(submenu) submenu.classList.toggle('show');
        });
      });

      // smooth scroll for anchors (mobile dock search)
      document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function(e){
          const id = this.getAttribute('href');
          if(!id || id === '#') return;
          const target = document.querySelector(id);
          if(!target) return;
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          // focus input if search section
          if(id === '#searchSection'){
            const input = target.querySelector('input[name="q"]');
            setTimeout(() => input?.focus(), 350);
          }
        });
      });

      // back to top
      const topBtn = document.getElementById('backToTop');
      const onScroll = () => {
        if(!topBtn) return;
        topBtn.classList.toggle('show', window.scrollY > 520);
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
      topBtn?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

      // hero background slideshow (auto change)
      const heroBg = document.querySelector('.hero-bg');
      if(heroBg){
        const imgs = [
          "{{ asset('slider/foto1.jpg') }}",
          "{{ asset('slider/hali4.jpg') }}",
          "{{ asset('slider/raffaello.jpg') }}"
        ];
        let i = 0;
        setInterval(() => {
          i = (i + 1) % imgs.length;
          heroBg.style.backgroundImage = `url('${imgs[i]}')`;
          heroBg.classList.remove('bg-swap');
          void heroBg.offsetWidth;
          heroBg.classList.add('bg-swap');
        }, 6500);
      }

      // scroll reveal animations
      const revealEls = document.querySelectorAll(
        '.cat-card, .product-card, .why-bullet, .seo-text, .weekly-card, .soft-card, .testi-wrap'
      );
      const io = new IntersectionObserver(entries => {
        entries.forEach(en => {
          if(en.isIntersecting){
            en.target.classList.add('in');
            io.unobserve(en.target);
          }
        });
      }, { threshold: 0.12 });

      revealEls.forEach(el => {
        el.classList.add('reveal');
        io.observe(el);
      });
    })();
  </script>
</body>
</html>
