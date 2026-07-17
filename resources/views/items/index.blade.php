<!doctype html>
@php
  $requestedLocale = request()->query('lang');
  $activeLocale = in_array($requestedLocale, ['sq', 'en', 'sr'], true)
    ? $requestedLocale
    : session('locale', app()->getLocale());
  $pageLocale = in_array($activeLocale, ['sq', 'en', 'sr'], true) ? $activeLocale : 'sq';
  $seoCopy = [
    'sq' => [
      'title' => 'Brillant | Tepiha, Perde, Mbulesa, Batanije & Dekor',
      'description' => 'Brillant në Lipjan: tepiha, perde ditore, perde anësore, mbulesa divani, set çarçafësh, postava, batanije, jastëk dekorues, tepiha banjo dhe lëkurë pelushi në Kosovë.',
      'ogTitle' => 'Brillant - Tepiha dhe Perde',
      'ogDescription' => 'Koleksione per shtepi me dizajn te paster, materiale te zgjedhura dhe kontakt direkt ne WhatsApp.',
      'keywords' => 'tepiha, perde ditore, perde anesore, mbulesa, batanije, set carcafesh, jasteke dekorues, tepiha banjo, garnishte, Brillant Lipjan',
    ],
    'en' => [
      'title' => 'Brillant | Rugs, Curtains, Covers, Blankets & Home Decor',
      'description' => 'Brillant in Lipjan offers rugs, day curtains, side curtains, sofa covers, bedsheet sets, blankets, decorative pillows, bath rugs, curtain rails and plush fur home decor in Kosovo.',
      'ogTitle' => 'Brillant - Rugs, Curtains and Home Textiles',
      'ogDescription' => 'Home collections with clean design, selected materials, clear categories and direct WhatsApp support.',
      'keywords' => 'rugs Kosovo, curtains Kosovo, day curtains, side curtains, sofa covers, blankets, bedsheet sets, decorative pillows, bath rugs, curtain rails, Brillant Lipjan',
    ],
    'sr' => [
      'title' => 'Brillant | Tepisi, Zavese, Prekrivaci, Cebad i Dekor',
      'description' => 'Brillant u Lipljanu nudi tepihe, dnevne zavese, bocne zavese, prekrivace, setove posteljine, cebad, dekorativne jastuke, kupatilske tepihe, garnisne i plisani dekor na Kosovu.',
      'ogTitle' => 'Brillant - Tepisi, Zavese i Tekstil za Dom',
      'ogDescription' => 'Kolekcije za dom sa urednim dizajnom, izabranim materijalima, jasnim kategorijama i direktnom WhatsApp podrskom.',
      'keywords' => 'tepisi Kosovo, zavese Kosovo, dnevne zavese, bocne zavese, prekrivaci, cebad, posteljina, dekorativni jastuci, kupatilski tepisi, garnisne, Brillant Lipljan',
    ],
  ];
  $seo = $seoCopy[$pageLocale];
  $localizedUrl = fn (string $locale) => $locale === 'sq' ? url('/') : url('/').'?lang='.$locale;
  $canonicalUrl = $localizedUrl($pageLocale);
