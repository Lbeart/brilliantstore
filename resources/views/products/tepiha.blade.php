<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />

  <!-- TITULLI & PERSHKRIMI KRYESOR SEO -->
  <title>Tepiha moderne & tradicionale | B-Brillant</title>
  <meta name="description" content="Tepiha online në Kosovë: akril, Hali, modernë dhe klasikë për sallon, dhomë gjumi e korridor. Dërgesë nga B-Brillant Lipjan.">

  <!-- LEJO INDEXIMIN -->
  <meta name="robots" content="index,follow">

  <link rel="sitemap" type="application/xml" title="Sitemap" href="https://b-brillant.com/sitemap.xml">

  <!-- FJALË KYÇE -->
  <meta name="keywords" content="tepiha, tepiha moderne, tepiha tradicional, tepih, tapeta, tepih Lipjan, tepih Kosove, tepiha akrill, tepiha antibakterial, tepiha hali, tepiha bambo, tepiha staz, tepiha rrethore, oferta tepiha">

  <!-- CANONICAL -->
  <link rel="canonical" href="{{ url('/tepiha') }}">

  <!-- VIEWPORT -->
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <!-- OPEN GRAPH -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Brillant Lipjan">
  <meta property="og:title" content="Tepiha moderne & tradicionale | Brillant Lipjan">
  <meta property="og:description" content="Zgjidh tepiha modern dhe tradicional, antialergjik dhe antibakterial për çdo dhomë. Koleksioni Brillant Lipjan.">
  <meta property="og:url" content="{{ url('/tepiha') }}">
  <meta property="og:image" content="{{ asset('images/og-tepiha.jpg') }}">

  <!-- TWITTER CARD -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Tepiha moderne & tradicionale | B-Brillant Lipjan">
  <meta name="twitter:description" content="Tepiha modern, klasik dhe rrethor për çdo ambient. Koleksioni Brillant Lipjan.">
  <meta name="twitter:image" content="{{ asset('images/og-tepiha.jpg') }}">

  <!-- JSON-LD STRUCTURED DATA -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Tepiha moderne & tradicionale | Brillant Lipjan",
    "description": "Koleksion tepihash modern dhe tradicional, antialergjik dhe antibakterial për çdo ambient të shtëpisë. Tepiha Online, Tepiha Hali, shkallore, Tepiha Rrethore.",
    "url": "{{ url('/tepiha') }}",
    "isPartOf": {
      "@type": "WebSite",
      "name": "B-Brillant",
      "url": "{{ url('/') }}"
    },
    "inLanguage": "sq"
  }
  </script>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">

  <style>
    /* ============================================================
      B-BRILLANT — UI V2 (Premium)
      CHANGES:
      ✅ Search bar removed from navbar (no offcanvas)
      ✅ Search bar moved ABOVE products on the page (works on mobile + desktop)
      ✅ Mobile product grid now shows 2 products per row
    ============================================================ */

    :root{
      --brand: #dc3545;
      --brand-2: #ff4d5f;

      --dark: #0b1220;
      --dark-2: #0f172a;

      --text: #0f172a;
      --muted: #6b7280;
      --line: rgba(15,23,42,.10);

      --bg: #f6f7fb;
      --card: #ffffff;

      --radius-xl: 22px;
      --radius-lg: 18px;
      --radius-md: 14px;
      --radius-sm: 12px;

      --shadow-sm: 0 6px 18px rgba(2,6,23,.07);
      --shadow-md: 0 12px 30px rgba(2,6,23,.10);
      --shadow-lg: 0 18px 42px rgba(2,6,23,.14);

      --ease: cubic-bezier(.2,.9,.2,1);
      --ease2: cubic-bezier(.2,.75,.25,1);
      --speed: .22s;

      --focus: 0 0 0 .22rem rgba(220,53,69,.22);

      /* default fallback; JS updates this dynamically */
      --nav-offset: 104px;
    }

    *{ box-sizing: border-box; }
    html{ scroll-behavior: smooth; }

    body{
      background:
        radial-gradient(900px 400px at 20% 0%, rgba(220,53,69,.12) 0%, rgba(220,53,69,0) 60%),
        radial-gradient(900px 400px at 90% 10%, rgba(59,130,246,.10) 0%, rgba(59,130,246,0) 55%),
        linear-gradient(180deg, #fbfbff 0%, #f6f7fb 40%, #f3f4f6 100%);
      color: var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
      padding-top: var(--nav-offset);
      overflow-x: hidden;
    }

    /* reduced motion */
    @media (prefers-reduced-motion: reduce){
      html{ scroll-behavior: auto; }
      *, *::before, *::after{
        animation-duration: .001ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: .001ms !important;
      }
    }

    /* Skip to content */
    .skip-link{
      position: absolute;
      left: -999px;
      top: 0;
      background: #fff;
      color: #111;
      padding: .5rem .75rem;
      border-radius: 10px;
      box-shadow: var(--shadow-sm);
      z-index: 2000;
    }
    .skip-link:focus{
      left: 10px;
      top: 10px;
      outline: none;
      box-shadow: var(--focus), var(--shadow-sm);
    }

    /* Top progress bar */
    .top-progress{
      position: fixed;
      top: 0; left: 0;
      height: 3px;
      width: 0%;
      background: linear-gradient(90deg, var(--brand), #f59e0b, #22c55e);
      z-index: 1031; /* above navbar */
      box-shadow: 0 8px 18px rgba(220,53,69,.25);
    }

    /* =========================================
      NAVBAR (GLASS + ANIMATIONS)
    ========================================= */
    .navbar-custom{
      position: fixed;
      top: 14px;
      left: 50%;
      transform: translateX(-50%);
      width: min(1180px, 94%);
      border-radius: var(--radius-xl);
      padding: .6rem .85rem;

      /* IMPORTANT: keep below bootstrap overlays */
      z-index: 1030;

      background:
        linear-gradient(135deg, rgba(2,6,23,.78) 0%, rgba(17,24,39,.74) 50%, rgba(15,23,42,.70) 100%);
      box-shadow: var(--shadow-md);
      border: 1px solid rgba(255,255,255,.10);

      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
    }

    .navbar-brand{
      display: inline-flex;
      align-items: center;
      gap: .6rem;
      user-select: none;
    }

    .navbar-brand img{
      height: 44px;
      filter: drop-shadow(0 8px 14px rgba(0,0,0,.22));
      transform: translateZ(0);
      transition: transform var(--speed) var(--ease);
    }
    .navbar-brand:hover img{ transform: translateY(-1px) scale(1.02); }

    .navbar-custom .nav-link{
      color: rgba(229,231,235,.92) !important;
      font-weight: 650;
      letter-spacing: .2px;
      font-size: .92rem;
      position: relative;
      padding: .55rem .7rem;
      border-radius: 12px;
      transition: color var(--speed) var(--ease), background var(--speed) var(--ease), transform var(--speed) var(--ease);
      outline: none;
    }

    /* underline animation */
    .navbar-custom .nav-link::after{
      content:"";
      position:absolute;
      left: 14px; right: 14px;
      bottom: 8px;
      height: 2px;
      border-radius: 999px;
      background: linear-gradient(90deg, rgba(220,53,69,0), rgba(220,53,69,1), rgba(220,53,69,0));
      transform: scaleX(0);
      transform-origin: center;
      transition: transform .26s var(--ease);
      opacity: .9;
    }

    .navbar-custom .nav-link:hover{
      color: #fff !important;
      background: rgba(255,255,255,.06);
      transform: translateY(-1px);
    }
    .navbar-custom .nav-link:hover::after{ transform: scaleX(1); }

    .navbar-custom .nav-link:focus-visible{
      box-shadow: var(--focus);
      background: rgba(255,255,255,.06);
    }

    .navbar-custom .nav-link.active{
      color:#fff !important;
      background: rgba(220,53,69,.14);
      border: 1px solid rgba(220,53,69,.26);
    }
    .navbar-custom .nav-link.active::after{ transform: scaleX(1); }

    .navbar-custom .navbar-toggler{
      border-color: rgba(255,255,255,.35);
      border-radius: 12px;
      padding: .35rem .5rem;
    }
    .navbar-custom .navbar-toggler:focus{ box-shadow: var(--focus); }

    .navbar-custom .navbar-toggler-icon{
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.92)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Dropdown menu (desktop) */
    .dropdown-menu{
      border: 1px solid rgba(15,23,42,.08);
      border-radius: 16px;
      padding: .55rem;
      box-shadow: var(--shadow-lg);
      background: rgba(255,255,255,.96);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      transform-origin: top;
      animation: pop .20s var(--ease2);
    }

    @keyframes pop{
      from{ opacity: 0; transform: translateY(8px) scale(.98); }
      to{ opacity: 1; transform: translateY(0) scale(1); }
    }

    .dropdown-item{
      border-radius: 12px;
      font-size: .92rem;
      padding: .55rem .7rem;
      transition: background var(--speed) var(--ease), transform var(--speed) var(--ease);
      white-space: nowrap;
    }
    .dropdown-item:hover{
      background: rgba(15,23,42,.06);
      transform: translateX(2px);
    }

    .dropdown-submenu{ position: relative; }
    .dropdown-submenu > .dropdown-menu{
      top: 0;
      left: 100%;
      margin-left: .35rem;
    }

    /* ===========================
      NAV ACTIONS (buttons)
    =========================== */
    .nav-btn{
      border-radius: 999px;
      padding: .38rem .75rem;
      font-weight: 700;
      transition: transform var(--speed) var(--ease), box-shadow var(--speed) var(--ease);
    }
    .nav-btn:hover{
      transform: translateY(-1px);
      box-shadow: 0 12px 26px rgba(0,0,0,.18);
    }

    /* =========================================
      MOBILE NAVBAR FIX
    ========================================= */
    @media (max-width: 991.98px){
      .navbar-custom{
        left: 8px;
        right: 8px;
        width: auto;
        transform: none;
        top: 10px;
        padding: .55rem .75rem;
        border-radius: 18px;
      }

      .navbar-brand img{ height: 40px; }

      /* collapsed menu container */
      .navbar-custom .navbar-collapse{
        margin-top: .65rem;
        padding: .65rem;
        border-radius: 16px;
        background: rgba(2,6,23,.88);
        border: 1px solid rgba(255,255,255,.10);
      }

      .navbar-custom .nav-link{
        padding: .7rem .75rem;
        border-radius: 14px;
      }

      /* Make dropdowns not popper-absolute in collapsed nav */
      .navbar-custom .dropdown-menu,
      .navbar-custom .dropdown-menu[data-bs-popper]{
        position: static !important;
        transform: none !important;
        float: none !important;
        width: 100%;
        margin-top: .35rem;
        background: transparent;
        border: 0;
        padding: .25rem 0 0;
        box-shadow: none;
      }

      .navbar-custom .dropdown-item{
        color: rgba(229,231,235,.95);
        padding: .65rem .75rem;
        border-radius: 12px;
        white-space: normal;
      }
      .navbar-custom .dropdown-item:hover{
        background: rgba(255,255,255,.06);
        color: #fff;
      }

      /* Submenu mobile: hidden by default, opens on click */
      .dropdown-submenu > .dropdown-menu{
        display: none;
        margin: .25rem 0 .25rem .6rem;
        padding: .25rem 0 0;
      }
      .dropdown-submenu.open > .dropdown-menu{ display: block; }

      .submenu-toggle{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .6rem;
      }
      .submenu-toggle i.chev{
        transition: transform var(--speed) var(--ease);
      }
      .dropdown-submenu.open .submenu-toggle i.chev{
        transform: rotate(180deg);
      }

      /* Cart dropdown menu: avoid overflow on small screens */
      #cartDropdown + .dropdown-menu{
        min-width: auto !important;
        width: 100% !important;
      }
    }

    /* =========================================
      HEADER
    ========================================= */
    .page-header{
      text-align: center;
      margin-top: 18px;
      margin-bottom: 14px;
    }
    .page-header h1{
      font-size: clamp(1.45rem, 1.1rem + 1.2vw, 2.15rem);
      font-weight: 900;
      letter-spacing: .25px;
      margin: 0;
      background: linear-gradient(135deg, #111827, #111827, #dc3545);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .page-sub{
      color: var(--muted);
      font-size: .98rem;
      margin-top: .35rem;
      padding: 0 .75rem;
    }

    /* =========================================
      SEARCH (NOW ON PAGE, ABOVE PRODUCTS)
    ========================================= */
    .search-shell{
      width: 100%;
      max-width: 980px;
      margin: 0 auto 14px;
    }
    .search-card{
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(15,23,42,.08);
      box-shadow: var(--shadow-sm);
      border-radius: var(--radius-xl);
      padding: .55rem .6rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .6rem;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .search-meta{
      display: flex;
      align-items: center;
      gap: .55rem;
      color: var(--muted);
      font-size: .86rem;
      white-space: nowrap;
    }
    .search-meta i{ color: rgba(220,53,69,.95); }

    .search-form{
      flex: 1;
      display: flex;
      align-items: center;
      gap: .5rem;
      min-width: 0;
    }
    .search-input{
      width: 100%;
      border-radius: 999px !important;
      border: 1px solid rgba(15,23,42,.10);
      padding: .56rem .9rem;
      font-size: .92rem;
      outline: none;
      transition: box-shadow var(--speed) var(--ease), border-color var(--speed) var(--ease);
    }
    .search-input:focus{
      border-color: rgba(220,53,69,.45);
      box-shadow: var(--focus);
    }
    .search-btn{
      border-radius: 999px;
      padding: .52rem .85rem;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      transition: transform var(--speed) var(--ease), box-shadow var(--speed) var(--ease);
      white-space: nowrap;
    }
    .search-btn:hover{
      transform: translateY(-1px);
      box-shadow: 0 16px 30px rgba(220,53,69,.22);
    }

    .search-clear{
      border-radius: 999px;
      padding: .52rem .72rem;
      border: 1px solid rgba(15,23,42,.10);
      background: #fff;
      color: #111827;
      font-weight: 800;
      transition: transform var(--speed) var(--ease), background var(--speed) var(--ease);
    }
    .search-clear:hover{ transform: translateY(-1px); background: rgba(15,23,42,.04); }

    @media (max-width: 576px){
      .search-card{
        border-radius: 18px;
        padding: .5rem .55rem;
      }
      .search-meta{ display: none; }
      .search-input{
        font-size: .88rem;
        padding: .52rem .85rem;
      }
      .search-btn{ padding: .5rem .7rem; }
      .search-btn span{ display: none; }
    }

    /* =========================================
      FILTER BAR
    ========================================= */
    .filter-bar{
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: .75rem;
      margin-bottom: 1.15rem;
    }
    .filter-bar-left{
      font-size: .88rem;
      color: rgba(75,85,99,1);
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: .4rem;
    }

    .filter-chip{
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      padding: .28rem .7rem;
      border-radius: 999px;
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(15,23,42,.08);
      font-size: .82rem;
      color: #374151;
      box-shadow: 0 1px 3px rgba(0,0,0,.05);
      transition: transform var(--speed) var(--ease), box-shadow var(--speed) var(--ease);
      user-select: none;
    }
    .filter-chip:hover{
      transform: translateY(-1px);
      box-shadow: var(--shadow-sm);
    }

    .sort-select{
      font-size: .84rem;
      padding: .4rem .85rem;
      border-radius: 999px;
      border: 1px solid rgba(15,23,42,.12);
      background: rgba(255,255,255,.92);
      color: #374151;
      outline: none;
    }
    .sort-select:focus{ box-shadow: var(--focus); border-color: rgba(220,53,69,.40); }

    /* =========================================
      PRODUCT GRID
    ========================================= */
    .product-card{
      position: relative;
      border: 1px solid rgba(15,23,42,.06);
      border-radius: 18px;
      box-shadow: var(--shadow-sm);
      background: rgba(255,255,255,.95);
      height: 100%;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      transition: transform .20s var(--ease), box-shadow .20s var(--ease), border-color .20s var(--ease);
      transform: translateZ(0);
      isolation: isolate;
    }
    .product-card:hover{
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
      border-color: rgba(220,53,69,.18);
    }

    /* subtle shine on hover */
    .product-card::before{
      content:"";
      position:absolute;
      inset:-40% -60%;
      background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.55), rgba(255,255,255,0) 50%);
      transform: rotate(18deg) translateY(18%);
      opacity: 0;
      transition: opacity .25s var(--ease);
      pointer-events:none;
      z-index: 0;
    }
    .product-card:hover::before{ opacity: .55; }

    .product-thumb-wrap{
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .product-thumb{
      width: 100%;
      display: block;
      object-fit: cover;
      background: #eef2f7;
      aspect-ratio: 4 / 5;
      transform: translateZ(0);
      transition: transform .5s var(--ease2), filter .4s var(--ease2);
    }
    .product-card:hover .product-thumb{
      transform: scale(1.055);
      filter: saturate(1.05) contrast(1.02);
    }

    @media (max-width: 767.98px){
  .product-thumb{ aspect-ratio: 3 / 4; }
}

    .bf-label{
      position: absolute;
      top: 10px;
      left: 10px;
      background: linear-gradient(135deg, rgba(220,53,69,.98), rgba(255,77,95,.92));
      color: #fff;
      font-size: .72rem;
      padding: .22rem .55rem;
      border-radius: 999px;
      text-transform: uppercase;
      letter-spacing: .12em;
      display: inline-flex;
      align-items: center;
      gap: .28rem;
      z-index: 3;
      box-shadow: 0 14px 28px rgba(220,53,69,.22);
    }
    .bf-label span{ font-weight: 900; }
    .bf-label small{ opacity: .95; font-weight: 800; letter-spacing: .08em; }

    .bf-label.is-discount{
      animation: pulse 2.2s var(--ease) infinite;
    }
    @keyframes pulse{
      0%,100%{ transform: scale(1); }
      50%{ transform: scale(1.03); }
    }

    .size-label{
      position: absolute;
      bottom: 10px;
      right: 10px;
      background: rgba(15,23,42,.84);
      color: rgba(229,231,235,.96);
      font-size: .75rem;
      padding: .18rem .6rem;
      border-radius: 999px;
      z-index: 3;
      border: 1px solid rgba(255,255,255,.12);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .product-body{
      padding: .92rem 1rem 1.05rem;
      text-align: center;
      z-index: 1;
    }

    .product-title{
      font-size: .98rem;
      font-weight: 900;
      color: #111827;
      margin-bottom: .12rem;

      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .product-desc{
      font-size: .76rem;
      color: var(--muted);
      margin-bottom: .55rem;
      min-height: 1.2em;
    }

    .meta-row{
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .55rem;
      margin: .15rem 0 .55rem;
      flex-wrap: wrap;
    }

    .rating-pill, .ship-pill{
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      border-radius: 999px;
      padding: .22rem .55rem;
      font-size: .74rem;
      border: 1px solid rgba(15,23,42,.08);
      background: rgba(255,255,255,.9);
      color: #334155;
    }
    .rating-pill i{ color: #f59e0b; }
    .ship-pill i{ color: #22c55e; }

    .price-row{
      display: flex;
      align-items: baseline;
      justify-content: center;
      gap: .42rem;
      margin-bottom: .08rem;
    }
    .price-new{
      color: var(--brand);
      font-weight: 950;
      font-size: 1.02rem;
      letter-spacing: .2px;
    }
    .price-old{
      color: #9ca3af;
      font-size: .82rem;
      text-decoration: line-through;
    }
    .price-note{
      font-size: .72rem;
      color: #6b7280;
    }

    /* quick actions */
    .quick-actions{
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 4;
      display: flex;
      flex-direction: column;
      gap: .45rem;
      opacity: 0;
      transform: translateY(-4px);
      transition: opacity .22s var(--ease), transform .22s var(--ease);
      pointer-events: none;
    }
    .product-card:hover .quick-actions{
      opacity: 1;
      transform: translateY(0);
    }

    .qa-btn{
      width: 38px;
      height: 38px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(15,23,42,.10);
      box-shadow: var(--shadow-sm);
      transition: transform var(--speed) var(--ease), box-shadow var(--speed) var(--ease);
      pointer-events: auto;
    }
    .qa-btn:hover{
      transform: translateY(-1px) scale(1.04);
      box-shadow: var(--shadow-md);
    }
    .qa-btn:focus-visible{ box-shadow: var(--focus), var(--shadow-md); outline: none; }
    .qa-btn i{ color: rgba(15,23,42,.86); }
    .qa-btn:hover i{ color: var(--brand); }

    /* stretched link */
    .stretched-link{ position: absolute; inset: 0; z-index: 2; -webkit-tap-highlight-color: transparent; }
    
    .product-card{ cursor: pointer; -webkit-tap-highlight-color: transparent; }
    @media (max-width: 991.98px){
  .quick-actions{ display: none !important; }
}

    /* reveal animation */
    .reveal{
      opacity: 0;
      transform: translateY(14px);
      transition: opacity .45s var(--ease), transform .45s var(--ease);
      will-change: transform, opacity;
    }
    .reveal.in{
      opacity: 1;
      transform: translateY(0);
    }

    /* XS: make cards cleaner (optimized for 2 cols on phone) */
    @media (max-width: 575.98px){
      .product-body{ padding: .70rem .75rem .80rem; }
      .product-desc, .meta-row{ display: none; }

      .product-title{
        font-size: .88rem;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
      .price-new{ font-size: .95rem; }
      .price-old{ font-size: .75rem; }
      .bf-label{ font-size: .68rem; padding: .20rem .5rem; }
      .size-label{ font-size: .70rem; }
    }

    /* EMPTY STATE */
    .empty{
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(15,23,42,.08);
      border-radius: 18px;
      box-shadow: var(--shadow-sm);
      padding: 1.25rem;
      color: var(--muted);
    }

    /* =========================================
      PAGINATION
    ========================================= */
    .pagination-container{
      margin-top: 1.9rem;
      display: flex;
      justify-content: center;
    }
    .pagination{
      gap: .55rem;
      flex-wrap: wrap;
    }
    .pagination .page-link{
      border: 0;
      color: #111827;
      font-weight: 800;
      font-size: .86rem;
      box-shadow: 0 2px 8px rgba(0,0,0,.07);
      transition: transform var(--speed) var(--ease), box-shadow var(--speed) var(--ease), background var(--speed) var(--ease);
    }
    .page-pill{
      border-radius: 999px !important;
      padding: .48rem 1.15rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,.94);
    }
    .pagination .page-link:hover{
      transform: translateY(-1px);
      box-shadow: var(--shadow-sm);
      background: rgba(15,23,42,.04);
    }
    .page-indicator{
      border-radius: 999px !important;
      background: rgba(243,244,246,.92);
      padding: .42rem 1rem;
      font-size: .8rem;
      color: #4b5563;
      box-shadow: none;
    }
    .pagination .page-item.disabled .page-link{
      opacity: .5;
      box-shadow: none;
    }
    .pagination .page-link:focus-visible{ box-shadow: var(--focus); outline: none; }

    @media (max-width: 576px){
      .pagination{
        width: 100%;
        justify-content: space-between;
      }
      .page-pill{ flex: 1 1 0; text-align: center; }
      .page-indicator{ display: none; }
    }

    /* =========================================
      SEO TEXT
    ========================================= */
    .seo-text{
      font-size: .98rem;
      line-height: 1.75;
      color: rgba(17,24,39,.92);
    }
    .seo-text h2{
      font-weight: 950;
      letter-spacing: .2px;
      font-size: clamp(1.15rem, 1rem + .7vw, 1.6rem);
      margin-bottom: .8rem;
    }

    /* =========================================
      FLOATING UI
    ========================================= */
    .fab{
      position: fixed;
      right: 16px;
      bottom: 18px;
      z-index: 1040;
      display: flex;
      flex-direction: column;
      gap: .6rem;
      pointer-events: none;
    }
    .fab .fab-btn{
      pointer-events: auto;
      width: 46px;
      height: 46px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid rgba(15,23,42,.10);
      background: rgba(255,255,255,.92);
      box-shadow: var(--shadow-md);
      transition: transform var(--speed) var(--ease), opacity var(--speed) var(--ease);
      opacity: 0;
      transform: translateY(8px);
    }
    .fab .fab-btn.show{
      opacity: 1;
      transform: translateY(0);
    }
    .fab .fab-btn:hover{ transform: translateY(-1px); }
    .fab .fab-btn:focus-visible{ box-shadow: var(--focus), var(--shadow-md); outline: none; }

    /* overlays MUST be above navbar */
    .offcanvas, .offcanvas-backdrop{ z-index: 2600; }
    .modal{ z-index: 2700; }
    .modal-backdrop{ z-index: 2690; }

    /* subtle custom scrollbar (desktop) */
    @media (min-width: 992px){
      ::-webkit-scrollbar{ width: 10px; }
      ::-webkit-scrollbar-thumb{
        background: rgba(15,23,42,.18);
        border-radius: 999px;
        border: 2px solid rgba(255,255,255,.55);
      }
      ::-webkit-scrollbar-thumb:hover{ background: rgba(15,23,42,.28); }
    }
  </style>
</head>

<body>
  @php
    $isEn = app()->getLocale() === 'en';
    $tepihaText = [
      'home' => $isEn ? 'Home' : 'Home',
      'products' => $isEn ? 'Products' : 'Products',
      'rugs' => $isEn ? 'Rugs' : 'Tepiha',
      'curtains' => $isEn ? 'Curtains' : 'Perde',
      'side_curtains' => $isEn ? 'Side curtains' : 'Perde Anësore',
      'day_curtains' => $isEn ? 'Day curtains' : 'Perde Ditore',
      'pillows' => $isEn ? 'Decorative pillows' : 'Jastëk dekorues',
      'bedsheets' => $isEn ? 'Bedsheet sets' : 'Set çarçafësh',
      'covers' => $isEn ? 'Covers' : 'Mbulesa',
      'blankets' => $isEn ? 'Blankets' : 'Batanije',
      'bath_rugs' => $isEn ? 'Bath rugs' : 'Tepiha për Banjo',
      'plush_fur' => $isEn ? 'Plush fur' : 'Lëkurë pelushi',
      'rails' => $isEn ? 'Curtain rails' : 'Garnishte',
      'account' => $isEn ? 'My account' : 'Llogaria ime',
      'cart' => $isEn ? 'Cart' : 'Shporta',
      'track_order' => $isEn ? 'Track order' : 'Gjurmo porosinë',
      'track' => $isEn ? 'Track' : 'Gjurmo',
      'view_cart' => $isEn ? 'View cart' : 'Shiko shportën',
      'title' => $isEn ? 'Rugs - Our collection' : 'Tepiha - Koleksioni ynë',
      'subtitle' => $isEn ? 'Modern and classic rugs with seasonal discounts. Models for living rooms, bedrooms and every space.' : 'Tepiha modern & klasik me zbritje sezonale. Modele për sallon, dhomë gjumi dhe çdo ambient.',
      'quick_search' => $isEn ? 'Search fast and find the model' : 'Kërko shpejt & gjej modelin',
      'search_placeholder' => $isEn ? 'Search rugs... e.g. 150x230, modern, classic' : 'Kërko brenda tepihave... p.sh. 150x230, modern, klasik',
      'search' => $isEn ? 'Search' : 'Kërko',
      'products_count' => $isEn ? 'products' : 'produkte',
      'living_bedroom' => $isEn ? 'Living rooms & bedrooms' : 'Sallone & dhoma gjumi',
      'sort' => $isEn ? 'Sort by: Collection' : 'Rendit sipas: Koleksionit',
      'tips' => $isEn ? 'Tips' : 'Këshilla',
    ];
  @endphp
  <a class="skip-link" href="#mainContent">Shko tek përmbajtja</a>
  <div class="top-progress" id="topProgress" aria-hidden="true"></div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Navigimi kryesor">
    <div class="container-fluid">
      <a class="navbar-brand" href="/" aria-label="Brillant Home">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
      </a>

      <div class="d-flex align-items-center gap-2 ms-auto">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#nav"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

          <li class="nav-item">
            <a class="nav-link" href="/" data-nav="home">{{ $tepihaText['home'] }}</a>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              data-bs-toggle="dropdown"
              role="button"
              aria-expanded="false"
              data-nav="products">
              {{ $tepihaText['products'] }}
            </a>

            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/tepiha">
                  <i class="bi bi-grid-3x3-gap me-2"></i> {{ $tepihaText['rugs'] }}
                </a>
              </li>

              <li class="dropdown-submenu">
                <a class="dropdown-item submenu-toggle" href="#" role="button" aria-expanded="false">
                  <span><i class="bi bi-columns-gap me-2"></i> {{ $tepihaText['curtains'] }}</span>
                  <i class="bi bi-chevron-down chev"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/anesore">{{ $tepihaText['side_curtains'] }}</a></li>
                  <li><a class="dropdown-item" href="/perde-ditore">{{ $tepihaText['day_curtains'] }}</a></li>
                </ul>
              </li>

              <li><a class="dropdown-item" href="/jastekdekorues"><i class="bi bi-square-fill me-2"></i> {{ $tepihaText['pillows'] }}</a></li>
              <li><a class="dropdown-item" href="/postava"><i class="bi bi-journal-text me-2"></i> {{ $tepihaText['bedsheets'] }}</a></li>
              <li><a class="dropdown-item" href="/mbulesa"><i class="bi bi-collection me-2"></i> {{ $tepihaText['covers'] }}</a></li>
              <li><a class="dropdown-item" href="/batanije"><i class="bi bi-layers me-2"></i> {{ $tepihaText['blankets'] }}</a></li>
              <li><a class="dropdown-item" href="/tepihebanjo"><i class="bi bi-droplet me-2"></i> {{ $tepihaText['bath_rugs'] }}</a></li>
              <li><a class="dropdown-item" href="/posteqia"><i class="bi bi-cloud-fog2 me-2"></i> {{ $tepihaText['plush_fur'] }}</a></li>
              <li><a class="dropdown-item" href="/garnishte"><i class="bi bi-dash-square me-2"></i> {{ $tepihaText['rails'] }}</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="{{ route('about') }}" data-nav="about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}" data-nav="contact">Contact</a></li>

          @auth
            <li class="nav-item dropdown ms-lg-2">
              <a
                class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                href="#"
                id="userDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person-circle"></i>
                <span class="user-name">{{ Auth::user()->name }}</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('account.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> {{ $tepihaText['account'] }}</a></li>
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
            <li class="nav-item ms-lg-2">
              <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm nav-btn">Log in</a>
            </li>
          @endauth

          <!-- Shporta + Gjurmo porosinë -->
          <li class="nav-item dropdown ms-lg-2">
            <a
              class="nav-link dropdown-toggle d-flex align-items-center gap-2"
              href="#"
              id="cartDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-bag"></i> {{ $tepihaText['cart'] }}
              <span class="badge bg-danger rounded-pill ms-1 cart-badge">
                {{ session('cart_total_qty', 0) }}
              </span>
            </a>

            <div
              class="dropdown-menu dropdown-menu-end p-3 shadow"
              aria-labelledby="cartDropdown"
              style="min-width: 320px; border-radius: 16px;">
              <div class="small text-muted mb-2">{{ $tepihaText['track_order'] }}</div>

              <form
                class="d-flex align-items-stretch gap-2"
                onsubmit="event.preventDefault();
                          const el=this.querySelector('#trackCodeNav');
                          const v=(el?.value||'').trim();
                          if(v){ window.location='{{ url('/track') }}/'+encodeURIComponent(v); }">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input
                    id="trackCodeNav"
                    type="text"
                    class="form-control"
                    placeholder="p.sh. BRL-LKNJ-0YXN"
                    autocomplete="off"
                    required>
                  <button class="btn btn-danger" type="submit">{{ $tepihaText['track'] }}</button>
                </div>
              </form>

              <div class="mt-3 d-grid">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('cart.index') }}">
                  <i class="bi bi-bag"></i> {{ $tepihaText['view_cart'] }}
                </a>
              </div>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Koka e faqes -->
  <header class="page-header">
    <h1>{{ $tepihaText['title'] }}</h1>
    <div class="page-sub">{{ $tepihaText['subtitle'] }}</div>
  </header>
  

  <main id="mainContent" class="container py-3 pb-5">

    <!-- SEARCH (MOVED HERE: above products, not in navbar) -->
    <div class="search-shell">
      <div class="search-card">
        <div class="search-meta">
          <i class="bi bi-stars"></i>
          <span>{{ $tepihaText['quick_search'] }}</span>
        </div>

        <form method="GET" action="{{ url('/tepiha') }}" class="search-form">
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control search-input"
            placeholder="{{ $tepihaText['search_placeholder'] }}"
          >
          @if(request('q'))
            <a href="{{ url('/tepiha') }}" class="search-clear" aria-label="Pastro kërkimin">
              <i class="bi bi-x-lg"></i>
            </a>
          @endif
          <button class="btn btn-danger search-btn" type="submit">
            <i class="bi bi-search"></i> <span>{{ $tepihaText['search'] }}</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Info / Filter bar -->
    <section class="filter-bar">
      <div class="filter-bar-left">
        @php
          $totalProducts = ($products instanceof \Illuminate\Support\Collection) ? $products->count() : $products->total();
        @endphp
        <span class="me-2 fw-bold">{{ $totalProducts }} {{ $tepihaText['products_count'] }}</span>
        <span class="filter-chip"><i class="bi bi-stars"></i> Modern</span>
        <span class="filter-chip"><i class="bi bi-shield-check"></i> Antibakterial</span>
        <span class="filter-chip d-none d-md-inline"><i class="bi bi-house-door"></i> {{ $tepihaText['living_bedroom'] }}</span>
        @if(request('q'))
          <span class="filter-chip"><i class="bi bi-search"></i> "{{ request('q') }}"</span>
        @endif
      </div>

      <div class="d-flex align-items-center gap-2">
        <select class="sort-select" disabled>
          <option>{{ $tepihaText['sort'] }}</option>
        </select>

        <button
          type="button"
          class="btn btn-light btn-sm"
          style="border-radius:999px; font-weight:900;"
          data-bs-toggle="modal"
          data-bs-target="#tipsModal">
          <i class="bi bi-lightbulb"></i>
          {{ $tepihaText['tips'] }}
        </button>
      </div>
    </section>

    <!-- Tips Modal -->
    <div class="modal fade" id="tipsModal" tabindex="-1" aria-labelledby="tipsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;">
          <div class="modal-header">
            <h5 class="modal-title" id="tipsModalLabel"><i class="bi bi-lightbulb me-1"></i> Si të zgjedhësh tepih?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Mbyll"></button>
          </div>
          <div class="modal-body">
            <ul class="mb-0">
              <li>Kontrollo madhësinë (p.sh. 150x230 / 200x300) sipas hapësirës.</li>
              <li>Për sallon: modele me densitet më të lartë & ngjyra stabile.</li>
              <li>Për dhoma gjumi: materiale më të buta dhe ngjyra të qeta.</li>
              <li>Për pastrim të lehtë: zgjidh teksturë që s’mbledh shumë pluhur.</li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius:999px; font-weight:900;">
              Mbyll
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty state -->
    @if(($products instanceof \Illuminate\Support\Collection && $products->isEmpty()) || ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->count() === 0))
      <div class="empty text-center mx-auto reveal" style="max-width:720px">
        <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
        <div class="fw-bold">S’ka ende produkte në këtë kategori.</div>
        <div class="small">Kthehu më vonë – po shtojmë vazhdimisht modele të reja.</div>
      </div>
    @endif

    <!-- Lista e produkteve (MOBILE 2-COL FIX) -->
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
      @foreach($products as $product)
        @php
          $price = $product->price;
          $oldPrice = $price ? round($price * 1.25, 2) : null;
          $discountPercent = ($oldPrice && $price && $oldPrice > $price)
            ? round(100 - ($price / $oldPrice * 100))
            : null;

          // ✅ FOTO (punon edhe kur image_path është JSON array)
          $src = \App\Support\ProductImages::url($product->image_path ?? null, asset('images/placeholder.jpg'));

          preg_match('/\d{2,3}x\d{2,3}/', $product->name, $sizeMatch);
          $sizeLabel = $sizeMatch[0] ?? null;

          // simple pseudo rating based on discount existence (just UI feel)
          $rating = $discountPercent ? 4.8 : 4.6;
          $reviews = $discountPercent ? 120 : 72;
        @endphp

        <div class="col reveal">
          <article class="product-card" data-product-card>
            <div class="product-thumb-wrap">

              <!-- Quick actions -->
              <div class="quick-actions" aria-hidden="false">
                <button
                  class="qa-btn"
                  type="button"
                  title="Shto në të preferuara"
                  aria-label="Shto në të preferuara"
                  onclick="event.stopPropagation(); toast('U shtua në të preferuara (UI)!');">
                  <i class="bi bi-heart"></i>
                </button>

                <button
                  class="qa-btn"
                  type="button"
                  title="Shpërndaje"
                  aria-label="Shpërndaje"
                  onclick="event.stopPropagation(); shareProduct('{{ route('products.show', $product->slug) }}','{{ $product->name }}');">
                  <i class="bi bi-share"></i>
                </button>

                <button
                  class="qa-btn"
                  type="button"
                  title="Kopjo linkun"
                  aria-label="Kopjo linkun"
                  onclick="event.stopPropagation(); copyLink('{{ route('products.show', $product->slug) }}');">
                  <i class="bi bi-link-45deg"></i>
                </button>
              </div>

              @if($discountPercent)
                <div class="bf-label is-discount">
                  <span>-{{ $discountPercent }}%</span>
                  <small>Oferta</small>
                </div>
              @else
                <div class="bf-label">
                  <span>SALE</span>
                  <small>Oferta</small>
                </div>
              @endif

              @if($sizeLabel)
                <div class="size-label">{{ $sizeLabel }} cm</div>
              @endif

              <img
                class="product-thumb"
                src="{{ $src }}"
                alt="{{ $product->name }}"
                loading="lazy"
                decoding="async"
                onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}'">
            </div>

            <div class="product-body">
              <div class="product-title" title="{{ $product->name }}">{{ $product->name }}</div>

              <div class="product-desc">
                Tepiha antibakterial, i përshtatshëm për përdorim të përditshëm.
              </div>

              <div class="meta-row" aria-hidden="true">
                <span class="rating-pill">
                  <i class="bi bi-star-fill"></i> {{ number_format($rating, 1) }}
                  <span style="opacity:.75;">({{ $reviews }})</span>
                </span>
                <span class="ship-pill">
                  <i class="bi bi-truck"></i> Dërgesë e shpejtë
                </span>
              </div>

              <div class="price-row">
                @if(!is_null($price))
                  <span class="price-new">{{ number_format($price, 2) }} €</span>
                @endif
                @if($oldPrice)
                  <span class="price-old">{{ number_format($oldPrice, 2) }} €</span>
                @endif
              </div>

              @if($oldPrice && $price)
                <div class="price-note">Çmim promo aktual</div>
              @endif
            </div>

            <a href="{{ route('products.show', $product->slug) }}" class="stretched-link"
               aria-label="Shiko {{ $product->name }}"></a>
          </article>
        </div>
      @endforeach
    </div>

    <!-- PAGINATION -->
    @if($products instanceof \Illuminate\Contracts\Pagination\Paginator || $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
      @if($products->hasPages())
        <div class="pagination-container">
          <nav aria-label="Navigimi i faqeve">
            <ul class="pagination mb-0">
              @php
                $prevUrl = method_exists($products, 'appends') ? $products->appends(request()->query())->previousPageUrl() : $products->previousPageUrl();
                $nextUrl = method_exists($products, 'appends') ? $products->appends(request()->query())->nextPageUrl() : $products->nextPageUrl();
              @endphp

              <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                <a
                  class="page-link page-pill"
                  href="{{ $prevUrl ?? '#' }}"
                  @if($products->onFirstPage()) tabindex="-1" aria-disabled="true" @endif>
                  <i class="bi bi-chevron-left me-1"></i>
                  Faqja paraprake
                </a>
              </li>

              <li class="page-item disabled d-none d-sm-block">
                <span class="page-link page-indicator">
                  Faqja {{ $products->currentPage() }} nga {{ $products->lastPage() }}
                </span>
              </li>

              <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                <a
                  class="page-link page-pill"
                  href="{{ $nextUrl ?? '#' }}"
                  @unless($products->hasMorePages()) tabindex="-1" aria-disabled="true" @endunless>
                  Faqja tjetër
                  <i class="bi bi-chevron-right ms-1"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      @endif
    @endif

  </main>

  <!-- SEO TEXT SECTION -->
  <section class="seo-text mt-5">
    <div class="container">
      <h2>Tepiha Modern dhe Klasik – Koleksioni Premium Brillant Tepiha</h2>

      <p>Koleksioni i tapetave Brillant ofron tepiha modern, tepiha klasik, modele rrethore dhe tapeta të dizajnuara posaçërisht për sallon, dhoma gjumi dhe çdo ambient të shtëpisë. Materialet që përdorim janë të qëndrueshme, antibakteriale dhe me cilësi të lartë për komoditet maksimal dhe jetëgjatësi.</p>

      <p>Ofrojmë madhësi të ndryshme si 150x230, 200x300, 120x170 dhe shumë të tjera, duke u përshtatur për çdo lloj ambienti. Çdo tepih përzgjidhet me kujdes për të ofruar dizajn modern, stil elegant dhe ngjyra që nuk zbehen me kohë.</p>

      <p>Në Brillant do të gjeni edhe tepiha akrilik, tepiha të butë, modele premium për sallon dhe tapeta banjo
        me cilësi superiore. Produktet tona janë të lehta për t’u pastruar, antialergjike dhe shumë rezistente ndaj
        konsumit të përditshëm.</p>

      <p>Kërkon stil, cilësi dhe dizajn? Brillant është zgjedhja ideale për tepiha modern në Lipjan dhe në gjithë Kosovën.</p>

      <p>Tepiha Online · Tepiha Hali · Tepiha Bambo · Tepiha pelushi · Staz · Tepiha Rrethore · Tepiha Moderne</p>

      <p>B-Brillant është një nga dyqanet më të besuara për tepih në Kosovë, duke ofruar dizajne moderne, materiale cilësore dhe çmime të përballueshme për çdo familje. Nëse po kërkoni “tepih Kosovë”, koleksioni ynë është ndër më të mirët në treg.</p>
      <h3>Tepiha online Kosove - akril, akrill, Hali dhe modele moderne</h3>
      <p>Te B-Brillant mund te porosisni tepiha online ne Kosove per sallon, dhome gjumi, korridor dhe ambiente familjare. Koleksioni perfshin tepiha akril, tepiha akrill, tepiha Hali, tepiha moderne, klasik, rrethore, staza dhe modele antibakteriale me dergese te shpejte ne Lipjan, Prishtine dhe qytete te tjera te Kosoves.</p>
      <h3>Si te zgjedhesh tepihun e duhur per shtepi?</h3>
      <p>Nese kerkon tepih per sallon, zakonisht zgjidhen madhesi me te medha si 200x300 ose 160x230, ndersa per dhome gjumi pershtaten modele me teksture me te bute dhe ngjyra me te qeta. Per korridor dhe hyrje, stazat dhe tepiha me material rezistent jane zgjedhje praktike sepse pastrohen lehte dhe e mbajne ambientin te rregullt.</p>
      <p>Klientet shpesh kerkojne ne Google fjale si tepiha Kosove, tepih online, tepiha ne Lipjan, tepiha ne Prishtine, tapeta moderne, tepiha akril, tepiha Hali, tepiha per sallon, tepiha per dhome gjumi dhe tepiha me oferta. Ne kete faqe gjeni modele te ndryshme per shtepi moderne, klasike dhe ambiente familjare.</p>
      <p>B-Brillant punon me perzgjedhje te kujdesshme te modeleve, materialeve dhe ngjyrave qe pershtaten me interierin e shtepise. Per cdo tepih mund te shikoni foton, emrin, cmimin dhe detajet e produktit, pastaj te vazhdoni porosine online ose te kontaktoni ekipin per me shume informacion.</p>
    </div>
  </section>

  <!-- Floating buttons -->
  <div class="fab" aria-hidden="false">
    <button class="fab-btn" id="backToTop" type="button" aria-label="Kthehu lart">
      <i class="bi bi-arrow-up"></i>
    </button>
  </div>

  <!-- Toast container -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 3000;">
    <div id="uiToast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite" aria-atomic="true" style="border-radius:14px;">
      <div class="d-flex">
        <div class="toast-body" id="uiToastBody">Njoftim</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Mbyll"></button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    /* ===========================
      Helpers: Toast, Copy, Share
    =========================== */
    function toast(msg){
      const el = document.getElementById('uiToast');
      const body = document.getElementById('uiToastBody');
      if(!el || !body) return;
      body.textContent = msg;
      const t = bootstrap.Toast.getOrCreateInstance(el, { delay: 2400 });
      t.show();
    }

    async function copyLink(url){
      try{
        await navigator.clipboard.writeText(url);
        toast('Linku u kopjua!');
      }catch(e){
        toast('S’u kopjua. Provo manualisht.');
      }
    }

    async function shareProduct(url, title){
      try{
        if(navigator.share){
          await navigator.share({ title, url });
        }else{
          await copyLink(url);
        }
      }catch(e){
        // user cancelled or error
      }
    }

    /* ===========================
      Auto body offset based on navbar height
      (fix overlap on mobile/desktop)
    =========================== */
    (function () {
      const nav = document.querySelector('.navbar-custom');
      if (!nav) return;

      const setOffset = () => {
        const h = Math.ceil(nav.getBoundingClientRect().height);
        const offset = h + 34; // buffer for top spacing
        document.documentElement.style.setProperty('--nav-offset', offset + 'px');
      };

      window.addEventListener('resize', setOffset, { passive: true });
      window.addEventListener('load', setOffset);
      setOffset();
    })();

    /* ===========================
      Nav active link (simple)
    =========================== */
    (function(){
      const path = (window.location.pathname || '').toLowerCase();
      document.querySelectorAll('.navbar-custom .nav-link').forEach(a => {
        const href = (a.getAttribute('href') || '').toLowerCase();
        if(href && href !== '#' && href !== '/' && path.startsWith(href)){
          a.classList.add('active');
        }
      });
      if(path === '/' || path === '') {
        const home = document.querySelector('.nav-link[data-nav="home"]');
        if(home) home.classList.add('active');
      }
    })();

    /* ===========================
      Submenu: desktop hover + mobile click
      (works correctly on resize)
    =========================== */
    (function(){
      const mq = window.matchMedia('(min-width: 992px)');

      document.querySelectorAll('.dropdown-submenu').forEach((item) => {
        const toggle = item.querySelector('.submenu-toggle');
        const menu = item.querySelector('.dropdown-menu');
        if(!toggle || !menu) return;

        // MOBILE click toggle
        toggle.addEventListener('click', (e) => {
          if(mq.matches) return; // desktop ignore click behavior
          e.preventDefault();
          e.stopPropagation();
          const open = item.classList.toggle('open');
          toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        // DESKTOP hover
        let enterTimer = null;
        let leaveTimer = null;

        item.addEventListener('mouseenter', () => {
          if(!mq.matches) return;
          clearTimeout(leaveTimer);
          enterTimer = setTimeout(() => menu.classList.add('show'), 70);
        });

        item.addEventListener('mouseleave', () => {
          if(!mq.matches) return;
          clearTimeout(enterTimer);
          leaveTimer = setTimeout(() => menu.classList.remove('show'), 110);
        });

        // close submenu when main dropdown closes
        const parentDropdown = item.closest('.dropdown');
        if(parentDropdown){
          parentDropdown.addEventListener('hide.bs.dropdown', () => {
            item.classList.remove('open');
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
          });
        }

        // reset on breakpoint change
        if(mq.addEventListener){
          mq.addEventListener('change', () => {
            item.classList.remove('open');
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
          });
        }
      });
    })();

    /* ===========================
      Scroll reveal for cards
    =========================== */
    (function(){
      const els = document.querySelectorAll('.reveal');
      if(!('IntersectionObserver' in window) || !els.length){
        els.forEach(e => e.classList.add('in'));
        return;
      }
      const obs = new IntersectionObserver((entries) => {
        entries.forEach(en => {
          if(en.isIntersecting){
            en.target.classList.add('in');
            obs.unobserve(en.target);
          }
        });
      }, { threshold: 0.12 });

      els.forEach(e => obs.observe(e));
    })();

    /* ===========================
      Back to top + progress bar
    =========================== */
    (function(){
      const btn = document.getElementById('backToTop');
      const bar = document.getElementById('topProgress');

      function onScroll(){
        const y = window.scrollY || document.documentElement.scrollTop;
        const h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const pct = h > 0 ? (y / h) * 100 : 0;
        if(bar) bar.style.width = pct.toFixed(2) + '%';

        if(btn){
          if(y > 380) btn.classList.add('show');
          else btn.classList.remove('show');
        }
      }

      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();

      if(btn){
        btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
      }
    })();

    /* ===========================
      Cart badge updater
    =========================== */
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });

    /* ===========================
      OPTIONAL: close navbar collapse on click (mobile UX)
    =========================== */
   (function(){
  const navCollapse = document.getElementById('nav');
  if(!navCollapse) return;

  navCollapse.addEventListener('click', (e) => {
    const a = e.target.closest('a');
    if(!a) return;

    // ✅ Mos e mbyll kur klikon dropdown toggle (p.sh. Products)
    if (a.classList.contains('dropdown-toggle')) return;

    // ✅ Mos e mbyll kur klikon brenda dropdown menus (opsionale)
    // (nëse don me e mbyll kur zgjedh item, hiqe këtë rresht)
    if (a.closest('.dropdown-menu')) return;

    // Mos mbyll për href="#"
    const href = (a.getAttribute('href') || '').trim();
    if (!href || href === '#') return;

    if (navCollapse.classList.contains('show')) {
      const bsCollapse = bootstrap.Collapse.getOrCreateInstance(navCollapse, { toggle: false });
      bsCollapse.hide();
    }
  });
})();
  </script>
</body>
</html>
