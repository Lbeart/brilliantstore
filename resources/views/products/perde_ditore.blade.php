<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">

  <!-- TITULLI & PËRSHKRIMI SEO -->
  <title>Perde Online Kosovë | Perde Ditore me Matje & Montim | Brillant</title>
  <meta name="description" content="Perde online në Kosovë: perde ditore, bamboo, kumash dhe anësore me matje, montim dhe dërgesë nga Brillant Lipjan.">




  <link rel="sitemap" type="application/xml" href="https://b-brillant.com/sitemap.xml">
  
  <!-- KEYWORDS -->
  <meta name="keywords" content="perde online, perde online Kosove, perde online Kosovë, perde ditore, perde bamboo, perde kumash, perde anesore, perde anësore, perde dritareje, perde shtëpie, perde zyre, perde moderne, perde me matje, perde me montim, perde online Lipjan, perde Kosove, perde Kosovë, perde bamboo online, perde kumash online, perde cilësore, perde elegante, perde transparente">

  <!-- INDEXIMI -->
  <meta name="robots" content="index, follow">

  <!-- CANONICAL -->
  <link rel="canonical" href="{{ url('/perde-ditore') }}">

  <!-- VIEWPORT -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- OPEN GRAPH (Facebook, IG, WhatsApp, Viber) -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Brillant Lipjan">
  <meta property="og:title" content="Perde Online Kosovë | Perde Ditore, Bamboo & Kumash – Brillant">
  <meta property="og:description" content="Porosit perde online në Kosovë: perde ditore, perde bamboo, perde kumash dhe perde anësore me matje, montim dhe dërgesë nga Brillant Lipjan.">
  <meta property="og:url" content="{{ url('/perde-ditore') }}">
  <meta property="og:image" content="{{ asset('perdeditoree/perde.jpg') }}">

  <!-- TWITTER CARD -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Perde Online Kosovë | Perde Ditore me Matje & Montim">
  <meta name="twitter:description" content="Perde ditore, bamboo dhe kumash online në Kosovë me matje, montim dhe dërgesë nga Brillant Lipjan.">
  <meta name="twitter:image" content="{{ asset('perdeditoree/perde.jpg') }}">

  <!-- JSON-LD (Structured Data për Google) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "CollectionPage",
        "@id": "{{ url('/perde-ditore') }}#collection",
        "name": "Perde Online Kosovë - Perde Ditore, Bamboo dhe Kumash",
        "description": "Perde online në Kosovë: perde ditore, bamboo, kumash dhe anësore me matje, montim dhe dërgesë nga Brillant Lipjan.",
        "url": "{{ url('/perde-ditore') }}",
        "image": "{{ asset('perdeditoree/perde.jpg') }}",
        "inLanguage": "sq",
        "isPartOf": {
          "@type": "WebSite",
          "name": "B-Brillant",
          "url": "{{ url('/') }}",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/search') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
      },
      {
        "@type": "BreadcrumbList",
        "@id": "{{ url('/perde-ditore') }}#breadcrumb",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Ballina",
            "item": "{{ url('/') }}"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Perde Online Kosovë",
            "item": "{{ url('/perde-ditore') }}"
          }
        ]
      },
      {
        "@type": "FAQPage",
        "@id": "{{ url('/perde-ditore') }}#faq",
        "mainEntity": [
          {
            "@type": "Question",
            "name": "A mund të porosis perde online në Kosovë?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Po, te Brillant mund të zgjidhni perde ditore, bamboo, kumash dhe anësore online, me këshillim, matje, montim dhe dërgesë në Kosovë."
            }
          },
          {
            "@type": "Question",
            "name": "A ofroni matje dhe montim për perde?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Po, Brillant ofron matje dhe montim profesional për perde në Lipjan dhe sipas mundësisë edhe në qytete të tjera të Kosovës."
            }
          }
        ]
      }
    ]
  }
  </script>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">

  <style>
    :root{
      --card-radius: 14px;
      --shadow-sm: 0 4px 14px rgba(0,0,0,.08);
      --shadow-lg: 0 12px 30px rgba(0,0,0,.10);
      --brand: #dc3545; /* për çmimet */
    }

    body{
      background:#f7f8fb;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", sans-serif;
      padding-top: 92px; /* hapësirë për navbar-in fixed */
    }

    /* ======= NAVBAR (dark navy – njësoj si faqet tjera) ======= */
    .navbar-custom{
      position: fixed;
      top: 12px; left: 50%; transform: translateX(-50%);
      width: min(1150px, 94%);
      background: linear-gradient(135deg, #0f172a 0%, #1f2937 100%);
      border-radius: 18px;
      box-shadow: var(--shadow-sm);
      z-index: 1000;
      padding: .65rem .9rem;
    }
    .navbar-brand img{ height:44px }
    .navbar-custom .nav-link{
      color:#ffffff !important; font-weight:600; letter-spacing:.2px;
    }
    .navbar-custom .nav-link:hover{ color:#e5e7eb !important }
    .navbar-dark .navbar-toggler{ border-color: rgba(255,255,255,.35); }

    .dropdown-menu{
      border:0; border-radius:14px; padding:.5rem;
      box-shadow: var(--shadow-lg); background:#ffffff;
    }
    .dropdown-item{ border-radius:8px; }
    .dropdown-item:hover{ background:#f3f4f6; }

    /* Submenu */
    .dropdown-submenu{ position:relative; }
    .dropdown-submenu > .dropdown-menu{
      top:0; left:100%; margin-left:.25rem; margin-right:.25rem;
    }

    /* ======= HEADER ======= */
    .page-header{ text-align:center; margin-top:18px; margin-bottom:8px; }
    .page-header h1{
      font-size: clamp(1.55rem, 1.25rem + 1.45vw, 2.45rem);
      font-weight: 800; color:#111827; margin:0;
    }
    .page-sub{ color:#6b7280; font-size:.98rem; max-width:760px; margin:.45rem auto 0; padding:0 1rem; }
    .seo-intro{
      max-width: 920px;
      margin: 0 auto 1.25rem;
      color:#4b5563;
      font-size:1rem;
      line-height:1.7;
      text-align:center;
      padding:0 1rem;
    }

    /* ======= GRID ======= */
    .product-card{
      position:relative; border:0; border-radius: var(--card-radius);
      box-shadow: var(--shadow-sm); background:#fff; height:100%;
      display:flex; flex-direction:column; overflow:hidden;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-card:hover{ transform: translateY(-4px); box-shadow: var(--shadow-lg); }

    .product-thumb{
      aspect-ratio: 4 / 5; /* i njëjti raport si faqet tjera */
      width:100%; object-fit: cover; display:block; background:#f2f3f7;
    }

    .product-body{ padding:.9rem 1rem 1.05rem; text-align:center }
    .product-title{
      font-size:.98rem; font-weight:700; color:#111827; margin-bottom:.15rem;
      white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .product-price{ color: var(--brand); font-weight:800 }
    .stretched-link{ position:absolute; inset:0; z-index:1 }

    /* ======= EMPTY STATE & PAGINATION ======= */
    .empty{ background:#fff; border-radius:16px; box-shadow:var(--shadow-sm); padding:1.2rem; color:#6b7280 }
    .pagination .page-link{ border:0; color:#374151; font-weight:600 }
    .pagination .page-link:focus{ box-shadow:none }
    .pagination .page-item.active .page-link{ background: var(--brand); }

    .seo-text{
      background:#fff;
      border-top:1px solid #eef0f4;
      padding:2.4rem 0 2.8rem;
    }
    .seo-text h2{
      color:#111827;
      font-size:clamp(1.35rem, 1.1rem + 1vw, 2rem);
      font-weight:800;
      margin-bottom:1rem;
    }
    .seo-text h3{
      color:#111827;
      font-size:1.08rem;
      font-weight:800;
      margin-top:1.4rem;
      margin-bottom:.45rem;
    }
    .seo-text p{ color:#4b5563; }
    .seo-list{
      display:grid;
      grid-template-columns:repeat(2, minmax(0, 1fr));
      gap:.75rem;
      padding:0;
      margin:1rem 0;
      list-style:none;
    }
    .seo-list li{
      background:#f7f8fb;
      border:1px solid #eef0f4;
      border-radius:12px;
      padding:.85rem 1rem;
      color:#374151;
      font-weight:600;
    }

    @media (max-width: 991.98px){
      body{ padding-top: 86px; }
      .navbar-custom{ padding:.55rem .7rem }
      .navbar-brand img{ height:40px }
    }
    @media (max-width: 575.98px){
      .seo-list{ grid-template-columns:1fr; }
    }
  </style>
</head>
<body>

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
            <a class="nav-link" href="/" data-nav="home">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              data-bs-toggle="dropdown"
              role="button"
              aria-expanded="false"
              data-nav="products">
              Products
            </a>

            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/tepiha">
                  <i class="bi bi-grid-3x3-gap me-2"></i> Tepiha
                </a>
              </li>

              <li class="dropdown-submenu">
                <a class="dropdown-item submenu-toggle" href="#" role="button" aria-expanded="false">
                  <span><i class="bi bi-columns-gap me-2"></i> Perde</span>
                  <i class="bi bi-chevron-down chev"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/anesore">Perde Anësore</a></li>
                  <li><a class="dropdown-item" href="/perde-ditore">Perde Ditore</a></li>
                </ul>
              </li>

              <li><a class="dropdown-item" href="/jastekdekorues"><i class="bi bi-square-fill me-2"></i> Jastëk dekorues</a></li>
              <li><a class="dropdown-item" href="/postava"><i class="bi bi-journal-text me-2"></i> Set çarçafesh</a></li>
              <li><a class="dropdown-item" href="/mbulesa"><i class="bi bi-collection me-2"></i> Mbulesa</a></li>
              <li><a class="dropdown-item" href="/batanije"><i class="bi bi-layers me-2"></i> Batanije</a></li>
              <li><a class="dropdown-item" href="/tepihebanjo"><i class="bi bi-droplet me-2"></i> Tepiha për Banjo</a></li>
              <li><a class="dropdown-item" href="/posteqia"><i class="bi bi-cloud-fog2 me-2"></i> Lëkurë pelushi</a></li>
              <li><a class="dropdown-item" href="/garnishte"><i class="bi bi-dash-square me-2"></i> Garnishte</a></li>
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
              <i class="bi bi-bag"></i> Shporta
              <span class="badge bg-danger rounded-pill ms-1 cart-badge">
                {{ session('cart_total_qty', 0) }}
              </span>
            </a>

            <div
              class="dropdown-menu dropdown-menu-end p-3 shadow"
              aria-labelledby="cartDropdown"
              style="min-width: 320px; border-radius: 16px;">
              <div class="small text-muted mb-2">Gjurmo porosinë</div>

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

<!-- Koka e faqes -->
<header class="page-header">
  <h1>Perde Online Kosovë - Perde Ditore, Bamboo dhe Kumash</h1>
  <div class="page-sub">Zgjidh perde moderne për shtëpi, sallon, kuzhinë dhe zyrë me matje, montim dhe dërgesë nga Brillant Lipjan.</div>
</header>
<p class="seo-intro">
  Te Brillant mund të porosisni perde online në Kosovë: perde ditore transparente, perde bamboo, perde kumash dhe perde anësore me materiale cilësore dhe dizajn elegant.
</p>
<div class="mb-4 container">
    <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center">
        <div class="col-9 col-md-10">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Kërko perde online (p.sh. perde ditore, bamboo, kumash...)"
            >
        </div>
        <div class="col-3 col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">
                Kërko
            </button>
        </div>
    </form>
</div>

<!-- Grid nga DB -->
<main class="container py-3 pb-5">
  @if(($products instanceof \Illuminate\Support\Collection && $products->isEmpty()) || ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->count() === 0))
    <div class="empty text-center mx-auto" style="max-width:720px">
      <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
      <div class="fw-bold">S’ka ende produkte në këtë kategori.</div>
      <div class="small">Kthehu më vonë – po shtojmë vazhdimisht.</div>
    </div>
  @else
    <div class="row g-4">
      @foreach ($products as $p)
      @php
  $imgs = [];
  $raw = $p->image_path ?? '';

  if($raw !== ''){
    $d = json_decode($raw, true);
    $imgs = is_array($d) ? $d : [$raw];
  }

  $mainImg = $imgs[0] ?? null;

  if($mainImg){
    if(preg_match('#^https?://#i', $mainImg)){
      $mainImg = parse_url($mainImg, PHP_URL_PATH) ?? $mainImg;
    }
    $mainImg = ltrim($mainImg, '/');
    $mainImg = preg_replace('#^(storage|public)/#', '', $mainImg);
  }

  $src = $mainImg
    ? asset($mainImg)
    : asset('images/placeholder.jpg');
@endphp
        <div class="col-6 col-md-4 col-lg-3">
          <article class="product-card">
            <img
  class="product-thumb"
  src="{{ $src }}"
  alt="{{ $p->name }}"
  loading="lazy"
  onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}'">


            <div class="product-body">
              <div class="product-title" title="{{ $p->name }}">{{ $p->name }}</div>

              @if(!is_null($p->price))
                <div class="product-price">{{ number_format($p->price, 2) }} €</div>
              @endif
            </div>

            <a href="{{ route('products.show', $p->slug) }}" class="stretched-link" aria-label="Shiko {{ $p->name }}"></a>
          </article>
        </div>
      @endforeach
    </div>

    @if($products instanceof \Illuminate\Contracts\Pagination\Paginator || $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
  <div class="mt-4 d-flex justify-content-center">
    <nav>
      <ul class="pagination mb-0">
        {{-- Previous --}}
        @if ($products->onFirstPage())
          <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
          <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pages --}}
        @foreach ($products->links()->elements[0] ?? [] as $page => $url)
          @if ($page == $products->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
          @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach

        {{-- Next --}}
        @if ($products->hasMorePages())
          <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
          <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
      </ul>
    </nav>
  </div>
@endif

  @endif
</main>
<!-- SEO TEXT SECTION -->
<section class="seo-text mt-5">
  <div class="container">
    <h2>Perde Online në Kosovë - Perde Ditore, Bamboo, Kumash dhe Anësore</h2>

    <p>Perdet ditore nga Brillant sjellin dritë natyrale, privatësi dhe elegancë në çdo dhomë të shtëpisë. Nëse po kërkon <strong>perde online Kosovë</strong>, këtu mund të gjesh modele të lehta, transparente dhe moderne për sallon, dhomë gjumi, kuzhinë, zyrë dhe ambiente hoteliere.</p>

    <p>Koleksioni ynë përfshin <strong>perde ditore</strong>, <strong>perde bamboo</strong>, <strong>perde kumash</strong> dhe perde anësore, të përshtatshme për çdo stil të enterierit. Materialet janë të zgjedhura për pamje të pastër, rënie elegante, qëndrueshmëri dhe mirëmbajtje të lehtë.</p>

    <ul class="seo-list">
      <li>Perde me matje dhe montim profesional</li>
      <li>Perde ditore për sallon, dhomë dhe kuzhinë</li>
      <li>Perde bamboo dhe kumash me dizajne moderne</li>
      <li>Dërgesë dhe shërbim në Kosovë nga Brillant Lipjan</li>
    </ul>

    <p>Nëse dëshiron perde sipas masës, ekipi ynë mund të ndihmojë me këshillim për materialin, ngjyrën, modelin dhe mënyrën e montimit. Zgjidh Brillant për perde cilësore, pamje elegante dhe porosi të lehtë online.</p>

    <h3>A mund të porosis perde online në Kosovë?</h3>
    <p>Po. Te Brillant mund të shikosh modelet online dhe të na kontaktosh për porosi, matje, montim dhe dërgesë në Kosovë.</p>

    <h3>Cilat perde janë më të kërkuara?</h3>
    <p>Modelet më të kërkuara janë perde ditore transparente, perde bamboo, perde kumash dhe kombinime me perde anësore për privatësi dhe dekor më të plotë.</p>
    <h3>Perde ditore online ne Kosove</h3>
    <p>B-Brillant ofron perde ditore online, perde bamboo, perde kumash dhe perde anesore per shtepi moderne. Porosit perde cilesore me matje te pershtatshme, dizajn elegant dhe dergese te shpejte ne Lipjan, Prishtine dhe ne gjithe Kosoven.</p>
    <h3>Perde ditore, bamboo, kumash dhe perde moderne</h3>
    <p>Perdet ditore jane zgjedhje ideale per klientet qe duan drite natyrale, privatese dhe pamje te paster ne sallon, kuzhine, dhome gjumi ose zyre. Materialet e lehta krijojne ndjesi te fresket, ndersa kombinimi me perde anesore e ben dritaren te duket me e kompletuar.</p>
    <p>Ne kete kategori gjeni perde online Kosove, perde ditore, perde bamboo, perde kumash, perde moderne, perde per sallon, perde per dhome gjumi dhe perde me dergese ne Lipjan, Prishtine, Ferizaj, Gjilan, Prizren, Peje dhe qytete te tjera. B-Brillant ndihmon klientet te zgjedhin modelin qe i pershtatet shtepise dhe buxhetit.</p>
  </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Submenu hover në desktop (opsionale)
  document.querySelectorAll('.dropdown-submenu').forEach(function (item) {
    const toggle = item.querySelector('.dropdown-toggle');
    const menu = item.querySelector('.dropdown-menu');
    item.addEventListener('mouseenter', () => {
      if(toggle){ new bootstrap.Dropdown(toggle); }
      menu?.classList.add('show');
    });
    item.addEventListener('mouseleave', () => {
      menu?.classList.remove('show');
    });
  });
   window.updateCartBadges = function(totalQty){
    document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
  };

  // dëgjo event-in global nga faqet ku shtohet në shportë
  document.addEventListener('cart:updated', e => {
    if (e.detail && typeof e.detail.totalQty !== 'undefined') {
      updateCartBadges(e.detail.totalQty);
    }
  });
</script>
</body>
</html>