@endphp
<html lang="{{ $pageLocale }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $seo['title'] }}</title>
  <meta name="description" content="{{ $seo['description'] }}">
  <meta name="keywords" content="{{ $seo['keywords'] }}">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ $canonicalUrl }}">
  <link rel="alternate" hreflang="sq" href="{{ $localizedUrl('sq') }}">
  <link rel="alternate" hreflang="en" href="{{ $localizedUrl('en') }}">
  <link rel="alternate" hreflang="sr" href="{{ $localizedUrl('sr') }}">
  <link rel="alternate" hreflang="x-default" href="{{ $localizedUrl('sq') }}">
  <meta name="theme-color" content="#7f1d2d">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <meta property="og:title" content="{{ $seo['ogTitle'] }}">
  <meta property="og:description" content="{{ $seo['ogDescription'] }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ $canonicalUrl }}">
  <meta property="og:image" content="{{ asset('images/home/hero-luxury-curtains.jpg') }}">
  <meta property="og:locale" content="{{ $pageLocale === 'en' ? 'en_US' : ($pageLocale === 'sr' ? 'sr_RS' : 'sq_AL') }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $seo['ogTitle'] }}">
  <meta name="twitter:description" content="{{ $seo['ogDescription'] }}">

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <link rel="preload" as="image" href="{{ asset('images/home/hero-luxury-curtains.jpg') }}" fetchpriority="high">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --bg: #fbf7f2;
      --paper: #ffffff;
      --paper-soft: #f5ede5;
      --ink: #1d1714;
      --muted: #756b63;
      --line: #e7dbcf;
      --brand: #7f1d2d;
      --brand-2: #a12d3b;
      --gold: #c99a46;
      --green: #198754;
      --dark: #211916;
      --shadow: 0 20px 50px rgba(55, 35, 25, .12);
      --shadow-soft: 0 10px 28px rgba(55, 35, 25, .08);
      --radius: 10px;
      --radius-lg: 18px;
      --dock-h: 70px;
    }

    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      margin: 0;
      font-family: Poppins, system-ui, -apple-system, Segoe UI, sans-serif;
      color: var(--ink);
      background: var(--bg);
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    img { display: block; max-width: 100%; height: auto; }
    button, input { font: inherit; }
    ::selection { background: rgba(127, 29, 45, .18); }

    .container {
      width: min(1160px, calc(100% - 32px));
      margin: 0 auto;
    }
    .nav-container {
      width: min(100% - 24px, 1480px);
      margin: 0 auto;
    }
    .section { padding: 58px 0; }
    .section-tight { padding: 36px 0; }
    .pt-0 { padding-top: 0 !important; }
    .inspiration-section { display: none !important; }
    .eyebrow {
      color: var(--brand);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: .76rem;
      font-weight: 800;
      letter-spacing: .14em;
      text-transform: uppercase;
      margin-bottom: 10px;
    }
    .eyebrow::before {
      content: "";
      width: 28px;
      height: 2px;
      background: var(--gold);
    }
    .section-head {
      display: flex;
      justify-content: space-between;
      align-items: end;
      gap: 22px;
      margin-bottom: 24px;
    }
    .section-head h2 {
      margin: 0;
      max-width: 680px;
      font-size: clamp(1.7rem, 3vw, 2.55rem);
      line-height: 1.08;
      font-weight: 800;
      letter-spacing: 0;
    }
    .section-head p {
      color: var(--muted);
      max-width: 560px;
      line-height: 1.7;
      margin: 10px 0 0;
    }

    .site-header {
      position: sticky;
      top: 0;
      z-index: 80;
      padding: 10px 0;
      background: rgba(251,247,242,.86);
      backdrop-filter: blur(14px);
    }
    .nav {
      min-height: 94px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      padding: 0 34px;
      border-radius: 22px;
      background: #111827;
      border: 1px solid rgba(255,255,255,.08);
      box-shadow: 0 18px 46px rgba(17,24,39,.16);
    }
    .brand {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      min-width: 0;
      font-weight: 800;
    }
    .brand img {
      width: 300px;
      height: 72px;
      object-fit: contain;
      object-position: left center;
    }
    .brand span { display: none; }
    .nav-links {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      flex: 1;
    }
    .nav-links a,
    .nav-dropdown summary {
      padding: 10px 13px;
      border-radius: var(--radius);
      color: rgba(255,255,255,.92);
      font-size: 1rem;
      font-weight: 700;
      white-space: nowrap;
      cursor: pointer;
      list-style: none;
    }
    .nav-links a:hover,
    .nav-dropdown:hover summary,
    .nav-dropdown[open] summary {
      background: rgba(255,255,255,.08);
      color: #fff;
    }
    .nav-dropdown {
      position: relative;
    }
    .nav-dropdown summary::-webkit-details-marker { display: none; }
    .nav-dropdown summary i {
      font-size: .75rem;
      margin-left: 5px;
    }
    .dropdown-menu {
      position: absolute;
      top: calc(100% + 12px);
      left: 50%;
      transform: translateX(-50%);
      min-width: 260px;
      padding: 10px;
      border-radius: 16px;
      background: #fff;
      border: 1px solid rgba(17,24,39,.08);
      box-shadow: 0 22px 55px rgba(17,24,39,.20);
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4px;
      z-index: 100;
    }
    .nav-dropdown:not([open]) .dropdown-menu { display: none; }
    .dropdown-menu a {
      color: #201a17;
      padding: 10px 11px;
      font-size: .9rem;
      border-radius: 10px;
    }
    .dropdown-menu a:hover {
      background: rgba(127,29,45,.08);
      color: var(--brand);
    }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .icon-btn {
      width: 44px;
      height: 44px;
      border: 1px solid rgba(255,255,255,.22);
      border-radius: var(--radius);
      background: rgba(255,255,255,.05);
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      position: relative;
      cursor: pointer;
    }
    .cart-badge {
      position: absolute;
      top: -7px;
      right: -7px;
      min-width: 21px;
      height: 21px;
      padding: 0 5px;
      border-radius: 99px;
      background: var(--brand);
      color: #fff;
      font-size: .72rem;
      font-weight: 800;
      line-height: 21px;
      text-align: center;
    }
    .menu-toggle { display: none; }
    .menu-toggle {
      touch-action: manipulation;
      -webkit-tap-highlight-color: transparent;
      z-index: 1300;
    }
    .login-btn {
      min-height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border-radius: 8px;
      border: 1px solid rgba(255,255,255,.70);
      color: #fff;
      padding: 10px 15px;
      font-weight: 700;
      white-space: nowrap;
    }
    .login-btn:hover {
      background: rgba(255,255,255,.10);
      color: #fff;
    }
    .account-mobile-link,
    .mobile-menu-lang { display: none; }
    .lang-switch {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 4px;
      border: 1px solid rgba(255,255,255,.18);
      border-radius: 999px;
      background: rgba(255,255,255,.06);
    }
    .lang-switch button {
      min-width: 34px;
      height: 30px;
      border: 0;
      border-radius: 999px;
      background: transparent;
      color: rgba(255,255,255,.78);
      font-size: .75rem;
      font-weight: 800;
      cursor: pointer;
    }
    .lang-switch button.active {
      background: #fff;
      color: var(--brand);
    }
    .cart-link {
      width: auto;
      min-width: 0;
      gap: 10px;
      padding: 0 10px;
      border: 0;
      background: transparent;
      font-weight: 800;
      font-size: 1rem;
    }
    .cart-link .cart-badge {
      position: static;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 2px;
      background: #ef334f;
    }
    .cart-more {
      color: rgba(255,255,255,.88);
      margin-left: 2px;
      font-size: .78rem;
    }
    .cart-dropdown .dropdown-menu {
      left: auto;
      right: 0;
      transform: none;
      min-width: 210px;
      grid-template-columns: 1fr;
    }
    .mobile-cart { display: none; }
    .btn {
      min-height: 46px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      border-radius: var(--radius);
      border: 1px solid transparent;
      padding: 12px 18px;
      font-weight: 800;
      line-height: 1;
      cursor: pointer;
      transition: transform .18s ease, background .18s ease, border-color .18s ease, color .18s ease;
    }
    .btn:hover { transform: translateY(-1px); }
    .btn-primary { background: var(--brand); color: #fff; box-shadow: 0 14px 28px rgba(127,29,45,.18); }
    .btn-primary:hover { background: #681522; color: #fff; }
    .btn-outline { background: #fff; color: var(--ink); border-color: var(--line); }
    .btn-outline:hover { background: var(--paper-soft); color: var(--brand); border-color: rgba(127,29,45,.18); }
    .btn-whatsapp { background: var(--green); color: #fff; }
    .btn-whatsapp:hover { color: #fff; filter: brightness(.97); }

    .hero {
      position: relative;
      color: var(--ink);
      isolation: isolate;
      overflow: hidden;
      background: linear-gradient(180deg, #fff 0%, #fbf7f2 100%);
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background:
        linear-gradient(90deg, rgba(255,255,255,.96), rgba(255,255,255,.76)),
        url("{{ asset('optimized/home/hero.jpg') }}") center / cover no-repeat;
      opacity: .26;
      z-index: -2;
    }
    .hero::after {
      content: "";
      position: absolute;
      inset: auto 0 0;
      height: 140px;
      background: linear-gradient(180deg, rgba(251,247,242,0), var(--bg));
      z-index: -1;
      pointer-events: none;
    }
    .hero-grid {
      min-height: 650px;
      display: grid;
      grid-template-columns: 340px minmax(0, 1fr);
      align-items: center;
      gap: 26px;
      padding: 44px 0 104px;
    }
    .hero-intro {
      min-width: 0;
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 28px;
      border-radius: 22px;
      background: rgba(255,255,255,.82);
      border: 1px solid rgba(55,35,25,.08);
      box-shadow: var(--shadow-soft);
      backdrop-filter: blur(12px);
    }
    .hero-intro img {
      width: min(260px, 100%);
      height: auto;
      object-fit: contain;
      object-position: left center;
      margin-bottom: 26px;
    }
    .hero-intro h1 {
      margin: 0;
      font-size: clamp(2.25rem, 4vw, 3.9rem);
      line-height: .98;
      letter-spacing: 0;
      font-weight: 800;
    }
    .hero-intro p {
      margin: 16px 0 0;
      color: var(--muted);
      line-height: 1.7;
      font-size: 1rem;
    }
    .hero-mini-stats {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 8px;
      margin-top: 22px;
    }
    .hero-mini-stat {
      min-height: 74px;
      border-radius: 12px;
      background: var(--paper-soft);
      display: grid;
      align-content: center;
      gap: 4px;
      padding: 10px;
      text-align: center;
    }
    .hero-mini-stat strong {
      color: var(--brand);
      font-size: 1.05rem;
      line-height: 1;
    }
    .hero-mini-stat span {
      color: #4a413b;
      font-size: .72rem;
      font-weight: 800;
    }
    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 24px;
    }
    .hero .btn-outline {
      background: #fff;
      border-color: rgba(127,29,45,.16);
      color: var(--brand);
    }
    .hero .btn-outline:hover { background: rgba(127,29,45,.08); color: var(--brand); }
    .hero-category-board {
      min-width: 0;
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      gap: 12px;
    }
    .hero-category-card {
      min-width: 0;
      min-height: 214px;
      border-radius: 18px;
      overflow: hidden;
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      box-shadow: var(--shadow-soft);
      display: flex;
      flex-direction: column;
      transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .hero-category-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow);
      border-color: rgba(127,29,45,.22);
    }
    .hero-category-media {
      display: block;
      width: 100%;
      height: 128px;
      background-color: #fff;
      background-position: center;
      background-repeat: no-repeat;
      background-size: contain;
    }
    .hero-category-card.featured {
      grid-column: span 2;
      grid-row: span 2;
      min-height: 440px;
      position: relative;
      color: #fff;
      background: #211916;
      isolation: isolate;
    }
    .hero-category-card.featured .hero-category-media {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      z-index: -2;
    }
    .hero-category-card.featured::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,.03), rgba(0,0,0,.68));
      z-index: -1;
    }
    .hero-category-body {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 14px;
      flex: 1;
    }
    .hero-category-card.featured .hero-category-body {
      margin-top: auto;
      padding: 22px;
    }
    .hero-category-body h2,
    .hero-category-body h3 {
      margin: 0;
      font-size: 1rem;
      line-height: 1.15;
      font-weight: 800;
    }
    .hero-category-card.featured h2 {
      font-size: clamp(1.8rem, 4vw, 3rem);
    }
    .hero-category-body p {
      margin: 0;
      color: var(--muted);
      font-size: .78rem;
      line-height: 1.45;
    }
    .hero-category-card.featured p {
      max-width: 360px;
      color: rgba(255,255,255,.86);
      font-size: .95rem;
    }
    .hero-category-link {
      margin-top: auto;
      color: var(--brand);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: .8rem;
      font-weight: 800;
    }
    .hero-category-card.featured .hero-category-link {
      color: #f4d795;
    }
    .hero-category-link i { font-size: 1rem; }
    .hero-mobile-logo {
      display: none;
    }

    .search-panel {
      position: relative;
      z-index: 3;
      margin-top: -64px;
    }
    .search-card {
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow);
      padding: 16px;
      display: grid;
      grid-template-columns: minmax(0, 1fr) auto auto;
      gap: 12px;
      align-items: center;
    }
    .search-field {
      min-width: 0;
      height: 54px;
      border: 1px solid var(--line);
      border-radius: var(--radius);
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 16px;
      background: #fff;
    }
    .search-field i { color: var(--brand); }
    .search-field input {
      width: 100%;
      min-width: 0;
      border: 0;
      outline: 0;
      color: var(--ink);
      font-weight: 600;
    }

    .quick-links {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 14px;
    }
    .quick-links a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 13px;
      border-radius: 99px;
      background: rgba(255,255,255,.78);
      border: 1px solid rgba(55,35,25,.08);
      color: #3a312b;
      font-size: .86rem;
      font-weight: 700;
    }
    .quick-links a:hover { background: #fff; color: var(--brand); }

    .category-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 16px;
    }
    .category-card {
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-soft);
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .category-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow);
    }
    .category-card img {
      width: 100%;
      aspect-ratio: 4 / 3;
      object-fit: contain;
      padding: 10px;
      background: #fff;
    }
    .category-card-body { padding: 16px; }
    .category-card h3 {
      margin: 0 0 5px;
      font-size: 1.02rem;
      font-weight: 800;
    }
    .category-card p {
      margin: 0;
      color: var(--muted);
      font-size: .88rem;
      line-height: 1.55;
    }

    .editorial-grid {
      display: grid;
      grid-template-columns: 1.25fr .75fr;
      gap: 18px;
    }
    .feature-tile {
      position: relative;
      min-height: 390px;
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-soft);
      color: #fff;
      display: flex;
      align-items: end;
      isolation: isolate;
    }
    .feature-tile.small { min-height: 186px; }
    .feature-tile::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,.05), rgba(0,0,0,.72));
      z-index: -1;
    }
    .feature-tile img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -2;
      transition: transform .6s ease;
    }
    .feature-tile:hover img { transform: scale(1.04); }
    .feature-tile.fit-contain img {
      object-fit: contain;
      padding: 14px;
      background: #f7f1ea;
    }
    .feature-tile.fit-contain:hover img { transform: none; }
    .feature-tile-content { padding: 22px; }
    .feature-tile h3 {
      margin: 0 0 8px;
      font-size: clamp(1.25rem, 2.4vw, 2.1rem);
      line-height: 1.1;
      font-weight: 800;
    }
    .feature-tile p {
      max-width: 480px;
      color: rgba(255,255,255,.86);
      line-height: 1.6;
      margin: 0 0 14px;
    }
    .feature-side { display: grid; gap: 18px; }

    .benefits {
      background: #fff;
      color: #fff;
    }
    .benefit-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 14px;
    }
    .benefit {
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      padding: 18px;
      background: #fff;
      color: var(--ink);
      box-shadow: var(--shadow-soft);
    }
    .benefit i {
      color: var(--brand);
      font-size: 1.4rem;
    }
    .benefit h3 {
      margin: 12px 0 6px;
      font-size: 1rem;
      font-weight: 800;
    }
    .benefit p {
      margin: 0;
      color: var(--muted);
      font-size: .88rem;
      line-height: 1.58;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }
    .product-carousel-wrap {
      position: relative;
    }
    .product-carousel {
      display: flex;
      gap: 18px;
      overflow-x: auto;
      overflow-y: hidden;
      scroll-snap-type: x mandatory;
      scroll-behavior: smooth;
      padding: 2px 2px 18px;
      scrollbar-width: thin;
      scrollbar-color: rgba(127,29,45,.35) transparent;
    }
    .product-carousel::-webkit-scrollbar { height: 8px; }
    .product-carousel::-webkit-scrollbar-track { background: transparent; }
    .product-carousel::-webkit-scrollbar-thumb {
      background: rgba(127,29,45,.28);
      border-radius: 999px;
    }
    .carousel-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: flex-end;
    }
    .carousel-btn {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      border: 1px solid rgba(127,29,45,.18);
      background: #fff;
      color: var(--brand);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow-soft);
      transition: transform .18s ease, background .18s ease, color .18s ease;
    }
    .carousel-btn:hover {
      transform: translateY(-1px);
      background: var(--brand);
      color: #fff;
    }
    .product-card {
      min-width: 0;
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-soft);
      display: flex;
      flex-direction: column;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-carousel .product-card {
      flex: 0 0 calc((100% - 36px) / 3);
      scroll-snap-align: start;
    }
    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow);
    }
    .product-media {
      position: relative;
      background: var(--paper-soft);
      display: block;
    }
    .product-media img {
      width: 100%;
      height: 280px;
      object-fit: contain;
      padding: 10px;
      background: #fff;
    }
    .product-badge,
    .stock-badge {
      position: absolute;
      top: 12px;
      z-index: 2;
      border-radius: 99px;
      padding: 6px 10px;
      font-size: .72rem;
      font-weight: 800;
      box-shadow: 0 10px 24px rgba(0,0,0,.16);
    }
    .product-badge { left: 12px; background: #f4d795; color: #211916; }
    .stock-badge { right: 12px; background: rgba(255,255,255,.92); color: var(--green); }
    .stock-badge.out { color: var(--brand); }
    .product-body {
      padding: 17px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .product-meta {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      color: var(--brand);
      font-size: .72rem;
      font-weight: 800;
      letter-spacing: .09em;
      text-transform: uppercase;
      margin-bottom: 9px;
    }
    .product-meta span:last-child {
      color: #95897f;
      letter-spacing: 0;
      text-transform: none;
      white-space: nowrap;
    }
    .product-body h3 {
      margin: 0 0 8px;
      font-size: 1.08rem;
      line-height: 1.32;
      font-weight: 800;
    }
    .product-desc {
      margin: 0 0 16px;
      color: var(--muted);
      line-height: 1.55;
      font-size: .9rem;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .product-bottom { margin-top: auto; }
    .price-label { color: #8a7f77; font-size: .76rem; font-weight: 700; }
    .price {
      display: block;
      color: var(--brand);
      font-size: 1.28rem;
      font-weight: 800;
      margin-top: 2px;
    }
    .product-actions {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-top: 14px;
    }
    .product-actions .btn { padding-left: 10px; padding-right: 10px; }

    .showroom {
      display: grid;
      grid-template-columns: .95fr 1.05fr;
      gap: 28px;
      align-items: center;
    }
    .showroom-image {
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow);
    }
    .showroom-image img {
      width: 100%;
      aspect-ratio: 4 / 3;
      object-fit: cover;
    }
    .info-list { display: grid; gap: 12px; margin-top: 20px; }
    .info-row {
      display: grid;
      grid-template-columns: 46px 1fr;
      gap: 14px;
      align-items: start;
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      padding: 16px;
      box-shadow: 0 8px 20px rgba(55,35,25,.05);
    }
    .info-row i {
      width: 46px;
      height: 46px;
      border-radius: var(--radius);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(127,29,45,.08);
      color: var(--brand);
      font-size: 1.2rem;
    }
    .info-row h3 {
      margin: 0 0 5px;
      font-size: 1rem;
      font-weight: 800;
    }
    .info-row p {
      margin: 0;
      color: var(--muted);
      line-height: 1.55;
      font-size: .9rem;
    }

    .contact-strip {
      background:
        linear-gradient(90deg, rgba(33,25,22,.92), rgba(127,29,45,.88)),
        url("{{ asset('optimized/home/gold2.jpg') }}") center / cover no-repeat;
      color: #fff;
      border-radius: var(--radius-lg);
      padding: 34px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 22px;
      box-shadow: var(--shadow);
    }
    .offers-grid {
      display: grid;
      grid-template-columns: .85fr 1.15fr;
      gap: 18px;
      align-items: stretch;
    }
    .day-offer {
      border-radius: var(--radius-lg);
      background: var(--dark);
      color: #fff;
      padding: 24px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 320px;
      box-shadow: var(--shadow);
    }
    .day-offer span {
      color: #f4d795;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .12em;
      font-size: .76rem;
    }
    .day-offer h3 {
      margin: 12px 0 10px;
      font-size: clamp(1.5rem, 3vw, 2.4rem);
      line-height: 1.08;
    }
    .mini-offer-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 14px;
    }
    .contact-strip h2 {
      margin: 0;
      font-size: clamp(1.45rem, 3vw, 2.35rem);
      line-height: 1.12;
      font-weight: 800;
    }
    .contact-strip p {
      margin: 10px 0 0;
      color: rgba(255,255,255,.82);
      line-height: 1.65;
      max-width: 640px;
    }

    .seo-box {
      background: #fff;
      border: 1px solid rgba(55,35,25,.09);
      border-radius: var(--radius-lg);
      padding: 26px;
      box-shadow: var(--shadow-soft);
    }
    .seo-box h2 {
      margin: 0 0 10px;
      font-size: 1.4rem;
      font-weight: 800;
    }
    .seo-box p {
      color: var(--muted);
      line-height: 1.75;
      margin: 0;
    }

    .site-footer {
      background: #fff;
      border-top: 1px solid rgba(55,35,25,.09);
      padding: 46px 0 92px;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.25fr repeat(3, 1fr);
      gap: 28px;
    }
    .footer-brand img { width: 210px; max-width: 100%; }
    .footer-brand p {
      color: var(--muted);
      line-height: 1.65;
      margin: 14px 0 0;
      max-width: 320px;
    }
    .site-footer h3 {
      margin: 0 0 14px;
      font-size: .92rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .06em;
    }
    .site-footer a {
      display: block;
      color: var(--muted);
      margin: 0 0 9px;
      font-size: .92rem;
    }
    .site-footer a:hover { color: var(--brand); }
    .copyright {
      margin-top: 28px;
      padding-top: 18px;
      border-top: 1px solid rgba(55,35,25,.09);
      color: var(--muted);
      font-size: .84rem;
    }

    .floating-wa {
      position: fixed;
      right: 18px;
      bottom: 22px;
      z-index: 90;
      width: 54px;
      height: 54px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: var(--green);
      color: #fff;
      box-shadow: 0 16px 32px rgba(25,135,84,.28);
    }
    .floating-wa i { font-size: 1.45rem; }
    @media (max-width: 1080px) {
      .nav-links a { padding-inline: 9px; }
      .brand img { width: 230px; }
      .hero-grid {
        grid-template-columns: 1fr;
        min-height: 0;
        padding-top: 30px;
      }
      .hero-intro {
        align-self: auto;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        align-items: end;
      }
      .hero-intro img { margin-bottom: 16px; }
      .hero-intro p { max-width: 620px; }
      .hero-actions { justify-content: flex-end; margin-top: 0; }
      .hero-category-board { grid-template-columns: repeat(4, minmax(0, 1fr)); }
      .benefit-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 900px) {
      .desktop-only { display: none !important; }
      .site-header { padding: 6px 0; }
      .nav {
        min-height: 66px;
        padding: 0 10px;
        border-radius: 16px;
      }
      .brand img { width: 190px; height: 50px; }
      .brand span { font-size: 1rem; }
      .menu-toggle { display: inline-flex; }
      .nav-links {
        position: fixed;
        left: 8px;
        right: 8px;
        top: 78px;
        display: none;
        flex: none;
        flex-direction: column;
        align-items: stretch;
        gap: 3px;
        max-height: calc(100vh - 92px);
        overflow-y: auto;
        overscroll-behavior: contain;
        background: #fff;
        border: 1px solid rgba(55,35,25,.10);
        border-radius: 16px;
        padding: 8px;
        box-shadow: 0 22px 60px rgba(17,24,39,.22);
        z-index: 1200;
      }
      .nav-links.open { display: flex; }
      .nav-links a,
      .nav-dropdown summary {
        color: #201a17;
        padding: 13px 12px;
      }
      .account-mobile-link,
      .mobile-menu-lang { display: flex; }
      .account-mobile-link {
        align-items: center;
        gap: 9px;
        border-top: 1px solid rgba(55,35,25,.09);
        margin-top: 4px;
      }
      .mobile-menu-lang {
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
      }
      .mobile-menu-lang .lang-switch {
        border-color: rgba(17,24,39,.12);
        background: #f8f3ee;
      }
      .mobile-menu-lang .lang-switch button {
        color: #4b413a;
      }
      .mobile-menu-lang .lang-switch button.active {
        background: var(--brand);
        color: #fff;
      }
      .nav-links a:hover,
      .nav-dropdown:hover summary,
      .nav-dropdown[open] summary {
        background: rgba(127,29,45,.08);
        color: var(--brand);
      }
      .dropdown-menu {
        position: static;
        transform: none;
        min-width: 0;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        box-shadow: none;
        border: 1px solid rgba(127,29,45,.10);
        padding: 8px;
        margin: 3px 0 5px;
        background: #fbf7f2;
        max-height: 218px;
        overflow-y: auto;
      }
      .dropdown-menu a {
        padding: 10px 9px;
        font-size: .82rem;
        white-space: normal;
        line-height: 1.25;
      }
      .nav-dropdown:not([open]) .dropdown-menu { display: none; }
      .cart-dropdown { display: none; }
      .login-btn { display: none; }
      .nav-actions > .lang-switch { display: none; }
      .mobile-cart { display: inline-flex; }
      .hero { min-height: 0; }
      .hero::before {
        background:
          linear-gradient(180deg, rgba(255,255,255,.80), rgba(255,255,255,.22)),
          url("{{ asset('optimized/home/hero.jpg') }}") center / cover no-repeat;
      }
      .hero-grid {
        min-height: 0;
        padding: 92px 0 78px;
        gap: 16px;
      }
      .hero-intro {
        display: block;
        padding: 20px;
        border-radius: 18px;
      }
      .hero-intro img { width: 210px; margin-bottom: 18px; }
      .hero-intro h1 { font-size: clamp(2rem, 8vw, 3.2rem); }
      .hero-actions { justify-content: flex-start; margin-top: 20px; }
      .hero-category-board { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; }
      .hero-category-card.featured {
        grid-column: span 3;
        grid-row: span 1;
        min-height: 280px;
      }
      .hero-category-card { min-height: 190px; border-radius: 14px; }
      .hero-category-media { height: 112px; }
      .search-panel { margin-top: -44px; }
      .search-card { grid-template-columns: 1fr; }
      .search-card .btn { width: 100%; }
      .category-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
      .editorial-grid,
      .offers-grid,
      .showroom,
      .footer-grid { grid-template-columns: 1fr; }
      .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .product-carousel .product-card { flex-basis: min(520px, 78vw); }
      .contact-strip { align-items: stretch; flex-direction: column; }
      .floating-wa { bottom: 18px; }
    }

    @media (max-width: 560px) {
      .container { width: calc(100% - 24px); }
      .section { padding: 42px 0; }
      .section-head { display: block; margin-bottom: 18px; }
      .section-head .btn { width: 100%; margin-top: 14px; }
      .nav-container {
        width: min(calc(100% - 12px), 378px);
        margin-left: 6px;
        margin-right: auto;
      }
      .nav { overflow: hidden; }
      .brand img { width: 148px; height: 46px; }
      .nav-actions { gap: 6px; }
      .icon-btn { width: 40px; height: 40px; }
      .cart-link {
        width: 42px;
        padding: 0;
        border: 1px solid rgba(255,255,255,.22);
        background: rgba(255,255,255,.05);
      }
      .cart-link span:not(.cart-badge),
      .cart-link .cart-more { display: none; }
      .cart-link .cart-badge { position: absolute; top: -7px; right: -7px; }
      .hero-grid { padding: 82px 0 68px; }
      .hero-intro {
        width: min(100%, 360px);
        margin: 0;
        padding: 16px;
      }
      .hero-intro img { width: 176px; margin-bottom: 14px; }
      .hero-intro h1 {
        max-width: 9ch;
        font-size: 1.9rem;
        line-height: 1.02;
        overflow-wrap: anywhere;
      }
      .hero-intro p { font-size: .92rem; line-height: 1.55; }
      .hero-mini-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 6px; margin-top: 16px; }
      .hero-mini-stat { min-height: 58px; padding: 7px; }
      .hero-mini-stat:last-child { grid-column: span 2; }
      .hero-mini-stat strong { font-size: .9rem; }
      .hero-mini-stat span { font-size: .62rem; }
      .hero-actions .btn { width: 100%; }
      .hero-category-board {
        width: min(100%, 360px);
        margin: 0;
        grid-template-columns: 1fr;
        gap: 9px;
      }
      .hero-category-card.featured {
        grid-column: span 1;
        min-height: 230px;
      }
      .hero-category-card {
        min-height: 112px;
        display: grid;
        grid-template-columns: 118px minmax(0, 1fr);
      }
      .hero-category-card.featured {
        display: flex;
      }
      .hero-category-media {
        width: 100%;
        height: 100%;
        min-height: 112px;
        background-color: #f8f1eb;
        background-size: cover;
      }
      .hero-category-card.featured .hero-category-media {
        min-height: 0;
        background-color: transparent;
      }
      .hero-category-body { padding: 10px; gap: 4px; }
      .hero-category-card.featured .hero-category-body { padding: 16px; }
      .hero-category-card.featured h2 { font-size: 1.65rem; }
      .hero-category-body h3 { font-size: .88rem; }
      .hero-category-body p { display: none; }
      .quick-links { overflow-x: auto; flex-wrap: nowrap; padding-bottom: 4px; }
      .quick-links a { white-space: nowrap; }
      .category-card-body { padding: 12px; }
      .category-card h3 { font-size: .95rem; }
      .category-card p { font-size: .8rem; }
      .feature-tile { min-height: 330px; }
      .feature-tile.small { min-height: 210px; }
      .benefit-grid,
      .mini-offer-grid,
      .product-grid { grid-template-columns: 1fr; }
      .recommended-section .section-head { display: grid; gap: 14px; }
      .carousel-actions { justify-content: flex-start; }
      .carousel-actions .btn { width: auto; margin-top: 0; }
      .product-carousel {
        gap: 12px;
        padding-bottom: 14px;
        margin-right: -12px;
        padding-right: 12px;
      }
      .product-carousel .product-card { flex-basis: min(318px, 86vw); }
      .product-media img { height: 240px; object-fit: contain; padding: 8px; }
      .product-actions { grid-template-columns: 1fr; }
      .info-row { grid-template-columns: 40px 1fr; padding: 14px; }
      .info-row i { width: 40px; height: 40px; }
      .contact-strip { padding: 22px; }
      .site-footer { padding-bottom: 100px; }
      .floating-wa { width: 50px; height: 50px; right: 14px; }
    }

    /* 2026 homepage refresh: calm, editorial and mobile-first */
    .hero { padding: 24px 0 54px; background: #f7f2eb; }
    .hero::before, .hero::after { display: none; }
    .hero-grid { display: grid; grid-template-columns: .82fr 1.18fr; gap: 22px; padding: 0; min-height: 680px; }
    .hero-intro { position: relative; z-index: 2; padding: clamp(34px,5vw,76px); border: 1px solid #e6dacd; border-radius: 28px; background: #fffdf9; box-shadow: 0 24px 70px rgba(46,31,23,.09); justify-content: center; }
    .hero-intro img { width: 220px; margin: 0 0 32px; filter: none; }
    .hero-intro h1 { max-width: 590px; margin: 0; color: #241b17; font-family: Georgia, 'Times New Roman', serif; font-size: clamp(3rem,5.8vw,5.8rem); font-weight: 500; line-height: .96; letter-spacing: -.055em; }
    .hero-intro p { max-width: 530px; margin: 26px 0 0; color: #71645c; font-size: 1.03rem; line-height: 1.75; }
    .hero-mini-stats { margin-top: 34px; }
    .hero-mini-stat { border-color: #e9ded3; background: #f8f3ed; }
    .hero-actions { margin-top: 34px; }
    .hero-gallery { display: grid; grid-template-columns: 1fr .52fr; grid-template-rows: 1fr 1fr; gap: 14px; min-width: 0; }
    .hero-photo { position: relative; overflow: hidden; border-radius: 28px; background: #d8cec3; box-shadow: 0 24px 70px rgba(46,31,23,.14); }
    .hero-photo:first-child { grid-row: 1 / 3; }
    .hero-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s ease; }
    .hero-photo:hover img { transform: scale(1.025); }
    .hero-photo:first-child img { object-position: 48% center; }
    .hero-photo:nth-child(2) img { object-position: 22% center; }
    .hero-photo-note { position: absolute; left: 18px; right: 18px; bottom: 18px; padding: 16px 18px; border: 1px solid rgba(255,255,255,.35); border-radius: 16px; color: #fff; background: rgba(27,20,16,.62); backdrop-filter: blur(12px); }
    .hero-photo-note strong { display: block; font-family: Georgia,serif; font-size: 1.3rem; }
    .hero-photo-note span { display: block; margin-top: 3px; font-size: .78rem; opacity: .84; }
    .hero-accent { display: grid; place-items: center; padding: 25px; border-radius: 28px; color: #f9f2e9; background: #31251f; text-align: center; }
    .hero-accent i { color: #d8b471; font-size: 2rem; }
    .hero-accent strong { display: block; margin-top: 12px; font-family: Georgia,serif; font-size: clamp(1.35rem,2vw,2rem); font-weight: 500; line-height: 1.15; }
    .categories-home { padding: 68px 0 42px; background: #fffdf9; }
    .categories-home .hero-category-board { grid-template-columns: repeat(5,minmax(0,1fr)); }
    .categories-home .hero-category-card, .categories-home .hero-category-card.featured { grid-column: auto; grid-row: auto; min-height: 280px; border-radius: 20px; }
    .categories-home .hero-category-card.featured .hero-category-media, .categories-home .hero-category-media { height: 170px; }
    .categories-home .hero-category-card.featured::after { display:none; }
    .categories-home .hero-category-card.featured .hero-category-body { position: static; color: inherit; background: #fff; padding: 15px; }
    .categories-home .hero-category-card.featured h2 { font: 700 1rem/1.2 Poppins,sans-serif; }
    .categories-home .hero-category-card.featured p { color: var(--muted); }
    .categories-home .hero-category-card.featured .hero-category-link { color: var(--brand); }
    .chatbot { position: fixed; right: 20px; bottom: 20px; z-index: 120; }
    .chat-toggle { width: 62px; height: 62px; border: 0; border-radius: 50%; color: #fff; background: var(--brand); box-shadow: 0 14px 35px rgba(127,29,45,.32); cursor: pointer; font-size: 1.5rem; }
    .chat-toggle::after { content:''; position:absolute; width:12px; height:12px; right:2px; top:2px; border:3px solid #fff; border-radius:50%; background:#36b66a; }
    .chat-panel { position: absolute; right: 0; bottom: 76px; width: min(370px,calc(100vw - 28px)); overflow: hidden; border: 1px solid #e5d8cc; border-radius: 22px; background: #fff; box-shadow: 0 24px 70px rgba(36,27,23,.22); transform-origin: bottom right; }
    .chat-panel[hidden] { display:none; }
    .chat-head { display:flex; align-items:center; gap:12px; padding:18px; color:#fff; background:#31251f; }
    .chat-head i { display:grid; place-items:center; width:42px; height:42px; border-radius:50%; background:#7f1d2d; }
    .chat-head strong,.chat-head small { display:block; }
    .chat-head small { opacity:.72; }
    .chat-close { margin-left:auto; border:0; color:#fff; background:transparent; cursor:pointer; font-size:1.1rem; }
    .chat-body { max-height: 420px; overflow:auto; padding:18px; background:#faf7f3; }
    .chat-message { width:fit-content; max-width:88%; margin:0 0 12px; padding:12px 14px; border-radius:15px 15px 15px 4px; background:#fff; box-shadow:0 4px 14px rgba(46,31,23,.07); font-size:.87rem; line-height:1.55; }
    .chat-message.user { margin-left:auto; border-radius:15px 15px 4px 15px; color:#fff; background:var(--brand); }
    .chat-options { display:grid; gap:8px; margin-top:14px; }
    .chat-option { padding:11px 13px; border:1px solid #ddcfc2; border-radius:12px; color:#392b24; background:#fff; text-align:left; cursor:pointer; font-size:.82rem; font-weight:600; }
    .chat-option:hover { border-color:var(--brand); color:var(--brand); }
    .chat-wa { display:flex; justify-content:center; gap:8px; margin:14px 18px 18px; padding:12px; border-radius:12px; color:#fff; background:#198754; font-size:.85rem; font-weight:700; }
    .floating-wa { display:none; }
    @media (max-width: 1050px) {
      .hero-grid { grid-template-columns:1fr; min-height:0; }
      .hero-gallery { height:560px; }
      .categories-home .hero-category-board { grid-template-columns:repeat(3,minmax(0,1fr)); }
    }
    @media (max-width: 620px) {
      .hero { padding: 10px 0 34px; }
      .hero-grid { padding:0; gap:12px; }
      .hero-intro { padding:34px 22px; border-radius:20px; }
      .hero-intro img { width:165px; margin-bottom:24px; }
      .hero-intro h1 { font-size:clamp(2.65rem,14vw,4rem); }
      .hero-intro p { margin-top:18px; font-size:.92rem; }
      .hero-mini-stats { margin-top:24px; grid-template-columns:repeat(3,1fr); }
      .hero-mini-stat:last-child { grid-column:auto; }
      .hero-actions { display:grid; margin-top:24px; }
      .hero-gallery { height:430px; grid-template-columns:1fr .48fr; gap:8px; }
      .hero-photo,.hero-accent { border-radius:18px; }
      .hero-photo-note { left:10px; right:10px; bottom:10px; padding:11px; }
      .hero-photo-note strong { font-size:1rem; }
      .hero-photo-note span { display:none; }
      .hero-accent { padding:12px; }
      .hero-accent strong { font-size:1rem; }
      .categories-home { padding:46px 0 28px; }
      .categories-home .hero-category-board { grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
      .categories-home .hero-category-card,.categories-home .hero-category-card.featured { min-height:205px; }
      .categories-home .hero-category-card.featured .hero-category-media,.categories-home .hero-category-media { height:122px; }
      .categories-home .hero-category-body p { display:none; }
      .chatbot { right:14px; bottom:88px; }
      .chat-toggle { width:54px; height:54px; }
    }

    /* Full-bleed hero inspired by premium interior brands */
    .site-header { position:absolute; inset:0 0 auto; padding:28px 0; background:transparent; backdrop-filter:none; }
    .nav { min-height:72px; padding:0 24px; border:1px solid rgba(255,255,255,.28); border-radius:36px; background:rgba(28,21,18,.55); box-shadow:0 14px 38px rgba(25,18,14,.20); backdrop-filter:blur(18px) saturate(115%); -webkit-backdrop-filter:blur(18px) saturate(115%); }
    .brand img { width:205px; height:56px; }
    .nav-links a,.nav-dropdown summary { color:#fff; font-size:.91rem; text-shadow:0 1px 10px rgba(0,0,0,.32); }
    .nav-links a:hover,.nav-dropdown:hover summary,.nav-dropdown[open] summary { color:#fff; background:rgba(255,255,255,.14); }
    .nav-actions .icon-btn,.nav-actions .login-btn { color:#fff; border-color:rgba(255,255,255,.35); background:rgba(255,255,255,.10); }
    .nav-actions .login-btn:hover,.nav-actions .icon-btn:hover { background:rgba(255,255,255,.20); }
    .nav-actions .lang-switch { border-color:rgba(255,255,255,.28); background:rgba(255,255,255,.09); }
    .nav-actions .lang-switch button { color:rgba(255,255,255,.82); }
    .nav-actions .lang-switch button.active { color:var(--brand); background:#fff; }
    .nav-actions .cart-more { color:rgba(255,255,255,.84); }
    .hero { min-height:100svh; padding:18px; background:#30251f; }
    .hero-stage { position:relative; display:grid; place-items:center; min-height:calc(100svh - 36px); overflow:hidden; border-radius:0 0 48px 48px; background:url('{{ asset('images/home/hero-luxury-curtains.jpg') }}') center center/cover no-repeat; }
    .hero-stage::before { content:''; position:absolute; inset:0; background:linear-gradient(180deg,rgba(22,16,13,.24),rgba(22,16,13,.42) 50%,rgba(22,16,13,.58)); }
    .hero-content { position:relative; z-index:2; width:min(1050px,calc(100% - 36px)); margin-top:96px; color:#fff; text-align:center; }
    .hero-content h1 { margin:0 auto; max-width:1000px; font-family:Georgia,'Times New Roman',serif; font-size:clamp(3.4rem,7.4vw,7.6rem); font-weight:400; line-height:.92; letter-spacing:-.055em; text-wrap:balance; text-shadow:0 5px 30px rgba(0,0,0,.28); }
    .hero-content .hero-cta { display:inline-flex; align-items:center; justify-content:center; gap:10px; min-width:230px; margin-top:42px; padding:16px 26px; border:1px solid rgba(255,255,255,.85); border-radius:999px; color:#fff; background:rgba(34,26,22,.24); backdrop-filter:blur(10px); font-weight:600; transition:.25s ease; }
    .hero-content .hero-cta:hover { color:#241b17; background:#fff; transform:translateY(-2px); }
    .hero-scroll { position:absolute; z-index:2; bottom:24px; color:rgba(255,255,255,.8); font-size:.75rem; letter-spacing:.12em; text-transform:uppercase; }
    @media (max-width:900px) {
      .site-header { padding:14px 0; }
      .nav { min-height:64px; padding:0 14px; border-radius:24px; }
      .brand img { width:150px; height:48px; }
      .nav-links.open a,.nav-links.open .nav-dropdown summary { color:#2b211c; text-shadow:none; }
      .nav-links.open a:hover,.nav-links.open .nav-dropdown:hover summary,.nav-links.open .nav-dropdown[open] summary { color:var(--brand); background:rgba(127,29,45,.08); }
      .nav-links.open .dropdown-menu a { color:#2b211c; }
      .menu-toggle,.mobile-cart { color:#fff; border-color:rgba(255,255,255,.32); background:rgba(255,255,255,.10); }
      .hero { padding:8px; }
      .hero-stage { min-height:calc(100svh - 16px); border-radius:0 0 28px 28px; background-position:58% center; }
      .hero-content { margin-top:68px; }
      .hero-content h1 { max-width:690px; font-size:clamp(3rem,12vw,5.8rem); }
    }
    @media (max-width:560px) {
      html,
      body {
        margin:0;
        padding:0;
        background-color:#30251f;
        background-image:url('{{ asset('images/home/hero-luxury-curtains.jpg') }}');
        background-position:57% top;
        background-size:100vw 100dvh;
        background-repeat:no-repeat;
      }
      main { margin:0; padding:0; }
      .site-header { padding-top:max(12px,calc(env(safe-area-inset-top) + 6px)); }
      .hero {
        position:relative;
        z-index:1;
        width:100%;
        min-height:calc(100svh + env(safe-area-inset-top));
        min-height:calc(100dvh + env(safe-area-inset-top));
        margin:0;
        padding:0;
        overflow:visible;
        background:transparent;
      }
      .hero-stage {
        width:100%;
        min-height:calc(100svh + env(safe-area-inset-top));
        min-height:calc(100dvh + env(safe-area-inset-top));
        margin-top:calc(-1 * env(safe-area-inset-top));
        padding-top:calc(env(safe-area-inset-top) * 2);
        border-radius:0 0 28px 28px;
        background-position:57% top;
        background-size:100vw 100dvh;
        background-repeat:no-repeat;
      }
      .hero-stage::before { background:linear-gradient(180deg,rgba(20,14,11,.3),rgba(20,14,11,.46) 52%,rgba(20,14,11,.62)); }
      .hero-content { width:calc(100% - 28px); margin-top:64px; }
      .hero-content h1 { font-size:clamp(3.15rem,16vw,4.7rem); line-height:.94; }
      .hero-content .hero-cta { min-width:210px; margin-top:32px; }
      .hero-scroll { display:none; }
    }

    /* Final mobile corrections: clickable menu and balanced category cards */
    @media (max-width:900px) {
      .site-header { z-index:1000; }
      .nav { position:relative; overflow:visible; }
      .nav-links {
        position:absolute;
        top:calc(100% + 10px);
        left:0;
        right:0;
        width:100%;
        max-height:calc(100svh - 100px);
        z-index:2000;
      }
      .nav-links.open { display:flex; pointer-events:auto; }
      .menu-toggle { position:relative; z-index:2100; pointer-events:auto; }
      .categories-home .hero-category-board {
        width:100%;
        max-width:none;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
      }
      .categories-home .hero-category-card,
      .categories-home .hero-category-card.featured {
        display:flex;
        flex-direction:column;
        min-width:0;
        min-height:0;
        height:auto;
        overflow:hidden;
      }
      .categories-home .hero-category-card.featured {
        grid-column:auto;
        grid-row:auto;
      }
      .categories-home .hero-category-media,
      .categories-home .hero-category-card.featured .hero-category-media {
        flex:none;
        width:100%;
        height:145px;
        min-height:145px;
        background-size:cover;
        background-position:center;
      }
      .categories-home .hero-category-body,
      .categories-home .hero-category-card.featured .hero-category-body {
        position:static;
        display:flex;
        flex:1;
        min-width:0;
        min-height:88px;
        padding:13px;
        color:var(--ink);
        background:#fff;
      }
      .categories-home .hero-category-body h2,
      .categories-home .hero-category-body h3,
      .categories-home .hero-category-card.featured h2 {
        display:block;
        max-width:100%;
        margin:0;
        color:var(--ink);
        font:700 .88rem/1.25 Poppins,sans-serif;
        overflow-wrap:anywhere;
      }
      .categories-home .hero-category-link,
      .categories-home .hero-category-card.featured .hero-category-link {
        margin-top:auto;
        color:var(--brand);
        font-size:.78rem;
      }
    }
    @media (max-width:560px) {
      .nav-container { width:calc(100% - 20px); margin:0 auto; }
      .nav { overflow:visible; }
      .brand img { width:min(148px,42vw); }
      .categories-home .hero-category-media,
      .categories-home .hero-category-card.featured .hero-category-media { height:126px; min-height:126px; }
      .categories-home .hero-category-body,
      .categories-home .hero-category-card.featured .hero-category-body { min-height:84px; padding:11px; }
    }

    /* Search: no overlap, consistent spacing and compact mobile actions */
    .search-panel {
      position:relative;
      z-index:3;
      margin-top:0;
      padding:48px 0 72px;
      background:var(--bg);
    }
    .categories-home .hero-category-card.featured .hero-category-media {
      position:static;
      inset:auto;
      z-index:auto;
    }
    .search-card {
      grid-template-columns:minmax(0,1fr) auto;
      gap:14px;
      padding:14px;
    }
    .search-actions {
      display:grid;
      grid-auto-flow:column;
      gap:10px;
    }
    .search-actions .btn { min-width:132px; white-space:nowrap; }
    .btn-assistant { color:#fff; border-color:#31251f; background:#31251f; }
    .btn-assistant:hover { color:#fff; background:#4a3930; }
    .quick-links { margin-top:18px; }

    /* Writable assistant with a viewport-safe mobile layout */
    .sr-only {
      position:absolute;
      width:1px;
      height:1px;
      padding:0;
      margin:-1px;
      overflow:hidden;
      clip:rect(0,0,0,0);
      white-space:nowrap;
      border:0;
    }
    .chatbot {
      position:fixed;
      right:max(18px,env(safe-area-inset-right));
      bottom:max(18px,env(safe-area-inset-bottom));
      z-index:3000;
    }
    .chat-toggle {
      position:relative;
      display:grid;
      place-items:center;
      width:60px;
      height:60px;
      padding:0;
      border:1px solid rgba(255,255,255,.22);
      border-radius:50%;
      color:#fff;
      background:var(--brand);
      box-shadow:0 16px 40px rgba(127,29,45,.34);
      cursor:pointer;
      font-size:1.35rem;
    }
    .chat-toggle::after { width:11px; height:11px; right:1px; top:1px; }
    .chat-backdrop { display:none; }
    .chat-panel {
      position:absolute;
      right:0;
      bottom:76px;
      display:flex;
      flex-direction:column;
      width:min(400px,calc(100vw - 32px));
      height:min(620px,calc(100dvh - 112px));
      min-height:420px;
      overflow:hidden;
      border:1px solid #dfd2c6;
      border-radius:24px;
      background:#fff;
      box-shadow:0 26px 80px rgba(35,25,20,.28);
      transform-origin:bottom right;
    }
    .chat-panel[hidden],.chat-backdrop[hidden] { display:none !important; }
    .chat-head {
      flex:none;
      display:flex;
      align-items:center;
      gap:11px;
      min-height:76px;
      padding:14px 15px;
      color:#fff;
      background:linear-gradient(135deg,#31251f,#201915);
    }
    .chat-avatar {
      flex:none;
      display:grid;
      place-items:center;
      width:44px;
      height:44px;
      border-radius:50%;
      color:#fff;
      background:var(--brand);
    }
    .chat-title-wrap { min-width:0; }
    .chat-title-wrap strong,.chat-title-wrap small { display:block; }
    .chat-title-wrap strong { font-size:.95rem; }
    .chat-title-wrap small { margin-top:2px; color:rgba(255,255,255,.72); font-size:.72rem; }
    .chat-status-dot { display:inline-block; width:7px; height:7px; margin-right:4px; border-radius:50%; background:#42cf79; }
    .chat-close {
      flex:none;
      display:grid;
      place-items:center;
      width:38px;
      height:38px;
      margin-left:auto;
      padding:0;
      border:0;
      border-radius:50%;
      color:#fff;
      background:rgba(255,255,255,.08);
      cursor:pointer;
    }
    .chat-close:hover { background:rgba(255,255,255,.16); }
    .chat-body {
      flex:1;
      min-height:0;
      max-height:none;
      overflow-y:auto;
      padding:18px;
      background:#f8f4ef;
      overscroll-behavior:contain;
      scrollbar-width:thin;
    }
    .chat-message {
      width:fit-content;
      max-width:88%;
      margin:0 0 11px;
      padding:11px 13px;
      border:1px solid rgba(55,35,25,.06);
      border-radius:16px 16px 16px 5px;
      color:#392f29;
      background:#fff;
      box-shadow:0 5px 16px rgba(46,31,23,.06);
      font-size:.86rem;
      line-height:1.55;
      white-space:pre-wrap;
      overflow-wrap:anywhere;
    }
    .chat-message.user {
      margin-left:auto;
      border-color:transparent;
      border-radius:16px 16px 5px 16px;
      color:#fff;
      background:var(--brand);
    }
    .chat-message.is-loading { display:flex; align-items:center; gap:5px; color:var(--muted); }
    .chat-message.is-loading span { width:6px; height:6px; border-radius:50%; background:#9b8e85; animation:chatPulse 1s infinite ease-in-out; }
    .chat-message.is-loading span:nth-child(2) { animation-delay:.14s; }
    .chat-message.is-loading span:nth-child(3) { animation-delay:.28s; }
    @keyframes chatPulse { 0%,70%,100%{opacity:.35;transform:translateY(0)} 35%{opacity:1;transform:translateY(-3px)} }
    .chat-suggestions { display:flex; flex-wrap:wrap; gap:7px; margin:5px 0 2px; }
    .chat-option,.chat-action-link {
      display:inline-flex;
      align-items:center;
      width:auto;
      padding:9px 11px;
      border:1px solid #d9c8ba;
      border-radius:999px;
      color:#4a3930;
      background:#fff;
      text-align:left;
      cursor:pointer;
      font-size:.76rem;
      font-weight:700;
    }
    .chat-option:hover,.chat-action-link:hover { border-color:var(--brand); color:var(--brand); }
    .chat-action-link { margin:0 0 12px; text-decoration:none; }
    .chat-product-grid { display:grid; grid-template-columns:1fr; gap:8px; margin:0 0 14px; }
    .chat-product-card { display:flex; min-width:0; overflow:hidden; border:1px solid #eadbd2; border-radius:14px; background:#fff; color:var(--ink); text-decoration:none; box-shadow:0 7px 18px rgba(39,28,23,.07); transition:transform .16s ease,border-color .16s ease; }
    .chat-product-card:hover { transform:translateY(-1px); border-color:#cdaea0; color:var(--ink); }
    .chat-product-card img { width:76px; height:84px; flex:0 0 76px; object-fit:cover; background:#f2eeeb; }
    .chat-product-details { min-width:0; padding:9px 10px; display:flex; flex-direction:column; justify-content:center; gap:3px; }
    .chat-product-details strong { overflow:hidden; font-size:.78rem; line-height:1.2; text-overflow:ellipsis; white-space:nowrap; }
    .chat-product-price { color:var(--brand); font-size:.72rem; font-weight:800; }
    .chat-product-meta { overflow:hidden; color:#75665e; font-size:.64rem; line-height:1.25; text-overflow:ellipsis; white-space:nowrap; }
    .chat-product-stock { font-size:.64rem; font-weight:700; }
    .chat-product-stock.in_stock { color:#15803d; }
    .chat-product-stock.out_of_stock { color:#b91c1c; }
    .chat-product-stock.confirm { color:#8a5a16; }
    .chat-composer {
      flex:none;
      display:grid;
      grid-template-columns:minmax(0,1fr) 44px;
      align-items:end;
      gap:9px;
      padding:11px 12px;
      border-top:1px solid #eadfd5;
      background:#fff;
    }
    .chat-composer textarea {
      width:100%;
      min-height:44px;
      max-height:104px;
      resize:none;
      overflow-y:auto;
      padding:11px 13px;
      border:1px solid #ddd0c5;
      border-radius:14px;
      outline:0;
      color:var(--ink);
      background:#fbf8f5;
      font:500 .86rem/1.45 Poppins,sans-serif;
    }
    .chat-composer textarea:focus { border-color:rgba(127,29,45,.55); box-shadow:0 0 0 3px rgba(127,29,45,.08); }
    .chat-send {
      display:grid;
      place-items:center;
      width:44px;
      height:44px;
      padding:0;
      border:0;
      border-radius:14px;
      color:#fff;
      background:var(--brand);
      cursor:pointer;
      font-size:1.05rem;
    }
    .chat-send:disabled { cursor:wait; opacity:.58; }
    .chat-footer {
      flex:none;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      min-height:42px;
      padding:7px 12px;
      border-top:1px solid #f0e8e1;
      color:var(--muted);
      background:#fff;
      font-size:.7rem;
    }
    .chat-footer .chat-wa {
      display:inline-flex;
      align-items:center;
      gap:5px;
      margin:0;
      padding:5px 8px;
      border-radius:99px;
      color:#167747;
      background:#e9f7ef;
      font-size:.7rem;
      font-weight:800;
    }
    @media (max-width:700px) {
      body.chat-open { overflow:hidden; }
      .search-panel { padding:32px 0 54px; }
      .search-card { grid-template-columns:1fr; gap:10px; padding:12px; }
      .search-actions { grid-template-columns:repeat(2,minmax(0,1fr)); grid-auto-flow:row; gap:9px; }
      .search-actions .btn { width:100%; min-width:0; padding-inline:10px; font-size:.78rem; }
      .quick-links { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; overflow:visible; padding-bottom:0; }
      .quick-links a { min-width:0; white-space:normal; line-height:1.25; }

      .chatbot { right:max(12px,env(safe-area-inset-right)); bottom:max(14px,env(safe-area-inset-bottom)); }
      .chat-toggle { width:54px; height:54px; }
      .chat-backdrop:not([hidden]) {
        position:fixed;
        inset:0;
        display:block;
        width:100%;
        height:100%;
        padding:0;
        border:0;
        background:rgba(18,13,11,.54);
        backdrop-filter:blur(2px);
      }
      .chat-panel {
        position:fixed;
        inset:auto 8px max(76px,calc(env(safe-area-inset-bottom) + 68px)) 8px;
        width:auto;
        height:min(560px,72dvh);
        min-height:0;
        max-height:calc(var(--chat-visual-height,100dvh) - 24px);
        border-radius:20px;
        transform-origin:bottom center;
        transition:max-height .14s ease,bottom .14s ease;
      }
      body.chat-keyboard-open .chat-panel {
        bottom:calc(var(--chat-keyboard-offset,0px) + 8px);
        height:min(440px,calc(var(--chat-visual-height,100dvh) - 16px));
        max-height:calc(var(--chat-visual-height,100dvh) - 16px);
        transition:none;
      }
      .chat-head { min-height:68px; padding:11px 12px; }
      .chat-avatar { width:40px; height:40px; }
      .chat-body { padding:14px; }
      .chat-suggestions { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:7px; margin:5px 0 2px; padding:0; overflow:visible; }
      .chat-option { width:100%; justify-content:center; white-space:normal; text-align:center; line-height:1.25; }
      .chat-composer { padding:10px; }
      .chat-footer { min-height:38px; }
      .chat-toggle[aria-expanded="true"] { opacity:0; pointer-events:none; }
    }
    @media (max-width:370px) {
      .search-actions,.quick-links { grid-template-columns:1fr; }
      .chat-footer > span { display:none; }
    }
  </style>
</head>
<body>
  @php
    $waNumber = '38344960661';

    $categories = [
      ['title' => 'Tepiha', 'title_en' => 'Rugs', 'title_sr' => 'Tepisi', 'desc' => 'Modele per sallon, dhome gjumi dhe korridor.', 'desc_en' => 'Models for living rooms, bedrooms and hallways.', 'desc_sr' => 'Modeli za dnevni boravak, spavacu sobu i hodnik.', 'url' => route('products.tepiha'), 'img' => asset('optimized/categories/tepiha.jpg')],
      ['title' => 'Perde anesore', 'title_en' => 'Side curtains', 'title_sr' => 'Bocne zavese', 'desc' => 'Pamje elegante dhe qepje profesionale.', 'desc_en' => 'Elegant look with professional tailoring.', 'desc_sr' => 'Elegantan izgled i profesionalno sivenje.', 'url' => route('products.anesore'), 'img' => asset('optimized/categories/perde-anesore.jpg')],
      ['title' => 'Perde ditore', 'title_en' => 'Day curtains', 'title_sr' => 'Dnevne zavese', 'desc' => 'Drite e bute dhe ambient me i paster.', 'desc_en' => 'Soft light and a cleaner room feeling.', 'desc_sr' => 'Meko svetlo i cistiji izgled prostora.', 'url' => route('products.perdeDitore'), 'img' => asset('optimized/categories/perde-ditore.jpg')],
      ['title' => 'Set çarçafësh', 'title_en' => 'Bedsheet sets', 'title_sr' => 'Set posteljine', 'desc' => 'Sete per gjume te rehatshem cdo nate.', 'desc_en' => 'Sets for comfortable sleep every night.', 'desc_sr' => 'Setovi za udoban san svake noci.', 'url' => route('products.postava'), 'img' => asset('optimized/categories/postava.jpg')],
      ['title' => 'Lekure pelushi', 'title_en' => 'Plush fur', 'title_sr' => 'Plisano krzno', 'desc' => 'Posteqia dhe lekur pelusho per dekor.', 'desc_en' => 'Plush fur and soft decor pieces.', 'desc_sr' => 'Plisano krzno i meki dekor.', 'url' => route('products.posteqia'), 'img' => asset('optimized/categories/posteqia.jpg')],
      ['title' => 'Batanije', 'title_en' => 'Blankets', 'title_sr' => 'Cebad', 'desc' => 'Qebe dhe batanije te ngrohta per shtepi.', 'desc_en' => 'Warm blankets for the home.', 'desc_sr' => 'Topla cebad za dom.', 'url' => route('products.batanije'), 'img' => asset('optimized/categories/batanije.jpg')],
      ['title' => 'Mbulesa', 'title_en' => 'Covers', 'title_sr' => 'Prekrivaci', 'desc' => 'Per divan, krevat dhe dekor te perditeshem.', 'desc_en' => 'For sofas, beds and everyday decor.', 'desc_sr' => 'Za sofu, krevet i svakodnevni dekor.', 'url' => route('products.mbulesa'), 'img' => asset('optimized/categories/mbulesa.jpg')],
      ['title' => 'Jasteke dekorues', 'title_en' => 'Decorative pillows', 'title_sr' => 'Dekorativni jastuci', 'desc' => 'Per divan, krevat, sallon dhe dekor.', 'desc_en' => 'For sofas, beds, living rooms and decor.', 'desc_sr' => 'Za sofu, krevet, dnevni boravak i dekor.', 'url' => route('products.jastekdekorues'), 'img' => asset('optimized/categories/jastekdekorues.jpg')],
      ['title' => 'Tepiha banjo', 'title_en' => 'Bath rugs', 'title_sr' => 'Kupatilski tepisi', 'desc' => 'Tapeta banjoje antirreshqitese.', 'desc_en' => 'Non-slip bathroom rugs.', 'desc_sr' => 'Neklizajuci tepisi za kupatilo.', 'url' => route('products.tepihebanjo'), 'img' => asset('optimized/categories/tepihebanjo.jpg')],
      ['title' => 'Garnishte', 'title_en' => 'Curtain rails', 'title_sr' => 'Garnisne', 'desc' => 'Aksesor per perde dhe montim me pamje te rregullt.', 'desc_en' => 'Curtain accessories for a clean installation.', 'desc_sr' => 'Dodaci za zavese i urednu montazu.', 'url' => route('products.garnishte'), 'img' => asset('optimized/categories/garnishte.jpg')],
    ];

    $quickLinks = [
      ['label' => 'Tepiha modern', 'url' => route('products.tepiha'), 'icon' => 'bi-grid-3x3-gap'],
      ['label' => 'Perde ditore', 'url' => route('products.perdeDitore'), 'icon' => 'bi-brightness-high'],
      ['label' => 'Perde anesore', 'url' => route('products.anesore'), 'icon' => 'bi-columns-gap'],
      ['label' => 'Batanije', 'url' => route('products.batanije'), 'icon' => 'bi-stars'],
      ['label' => 'Tepiha banjo', 'url' => route('products.tepihebanjo'), 'icon' => 'bi-droplet'],
      ['label' => 'Garnishte', 'url' => route('products.garnishte'), 'icon' => 'bi-sliders'],
    ];
  @endphp

  <header class="site-header">
    <div class="nav-container nav">
      <a class="brand" href="{{ route('home') }}" aria-label="Brillant home">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
        <span>Brillant</span>
      </a>

      <nav id="mainMenu" class="nav-links" aria-label="Navigimi kryesor">
        <a href="{{ route('home') }}" data-sq="Home" data-en="Home" data-sr="Pocetna">Home</a>

        <details class="nav-dropdown">
          <summary><span data-sq="Products" data-en="Products" data-sr="Proizvodi">Products</span> <i class="bi bi-caret-down-fill"></i></summary>
          <div class="dropdown-menu">
            @foreach($categories as $category)
              <a href="{{ $category['url'] }}" data-sq="{{ $category['title'] }}" data-en="{{ $category['title_en'] }}" data-sr="{{ $category['title_sr'] }}">{{ $category['title'] }}</a>
            @endforeach
          </div>
        </details>

        <a href="{{ route('about') }}" data-sq="About" data-en="About" data-sr="O nama">About</a>
        <a href="{{ route('contact') }}" data-sq="Contact" data-en="Contact" data-sr="Kontakt">Contact</a>
        @auth
          <a class="account-mobile-link" href="{{ route('account.dashboard') }}"><i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}</a>
        @else
          <a class="account-mobile-link" href="{{ route('login') }}"><i class="bi bi-person-circle"></i> Llogaria ime</a>
        @endauth
        <div class="mobile-menu-lang" aria-label="Language switcher mobile">
          <div class="lang-switch">
            <button type="button" data-lang="sq" data-url="/lang/sq" class="{{ $pageLocale === 'sq' ? 'active' : '' }}">SQ</button>
            <button type="button" data-lang="en" data-url="/lang/en" class="{{ $pageLocale === 'en' ? 'active' : '' }}">EN</button>
            <button type="button" data-lang="sr" data-url="/lang/sr" class="{{ $pageLocale === 'sr' ? 'active' : '' }}">SR</button>
          </div>
        </div>
      </nav>

      <div class="nav-actions">
        <div class="lang-switch" aria-label="Language switcher">
          <button type="button" data-lang="sq" data-url="/lang/sq" class="{{ $pageLocale === 'sq' ? 'active' : '' }}">SQ</button>
          <button type="button" data-lang="en" data-url="/lang/en" class="{{ $pageLocale === 'en' ? 'active' : '' }}">EN</button>
          <button type="button" data-lang="sr" data-url="/lang/sr" class="{{ $pageLocale === 'sr' ? 'active' : '' }}">SR</button>
        </div>
        @auth
          <a class="login-btn" href="{{ route('account.dashboard') }}"><i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Str::limit(auth()->user()->name, 16) }}</a>
        @else
          <a class="login-btn" href="{{ route('login') }}"><i class="bi bi-person-circle"></i> Llogaria ime</a>
        @endauth

        <details class="nav-dropdown cart-dropdown">
          <summary class="icon-btn cart-link">
            <i class="bi bi-bag"></i>
            <span>Shporta</span>
            <span class="cart-badge">{{ session('cart_total_qty', 0) }}</span>
            <i class="bi bi-caret-down-fill cart-more"></i>
          </summary>
          <div class="dropdown-menu">
            <a href="{{ route('cart.index') }}">Hap shporten</a>
            <a href="{{ route('track.form') }}">Gjurmo porosine</a>
          </div>
        </details>

        <a class="icon-btn cart-link mobile-cart" href="{{ route('cart.index') }}" aria-label="Shporta">
          <i class="bi bi-bag"></i>
          <span class="cart-badge">{{ session('cart_total_qty', 0) }}</span>
        </a>

        <button class="icon-btn menu-toggle" type="button" aria-label="Hap menune" aria-controls="mainMenu" aria-expanded="false">
          <i class="bi bi-list"></i>
        </button>
      </div>
    </div>
  </header>

  <main>
    <section class="hero" aria-label="Brillant home">
      <div class="hero-stage">
        <div class="hero-content">
          <h1 data-sq="Rehati. Stil. Brillant." data-en="Comfort. Style. Brillant." data-sr="Udobnost. Stil. Brillant.">Rehati. Stil. Brillant.</h1>
          <a class="hero-cta" href="{{ route('products.index') }}"><span data-sq="Shiko koleksionet" data-en="Explore collections" data-sr="Pogledaj kolekcije">Shiko koleksionet</span><i class="bi bi-arrow-right"></i></a>
        </div>
        <a class="hero-scroll" href="#searchSection">Zbulo më shumë ↓</a>
      </div>
    </section>

    <section class="categories-home" aria-labelledby="categoriesTitle">
      <div class="container">
        <div class="section-head">
          <div>
            <div class="eyebrow">Koleksionet</div>
            <h2 id="categoriesTitle">Gjeje shpejt atë që të duhet.</h2>
            <p>Kategoritë më të kërkuara, të organizuara qartë për një blerje pa humbur kohë.</p>
          </div>
          <a class="btn btn-outline" href="{{ route('products.index') }}">Shiko të gjitha</a>
        </div>
        <div class="hero-category-board" aria-label="Kategoritë Brillant">
          @foreach($categories as $category)
            <a class="hero-category-card {{ $loop->first ? 'featured' : '' }}" href="{{ $category['url'] }}">
              <span class="hero-category-media" role="img" aria-label="{{ $category['title'] }}" style="background-image: url('{{ $category['img'] }}')"></span>
              <div class="hero-category-body">
                @if($loop->first)
                  <h2 data-sq="{{ $category['title'] }}" data-en="{{ $category['title_en'] }}" data-sr="{{ $category['title_sr'] }}">{{ $category['title'] }}</h2>
                @else
                  <h3 data-sq="{{ $category['title'] }}" data-en="{{ $category['title_en'] }}" data-sr="{{ $category['title_sr'] }}">{{ $category['title'] }}</h3>
                @endif
                <p data-sq="{{ $category['desc'] }}" data-en="{{ $category['desc_en'] }}" data-sr="{{ $category['desc_sr'] }}">{{ $category['desc'] }}</p>
                <span class="hero-category-link">
                  <span data-sq="Shiko" data-en="View" data-sr="Pogledaj">Shiko</span>
                  <i class="bi bi-arrow-right-short"></i>
                </span>
              </div>
            </a>
          @endforeach
        </div>
        </div>
    </section>

    <section id="searchSection" class="search-panel">
      <div class="container">
        <form class="search-card" action="{{ route('search') }}" method="GET">
          <label class="search-field">
            <i class="bi bi-search"></i>
            <input name="q" type="search" placeholder="Kërko produkt..." autocomplete="off" data-placeholder-sq="Kërko produkt..." data-placeholder-en="Search products..." data-placeholder-sr="Pretraži proizvode...">
          </label>
          <div class="search-actions">
            <button class="btn btn-primary" type="submit" data-sq="Kërko" data-en="Search" data-sr="Pretraži">Kërko</button>
            <button class="btn btn-assistant" type="button" data-open-chat>
              <i class="bi bi-chat-dots"></i> <span data-sq="Pyet asistentin" data-en="Ask assistant" data-sr="Pitaj asistenta">Pyet asistentin</span>
            </button>
          </div>
        </form>

        <div class="quick-links" aria-label="Kerkime te shpejta">
          @foreach($quickLinks as $link)
            <a href="{{ $link['url'] }}"><i class="bi {{ $link['icon'] }}"></i>{{ $link['label'] }}</a>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section pt-0 inspiration-section">
      <div class="container">
        <div class="section-head">
          <div>
            <div class="eyebrow">Inspirim</div>
          <h2>Më të kërkuarat.</h2>
          </div>
        </div>

        <div class="editorial-grid">
          <a class="feature-tile fit-contain" href="{{ route('products.tepiha') }}">
            <img src="{{ asset('carpet/carpetmara.jpg') }}" alt="Tepiha moderne" loading="lazy" decoding="async" width="760" height="520">
            <div class="feature-tile-content">
              <h3>Tepiha per sallon modern</h3>
              <p>Teksture, ngjyra dhe permasa qe e lidhin komplet ambientin.</p>
              <span class="btn btn-outline">Shiko tepihat</span>
            </div>
          </a>

          <div class="feature-side">
            <a class="feature-tile small" href="{{ route('products.perde') }}">
              <img src="{{ asset('optimized/home/raffaello.jpg') }}" alt="Perde elegante" loading="lazy" decoding="async" width="520" height="320">
              <div class="feature-tile-content">
                <h3>Perde me stil</h3>
                <p>Qepje dhe material i zgjedhur.</p>
              </div>
            </a>
            <a class="feature-tile small" href="{{ route('products.batanije') }}">
              <img src="{{ asset('optimized/home/gold.jpg') }}" alt="Batanije" loading="lazy" decoding="async" width="520" height="320">
              <div class="feature-tile-content">
                <h3>Ngrohtesi per cdo dite</h3>
                <p>Batanije dhe tekstil i bute.</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="benefits section-tight removed-benefits">
      <div class="container benefit-grid">
        <div class="benefit">
          <i class="bi bi-rulers"></i>
          <h3>Transport i sigurt</h3>
          <p>Porosia konfirmohet dhe ndiqet deri te dorezimi.</p>
        </div>
        <div class="benefit">
          <i class="bi bi-patch-check"></i>
          <h3>Blerje e lehte</h3>
          <p>Kategori te qarta, shporte dhe kontakt direkt per pyetje.</p>
        </div>
        <div class="benefit">
          <i class="bi bi-whatsapp"></i>
          <h3>Mbështetje deri në dorëzim</h3>
          <p>Pyet per cmim, stock, matje ose rekomandim pa humb kohe.</p>
        </div>
        <div class="benefit">
          <i class="bi bi-bag-check"></i>
          <h3>Cmim i qarte</h3>
          <p>Produktet shfaqin cmim, stock dhe detaje per blerje me te lehte.</p>
        </div>
      </div>
    </section>

    <section class="section pt-0 recommended-section">
      <div class="container">
        <div class="section-head">
          <div>
            <div class="eyebrow">Te rejat</div>
          <h2>Të Rekomanduara.</h2>
          </div>
          <div class="carousel-actions">
            @if($latestProducts->count())
              <button class="carousel-btn" type="button" data-carousel-prev aria-label="Produktet majtas">
                <i class="bi bi-chevron-left"></i>
              </button>
              <button class="carousel-btn" type="button" data-carousel-next aria-label="Produktet djathtas">
                <i class="bi bi-chevron-right"></i>
              </button>
            @endif
            <a class="btn btn-outline" href="{{ route('products.index') }}">Shiko produktet</a>
          </div>
        </div>

        @if($latestProducts->count())
          <div class="product-carousel-wrap">
          <div class="product-grid product-carousel" id="latestProductsCarousel" tabindex="0" aria-label="Produktet e rekomanduara">
            @foreach($latestProducts as $item)
              @php
                $imgUrl = \App\Support\ProductImages::url($item->image_path ?? null, asset('images/placeholder-product.png'), $item);

                $sizes = $item->sizes ?? null;
                if (is_string($sizes)) {
                  $decodedSizes = json_decode($sizes, true);
                  $sizes = is_array($decodedSizes) ? $decodedSizes : [];
                }
                if (!is_array($sizes)) $sizes = [];

                $priceValue = $item->price;
                if (!empty($sizes)) {
                  $prices = [];
                  foreach ($sizes as $size) {
                    if (isset($size['price']) && $size['price'] !== null) {
                      $prices[] = $size['price'];
                    }
                  }
                  if (!empty($prices)) $priceValue = min($prices);
                }
                $priceLabel = $priceValue !== null ? 'EUR ' . number_format((float) $priceValue, 2) : 'Me kerkese';
                $inStock = (int)($item->stock ?? 0) > 0;
                $cat = $item->category ? strtoupper($item->category) : 'PRODUKT';
                $detailsUrl = $item->slug ? route('products.show', $item->slug) : route('products.index');
              @endphp

              <article class="product-card">
                <a class="product-media" href="{{ $detailsUrl }}" aria-label="Shiko {{ $item->name }}">
                  <img src="{{ $imgUrl }}" alt="{{ $item->name }}" loading="lazy" fetchpriority="low" decoding="async" sizes="(max-width: 576px) 100vw, (max-width: 992px) 50vw, 33vw" width="640" height="520" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                  <span class="product-badge">I ri</span>
                  <span class="stock-badge {{ $inStock ? '' : 'out' }}">{{ $inStock ? 'Ne stock' : 'Pa stock' }}</span>
                </a>
                <div class="product-body">
                  <div class="product-meta">
                    <span>{{ $cat }}</span>
                    @if(!empty($item->sku))
                      <span>SKU: {{ $item->sku }}</span>
                    @endif
                  </div>
                  <h3>{{ $item->name }}</h3>
                  <p class="product-desc">
                    {{ $item->description ? \Illuminate\Support\Str::limit($item->description, 115) : "Detajet e produktit mund t'i merrni shpejt ne WhatsApp." }}
                  </p>
                  <div class="product-bottom">
                    <span class="price-label">Cmimi</span>
                    <strong class="price">{{ $priceLabel }}</strong>
                    <div class="product-actions">
                      <a class="btn btn-outline" href="{{ $detailsUrl }}">Detaje</a>
                      <a class="btn btn-whatsapp" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Pershendetje! Jam i interesuar per: '.$item->name.' ('.$priceLabel.'). A ka ne stock?') }}" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp"></i> Pyet
                      </a>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
          </div>
        @else
          <div class="seo-box">
            <h2 data-sq="Produktet do te shfaqen se shpejti." data-en="Products will appear soon." data-sr="Proizvodi ce uskoro biti prikazani.">Produktet do te shfaqen se shpejti.</h2>
            <p data-sq="Per produktet aktuale, na shkruani ne WhatsApp dhe ju dergojme opsionet qe jane ne stock." data-en="For current products, message us on WhatsApp and we will send the options available in stock." data-sr="Za aktuelne proizvode pisite nam na WhatsApp i poslaćemo opcije koje su na stanju.">Per produktet aktuale, na shkruani ne WhatsApp dhe ju dergojme opsionet qe jane ne stock.</p>
          </div>
        @endif
      </div>
    </section>

    <section class="section pt-0">
      <div class="container showroom">
        <div class="showroom-image">
          <img src="{{ asset('optimized/home/paris.jpg') }}" alt="Showroom Brillant" loading="lazy" decoding="async" width="760" height="570">
        </div>

        <div>
          <div class="eyebrow">Sherbimi</div>
          <h2 style="font-size: clamp(1.7rem, 3vw, 2.55rem); line-height: 1.08; margin: 0; font-weight: 800;">Jo vetem produkt, por zgjidhje per ambientin.</h2>
          <p style="color: var(--muted); line-height: 1.75; margin: 14px 0 0;">Faqja eshte ndertuar qe klienti te kuptoje shpejt cfare shitet, ku duhet te klikoje dhe si te kontaktoje pa u lodhur.</p>

          <div class="info-list">
            <div class="info-row">
              <i class="bi bi-palette"></i>
              <div>
                <h3>Kombinim ngjyrash</h3>
                <p>Ndihme per zgjedhje mes tepiheve, perdeve, mbulesave dhe dekorit.</p>
              </div>
            </div>
            <div class="info-row">
              <i class="bi bi-scissors"></i>
              <div>
                <h3>Perde me qepje profesionale</h3>
                <p>Perde ditore dhe anesore me pamje elegante per shtepi moderne.</p>
              </div>
            </div>
            <div class="info-row">
              <i class="bi bi-house-heart"></i>
              <div>
                <h3>Tekstil per cdo dhome</h3>
                <p>Tepiha, Set çarçafësh, batanije, mbulesa dhe jasteke ne nje vend.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-tight">
      <div class="container">
        <div class="contact-strip">
          <div>
            <h2>Ke foto te dhomes? Dergoje dhe ta sugjerojme kombinimin.</h2>
            <p>Na shkruaj per model, ngjyre, dimension ose stock. Pergjigja ne WhatsApp eshte rruga me e shpejte.</p>
          </div>
          <a class="btn btn-whatsapp" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Pershendetje! Dua ndihme per kombinim produktesh ne shtepi.') }}" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp"></i> Shkruaj tani
          </a>
        </div>
      </div>
    </section>

    <section class="section-tight">
      <div class="container">
        <div class="seo-box">
          <h2 data-sq="Brillant - tepiha, perde, mbulesa dhe tekstil per shtepi" data-en="Brillant - rugs, curtains, covers and home textiles" data-sr="Brillant - tepisi, zavese, prekrivaci i tekstil za dom">Brillant - tepiha, perde, mbulesa dhe tekstil per shtepi</h2>
          <p data-sq="Brillant ofron tepiha moderne, perde ditore, perde anesore, batanije, set çarçafësh, mbulesa divani, tepiha banjo, jasteke dekorues, posteqia dhe lekur pelushi per shtepi. Qellimi eshte me e bo blerjen te lehte: kategori te qarta, foto te dukshme, produkte te fundit dhe kontakt direkt per cdo pyetje." data-en="Brillant offers modern rugs, day curtains, side curtains, blankets, bedsheet sets, sofa covers, bath rugs, decorative pillows, plush fur and home textiles in Kosovo. The goal is to make shopping easy: clear categories, visible photos, latest products and direct contact for every question." data-sr="Brillant nudi moderne tepihe, dnevne zavese, bocne zavese, cebad, setove posteljine, prekrivace za sofu, kupatilske tepihe, dekorativne jastuke, plisano krzno i tekstil za dom na Kosovu. Cilj je laka kupovina: jasne kategorije, vidljive fotografije, najnoviji proizvodi i direktan kontakt za svako pitanje.">Brillant ofron tepiha moderne, perde ditore, perde anesore, batanije, set çarçafësh, mbulesa divani, tepiha banjo, jasteke dekorues, posteqia dhe lekur pelushi per shtepi. Qellimi eshte me e bo blerjen te lehte: kategori te qarta, foto te dukshme, produkte te fundit dhe kontakt direkt per cdo pyetje.</p>
          <p>
            <span data-sq="Kerkime te shpeshta:" data-en="Frequent searches:" data-sr="Ceste pretrage:">Kerkime te shpeshta:</span>
            <a href="{{ route('products.perdeDitore') }}" data-sq="perde ditore" data-en="day curtains" data-sr="dnevne zavese">perde ditore</a>,
            <a href="{{ route('products.anesore') }}" data-sq="perde anesore" data-en="side curtains" data-sr="bocne zavese">perde anesore</a>,
            <a href="{{ route('products.mbulesa') }}" data-sq="mbulesa online" data-en="covers online" data-sr="prekrivaci online">mbulesa online</a>,
            <a href="{{ route('products.mbulesa') }}" data-sq="mbulesa divani" data-en="sofa covers" data-sr="prekrivaci za sofu">mbulesa divani</a>,
            <a href="{{ route('products.postava') }}" data-sq="set çarçafësh" data-en="bedsheet sets" data-sr="setovi posteljine">set çarçafësh</a>,
            <a href="{{ route('products.batanije') }}" data-sq="batanije" data-en="blankets" data-sr="cebad">batanije</a>,
            <a href="{{ route('products.jastekdekorues') }}" data-sq="jastek dekorues" data-en="decorative pillows" data-sr="dekorativni jastuci">jastek dekorues</a>,
            <a href="{{ route('products.tepihebanjo') }}" data-sq="tepiha banjo" data-en="bath rugs" data-sr="kupatilski tepisi">tepiha banjo</a>,
            <a href="{{ route('products.posteqia') }}" data-sq="lekur pelusho" data-en="plush fur" data-sr="plisano krzno">lekur pelusho</a>.
          </p>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <img src="{{ asset('images/brillant.png') }}" alt="Brillant" loading="lazy" decoding="async">
          <p>Brillant ne Lipjan - zgjedhje profesionale per tepiha, perde dhe tekstil per shtepi.</p>
        </div>
        <div>
          <h3>Produkte</h3>
          <a href="{{ route('products.tepiha') }}">Tepiha</a>
          <a href="{{ route('products.perdeDitore') }}">Perde ditore</a>
          <a href="{{ route('products.anesore') }}">Perde anesore</a>
          <a href="{{ route('products.tepihebanjo') }}">Tepiha banjo</a>
          <a href="{{ route('products.garnishte') }}">Garnishte</a>
        </div>
        <div>
          <h3>Tekstil</h3>
          <a href="{{ route('products.postava') }}">Set çarçafësh</a>
          <a href="{{ route('products.posteqia') }}">Lekure pelushi</a>
          <a href="{{ route('products.batanije') }}">Batanije</a>
          <a href="{{ route('products.mbulesa') }}">Mbulesa</a>
          <a href="{{ route('products.jastekdekorues') }}">Jasteke dekorues</a>
        </div>
        <div>
          <h3>Ndihme</h3>
          <a href="{{ route('products.index') }}">Products</a>
          <a href="{{ route('cart.index') }}">Shporta</a>
          <a href="{{ route('track.form') }}">Gjurmo porosine</a>
          <a href="{{ route('contact') }}">Kontakt</a>
          <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
      </div>

      <div class="copyright">
        Copyright &copy; {{ date('Y') }} Brillant. Crafted by RDR Digital L.L.C.
      </div>
    </div>
  </footer>

  <a class="floating-wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="WhatsApp">
    <i class="bi bi-whatsapp fs-4"></i>
  </a>

  <div class="chatbot" id="brillantChat" data-endpoint="{{ route('chatbot.message', [], false) }}">
    <button class="chat-backdrop" type="button" hidden aria-label="Mbyll asistentin"></button>
    <section class="chat-panel" id="chatPanel" hidden role="dialog" aria-modal="true" aria-labelledby="chatTitle">
      <header class="chat-head">
        <span class="chat-avatar"><i class="bi bi-chat-heart"></i></span>
        <div class="chat-title-wrap">
          <strong id="chatTitle">Asistenti Brillant</strong>
          <small><span class="chat-status-dot"></span> Shkruaj pyetjen tënde</small>
        </div>
        <button class="chat-close" type="button" aria-label="Mbyll chatbot-in"><i class="bi bi-x-lg"></i></button>
      </header>

      <div class="chat-body" id="chatBody" role="log" aria-live="polite" aria-relevant="additions">
        <div class="chat-message">Përshëndetje! 👋 Mund të më pyesësh për perde, tepiha, çmime, dërgesë ose porosinë tënde.</div>
      </div>

      <form class="chat-composer" id="chatForm">
        <label class="sr-only" for="chatInput">Shkruaj mesazhin</label>
        <textarea id="chatInput" rows="1" maxlength="600" placeholder="Shkruaj këtu..." autocomplete="off"></textarea>
        <button class="chat-send" type="submit" aria-label="Dërgo mesazhin"><i class="bi bi-arrow-up"></i></button>
      </form>

      <footer class="chat-footer">
        <span>Për përgjigje nga ekipi:</span>
        <a class="chat-wa" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Përshëndetje! Kam nevojë për ndihmë nga Brillant.') }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a>
      </footer>
    </section>
    <button class="chat-toggle" type="button" aria-label="Hap asistentin" aria-controls="chatPanel" aria-expanded="false"><i class="bi bi-chat-dots-fill"></i></button>
  </div>

  <script>
    (function () {
      const menu = document.getElementById('mainMenu');
      const toggle = document.querySelector('.menu-toggle');
      const recommended = document.querySelector('.recommended-section');
      const benefits = document.querySelector('.removed-benefits');
      const latestCarousel = document.getElementById('latestProductsCarousel');
      const chatPanel = document.getElementById('chatPanel');
      const chatToggle = document.querySelector('.chat-toggle');
      const chatClose = document.querySelector('.chat-close');
      const chatBody = document.getElementById('chatBody');
      const chatbot = document.getElementById('brillantChat');
      const chatBackdrop = document.querySelector('.chat-backdrop');
      const chatForm = document.getElementById('chatForm');
      const chatInput = document.getElementById('chatInput');
      const chatSend = document.querySelector('.chat-send');
      const csrfToken = document.querySelector('meta[name="csrf-token"]');
      const chatHistory = [];
      let chatBusy = false;
      let lastChatProductIds = [];

      function setChat(open) {
        if (!chatPanel || !chatToggle) return;
        chatPanel.hidden = !open;
        if (chatBackdrop) chatBackdrop.hidden = !open;
        chatToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        chatToggle.innerHTML = open ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-chat-dots-fill"></i>';
        document.body.classList.toggle('chat-open', open);
        // Në telefon mos e hap tastierën bashkë me panelin; ky kombinim shkakton
        // kërcim të visual viewport. Klienti prek fushën kur është gati të shkruajë.
        if (open && chatInput && window.matchMedia('(min-width: 701px)').matches) {
          window.setTimeout(function () { chatInput.focus(); }, 80);
        }
      }
      if (chatToggle) chatToggle.addEventListener('click', function () { setChat(chatPanel.hidden); });
      if (chatClose) chatClose.addEventListener('click', function () { setChat(false); });
      if (chatBackdrop) chatBackdrop.addEventListener('click', function () { setChat(false); });
      Array.prototype.forEach.call(document.querySelectorAll('[data-open-chat]'), function (button) {
        button.addEventListener('click', function () { setChat(true); });
      });

      function scrollChatToEnd() {
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
      }

      function appendChatMessage(text, role, action) {
        if (!chatBody) return null;
        const message = document.createElement('div');
        message.className = 'chat-message' + (role === 'user' ? ' user' : '');
        message.textContent = text;
        chatBody.appendChild(message);

        if (action && action.url && action.label) {
          const link = document.createElement('a');
          link.className = 'chat-action-link';
          link.href = action.url;
          link.textContent = action.label + ' →';
          chatBody.appendChild(link);
        }

        scrollChatToEnd();
        return message;
      }

      function appendChatProducts(products) {
        if (!chatBody || !Array.isArray(products) || !products.length) return;
        const grid = document.createElement('div');
        grid.className = 'chat-product-grid';
        products.forEach(function (product) {
          const card = document.createElement('a');
          card.className = 'chat-product-card';
          card.href = product.url;
          card.setAttribute('aria-label', 'Shiko produktin ' + (product.name || 'Brillant'));

          const image = document.createElement('img');
          image.src = product.image;
          image.alt = '';
          image.setAttribute('aria-hidden', 'true');
          image.loading = 'lazy';
          image.addEventListener('error', function () {
            image.remove();
          }, { once: true });

          const details = document.createElement('span');
          details.className = 'chat-product-details';
          const name = document.createElement('strong');
          name.textContent = product.name || 'Produkt';
          const price = document.createElement('span');
          price.className = 'chat-product-price';
          price.textContent = product.price_text || 'Shiko produktin';
          const meta = document.createElement('span');
          meta.className = 'chat-product-meta';
          const sizeLabels = Array.isArray(product.sizes) ? product.sizes.slice(0, 3).map(function (size) { return size.label; }).filter(Boolean) : [];
          const colorLabels = Array.isArray(product.colors) ? product.colors.slice(0, 3).filter(Boolean) : [];
          const metaParts = [];
          if (sizeLabels.length) metaParts.push('Përmasa: ' + sizeLabels.join(', '));
          if (colorLabels.length) metaParts.push('Ngjyra: ' + colorLabels.join(', '));
          meta.textContent = metaParts.length ? metaParts.join(' • ') : 'Kliko për detaje';
          meta.title = meta.textContent;
          const stock = document.createElement('span');
          stock.className = 'chat-product-stock ' + (product.stock_status || 'confirm');
          stock.textContent = product.stock_label || 'Konfirmo stokun';
          details.appendChild(name);
          details.appendChild(price);
          details.appendChild(meta);
          details.appendChild(stock);
          card.appendChild(image);
          card.appendChild(details);
          grid.appendChild(card);
        });
        chatBody.appendChild(grid);
        scrollChatToEnd();
      }

      function appendTypingIndicator() {
        if (!chatBody) return null;
        const indicator = document.createElement('div');
        indicator.className = 'chat-message is-loading';
        indicator.setAttribute('aria-label', 'Asistenti po shkruan');
        indicator.innerHTML = '<span></span><span></span><span></span>';
        chatBody.appendChild(indicator);
        scrollChatToEnd();
        return indicator;
      }

      function resizeChatInput() {
        if (!chatInput) return;
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 104) + 'px';
      }

      async function sendChatMessage(rawMessage) {
        const message = (rawMessage || '').trim();
        if (!message || chatBusy || !chatbot) return;

        const previousHistory = chatHistory.slice(-8);
        appendChatMessage(message, 'user');
        chatHistory.push({ role: 'user', content: message });
        chatBusy = true;
        if (chatSend) chatSend.disabled = true;
        if (chatInput) {
          chatInput.value = '';
          resizeChatInput();
        }
        const typing = appendTypingIndicator();

        try {
          const response = await fetch(chatbot.dataset.endpoint, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
            },
            body: JSON.stringify({
              message: message,
              history: previousHistory,
              context_product_ids: lastChatProductIds
            })
          });

          if (!response.ok) {
            if (response.status === 429) throw new Error('rate_limit');
            throw new Error('request_failed');
          }

          const data = await response.json();
          if (typing) typing.remove();
          const reply = data.reply || 'Nuk munda të jap përgjigje tani. Na shkruaj në WhatsApp dhe ekipi të ndihmon.';
          appendChatMessage(reply, 'assistant', data.action || null);
          appendChatProducts(data.products || []);
          if (Array.isArray(data.products) && data.products.length) {
            lastChatProductIds = data.products.map(function (product) { return Number(product.id); }).filter(Number.isInteger).slice(0, 30);
          }
          chatHistory.push({ role: 'assistant', content: reply });
        } catch (error) {
          if (typing) typing.remove();
          const errorText = error.message === 'rate_limit'
            ? 'U dërguan shumë mesazhe përnjëherë. Prit pak dhe provo sërish, ose na shkruaj në WhatsApp.'
            : 'Lidhja u ndërpre. Provo përsëri ose vazhdo direkt në WhatsApp.';
          appendChatMessage(errorText, 'assistant');
        } finally {
          chatBusy = false;
          if (chatSend) chatSend.disabled = false;
          if (chatInput) chatInput.focus();
        }
      }

      if (chatForm) chatForm.addEventListener('submit', function (event) {
        event.preventDefault();
        sendChatMessage(chatInput ? chatInput.value : '');
      });
      if (chatInput) {
        chatInput.addEventListener('input', resizeChatInput);
        chatInput.addEventListener('focus', function () {
          document.body.classList.add('chat-keyboard-open');
          updateChatViewport();
          window.setTimeout(scrollChatToEnd, 120);
        });
        chatInput.addEventListener('blur', function () {
          document.body.classList.remove('chat-keyboard-open');
          updateChatViewport();
        });
        chatInput.addEventListener('keydown', function (event) {
          if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            if (chatForm) chatForm.requestSubmit();
          }
        });
      }

      function updateChatViewport() {
        const viewport = window.visualViewport;
        const visibleHeight = viewport ? viewport.height : window.innerHeight;
        const offsetTop = viewport ? viewport.offsetTop : 0;
        const keyboardOffset = Math.max(0, window.innerHeight - visibleHeight - offsetTop);
        document.documentElement.style.setProperty('--chat-visual-height', Math.round(visibleHeight) + 'px');
        document.documentElement.style.setProperty('--chat-keyboard-offset', Math.round(keyboardOffset) + 'px');
      }

      updateChatViewport();
      if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', updateChatViewport);
        window.visualViewport.addEventListener('scroll', updateChatViewport);
      }
      window.addEventListener('orientationchange', function () {
        window.setTimeout(updateChatViewport, 120);
      });
      Array.prototype.forEach.call(document.querySelectorAll('.chat-option[data-chat-message]'), function (option) {
        option.addEventListener('click', function () {
          setChat(true);
          sendChatMessage(option.dataset.chatMessage);
        });
      });
      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && chatPanel && !chatPanel.hidden) setChat(false);
      });

      if (recommended && benefits && recommended.parentNode) {
        recommended.parentNode.insertBefore(benefits, recommended.nextSibling);
      }

      function scrollLatestProducts(direction) {
        if (!latestCarousel) return;
        const firstCard = latestCarousel.querySelector('.product-card');
        const distance = firstCard ? firstCard.getBoundingClientRect().width + 18 : latestCarousel.clientWidth * 0.8;
        const maxScroll = latestCarousel.scrollWidth - latestCarousel.clientWidth - 4;

        if (direction > 0 && latestCarousel.scrollLeft >= maxScroll) {
          latestCarousel.scrollTo({ left: 0, behavior: 'smooth' });
          return;
        }

        if (direction < 0 && latestCarousel.scrollLeft <= 4) {
          latestCarousel.scrollTo({ left: latestCarousel.scrollWidth, behavior: 'smooth' });
          return;
        }

        latestCarousel.scrollBy({ left: direction * distance, behavior: 'smooth' });
      }

      const prevProductButton = document.querySelector('[data-carousel-prev]');
      const nextProductButton = document.querySelector('[data-carousel-next]');
      let latestCarouselTimer = null;

      function stopLatestCarousel() {
        if (latestCarouselTimer) {
          clearInterval(latestCarouselTimer);
          latestCarouselTimer = null;
        }
      }

      function startLatestCarousel() {
        if (!latestCarousel || latestCarouselTimer || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if (latestCarousel.scrollWidth <= latestCarousel.clientWidth + 8) return;
        latestCarouselTimer = setInterval(function () {
          scrollLatestProducts(1);
        }, 3600);
      }

      function restartLatestCarousel() {
        stopLatestCarousel();
        window.setTimeout(startLatestCarousel, 5200);
      }

      if (prevProductButton) prevProductButton.addEventListener('click', function () {
        scrollLatestProducts(-1);
        restartLatestCarousel();
      });
      if (nextProductButton) nextProductButton.addEventListener('click', function () {
        scrollLatestProducts(1);
        restartLatestCarousel();
      });

      if (latestCarousel) {
        latestCarousel.addEventListener('mouseenter', stopLatestCarousel);
        latestCarousel.addEventListener('mouseleave', startLatestCarousel);
        latestCarousel.addEventListener('focusin', stopLatestCarousel);
        latestCarousel.addEventListener('focusout', startLatestCarousel);
        latestCarousel.addEventListener('pointerdown', stopLatestCarousel);
        latestCarousel.addEventListener('pointerup', restartLatestCarousel);
        latestCarousel.addEventListener('touchend', restartLatestCarousel);
        startLatestCarousel();
      }

      if (toggle && menu) {
        toggle.addEventListener('click', function (event) {
          event.preventDefault();
          event.stopPropagation();
          const open = menu.classList.toggle('open');
          toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
          toggle.innerHTML = open ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
        });
      }

      Array.prototype.forEach.call(document.querySelectorAll('#mainMenu a'), function (link) {
        link.addEventListener('click', function () {
          if (!menu) return;
          menu.classList.remove('open');
          if (toggle) toggle.setAttribute('aria-expanded', 'false');
          if (toggle) toggle.innerHTML = '<i class="bi bi-list"></i>';
        });
      });

      document.addEventListener('click', function (event) {
        if (!menu || !toggle || !menu.classList.contains('open')) return;
        if (menu.contains(event.target) || toggle.contains(event.target)) return;
        menu.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '<i class="bi bi-list"></i>';
      });

      window.updateCartBadges = function (totalQty) {
        Array.prototype.forEach.call(document.querySelectorAll('.cart-badge'), function (badge) {
          badge.textContent = totalQty;
        });
      };

      document.addEventListener('cart:updated', function (event) {
        if (event.detail && typeof event.detail.totalQty !== 'undefined') {
          window.updateCartBadges(event.detail.totalQty);
        }
      });

      const langButtons = document.querySelectorAll('.lang-switch [data-lang]');
      const translatable = document.querySelectorAll('[data-sq][data-en][data-sr]');
      const placeholderNodes = document.querySelectorAll('[data-placeholder-sq]');

      function setLanguage(lang) {
        const selected = ['sq', 'en', 'sr'].includes(lang) ? lang : 'sq';

        Array.prototype.forEach.call(translatable, function (node) {
          if (node.dataset[selected]) {
            node.textContent = node.dataset[selected];
          }
        });

        Array.prototype.forEach.call(placeholderNodes, function (node) {
          const value = node.dataset['placeholder' + selected.charAt(0).toUpperCase() + selected.slice(1)];
          if (value) node.setAttribute('placeholder', value);
        });

        Array.prototype.forEach.call(langButtons, function (button) {
          button.classList.toggle('active', button.dataset.lang === selected);
        });

        document.documentElement.lang = selected === 'sr' ? 'sr' : selected;
        localStorage.setItem('brillant_lang', selected);
      }

      Array.prototype.forEach.call(langButtons, function (button) {
        button.addEventListener('click', function () {
          setLanguage(button.dataset.lang);
          if (button.dataset.url) {
            window.location.href = button.dataset.url;
          }
        });
      });

      const serverLang = '{{ $pageLocale }}';
      const savedLang = localStorage.getItem('brillant_lang');
      setLanguage(serverLang || savedLang || 'sq');
    })();
  </script>
</body>
</html>
