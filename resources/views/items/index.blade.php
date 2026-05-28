<!doctype html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Brillant | Tepiha, Perde Online, Mbulesa, Batanije & Dekor</title>
  <meta name="description" content="Brillant në Lipjan: tepiha, perde online, mbulesa divani, set çarçafësh, postava, batanije, jastëk dekorues, tepiha banjo dhe lëkurë pelushi në Kosovë.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ url('/') }}">
  <meta name="theme-color" content="#7f1d2d">

  <meta property="og:title" content="Brillant - Tepiha dhe Perde">
  <meta property="og:description" content="Koleksione per shtepi me dizajn te paster, materiale te zgjedhura dhe kontakt direkt ne WhatsApp.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url('/') }}">
  <meta property="og:image" content="{{ asset('optimized/home/hero.jpg') }}">

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <link rel="preload" as="image" href="{{ asset('optimized/home/hero.jpg') }}" media="(max-width: 767px)" fetchpriority="high">
  <link rel="preload" as="image" href="{{ asset('optimized/home/hero.jpg') }}" media="(min-width: 768px)" fetchpriority="high">
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
      min-height: 520px;
      color: #fff;
      display: grid;
      align-items: stretch;
      isolation: isolate;
      overflow: hidden;
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background:
        linear-gradient(90deg, rgba(20,14,12,.86), rgba(20,14,12,.50) 52%, rgba(20,14,12,.16)),
        url("{{ asset('optimized/home/hero.jpg') }}") center / cover no-repeat;
      z-index: -2;
    }
    .hero::after {
      content: "";
      position: absolute;
      inset: auto 0 0;
      height: 180px;
      background: linear-gradient(180deg, rgba(251,247,242,0), var(--bg));
      z-index: -1;
      pointer-events: none;
    }
    .hero-grid {
      min-height: 520px;
      display: grid;
      grid-template-columns: minmax(0, 1.08fr) minmax(310px, .55fr);
      align-items: center;
      gap: 36px;
      padding: 56px 0 92px;
    }
    .hero-copy { max-width: 760px; }
    .hero .eyebrow { color: #f4d795; }
    .hero .eyebrow::before { background: #f4d795; }
    .hero h1 {
      margin: 0;
      font-size: clamp(2.55rem, 6vw, 5.25rem);
      line-height: .96;
      font-weight: 800;
      letter-spacing: 0;
    }
    .nota-hero-thumbs {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 12px;
      margin-top: 28px;
      max-width: 760px;
    }
    .nota-hero-thumb {
      min-height: 118px;
      border-radius: var(--radius-lg);
      overflow: hidden;
      position: relative;
      display: flex;
      align-items: end;
      padding: 12px;
      isolation: isolate;
      color: #fff;
      font-weight: 800;
      box-shadow: 0 14px 34px rgba(0,0,0,.18);
    }
    .nota-hero-thumb img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -2;
    }
    .nota-hero-thumb::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,.05), rgba(0,0,0,.68));
      z-index: -1;
    }
    .hero h1 span { color: #f4d795; }
    .hero p {
      color: rgba(255,255,255,.9);
      max-width: 640px;
      margin: 20px 0 0;
      font-size: 1.08rem;
      line-height: 1.75;
    }
    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 28px;
    }
    .hero .btn-outline {
      background: rgba(255,255,255,.10);
      border-color: rgba(255,255,255,.36);
      color: #fff;
    }
    .hero .btn-outline:hover { background: rgba(255,255,255,.18); color: #fff; }
    .hero-stats {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 12px;
      margin-top: 34px;
      max-width: 700px;
    }
    .hero-stat {
      padding: 14px;
      border: 1px solid rgba(255,255,255,.18);
      border-radius: var(--radius);
      background: rgba(255,255,255,.10);
    }
    .hero-stat strong {
      display: block;
      color: #f4d795;
      font-size: 1.35rem;
      line-height: 1;
      margin-bottom: 6px;
    }
    .hero-stat span { color: rgba(255,255,255,.82); font-size: .86rem; }

    .hero-card {
      align-self: end;
      background: rgba(255,255,255,.94);
      color: var(--ink);
      border-radius: var(--radius-lg);
      overflow: hidden;
      border: 1px solid rgba(255,255,255,.28);
      box-shadow: 0 26px 70px rgba(0,0,0,.28);
    }
    .hero-card img {
      width: 100%;
      height: 230px;
      object-fit: cover;
    }
    .hero-card-body { padding: 20px; }
    .hero-card h2 {
      margin: 0;
      font-size: 1.15rem;
      font-weight: 800;
    }
    .hero-card p {
      color: var(--muted);
      font-size: .92rem;
      line-height: 1.6;
      margin: 9px 0 16px;
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
      .hero-grid { grid-template-columns: 1fr; }
      .hero-card {
        width: min(420px, 100%);
        align-self: auto;
      }
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
      .hero { min-height: 590px; }
      .hero::before {
        background:
          linear-gradient(180deg, rgba(20,14,12,.18), rgba(20,14,12,.88)),
          url("{{ asset('optimized/home/hero.jpg') }}") center / cover no-repeat;
      }
      .hero-grid {
        min-height: 590px;
        padding: 150px 0 88px;
        gap: 24px;
      }
      .hero h1 { font-size: clamp(2.25rem, 10vw, 3.7rem); }
      .hero p { font-size: .98rem; line-height: 1.65; }
      .hero-card { display: none; }
      .nota-hero-thumbs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .search-panel { margin-top: -44px; }
      .search-card { grid-template-columns: 1fr; }
      .search-card .btn { width: 100%; }
      .category-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
      .editorial-grid,
      .offers-grid,
      .showroom,
      .footer-grid { grid-template-columns: 1fr; }
      .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .contact-strip { align-items: stretch; flex-direction: column; }
      .floating-wa { bottom: 18px; }
    }

    @media (max-width: 560px) {
      .container { width: calc(100% - 24px); }
      .section { padding: 42px 0; }
      .section-head { display: block; margin-bottom: 18px; }
      .section-head .btn { width: 100%; margin-top: 14px; }
      .nav-container { width: calc(100% - 12px); }
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
      .hero { min-height: 560px; }
      .hero-grid { min-height: 560px; padding: 120px 0 78px; }
      .hero-actions .btn { width: 100%; }
      .hero-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
      .nota-hero-thumbs { gap: 8px; }
      .nota-hero-thumb { min-height: 96px; font-size: .82rem; }
      .hero-stat { padding: 11px; }
      .hero-stat strong { font-size: 1.1rem; }
      .hero-stat span { font-size: .76rem; }
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
      .product-media img { height: 240px; object-fit: contain; padding: 8px; }
      .product-actions { grid-template-columns: 1fr; }
      .info-row { grid-template-columns: 40px 1fr; padding: 14px; }
      .info-row i { width: 40px; height: 40px; }
      .contact-strip { padding: 22px; }
      .site-footer { padding-bottom: 100px; }
      .floating-wa { width: 50px; height: 50px; right: 14px; }
    }
  </style>
</head>
<body>
  @php
    $waNumber = '38344960661';

    $categories = [
      ['title' => 'Tepiha', 'title_en' => 'Rugs', 'title_sr' => 'Tepisi', 'desc' => 'Modele per sallon, dhome gjumi dhe korridor.', 'desc_en' => 'Models for living rooms, bedrooms and hallways.', 'desc_sr' => 'Modeli za dnevni boravak, spavacu sobu i hodnik.', 'url' => route('products.tepiha'), 'img' => asset('carpet/carpetmara.jpg')],
      ['title' => 'Perde online', 'title_en' => 'Curtains online', 'title_sr' => 'Zavese online', 'desc' => 'Perde ditore, anesore, bamboo dhe kumash.', 'desc_en' => 'Day, side, bamboo and fabric curtains.', 'desc_sr' => 'Dnevne, bocne, bamboo i platnene zavese.', 'url' => route('products.perde'), 'img' => asset('perdeditoree/perde.jpg')],
      ['title' => 'Perde anesore', 'title_en' => 'Side curtains', 'title_sr' => 'Bocne zavese', 'desc' => 'Pamje elegante dhe qepje profesionale.', 'desc_en' => 'Elegant look with professional tailoring.', 'desc_sr' => 'Elegantan izgled i profesionalno sivenje.', 'url' => route('products.anesore'), 'img' => asset('curtainn/SOFTPERDE.jpg')],
      ['title' => 'Perde ditore', 'title_en' => 'Day curtains', 'title_sr' => 'Dnevne zavese', 'desc' => 'Drite e bute dhe ambient me i paster.', 'desc_en' => 'Soft light and a cleaner room feeling.', 'desc_sr' => 'Meko svetlo i cistiji izgled prostora.', 'url' => route('products.perdeDitore'), 'img' => asset('perdeditoree/image00001.jpeg')],
      ['title' => 'Set çarçafësh', 'title_en' => 'Bedsheet sets', 'title_sr' => 'Set posteljine', 'desc' => 'Sete per gjume te rehatshem cdo nate.', 'desc_en' => 'Sets for comfortable sleep every night.', 'desc_sr' => 'Setovi za udoban san svake noci.', 'url' => route('products.postava'), 'img' => asset('postavav/beedsheet10.png')],
      ['title' => 'Lekure pelushi', 'title_en' => 'Plush fur', 'title_sr' => 'Plisano krzno', 'desc' => 'Posteqia dhe lekur pelusho per dekor.', 'desc_en' => 'Plush fur and soft decor pieces.', 'desc_sr' => 'Plisano krzno i meki dekor.', 'url' => route('products.posteqia'), 'img' => asset('posteqiaa/faux-1.jpg')],
      ['title' => 'Batanije online', 'title_en' => 'Blankets online', 'title_sr' => 'Cebad online', 'desc' => 'Qebe dhe batanije te ngrohta per shtepi.', 'desc_en' => 'Warm blankets for the home.', 'desc_sr' => 'Topla cebad za dom.', 'url' => route('products.batanije'), 'img' => asset('batanijee/IMG_7631.jpg')],
      ['title' => 'Mbulesa', 'title_en' => 'Covers', 'title_sr' => 'Prekrivaci', 'desc' => 'Per divan, krevat dhe dekor te perditeshem.', 'desc_en' => 'For sofas, beds and everyday decor.', 'desc_sr' => 'Za sofu, krevet i svakodnevni dekor.', 'url' => route('products.mbulesa'), 'img' => asset('mbulesaa/IMG_7526.jpg')],
      ['title' => 'Jasteke dekorues', 'title_en' => 'Decorative pillows', 'title_sr' => 'Dekorativni jastuci', 'desc' => 'Per divan, krevat, sallon dhe dekor.', 'desc_en' => 'For sofas, beds, living rooms and decor.', 'desc_sr' => 'Za sofu, krevet, dnevni boravak i dekor.', 'url' => route('products.jastekdekorues'), 'img' => asset('jastak/IMG_7959.jpg')],
      ['title' => 'Tepiha banjo', 'title_en' => 'Bath rugs', 'title_sr' => 'Kupatilski tepisi', 'desc' => 'Tapeta banjoje antirreshqitese.', 'desc_en' => 'Non-slip bathroom rugs.', 'desc_sr' => 'Neklizajuci tepisi za kupatilo.', 'url' => route('products.tepihebanjo'), 'img' => asset('tepihebanjoo/crop-template-print1-1120x1493.png')],
      ['title' => 'Garnishte', 'title_en' => 'Curtain rails', 'title_sr' => 'Garnisne', 'desc' => 'Aksesor per perde dhe montim me pamje te rregullt.', 'desc_en' => 'Curtain accessories for a clean installation.', 'desc_sr' => 'Dodaci za zavese i urednu montazu.', 'url' => route('products.garnishte'), 'img' => asset('images/garnishte.jpg')],
    ];

    $quickLinks = [
      ['label' => 'Tepiha modern', 'url' => route('products.tepiha'), 'icon' => 'bi-grid-3x3-gap'],
      ['label' => 'Perde online', 'url' => route('products.perde'), 'icon' => 'bi-columns-gap'],
      ['label' => 'Batanije online', 'url' => route('products.batanije'), 'icon' => 'bi-stars'],
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
            <button type="button" data-lang="sq" data-url="/lang/sq" class="{{ app()->getLocale() === 'sq' ? 'active' : '' }}">SQ</button>
            <button type="button" data-lang="en" data-url="/lang/en" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</button>
            <button type="button" data-lang="sr" data-url="/lang/sr" class="{{ app()->getLocale() === 'sr' ? 'active' : '' }}">SR</button>
          </div>
        </div>
      </nav>

      <div class="nav-actions">
        <div class="lang-switch" aria-label="Language switcher">
          <button type="button" data-lang="sq" data-url="/lang/sq" class="{{ app()->getLocale() === 'sq' ? 'active' : '' }}">SQ</button>
          <button type="button" data-lang="en" data-url="/lang/en" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</button>
          <button type="button" data-lang="sr" data-url="/lang/sr" class="{{ app()->getLocale() === 'sr' ? 'active' : '' }}">SR</button>
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
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-copy">
          <div class="eyebrow" data-sq="Koleksion i zgjedhur" data-en="Curated collection" data-sr="Odabrana kolekcija">Koleksion i zgjedhur</div>
          <h1 data-sq="Shtepia duket me bukur kur tekstili eshte i menduar mire." data-en="Your home looks better when textiles are chosen with care." data-sr="Dom izgleda lepse kada je tekstil pazljivo odabran.">Shtepia duket me bukur kur tekstili eshte <span>i menduar mire.</span></h1>
          <p data-sq="Brillant sjell tepiha, perde, Set çarçafësh, batanije dhe detaje dekoruese me pamje te paster, cilesi te mire dhe porosi te lehte." data-en="Brillant brings rugs, curtains, bedsheet sets, blankets and decor details with a clean look, good quality and easy ordering." data-sr="Brillant nudi tepihe, zavese, set posteljine, cebad i dekor sa urednim izgledom, dobrim kvalitetom i lakom porudzbinom.">Brillant sjell tepiha, perde, Set çarçafësh, batanije dhe detaje dekoruese me pamje te paster, cilesi te mire dhe porosi te lehte.</p>

          <div class="hero-stats" aria-label="Pikat kryesore">
            <div class="hero-stat"><strong>10</strong><span>Kategori per shtepi</span></div>
            <div class="hero-stat"><strong>24h</strong><span>Pergjigje e shpejte</span></div>
            <div class="hero-stat"><strong>1 vend</strong><span>Tepiha, perde, tekstil</span></div>
          </div>

          <div class="nota-hero-thumbs" aria-label="Kategorite kryesore">
            @foreach(array_slice($categories, 0, 4) as $category)
              <a class="nota-hero-thumb" href="{{ $category['url'] }}">
                <img src="{{ $category['img'] }}" alt="{{ $category['title'] }}" loading="eager" decoding="async">
                <span data-sq="{{ $category['title'] }}" data-en="{{ $category['title_en'] }}" data-sr="{{ $category['title_sr'] }}">{{ $category['title'] }}</span>
              </a>
            @endforeach
          </div>
        </div>

        <aside class="hero-card">
          <img src="{{ asset('optimized/home/side.jpg') }}" alt="Tepih Brillant" width="520" height="360">
          <div class="hero-card-body">
            <h2 data-sq="Koleksionet e reja" data-en="New collections" data-sr="Nove kolekcije">Koleksionet e reja</h2>
            <p data-sq="Shiko produktet e fundit ose dergo foto te ambientit per rekomandim me te sakte." data-en="View the latest products or send a room photo for a better recommendation." data-sr="Pogledaj najnovije proizvode ili posalji sliku prostora za bolju preporuku.">Shiko produktet e fundit ose dergo foto te ambientit per rekomandim me te sakte.</p>
            <a class="btn btn-primary" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Pershendetje! Dua rekomandim per shtepine time.') }}" target="_blank" rel="noopener">
              <i class="bi bi-whatsapp"></i> Pyet tani
            </a>
          </div>
        </aside>
      </div>
    </section>

    <section id="searchSection" class="search-panel">
      <div class="container">
        <form class="search-card" action="{{ route('search') }}" method="GET">
          <label class="search-field">
            <i class="bi bi-search"></i>
            <input name="q" type="search" placeholder="Kerko tepih, perde, Set çarçafësh, batanije..." autocomplete="off" data-placeholder-sq="Kerko tepih, perde, Set çarçafësh, batanije..." data-placeholder-en="Search rugs, curtains, bedsheet sets, blankets..." data-placeholder-sr="Pretrazi tepihe, zavese, set posteljine, cebad...">
          </label>
          <button class="btn btn-primary" type="submit" data-sq="Kerko" data-en="Search" data-sr="Pretrazi">Kerko</button>
          <a class="btn btn-whatsapp" href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Pershendetje! Po kerkoj nje produkt ne Brillant.') }}" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp"></i> Chat
          </a>
        </form>

        <div class="quick-links" aria-label="Kerkime te shpejta">
          @foreach($quickLinks as $link)
            <a href="{{ $link['url'] }}"><i class="bi {{ $link['icon'] }}"></i>{{ $link['label'] }}</a>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="section-head">
          <div>
            <div class="eyebrow" data-sq="Kategorite" data-en="Categories" data-sr="Kategorije">Kategorite</div>
            <h2>Kategoritë kryesore.</h2>
            <p>Te gjitha kategorite reale jane ketu: tepiha, perde, tekstil per dhome dhe aksesor.</p>
          </div>
          <a class="btn btn-outline" href="{{ route('products.index') }}" data-sq="Te gjitha produktet" data-en="All products" data-sr="Svi proizvodi">Te gjitha produktet</a>
        </div>

        <div class="category-grid">
          @foreach($categories as $category)
            <a class="category-card" href="{{ $category['url'] }}">
              <img src="{{ $category['img'] }}" alt="{{ $category['title'] }}" loading="lazy" decoding="async" width="560" height="420">
              <div class="category-card-body">
                <h3 data-sq="{{ $category['title'] }}" data-en="{{ $category['title_en'] }}" data-sr="{{ $category['title_sr'] }}">{{ $category['title'] }}</h3>
                <p data-sq="{{ $category['desc'] }}" data-en="{{ $category['desc_en'] }}" data-sr="{{ $category['desc_sr'] }}">{{ $category['desc'] }}</p>
              </div>
            </a>
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
            <p>Produktet e fundit jane vendosur si rekomandime, me foto, cmim, stock dhe veprime direkte.</p>
          </div>
          <a class="btn btn-outline" href="{{ route('products.index') }}">Shiko produktet</a>
        </div>

        @if($latestProducts->count())
          <div class="product-grid">
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
                  <img src="{{ $imgUrl }}" alt="{{ $item->name }}" loading="{{ $loop->iteration <= 3 ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->iteration <= 3 ? 'high' : 'auto' }}" decoding="async" sizes="(max-width: 576px) 100vw, (max-width: 992px) 50vw, 33vw" width="640" height="520" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
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
        @else
          <div class="seo-box">
            <h2>Produktet do te shfaqen se shpejti.</h2>
            <p>Per produktet aktuale, na shkruani ne WhatsApp dhe ju dergojme opsionet qe jane ne stock.</p>
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
          <h2>Brillant - tepiha, perde online, mbulesa dhe tekstil per shtepi</h2>
          <p>Brillant ofron tepiha moderne, perde online, batanije, set çarçafësh, mbulesa divani, tepiha banjo, jasteke dekorues, posteqia dhe lekur pelushi per shtepi. Qellimi eshte me e bo blerjen te lehte: kategori te qarta, foto te dukshme, produkte te fundit dhe kontakt direkt per cdo pyetje.</p>
          <p>
            Kerkime te shpeshta:
            <a href="{{ route('products.perde') }}">perde online</a>,
            <a href="{{ route('products.mbulesa') }}">mbulesa online</a>,
            <a href="{{ route('products.mbulesa') }}">mbulesa divani</a>,
            <a href="{{ route('products.postava') }}">set çarçafësh</a>,
            <a href="{{ route('products.batanije') }}">batanije online</a>,
            <a href="{{ route('products.jastekdekorues') }}">jastek dekorues</a>,
            <a href="{{ route('products.tepihebanjo') }}">tepiha banjo</a>,
            <a href="{{ route('products.posteqia') }}">lekur pelusho</a>.
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
          <a href="{{ route('products.perde') }}">Perde online</a>
          <a href="{{ route('products.anesore') }}">Perde anesore</a>
          <a href="{{ route('products.perdeDitore') }}">Perde ditore</a>
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

  <script>
    (function () {
      const menu = document.getElementById('mainMenu');
      const toggle = document.querySelector('.menu-toggle');
      const recommended = document.querySelector('.recommended-section');
      const benefits = document.querySelector('.removed-benefits');

      if (recommended && benefits && recommended.parentNode) {
        recommended.parentNode.insertBefore(benefits, recommended.nextSibling);
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

      const serverLang = '{{ app()->getLocale() }}';
      const savedLang = localStorage.getItem('brillant_lang');
      setLanguage(serverLang || savedLang || 'sq');
    })();
  </script>
</body>
</html>
