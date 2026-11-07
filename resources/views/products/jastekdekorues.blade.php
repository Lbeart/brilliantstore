<!DOCTYPE html>
<html lang="sq">
<head>
 <meta charset="UTF-8">

  <!-- TITULLI & PËRSHKRIMI SEO -->
  <title>Jastëk Dekorues Online në Kosovë | Jastëkë për Divan & Krevat | Brillant</title>
  <meta name="description" content="Jastëk dekorues online në Kosovë për divan, krevat, sallon dhe dhomë gjumi. Jastëkë modern, dekorativë dhe me dërgesë nga Brillant Lipjan.">

  <!-- KEYWORDS (ndihmojnë pak SEO) -->
  <meta name="keywords" content="jastek dekorues online, jasteke dekorues, jastak dekorues, jasteke dekorative, jastake dekorues, jasteke per divan, jasteke per krevat, jasteke salloni, jasteke moderne, jasteke online, dekor shtepie, Brillant Lipjan">

  <!-- INDEXIMI -->
  <meta name="robots" content="index, follow">

  <!-- CANONICAL – shumë e rëndësishme për Google -->
  <link rel="canonical" href="{{ url('/jastekdekorues') }}">

  <!-- VIEWPORT -->
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <!-- OPEN GRAPH (Facebook, Instagram, Viber, WhatsApp) -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Brillant Lipjan">
  <meta property="og:title" content="Jastëk Dekorues Online në Kosovë | Brillant">
  <meta property="og:description" content="Jastëkë dekorues për divan, krevat, sallon dhe dhomë gjumi. Modele moderne me dërgesë në Kosovë.">
  <meta property="og:url" content="{{ url('/jastekdekorues') }}">
  <meta property="og:image" content="{{ asset('images/og-jasteke.jpg') }}">

  <!-- TWITTER CARD -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Jastëk Dekorues Online në Kosovë">
  <meta name="twitter:description" content="Jastëkë dekorues modernë për divan, krevat, sallon dhe dekor shtëpie.">
  <meta name="twitter:image" content="{{ asset('images/og-jasteke.jpg') }}">

  <!-- JSON-LD STRUCTURED DATA → Google SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Jastëk Dekorues Online në Kosovë - Jastëkë për Divan dhe Krevat",
    "description": "Jastëkë dekorues me materiale cilësore, ngjyra të qëndrueshme dhe dizajn modern për divan, krevat, sallon dhe dhomë gjumi.",
    "url": "{{ url('/jastekdekorues') }}",
    "image": "{{ asset('images/og-jasteke.jpg') }}",
    "inLanguage": "sq",
    "isPartOf": {
      "@type": "WebSite",
      "name": "B-Brillant",
      "url": "{{ url('/') }}"
    }
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "A mund të porosis jastëk dekorues online në Kosovë?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Po. Te B-Brillant mund të porosisni jastëkë dekorues online për divan, krevat, sallon dhe dhomë gjumi me dërgesë në Kosovë."
        }
      },
      {
        "@type": "Question",
        "name": "A kombinohen jastëkët dekorues me perde dhe mbulesa?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Po. Jastëkët dekorues mund të kombinohen me perde, tepiha, mbulesa, batanije dhe tekstil tjetër për shtëpi."
        }
      }
    ]
  }
  </script>

  @include('products.partials.item-list-schema')

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

    /* ======= NAVBAR (dark navy) ======= */
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
    .dropdown-menu{
      border:0; border-radius:14px; padding:.5rem; box-shadow: var(--shadow-lg);
      background:#ffffff;
    }
    .dropdown-item{ border-radius:8px; }
    .dropdown-item:hover{ background:#f3f4f6; }

    /* Submenu (hover) */
    .dropdown-submenu{ position:relative; }
    .dropdown-submenu > .dropdown-menu{ top:0; left:100%; margin-left:.25rem; }

    /* ======= HEADER ======= */
    .page-header{ text-align:center; margin-top:18px; margin-bottom:8px; }
    .page-header h1{
      font-size: clamp(1.35rem, 1.2rem + 1vw, 2rem);
      font-weight: 800; letter-spacing:.2px; color:#111827; margin:0;
    }
    .page-sub{ color:#6b7280; font-size:.95rem }

    /* ======= GRID ======= */
    .product-card{
      position:relative; border:0; border-radius: var(--card-radius);
      box-shadow: var(--shadow-sm); background:#fff; height:100%;
      display:flex; flex-direction:column; overflow:hidden;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-card:hover{ transform: translateY(-4px); box-shadow: var(--shadow-lg); }

    .product-thumb{
      width:100%; display:block; object-fit:cover; background:#f2f3f7;
      aspect-ratio: 1 / 1;
    }
    @media (min-width: 768px){ .product-thumb{ aspect-ratio: 4 / 5; } }

    .product-body{ padding: .9rem 1rem 1.05rem; text-align:center }
    .product-title{
      font-size: .98rem; font-weight:700; color:#111827; margin-bottom:.15rem;
      white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    }
    .product-price{ color: var(--brand); font-weight:800 }
    .stretched-link{ position:absolute; inset:0; z-index:1 }

    /* ======= EMPTY STATE ======= */
    .empty{
      background:#fff; border-radius:16px; box-shadow:var(--shadow-sm);
      padding:1.2rem; color:#6b7280
    }

    /* ======= PAGINATION ======= */
    .pagination .page-link{ border:0; color:#374151; font-weight:600 }
    .pagination .page-link:focus{ box-shadow:none }
    .pagination .page-item.active .page-link{ background: var(--brand); }

    @media (max-width: 991.98px){
      body{ padding-top: 86px; }
      .navbar-custom{ padding:.55rem .7rem }
      .navbar-brand img{ height:40px }
    }
  </style>
  <link rel="stylesheet" href="{{ asset('css/storefront-theme.css') }}?v=20261107.8">
  <script>try { if (localStorage.getItem('brillant-theme-version') !== '2') { localStorage.setItem('brillant-theme-version', '2'); localStorage.setItem('brillant-admin-theme', 'light'); } document.documentElement.dataset.adminTheme = localStorage.getItem('brillant-admin-theme') || 'light'; } catch (_) { document.documentElement.dataset.adminTheme = 'light'; }</script>
</head>
<body>

<!-- NAVBAR -->
  @include('partials.storefront-nav')

<!-- Header -->
<header class="page-header">
  <h1>Jastëk Dekorues Online për Divan dhe Krevat</h1>
  <div class="page-sub">Koleksion i freskët, gati për porosi.</div>
</header>
<div class="mb-4">
    <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center">
        <div class="col-9 col-md-10">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Kërko produkte (p.sh. shkallore, otto, plastik, rodos...)"
            >
        </div>
        <div class="col-3 col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">
                Kërko
            </button>
        </div>
    </form>
</div>

<!-- Product Grid -->
<main class="container py-4">
  @if(($products instanceof \Illuminate\Support\Collection && $products->isEmpty()) || ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->count() === 0))
    <div class="empty text-center mx-auto" style="max-width:720px">
      <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
      <div class="fw-bold">S’ka ende produkte në këtë kategori.</div>
      <div class="small">Kthehu më vonë – po shtojmë vazhdimisht.</div>
    </div>
  @endif

  <div class="row g-4 justify-content-center">
    @foreach ($products as $p)
    @php
  $src = \App\Support\ProductImages::url($p->image_path ?? null, asset('images/placeholder-product.png'), $p);
@endphp

      <div class="col-6 col-md-4 col-lg-3">
        <article class="card product-card h-100">
         
<img
  class="product-thumb"
  src="{{ $src }}"
  alt="{{ $p->name }}"
  loading="{{ $loop->iteration <= 4 ? 'eager' : 'lazy' }}"
  fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
  decoding="async"
  sizes="(max-width: 576px) 50vw, (max-width: 992px) 33vw, 25vw"
  onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">

          <div class="product-body">
            <div class="product-title" title="{{ $p->name }}">{{ $p->name }}</div>
            @if(!is_null($p->price))
              @include('products.partials.price', ['product' => $p, 'price' => $p->price])
            @endif
          </div>
          <a class="stretched-link" href="{{ route('products.show', $p->slug) }}" aria-label="Shiko {{ $p->name }}"></a>
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

</main>
  
  <!-- SEO TEXT SECTION -->
<section class="seo-text mt-5" style="font-size:16px; line-height:1.6;">
  <div class="container">
    <h2>Jastëk Dekorues Online në Kosovë për Sallon dhe Dhomë Gjumi</h2>

    <p>Jastëkët dekorues të Brillant janë mënyra më e shpejtë dhe më e bukur për të sjellë ngrohtësi, stil dhe personalitet në çdo hapësirë të shtëpisë. Koleksioni ynë përfshin jastëkë modern, jastëkë klasik, jastëkë për divan dhe jastëkë dekorues për krevat – të punuar me materiale cilësore, ngjyra të qëndrueshme dhe dizajne të përzgjedhura me kujdes.</p>

    <p>Me tekstil të butë, printe elegante dhe detaje të rafinuara, jastëkët tanë janë idealë për dhomën e ndenjjes, dhomën e gjumit, sallonin apo zyrën. Çdo model është krijuar për t’i dhënë ambientit një pamje të freskët dhe moderne pa shumë mundim.</p>

    <p>Përveç dizajnit, jastëkët dekorues të Brillant ofrojnë mbështetje të rehatshme dhe janë të lehtë për t’u mirëmbajtur falë materialeve të cilësisë së lartë. Fercat rezistente dhe mbulesat e heqshme sigurojnë jetëgjatësi dhe pastërti pa kompromis.</p>

    <p>Zgjidh një set jastëkësh dekorativ ose kombino ngjyrat dhe modelet sipas stilit të shtëpisë tënde. Brillant ofron dërgesë të shpejtë në gjithë Kosovën, me cilësi të garantuar dhe shërbim profesional.</p>
    <h3>Jasteke dekorues online ne Kosove</h3>
    <p>Zgjidh jasteke dekorues online nga B-Brillant per sallon, divan, krevat dhe dhoma moderne. Modelet tona kombinojne ngjyra te bukura, materiale cilesore dhe dizajn elegant per shtepi ne Lipjan, Prishtine dhe ne gjithe Kosoven.</p>
    <h3>Jasteke per divan, krevat dhe dekor modern</h3>
    <p>Jasteket dekorues jane menyra me e lehte per ta rifreskuar sallonin ose dhomen e gjumit. Mjafton te kombinohen me ngjyren e divanit, perdeve, tepihut ose mbuleses dhe ambienti merr pamje me te ngrohte, me moderne dhe me te kompletuar.</p>
    <p>Klientet qe kerkojne jasteke dekorues Kosove, jasteke per divan, jasteke per krevat, jasteke modern, jasteke online dhe dekor shtepie mund te gjejne ne B-Brillant modele te ndryshme per perdorim familjar, dekor sezonal dhe arredim te brendshem.</p>
    <h3>Jasteke dekorative per sallon dhe dhome gjumi</h3>
    <p>Per kerkimet jastak dekorues, jastek dekorues, jasteke dekorative dhe jasteke salloni, kjo kategori eshte e ndertuar per klientet qe duan me e fresku pamjen e divanit, krevatit ose karrigeve. Modelet kombinohen bukur me perde, tepiha, mbulesa dhe batanije.</p>
  </div>
</section>


<!-- Scripts -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Submenu hover në desktop
  document.querySelectorAll('.dropdown-submenu').forEach(function (item) {
    const toggle = item.querySelector('.dropdown-toggle');
    const menu = item.querySelector('.dropdown-menu');
    item.addEventListener('mouseenter', () => {
      if(toggle){ new bootstrap.Dropdown(toggle); }
      if(menu){ menu.classList.add('show'); }
    });
    item.addEventListener('mouseleave', () => {
      if(menu){ menu.classList.remove('show'); }
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
<script defer src="{{ asset('js/admin-theme.js') }}?v=20261107.6"></script>
</body>
</html>
