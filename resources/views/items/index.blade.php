<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Brillant – Tepiha & Perde në Lipjan | Porosit Online</title>

  <!-- ===================== SEO CORE ===================== -->
  <meta name="description" content="Brillant Lipjan: tepiha modern & klasik, perde anësore/ditore, set çarçafësh, mbulesa, batanije, garnishte, jastakë dekorues dhe tepiha për banjo. Porosit online – dërgesë në gjithë Kosovën." />
  <meta name="keywords" content="tepiha, perde, set çarçafesh, mbulesa, batanije, garnishte, jastak dekorues, tepiha banjo, lipjan, kosove, brillant, b-brillant" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
  <meta name="author" content="Brillant" />
  <meta name="theme-color" content="#dc3545" />

  <!-- Canonical -->
  <link rel="canonical" href="https://b-brillant.com/" />

  <!-- Hreflang (opsionale) -->
  <link rel="alternate" href="https://b-brillant.com/" hreflang="sq" />
  <link rel="alternate" href="https://b-brillant.com/" hreflang="x-default" />

  <!-- OpenGraph -->
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="sq_AL" />
  <meta property="og:site_name" content="Brillant" />
  <meta property="og:title" content="Brillant – Tepiha & Perde | Porosit Online" />
  <meta property="og:description" content="Tepiha, perde, set çarçafësh, mbulesa, batanije dhe dekorime për shtëpi. Shërbim profesional në Lipjan + dërgesë në gjithë Kosovën." />
  <meta property="og:url" content="https://b-brillant.com/" />
  <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Brillant – Tepiha & Perde | Porosit Online" />
  <meta name="twitter:description" content="Tepiha, perde, set çarçafësh, mbulesa, batanije dhe dekorime për shtëpi. Dërgesë në gjithë Kosovën." />
  <meta name="twitter:image" content="{{ asset('images/og-cover.jpg') }}" />

  <!-- Preconnect -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}" />

  <!-- ===================== JSON-LD (STRUCTURED DATA) ===================== -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Brillant",
    "url": "https://b-brillant.com/",
    "logo": "{{ asset('images/llogo.png') }}",
    "sameAs": [
      "https://www.instagram.com/"
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "Brillant Tepiha & Perde",
    "url": "https://b-brillant.com/",
    "image": "{{ asset('images/og-cover.jpg') }}",
    "logo": "{{ asset('images/llogo.png') }}",
    "telephone": "+38344960661",
    "priceRange": "€€",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Lipjan",
      "addressCountry": "XK"
    },
    "areaServed": "XK"
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

  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[
      { "@type":"ListItem","position":1,"name":"Home","item":"https://b-brillant.com/" }
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"FAQPage",
    "mainEntity":[
      {
        "@type":"Question",
        "name":"A bëni dërgesë në gjithë Kosovën?",
        "acceptedAnswer":{"@type":"Answer","text":"Po, dërgojmë në gjithë Kosovën. Për porosi na kontakto në WhatsApp ose përmes faqes."}
      },
      {
        "@type":"Question",
        "name":"A bëni matje dhe montim të perdeve?",
        "acceptedAnswer":{"@type":"Answer","text":"Po, ofrojmë matje në terren dhe montim profesional (sipas marrëveshjes)."}
      },
      {
        "@type":"Question",
        "name":"Sa kohë zgjat porosia?",
        "acceptedAnswer":{"@type":"Answer","text":"Zakonisht 1-3 ditë pune, varësisht lokacionit dhe stokut. Për detaje: WhatsApp."}
      }
    ]
  }
  </script>

  <!-- ===================== STYLE ===================== -->
  <style>
    :root{
      --bg: #f6f7fb;
      --text: #0b1220;
      --muted:#64748b;
      --brand:#dc3545;     /* red */
      --brand2:#ffc107;    /* gold */
      --dark:#0b1020;
      --card:#ffffff;
      --line: rgba(2,6,23,.08);
      --shadow: 0 18px 55px rgba(2,6,23,.12);
      --shadow2: 0 10px 26px rgba(2,6,23,.10);
      --ring: rgba(220,53,69,.20);
      --r16: 16px;
      --r20: 20px;
      --r28: 28px;
      --r36: 36px;
    }

    *{ box-sizing: border-box; }
    html,body{ height:100%; }
    body{
      margin:0;
      font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--text);
      background:
        radial-gradient(1200px 700px at 12% -10%, rgba(220,53,69,.14), transparent 55%),
        radial-gradient(900px 500px at 92% 0%, rgba(255,193,7,.10), transparent 55%),
        var(--bg);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: optimizeLegibility;
    }

    a{ text-decoration:none; }
    img{ max-width:100%; height:auto; }
    .container{ max-width: 1180px; }

    /* ===== Utilities ===== */
    .pill{ border-radius: 999px !important; }
    .soft-card{
      background: rgba(255,255,255,.82);
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      border-radius: var(--r28);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .btn-brand{
      background: var(--brand);
      border-color: var(--brand);
      color:#fff;
      font-weight: 900;
      box-shadow: 0 14px 34px rgba(220,53,69,.22);
    }
    .btn-brand:hover{
      filter: brightness(.98);
      color:#fff;
      box-shadow: 0 18px 44px rgba(220,53,69,.28);
    }

    /* ===== Announcement strip (NEW) ===== */
    .announce{
      background: linear-gradient(90deg, rgba(220,53,69,.12), rgba(255,193,7,.12));
      border-bottom: 1px solid var(--line);
    }
    .announce .wrap{
      display:flex;
      gap: 10px;
      align-items:center;
      justify-content:center;
      padding: 10px 0;
      font-size: 14px;
      color: rgba(11,18,32,.85);
      font-weight: 600;
      flex-wrap: wrap;
      text-align:center;
    }
    .announce .wrap b{ color: var(--brand); }
    .announce .badge{
      border: 1px solid rgba(220,53,69,.25);
      background: rgba(220,53,69,.12);
      color: var(--brand);
      font-weight: 900;
    }

    /* ===== Navbar (NEW DIFFERENT LOOK) ===== */
    .navbar-custom{
      position: sticky;
      top:0;
      z-index: 1000;
      padding: .65rem 0;
      background: rgba(11,16,32,.86);
      border-bottom: 1px solid rgba(255,255,255,.10);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }
    .navbar-custom .navbar-brand{
      display:flex; align-items:center; gap:10px;
    }
    .navbar-custom .navbar-brand img{
      height: 42px;
      filter: drop-shadow(0 10px 18px rgba(0,0,0,.22));
    }
    .brand-mini{
      display:flex; flex-direction:column; line-height: 1.1;
    }
    .brand-mini strong{ color:#fff; font-weight: 900; letter-spacing:.02em; }
    .brand-mini span{ color: rgba(255,255,255,.72); font-size: 12px; font-weight: 600; }

    .navbar-custom .nav-link{
      color: rgba(248,250,252,.92) !important;
      font-weight: 700;
      font-size: .93rem;
      padding: .55rem .80rem;
      border-radius: 999px;
      transition: transform .18s ease, background .18s ease;
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
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu{
      border: 1px solid rgba(2,6,23,.10);
      border-radius: 18px;
      box-shadow: 0 22px 70px rgba(2,6,23,.22);
      padding: .65rem;
    }
    .dropdown-item{
      border-radius: 12px;
      padding: .60rem .80rem;
      font-weight: 700;
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
      min-width: 220px;
      border-radius: 16px;
    }
    .dropdown-submenu:hover .submenu{ display:block; }

    .nav-cta{
      display:flex; align-items:center; gap:10px;
    }
    .nav-mini-btn{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding: .50rem .90rem;
      border-radius: 999px;
      border: 1px solid rgba(255,255,255,.18);
      background: rgba(255,255,255,.08);
      color:#fff;
      font-weight: 900;
      transition: all .18s ease;
      white-space: nowrap;
    }
    .nav-mini-btn:hover{
      background: rgba(255,255,255,.12);
      color:#fff;
      transform: translateY(-1px);
    }
    .nav-mini-btn .dot{
      width: 8px; height: 8px; border-radius: 999px;
      background: var(--brand2);
      box-shadow: 0 0 0 4px rgba(255,193,7,.18);
    }

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
      .brand-mini{ display:none; }
      .nav-cta{ margin-top: 10px; justify-content: flex-start; flex-wrap: wrap; }
    }

    /* ===== Topbar (NEW layout) ===== */
    .topbar{ margin-top: 14px; }
    .topbar-inner{
      padding: 14px;
      border-radius: var(--r28);
      background: rgba(255,255,255,.86);
      border: 1px solid var(--line);
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
      font-weight: 900;
      color: #0b1220;
      transition: all .18s ease;
      font-size: 14px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .chip:hover{
      background: rgba(220,53,69,.10);
      color: var(--brand);
      transform: translateY(-1px);
    }

    .search-pro{ position: relative; }
    .search-pro input{
      height: 54px;
      border-radius: 999px;
      padding-left: 48px;
      padding-right: 132px;
      border: 1px solid rgba(2,6,23,.10);
      box-shadow: 0 12px 30px rgba(2,6,23,.08);
      outline:none;
    }
    .search-pro input:focus{
      border-color: rgba(220,53,69,.45);
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
    .wa-btn:hover{
      filter: brightness(.98);
      color:#fff;
      box-shadow: 0 18px 44px rgba(22,163,74,.22);
    }

    /* ===== Hero (COMPLET NDYSHE) ===== */
    .hero{
      margin-top: 14px;
      border-radius: var(--r36);
      overflow: hidden;
      position: relative;
      box-shadow: 0 32px 100px rgba(2,6,23,.22);
      background: linear-gradient(180deg, rgba(11,16,32,.95), rgba(2,6,23,.92));
      color:#fff;
    }

    .hero-grid{
      position: relative;
      z-index: 2;
      display:grid;
      grid-template-columns: 1.25fr .75fr;
      gap: 18px;
      padding: 20px;
      align-items: stretch;
    }

    .hero-left{
      border-radius: 30px;
      overflow: hidden;
      position: relative;
      min-height: 420px;
      display:flex;
      flex-direction: column;
      justify-content: center;
      padding: 34px;
      background:
        radial-gradient(900px 500px at 18% 24%, rgba(255,193,7,.18), transparent 60%),
        radial-gradient(900px 500px at 82% 40%, rgba(220,53,69,.22), transparent 65%),
        linear-gradient(90deg, rgba(2,6,23,.80), rgba(2,6,23,.45));
    }

    .hero-left::before{
      content:"";
      position:absolute;
      inset:0;
      background: url('{{ asset('slider/foto1.jpg') }}') center/cover no-repeat;
      filter: brightness(.45) saturate(1.08);
      transform: scale(1.03);
      z-index: -1;
    }

    .hero-badge{
      display:inline-flex;
      align-items:center;
      gap:10px;
      width: fit-content;
      padding: .42rem .95rem;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.16);
      font-size: .82rem;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-weight: 900;
    }
    .hero-badge .tag{
      background: var(--brand2);
      color: #111;
      padding: .14rem .62rem;
      border-radius: 999px;
      font-weight: 900;
      letter-spacing: .10em;
    }

    .hero-title{
      margin-top: 14px;
      font-weight: 900;
      line-height: 1.06;
      font-size: clamp(2.05rem, 4.4vw, 3.55rem);
      max-width: 700px;
    }
    .hero-title em{
      font-style: normal;
      color: var(--brand2);
      text-shadow: 0 18px 40px rgba(255,193,7,.12);
    }

    .hero-sub{
      margin-top: 14px;
      max-width: 640px;
      color: rgba(248,250,252,.92);
      line-height: 1.75;
      font-size: 1.03rem;
    }

    .hero-actions{
      margin-top: 18px;
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .hero-actions .btn{
      border-radius: 999px;
      padding: .80rem 1.35rem;
      font-weight: 900;
      display:inline-flex;
      align-items:center;
      gap:10px;
    }

    .hero-trust{
      margin-top: 16px;
      display:flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .trust-chip{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      padding: .62rem .85rem;
      border-radius: 16px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.14);
      font-weight: 800;
      color: rgba(248,250,252,.95);
      font-size: .92rem;
    }
    .trust-chip i{ color: var(--brand2); }

    /* Right side hero cards */
    .hero-right{
      display:flex;
      flex-direction: column;
      gap: 14px;
    }

    .promo-card{
      background: rgba(255,255,255,.92);
      border: 1px solid rgba(255,255,255,.16);
      border-radius: 26px;
      overflow:hidden;
      box-shadow: 0 18px 55px rgba(2,6,23,.24);
      color: #0b1220;
    }
    .promo-card .head{
      padding: 14px 16px 10px;
      display:flex;
      align-items:flex-start;
      justify-content: space-between;
      gap: 10px;
    }
    .promo-card .head .k{
      font-weight: 900;
      letter-spacing: .14em;
      text-transform: uppercase;
      font-size: 12px;
      color: rgba(2,6,23,.62);
    }
    .promo-card .head h5{
      margin: 2px 0 0;
      font-weight: 900;
      color: #0f172a;
    }
    .promo-card .head .mini{
      width: 46px; height: 46px;
      border-radius: 16px;
      background: rgba(220,53,69,.12);
      display:flex;
      align-items:center;
      justify-content:center;
      color: var(--brand);
      font-size: 20px;
      flex-shrink:0;
    }

    .promo-item{
      border-top: 1px solid rgba(2,6,23,.06);
      padding: 12px 16px;
      display:flex;
      gap: 12px;
      align-items:center;
    }
    .promo-item img{
      width: 92px;
      height: 92px;
      object-fit: cover;
      border-radius: 18px;
      box-shadow: 0 12px 26px rgba(2,6,23,.12);
      flex-shrink:0;
    }
    .promo-item .badge{
      border: 1px solid rgba(220,53,69,.20);
      background: rgba(220,53,69,.10);
      color: var(--brand);
      font-weight: 900;
    }
    .promo-item .name{ font-weight: 900; }
    .promo-item .desc{ font-size: 13px; color: rgba(2,6,23,.64); }
    .price{ font-weight: 900; color: var(--brand); }
    .old{ color: rgba(2,6,23,.45); text-decoration: line-through; font-size: 13px; }

    .hero-mini{
      border-radius: 26px;
      padding: 16px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.14);
      color: rgba(248,250,252,.95);
    }
    .hero-mini h6{ margin:0 0 6px; font-weight: 900; }
    .hero-mini p{ margin:0; color: rgba(248,250,252,.82); font-size: 14px; line-height: 1.55; }

    /* ===== Sections ===== */
    .section-pad{ padding: 3.8rem 0; }
    .section-title{
      text-align:center;
      margin-bottom: 2.2rem;
    }
    .section-title .k{
      display:inline-block;
      font-size: 12px;
      font-weight: 900;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--brand);
      background: rgba(220,53,69,.08);
      border: 1px solid rgba(220,53,69,.14);
      padding: .40rem .90rem;
      border-radius: 999px;
    }
    .section-title h2{
      margin-top: .90rem;
      font-weight: 900;
      color: #0f172a;
      letter-spacing: -.01em;
    }
    .section-title p{
      margin: .55rem auto 0;
      max-width: 760px;
      color: var(--muted);
      line-height: 1.7;
    }

    /* ===== Categories (NEW mega cards) ===== */
    .cat-card{
      height:100%;
      border-radius: 26px;
      background:#fff;
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
      overflow:hidden;
      transition: transform .20s ease, box-shadow .20s ease;
      position: relative;
    }
    .cat-card:hover{
      transform: translateY(-7px);
      box-shadow: 0 28px 80px rgba(2,6,23,.16);
    }
    .cat-media{
      position:relative;
      overflow:hidden;
      height: 220px;
      background: #f3f4f6;
    }
    .cat-media img{
      width:100%;
      height:100%;
      object-fit: cover;
      transition: transform .55s ease;
    }
    .cat-card:hover .cat-media img{
      transform: scale(1.08);
    }
    .cat-overlay{
      position:absolute;
      inset:0;
      background: linear-gradient(180deg, rgba(2,6,23,0) 40%, rgba(2,6,23,.55));
      pointer-events:none;
    }
    .cat-badge{
      position:absolute;
      top: 12px;
      left: 12px;
      background: rgba(11,16,32,.82);
      color:#fff;
      padding: .30rem .82rem;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 900;
      letter-spacing:.08em;
      text-transform: uppercase;
      border: 1px solid rgba(255,255,255,.16);
    }
    .cat-body{
      padding: 16px 16px 18px;
    }
    .cat-body h5{
      font-weight: 900;
      margin: 0 0 6px;
    }
    .cat-body p{
      color: var(--muted);
      font-size: 14px;
      line-height: 1.6;
      margin: 0 0 12px;
    }
    .cat-actions{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 10px;
    }
    .cat-link{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      color: var(--brand);
      font-weight: 900;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-size: 12px;
    }
    .mini-pills{
      display:flex;
      gap: 6px;
      flex-wrap: wrap;
      justify-content:flex-end;
    }
    .mini-pill{
      font-size: 11px;
      font-weight: 800;
      color: rgba(2,6,23,.72);
      background: rgba(2,6,23,.04);
      border: 1px solid rgba(2,6,23,.06);
      padding: 4px 8px;
      border-radius: 999px;
    }

    /* ===== Best sellers slider (NEW) ===== */
    .shelf{
      border-radius: var(--r28);
      background: rgba(255,255,255,.84);
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      padding: 14px;
    }
    .shelf-head{
      display:flex;
      align-items:end;
      justify-content: space-between;
      gap: 14px;
      padding: 8px 6px 12px;
    }
    .shelf-head h3{
      margin:0;
      font-weight: 900;
      letter-spacing: -.01em;
    }
    .shelf-head .sub{
      margin:4px 0 0;
      color: var(--muted);
      font-size: 14px;
    }

    .product-card{
      height:100%;
      border-radius: 22px;
      overflow:hidden;
      background:#fff;
      border: 1px solid rgba(2,6,23,.06);
      box-shadow: var(--shadow2);
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-card:hover{
      transform: translateY(-6px);
      box-shadow: 0 26px 75px rgba(2,6,23,.16);
    }
    .product-media{
      position: relative;
      height: 240px;
      background: #f3f4f6;
    }
    .product-media img{
      width:100%;
      height:100%;
      object-fit: cover;
    }
    .product-flags{
      position:absolute;
      top: 10px;
      left: 10px;
      display:flex;
      gap: 8px;
      flex-wrap: wrap;
    }
    .flag{
      font-size: 11px;
      font-weight: 900;
      letter-spacing:.06em;
      text-transform: uppercase;
      padding: 6px 10px;
      border-radius: 999px;
      background: rgba(11,16,32,.82);
      color:#fff;
      border: 1px solid rgba(255,255,255,.14);
    }
    .flag.hot{
      background: rgba(220,53,69,.92);
      border-color: rgba(220,53,69,.10);
    }
    .flag.new{
      background: rgba(255,193,7,.92);
      color:#111;
      border-color: rgba(255,193,7,.18);
    }
    .product-body{
      padding: 14px 14px 16px;
    }
    .product-body h6{
      margin:0 0 6px;
      font-weight: 900;
      color: #0f172a;
    }
    .product-body p{
      margin:0 0 10px;
      color: var(--muted);
      font-size: 13px;
      line-height: 1.55;
    }
    .product-meta{
      display:flex;
      align-items:center;
      justify-content: space-between;
      gap: 10px;
    }
    .product-meta .price{
      font-weight: 900;
      color: var(--brand);
    }
    .product-meta .cta{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      padding: 8px 12px;
      border-radius: 999px;
      border: 1px solid rgba(2,6,23,.10);
      background: rgba(2,6,23,.02);
      font-weight: 900;
      color: #0f172a;
      font-size: 13px;
    }
    .product-meta .cta:hover{
      background: rgba(220,53,69,.08);
      border-color: rgba(220,53,69,.18);
      color: var(--brand);
    }

    /* ===== Service strip (NEW) ===== */
    .service-strip{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 12px;
    }
    .service{
      border-radius: 22px;
      background: rgba(255,255,255,.82);
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      padding: 14px;
      display:flex;
      gap: 12px;
      align-items:flex-start;
    }
    .service .icon{
      width: 46px;
      height: 46px;
      border-radius: 18px;
      display:flex;
      align-items:center;
      justify-content:center;
      background: rgba(220,53,69,.10);
      color: var(--brand);
      font-size: 20px;
      flex-shrink:0;
    }
    .service h6{ margin:0 0 4px; font-weight: 900; }
    .service p{ margin:0; color: var(--muted); font-size: 13px; line-height: 1.55; }

    /* ===== Before/After (NEW section) ===== */
    .ba{
      border-radius: var(--r28);
      overflow:hidden;
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      background: rgba(255,255,255,.86);
    }
    .ba .left{
      padding: 22px;
      background: linear-gradient(135deg, rgba(220,53,69,.10), rgba(255,193,7,.10));
    }
    .ba .left h3{ margin:0 0 8px; font-weight: 900; }
    .ba .left p{ margin:0; color: rgba(2,6,23,.72); line-height: 1.7; }
    .ba .right{
      padding: 18px;
    }
    .ba-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .ba-shot{
      border-radius: 20px;
      overflow:hidden;
      position: relative;
      height: 230px;
      border: 1px solid rgba(2,6,23,.08);
      background:#f3f4f6;
    }
    .ba-shot img{
      width:100%;
      height:100%;
      object-fit: cover;
    }
    .ba-label{
      position:absolute;
      top: 10px;
      left: 10px;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 900;
      letter-spacing:.08em;
      text-transform: uppercase;
      background: rgba(11,16,32,.82);
      color:#fff;
      border: 1px solid rgba(255,255,255,.16);
    }

    /* ===== Testimonials ===== */
    .testi{
      border-radius: 26px;
      background: rgba(255,255,255,.86);
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      padding: 16px;
      height:100%;
    }
    .testi .stars{ color: var(--brand2); }
    .testi p{ color: rgba(2,6,23,.75); line-height: 1.7; margin: 10px 0 0; }
    .testi .who{
      display:flex; gap: 10px; align-items:center; margin-top: 12px;
    }
    .avatar{
      width: 42px; height: 42px; border-radius: 16px;
      background: rgba(220,53,69,.10);
      border: 1px solid rgba(220,53,69,.16);
      display:flex; align-items:center; justify-content:center;
      color: var(--brand);
      font-weight: 900;
    }
    .who b{ display:block; font-weight: 900; }
    .who span{ display:block; font-size: 12px; color: var(--muted); }

    /* ===== FAQ ===== */
    .accordion .accordion-item{
      border: 1px solid var(--line);
      border-radius: 18px;
      overflow:hidden;
      margin-bottom: 10px;
      background: rgba(255,255,255,.90);
      box-shadow: 0 10px 26px rgba(2,6,23,.06);
    }
    .accordion-button{
      font-weight: 900;
      padding: 14px 16px;
    }
    .accordion-button:focus{
      box-shadow: 0 0 0 6px var(--ring);
    }
    .accordion-body{
      color: rgba(2,6,23,.72);
      line-height: 1.7;
    }

    /* ===== Instagram grid ===== */
    .ig-grid{
      display:grid;
      grid-template-columns: repeat(6, minmax(0, 1fr));
      gap: 10px;
    }
    .ig{
      border-radius: 18px;
      overflow:hidden;
      position: relative;
      height: 140px;
      background: #f3f4f6;
      border: 1px solid rgba(2,6,23,.08);
    }
    .ig img{
      width:100%;
      height:100%;
      object-fit: cover;
      transition: transform .35s ease;
    }
    .ig:hover img{ transform: scale(1.06); }
    .ig::after{
      content:"";
      position:absolute;
      inset:0;
      background: linear-gradient(180deg, rgba(2,6,23,0) 50%, rgba(2,6,23,.50));
      opacity:.0;
      transition: opacity .2s ease;
    }
    .ig:hover::after{ opacity: 1; }
    .ig span{
      position:absolute;
      left: 10px;
      bottom: 10px;
      color:#fff;
      font-weight: 900;
      font-size: 12px;
      letter-spacing:.08em;
      text-transform: uppercase;
      opacity: 0;
      transition: opacity .2s ease;
      z-index: 2;
    }
    .ig:hover span{ opacity: 1; }

    /* ===== Newsletter ===== */
    .newsletter{
      border-radius: 28px;
      background: linear-gradient(135deg, rgba(220,53,69,.10), rgba(255,193,7,.10));
      border: 1px solid var(--line);
      box-shadow: var(--shadow2);
      padding: 1.8rem;
    }
    .newsletter h3{ font-weight: 900; margin:0; }
    .newsletter p{ color: var(--muted); margin:.40rem 0 1rem; line-height: 1.7; }
    .newsletter .form-control{
      height: 52px;
      border-radius: 999px;
      border: 1px solid rgba(2,6,23,.10);
    }

    /* ===== SEO text ===== */
    .seo-text{
      font-size: .98rem;
      line-height: 1.85;
      color: rgba(2,6,23,.78);
      background: rgba(255,255,255,.86);
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 1.6rem;
      box-shadow: var(--shadow2);
    }
    .seo-text h2{ font-weight: 900; margin-bottom: .85rem; }

    /* ===== Footer ===== */
    footer{
      font-size:.92rem;
      background: rgba(255,255,255,.84) !important;
      border-top: 1px solid var(--line) !important;
      backdrop-filter: blur(12px);
    }

    /* ===== Floating buttons (Desktop) ===== */
    .float-actions{
      position: fixed;
      right: 16px;
      bottom: 16px;
      z-index: 1200;
      display:flex;
      flex-direction: column;
      gap: 10px;
    }
    .fab{
      width: 52px;
      height: 52px;
      border-radius: 18px;
      display:flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-size: 20px;
      box-shadow: 0 18px 45px rgba(2,6,23,.22);
      border: 1px solid rgba(255,255,255,.18);
      backdrop-filter: blur(10px);
    }
    .fab.wa{ background: #16a34a; }
    .fab.up{ background: rgba(11,16,32,.92); }
    .fab:hover{ filter: brightness(.98); transform: translateY(-1px); }

    /* ===== Mobile bottom bar (NEW) ===== */
    .mobile-bar{
      display:none;
      position: fixed;
      left: 12px;
      right: 12px;
      bottom: 12px;
      z-index: 1300;
      background: rgba(11,16,32,.92);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 18px;
      padding: 10px;
      backdrop-filter: blur(14px);
      box-shadow: 0 18px 45px rgba(2,6,23,.22);
      gap: 10px;
    }
    .mobile-bar a{
      flex:1;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      padding: 12px 10px;
      border-radius: 14px;
      font-weight: 900;
      color:#fff;
      white-space: nowrap;
    }
    .mobile-bar a.call{ background: rgba(255,255,255,.10); }
    .mobile-bar a.wa{ background: #16a34a; }
    .mobile-bar a.cart{ background: rgba(220,53,69,.92); }

    /* ===== Responsive ===== */
    @media (max-width: 1200px){
      .hero-left{ min-height: 410px; }
    }
    @media (max-width: 992px){
      .hero-grid{
        grid-template-columns: 1fr;
        padding: 14px;
      }
      .hero-left{ padding: 26px; min-height: 420px; }
      .ig-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); }
      .service-strip{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 768px){
      body{ padding-bottom: 92px; } /* space for mobile bar */
      .mobile-bar{ display:flex; }
      .float-actions{ display:none; }
      .hero-actions .btn{ width: 100%; justify-content:center; }
      .ba-grid{ grid-template-columns: 1fr; }
      .chips{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .section-pad{ padding: 3.2rem 0; }
      .search-pro input{ padding-right: 118px; }
    }
    @media (max-width: 420px){
      .chips{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .ig{ height: 120px; }
    }
  </style>
</head>

<body id="top">

  <!-- ===================== ANNOUNCEMENT STRIP ===================== -->
  <div class="announce">
    <div class="container">
      <div class="wrap">
        <span class="badge rounded-pill">OFERTË</span>
        <span>Porosit sot: <b>Dërgesë në gjithë Kosovën</b> · Matje & montim për perde · Pagesë e sigurt</span>
        <span class="d-inline-flex align-items-center gap-2">
          <i class="bi bi-whatsapp text-success"></i>
          <span>+383 44 960 661</span>
        </span>
      </div>
    </div>
  </div>

  <!-- ===================== NAVBAR ===================== -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Main navigation">
    <div class="container">
      <a class="navbar-brand" href="/" aria-label="Brillant Home">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant Logo" />
        <div class="brand-mini">
          <strong>Brillant</strong>
          <span>Tepiha & Perde · Lipjan</span>
        </div>
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

              <li><a class="dropdown-item" href="/jastekdekorues">Jastak Dekorues</a></li>
              <li><a class="dropdown-item" href="/postava">Set çarçafësh</a></li>
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
              <a href="{{ route('login') }}" class="nav-mini-btn"><span class="dot"></span> Log in</a>
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

            <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="cartDropdown" style="min-width: 330px;">
              <div class="small text-muted mb-2">Gjurmo porosinë</div>

              <form class="d-flex align-items-stretch gap-2"
                    onsubmit="event.preventDefault();
                              const el=this.querySelector('#trackCodeNav');
                              const v=(el?.value||'').trim();
                              if(v){ window.location='{{ url('/track') }}/'+encodeURIComponent(v); }">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input id="trackCodeNav" type="text" class="form-control"
                         placeholder="p.sh. BRL-LKNJ-0YXN" autocomplete="off" required />
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

        <div class="nav-cta ms-lg-2">
          <a class="nav-mini-btn" href="https://wa.me/38344960661" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===================== TOPBAR ===================== -->
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
            <a class="chip" href="/postava"><i class="bi bi-bag-check"></i> Set çarçafësh</a>
          </div>
        </div>

        <div class="col-lg-5">
          <form action="{{ route('search') }}" method="GET" class="search-pro" role="search" aria-label="Kërko produkte">
            <i class="bi bi-search icon"></i>
            <input type="text" name="q" class="form-control"
                   placeholder="Kërko produktin (p.sh. tepiha 150x230, perde ditore...)"
                   value="{{ request('q') }}" required />
            <button class="btn btn-brand" type="submit">Kërko</button>
          </form>
          <div class="mt-2 small text-muted">
            Popullore:
            <a class="text-danger fw-bold" href="/tepiha">Tepiha</a> ·
            <a class="text-danger fw-bold" href="/anesore">Perde</a> ·
            <a class="text-danger fw-bold" href="/postava">Set çarçafësh</a>
          </div>
        </div>

        <div class="col-lg-3 text-lg-end">
          <a href="https://wa.me/38344960661" target="_blank" rel="noopener"
             class="wa-btn d-inline-flex align-items-center gap-2">
            <i class="bi bi-whatsapp"></i> Chat në WhatsApp
          </a>
          <div class="small text-muted mt-2">
            Për porosi / matje: <span class="fw-bold">+383 44 960 661</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== HERO (NEW) ===================== -->
  <section class="container mt-3">
    <div class="hero">
      <div class="hero-grid">

        <!-- LEFT -->
        <div class="hero-left">
          <div class="hero-badge">
            <span class="tag">NEW</span>
            Koleksion i ri · premium · modern
          </div>

          <h1 class="hero-title">
            Brillant: Tepiha & Perde <em>që e ndryshojnë</em> krejt ambientin.
          </h1>

          <p class="hero-sub">
            Zgjidh modelet ma të kërkume për sallon, dhomë gjumi, korridor dhe banjo.
            Cilësi e lartë, dizajn i pastër dhe shërbim profesional në Lipjan.
          </p>

          <div class="hero-actions">
            <a href="/tepiha" class="btn btn-brand">
              <i class="bi bi-grid"></i> Shiko TEPiHAT
            </a>
            <a href="/anesore" class="btn btn-outline-light">
              <i class="bi bi-layout-text-window"></i> Shiko PERDET
            </a>
            <a href="{{ route('contact') }}" class="btn btn-light">
              <i class="bi bi-geo-alt"></i> Na gjej në Lipjan
            </a>
          </div>

          <div class="hero-trust">
            <div class="trust-chip"><i class="bi bi-check-circle-fill"></i> Dërgesë në gjithë Kosovën</div>
            <div class="trust-chip"><i class="bi bi-shield-check"></i> Cilësi & garanci</div>
            <div class="trust-chip"><i class="bi bi-scissors"></i> Qepje & montim profesional</div>
            <div class="trust-chip"><i class="bi bi-star-fill"></i> Klientë të kënaqur</div>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="hero-right">

          <div class="promo-card">
            <div class="head">
              <div>
                <div class="k">OFERTA</div>
                <h5>Oferta e javës</h5>
              </div>
              <div class="mini"><i class="bi bi-fire"></i></div>
            </div>

            <div id="weeklyOffersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5200">
              <div class="carousel-inner">

                <div class="carousel-item active">
                  <div class="promo-item">
                    <img loading="lazy" src="{{ asset('slider/side.bmp') }}" alt="Tepiha Modern 150x230" />
                    <div class="flex-grow-1">
                      <span class="badge rounded-pill mb-2">Tepiha</span>
                      <div class="name">Tepiha Modern 150x230 cm</div>
                      <div class="desc">Antibakterial, akrilik, lehtë për pastrim.</div>
                      <div class="d-flex gap-2 align-items-baseline mt-2">
                        <span class="price">€75.00</span>
                        <span class="old">€95.00</span>
                      </div>
                      <a href="/tepiha" class="d-inline-flex align-items-center gap-2 mt-2 text-danger fw-bold small">
                        Shiko tepihat <i class="bi bi-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="carousel-item">
                  <div class="promo-item">
                    <img loading="lazy" src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha Hali 200x300" />
                    <div class="flex-grow-1">
                      <span class="badge rounded-pill mb-2">Tepiha</span>
                      <div class="name">Tepiha Hali 200x300 cm</div>
                      <div class="desc">Rezistente, fibra cilësore për sallon.</div>
                      <div class="d-flex gap-2 align-items-baseline mt-2">
                        <span class="price">€95.00</span>
                        <span class="old">€120.00</span>
                      </div>
                      <a href="/tepiha" class="d-inline-flex align-items-center gap-2 mt-2 text-danger fw-bold small">
                        Shiko modelet <i class="bi bi-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="carousel-item">
                  <div class="promo-item">
                    <img loading="lazy" src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh pambuk" />
                    <div class="flex-grow-1">
                      <span class="badge rounded-pill mb-2" style="background:rgba(255,193,7,.25); color:#6b4e00; border:1px solid rgba(255,193,7,.35)">Set çarçafësh</span>
                      <div class="name">Set çarçafësh pambuk</div>
                      <div class="desc">I butë, ngjyra nuk zbehen, i përditshëm.</div>
                      <div class="d-flex gap-2 align-items-baseline mt-2">
                        <span class="price">€25.00</span>
                        <span class="old">€59.00</span>
                      </div>
                      <a href="/postava" class="d-inline-flex align-items-center gap-2 mt-2 text-danger fw-bold small">
                        Shiko setet <i class="bi bi-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>

              </div>

              <button class="carousel-control-prev" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>

            <div class="p-3 pt-2">
              <a href="/tepiha" class="btn btn-outline-dark w-100 pill btn-sm">Shiko ofertat</a>
            </div>
          </div>

          <div class="hero-mini">
            <h6><i class="bi bi-lightning-charge-fill text-warning me-1"></i> Porosi e shpejtë</h6>
            <p>
              Na shkruaj në WhatsApp për stok, çmime dhe këshillim për modelin.
              Për perde: matje + qepje + montim.
            </p>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- ===================== MAIN ===================== -->
  <main class="section-pad">
    <div class="container">

      <!-- ===== Service strip ===== -->
      <section class="mb-5">
        <div class="service-strip">
          <div class="service">
            <div class="icon"><i class="bi bi-truck"></i></div>
            <div>
              <h6>Dërgesë në Kosovë</h6>
              <p>Porosi e sigurt & e shpejtë në gjithë Kosovën.</p>
            </div>
          </div>
          <div class="service">
            <div class="icon"><i class="bi bi-rulers"></i></div>
            <div>
              <h6>Matje në terren</h6>
              <p>Matje për perde, këshillim për përshtatje perfekte.</p>
            </div>
          </div>
          <div class="service">
            <div class="icon"><i class="bi bi-patch-check"></i></div>
            <div>
              <h6>Cilësi e garantuar</h6>
              <p>Materiale cilësore me jetëgjatësi & pamje premium.</p>
            </div>
          </div>
          <div class="service">
            <div class="icon"><i class="bi bi-headset"></i></div>
            <div>
              <h6>Support në WhatsApp</h6>
              <p>Përgjigje brenda ditës për porosi & pyetje.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== Categories ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">KATEGORITË</span>
          <h2>Zgjidh çka po t’duhet sot</h2>
          <p>Prej tepihave e perdeve deri te setet e shtratit — të gjitha në një vend, me pamje premium.</p>
        </div>

        <div class="row g-4">
          <div class="col-md-3 col-sm-6">
            <a href="/tepiha" class="text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img loading="lazy" src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha Brillant" />
                  <div class="cat-overlay"></div>
                  <span class="cat-badge">Tepiha</span>
                </div>
                <div class="cat-body">
                  <h5>Tepiha modern & klasik</h5>
                  <p>Modele për sallon, korridor, dhoma fëmijësh dhe banjo.</p>
                  <div class="cat-actions">
                    <span class="cat-link">Shiko <i class="bi bi-arrow-right"></i></span>
                    <div class="mini-pills">
                      <span class="mini-pill">150x230</span>
                      <span class="mini-pill">200x300</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/anesore" class="text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img loading="lazy" src="{{ asset('slider/raffaello.jpg') }}" alt="Perde Brillant" />
                  <div class="cat-overlay"></div>
                  <span class="cat-badge">Perde</span>
                </div>
                <div class="cat-body">
                  <h5>Perde anësore & ditore</h5>
                  <p>Sisteme amerikane, dizajn modern dhe qepje profesionale.</p>
                  <div class="cat-actions">
                    <span class="cat-link">Shiko <i class="bi bi-arrow-right"></i></span>
                    <div class="mini-pills">
                      <span class="mini-pill">Ditore</span>
                      <span class="mini-pill">Anësore</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/postava" class="text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img loading="lazy" src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh Brillant" />
                  <div class="cat-overlay"></div>
                  <span class="cat-badge">Shtrat</span>
                </div>
                <div class="cat-body">
                  <h5>Set çarçafësh & kompleta</h5>
                  <p>Pambuk & material premium, komfort i përditshëm.</p>
                  <div class="cat-actions">
                    <span class="cat-link">Shiko <i class="bi bi-arrow-right"></i></span>
                    <div class="mini-pills">
                      <span class="mini-pill">2+1</span>
                      <span class="mini-pill">King</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/mbulesa" class="text-dark">
              <div class="cat-card">
                <div class="cat-media">
                  <img loading="lazy" src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa & batanije Brillant" />
                  <div class="cat-overlay"></div>
                  <span class="cat-badge">Komfor</span>
                </div>
                <div class="cat-body">
                  <h5>Mbulesa & batanije</h5>
                  <p>Ngrohtësi, stil dhe materiale që zgjasin gjatë.</p>
                  <div class="cat-actions">
                    <span class="cat-link">Shiko <i class="bi bi-arrow-right"></i></span>
                    <div class="mini-pills">
                      <span class="mini-pill">Dimër</span>
                      <span class="mini-pill">Soft</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </section>

      <!-- ===== Best sellers (static slider) ===== -->
      <section class="mb-5">
        <div class="shelf">
          <div class="shelf-head">
            <div>
              <h3>Best Sellers</h3>
              <div class="sub">Produktet ma të shituna – ide të shpejta për sallon & dhomë gjumi.</div>
            </div>
            <a href="/tepiha" class="btn btn-brand btn-sm pill">Shiko katalogun</a>
          </div>

          @php
            $best = [
              ['img'=>'side.bmp',  'name'=>'Tepiha Modern Rose', 'desc'=>'Akrilik, antibakterial, lehtë për pastrim', 'price'=>'€45+','flag'=>'HOT'],
              ['img'=>'hali4.jpg', 'name'=>'Tepiha Hali Premium', 'desc'=>'Fibra cilësore, rezistente, sallon',       'price'=>'€95+','flag'=>'NEW'],
              ['img'=>'gold.bmp',  'name'=>'Tepiha Modern Gold', 'desc'=>'Dizajn elegant, ngjyra të ngrohta',         'price'=>'€55+','flag'=>'HOT'],
              ['img'=>'rose1.jpg', 'name'=>'Tepiha Rose 300x200', 'desc'=>'Pamje luksoze, e butë, komode',             'price'=>'€105+','flag'=>'NEW']
            ];
          @endphp

          <div id="bestCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4200">
            <div class="carousel-inner">
              @php $chunks = collect($best)->chunk(4); @endphp
              @foreach($chunks as $ci => $group)
              <div class="carousel-item {{ $ci===0 ? 'active' : '' }}">
                <div class="row g-3">
                  @foreach($group as $p)
                  <div class="col-12 col-md-6 col-lg-3">
                    <div class="product-card">
                      <div class="product-media">
                        <img loading="lazy" src="{{ asset('slider/'.$p['img']) }}" alt="{{ $p['name'] }}" />
                        <div class="product-flags">
                          <span class="flag {{ strtolower($p['flag']) }}">{{ $p['flag'] }}</span>
                        </div>
                      </div>
                      <div class="product-body">
                        <h6>{{ $p['name'] }}</h6>
                        <p>{{ $p['desc'] }}</p>
                        <div class="product-meta">
                          <span class="price">{{ $p['price'] }}</span>
                          <a href="/tepiha" class="cta"><i class="bi bi-arrow-right"></i> Shiko</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#bestCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bestCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </section>

      <!-- ===== Latest products from DB (more premium cards) ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">RISHTAZI</span>
          <h2>Produktet e fundit në katalog</h2>
          <p>Këtu dalin automatikisht produktet e reja që i shton në admin.</p>
        </div>

        <div class="row g-4">
          @if(isset($items) && $items->count())
            @foreach($items->take(8) as $item)
              <div class="col-md-4 col-sm-6">
                <div class="product-card">
                  <div class="product-media">
                    @if($item->image_path)
                      <img loading="lazy" src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}">
                    @else
                      <img loading="lazy" src="{{ asset('images/og-cover.jpg') }}" alt="Brillant product placeholder">
                    @endif
                    <div class="product-flags">
                      <span class="flag new">NEW</span>
                      <span class="flag">IN STOCK</span>
                    </div>
                  </div>

                  <div class="product-body">
                    <h6 class="text-danger">{{ $item->name }}</h6>
                    <p>{{ \Illuminate\Support\Str::limit($item->description, 110) }}</p>
                    <div class="product-meta">
                      <span class="price">Shiko çmimin</span>
                      <a href="#" class="cta" onclick="event.preventDefault(); window.location='{{ route('contact') }}';">
                        <i class="bi bi-chat-dots"></i> Pyet
                      </a>
                    </div>
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

      <!-- ===== Before/After section (NEW) ===== -->
      <section class="mb-5">
        <div class="ba">
          <div class="row g-0 align-items-stretch">
            <div class="col-lg-4 left">
              <h3>Transformo ambientin ✨</h3>
              <p>
                Me tepiha & perde të zgjedhura mirë, shtëpia duket ma e ngrohtë dhe ma luksoze.
                Ne t’ndihmojmë me zgjedh modelin sipas ngjyrave & stilit.
              </p>
              <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="/tepiha" class="btn btn-brand pill btn-sm"><i class="bi bi-grid"></i> Tepiha</a>
                <a href="/anesore" class="btn btn-outline-dark pill btn-sm"><i class="bi bi-layout-text-window"></i> Perde</a>
                <a href="https://wa.me/38344960661" class="btn btn-outline-success pill btn-sm" target="_blank" rel="noopener">
                  <i class="bi bi-whatsapp"></i> Konsultim
                </a>
              </div>
            </div>
            <div class="col-lg-8 right">
              <div class="ba-grid">
                <div class="ba-shot">
                  <img loading="lazy" src="{{ asset('slider/foto1.jpg') }}" alt="Ambient me perde Brillant">
                  <span class="ba-label">Perde</span>
                </div>
                <div class="ba-shot">
                  <img loading="lazy" src="{{ asset('slider/hali4.jpg') }}" alt="Ambient me tepiha Brillant">
                  <span class="ba-label">Tepiha</span>
                </div>
              </div>
              <div class="mt-3 small text-muted">
                *Fotot janë shembuj; modelet ndryshojnë sipas stokut.
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== Testimonials (NEW) ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">VLERËSIME</span>
          <h2>Çka po thojnë klientët</h2>
          <p>Ne fokusohemi në cilësi, shërbim dhe kënaqësi të klientit.</p>
        </div>

        <div class="row g-4">
          <div class="col-md-4">
            <div class="testi">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                “Perdet i kom marr te Brillant — qepja perfekte, materiali shumë i mirë, e edhe montimi super.”
              </p>
              <div class="who">
                <div class="avatar">A</div>
                <div><b>Arta</b><span>Lipjan</span></div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="testi">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
              </div>
              <p>
                “Tepihat janë shumë cilësore, ngjyrat s’kanë ndryshu hiç. Dërgesa erdh shpejt.”
              </p>
              <div class="who">
                <div class="avatar">B</div>
                <div><b>Besnik</b><span>Prishtinë</span></div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="testi">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                “Setet e çarçafëve janë super të butë. Për çdo pyetje m’kanë kthy menjëherë në WhatsApp.”
              </p>
              <div class="who">
                <div class="avatar">E</div>
                <div><b>Elona</b><span>Ferizaj</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== FAQ (NEW) ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">FAQ</span>
          <h2>Pyetjet ma të shpeshta</h2>
          <p>Po ta lejmë këtu përgjigjet kryesore për porosi, dërgesë dhe perde.</p>
        </div>

        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="q1">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true" aria-controls="a1">
                A bëni dërgesë në gjithë Kosovën?
              </button>
            </h2>
            <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Po, dërgojmë në gjithë Kosovën. Për porosi më shpejt: WhatsApp ose përmes faqes.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="q2">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false" aria-controls="a2">
                A bëni matje dhe montim për perde?
              </button>
            </h2>
            <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Po, ofrojmë matje në terren dhe montim profesional (sipas marrëveshjes). Na shkruaj në WhatsApp për termin.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="q3">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false" aria-controls="a3">
                Sa kohë zgjat porosia?
              </button>
            </h2>
            <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Zakonisht 1–3 ditë pune (varësisht lokacionit dhe stokut). Për perde me qepje/montim koha varet prej projektit.
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== Instagram grid (NEW) ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">INSPIRIM</span>
          <h2>Ide & modele (Instagram style)</h2>
          <p>Vendos këtu foto reale të produkteve të tua (sa më “clean” aq më premium doket).</p>
        </div>

        <div class="ig-grid">
          <a class="ig" href="#" aria-label="Foto 1"><img loading="lazy" src="{{ asset('slider/raffaello.jpg') }}" alt="Perde Brillant 1"><span>Perde</span></a>
          <a class="ig" href="#" aria-label="Foto 2"><img loading="lazy" src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha Brillant 2"><span>Tepiha</span></a>
          <a class="ig" href="#" aria-label="Foto 3"><img loading="lazy" src="{{ asset('slider/side.bmp') }}" alt="Tepiha Brillant 3"><span>New</span></a>
          <a class="ig" href="#" aria-label="Foto 4"><img loading="lazy" src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa Brillant 4"><span>Mbulesa</span></a>
          <a class="ig" href="#" aria-label="Foto 5"><img loading="lazy" src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh 5"><span>Shtrat</span></a>
          <a class="ig" href="#" aria-label="Foto 6"><img loading="lazy" src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha 6"><span>Sale</span></a>
        </div>

        <div class="text-center mt-3">
          <a href="https://www.instagram.com/" target="_blank" rel="noopener" class="btn btn-outline-dark pill">
            <i class="bi bi-instagram"></i> Na ndiq në Instagram
          </a>
        </div>
      </section>

      <!-- ===== Newsletter ===== -->
      <section class="newsletter mb-5">
        <div class="row align-items-center g-3">
          <div class="col-lg-6">
            <h3>Merre ofertën e javës në inbox ✨</h3>
            <p>Na lë email-in dhe t’i dërgojmë zbritjet / koleksionet e reja.</p>
          </div>
          <div class="col-lg-6">
            <form class="d-flex gap-2 flex-column flex-sm-row" onsubmit="event.preventDefault(); toast('Faleminderit!');">
              <input type="email" class="form-control" placeholder="Email-i yt..." required />
              <button class="btn btn-brand pill px-4" type="submit">Abonohu</button>
            </form>
          </div>
        </div>
      </section>

      <!-- ===== Map (NEW) ===== -->
      <section class="mb-5">
        <div class="section-title">
          <span class="k">LOKACIONI</span>
          <h2>Na gjej në Lipjan</h2>
          <p>Vendos linkun real të Google Maps këtu (embed). E rrit besimin edhe SEO local.</p>
        </div>

        <div class="soft-card p-3">
          <div class="ratio ratio-21x9 rounded-4 overflow-hidden" style="border:1px solid rgba(2,6,23,.08);">
            <!-- Zëvendëso src me embed real -->
            <iframe
              title="Brillant Location"
              src="https://www.google.com/maps?q=Lipjan&output=embed"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-3">
            <a class="btn btn-brand pill" href="https://wa.me/38344960661" target="_blank" rel="noopener">
              <i class="bi bi-whatsapp"></i> Porosit në WhatsApp
            </a>
            <a class="btn btn-outline-dark pill" href="{{ route('contact') }}">
              <i class="bi bi-geo-alt"></i> Contact / Directions
            </a>
            <a class="btn btn-outline-secondary pill" href="tel:+38344960661">
              <i class="bi bi-telephone"></i> Thirr
            </a>
          </div>
        </div>
      </section>

      <!-- ===== SEO TEXT ===== -->
      <section class="seo-text">
        <h2>Brillant – Tepiha, Perde dhe Dekorime për Shtëpi</h2>
        <p>
          Brillant në Lipjan ofron një koleksion të gjerë të <strong>tepihave modern dhe klasik</strong>, <strong>perdeve anësore/ditore</strong>,
          <strong>seteve të çarçafëve</strong>, <strong>mbulesave</strong>, <strong>batanijeve</strong>, <strong>garnishteve</strong> dhe
          <strong>tepihave për banjo</strong>. Qëllimi ynë është t’ju sjellim cilësi dhe dizajn që e bën shtëpinë më të ngrohtë dhe më elegante.
        </p>
        <p>
          Për perde ofrojmë edhe <strong>matje, këshillim</strong>, <strong>qepje</strong> dhe <strong>montim profesional</strong>.
          Për porosi të shpejta, na kontaktoni në WhatsApp. Dërgesa bëhet në gjithë Kosovën.
        </p>
        <p>
          Brillant – cilësi, stil dhe shërbim profesional në Lipjan. Porosit online lehtë dhe shpejt.
        </p>
      </section>

    </div>
  </main>

  <!-- ===================== FOOTER ===================== -->
  <footer class="text-dark pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <img src="{{ asset('images/llogo.png') }}" alt="Brillant" width="150" class="mb-2" />
          <p class="text-muted mb-2">Tepiha · Perde · Set çarçafësh · Mbulesa · Batanije · Dekor</p>
          <div class="small">
            <div><i class="bi bi-geo-alt me-1 text-danger"></i> Lipjan, Kosovë</div>
            <div><i class="bi bi-telephone me-1 text-danger"></i> +383 44 960 661</div>
            <div><i class="bi bi-whatsapp me-1 text-success"></i> WhatsApp: +383 44 960 661</div>
          </div>
        </div>

        <div class="col-md-2">
          <h6 class="text-uppercase fw-bold mb-3">Katalog</h6>
          <ul class="list-unstyled d-grid gap-2">
            <li><a href="/tepiha" class="text-dark">Tepiha</a></li>
            <li><a href="/anesore" class="text-dark">Perde</a></li>
            <li><a href="/postava" class="text-dark">Set çarçafësh</a></li>
            <li><a href="/mbulesa" class="text-dark">Mbulesa</a></li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6 class="text-uppercase fw-bold mb-3">Informata</h6>
          <ul class="list-unstyled d-grid gap-2">
            <li><a href="{{ route('about') }}" class="text-dark">About Us</a></li>
            <li><a href="{{ route('contact') }}" class="text-dark">Contact</a></li>
            <li><a href="/track" class="text-dark">Gjurmo porosinë</a></li>
            <li><a href="{{ route('cart.index') }}" class="text-dark">Shporta</a></li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6 class="text-uppercase fw-bold mb-3">Social</h6>
          <div class="d-flex gap-3">
            <a href="https://www.instagram.com/" class="text-dark fs-4" aria-label="Instagram" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
            <a href="https://wa.me/38344960661" target="_blank" rel="noopener" class="text-dark fs-4" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          </div>

          <div class="small text-muted mt-3">
            Porosi të shpejta në WhatsApp – përgjigje brenda ditës.
          </div>

          <div class="mt-3">
            <a href="#top" class="btn btn-outline-dark pill btn-sm">
              <i class="bi bi-arrow-up"></i> Lart
            </a>
          </div>
        </div>
      </div>

      <hr class="my-4" />

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

  <!-- ===================== FLOATING ACTIONS (Desktop) ===================== -->
  <div class="float-actions" aria-label="Quick actions">
    <a class="fab wa" href="https://wa.me/38344960661" target="_blank" rel="noopener" aria-label="WhatsApp">
      <i class="bi bi-whatsapp"></i>
    </a>
    <a class="fab up" href="#top" aria-label="Back to top">
      <i class="bi bi-arrow-up"></i>
    </a>
  </div>

  <!-- ===================== MOBILE BAR ===================== -->
  <div class="mobile-bar" role="navigation" aria-label="Mobile actions">
    <a class="call" href="tel:+38344960661"><i class="bi bi-telephone"></i> Thirr</a>
    <a class="wa" href="https://wa.me/38344960661" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a>
    <a class="cart" href="{{ route('cart.index') }}"><i class="bi bi-bag"></i> Shporta</a>
  </div>

  <!-- ===================== SCRIPTS ===================== -->
  <script>
    // Update cart badges globally
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });

    // Small toast (no library)
    function toast(msg){
      const t = document.createElement('div');
      t.textContent = msg;
      t.style.position = 'fixed';
      t.style.left = '50%';
      t.style.bottom = '92px';
      t.style.transform = 'translateX(-50%)';
      t.style.background = 'rgba(11,16,32,.92)';
      t.style.color = '#fff';
      t.style.padding = '12px 14px';
      t.style.borderRadius = '14px';
      t.style.border = '1px solid rgba(255,255,255,.12)';
      t.style.boxShadow = '0 18px 45px rgba(2,6,23,.22)';
      t.style.zIndex = '1400';
      t.style.fontWeight = '800';
      t.style.fontSize = '14px';
      document.body.appendChild(t);
      setTimeout(()=>{ t.style.opacity='0'; t.style.transition='opacity .25s ease'; }, 1600);
      setTimeout(()=>{ t.remove(); }, 2000);
    }
  </script>

</body>
</html>