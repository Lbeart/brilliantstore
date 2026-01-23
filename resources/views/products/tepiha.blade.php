<!DOCTYPE html>  
<html lang="sq">
<head>
  <meta charset="UTF-8">

  <!-- TITULLI & PERSHKRIMI KRYESOR SEO -->
  <title>Tepiha moderne & tradicionale | B-Brillant</title>
  <meta name="description" content="Tepiha moderne dhe tradicionale në Lipjan. Tepiha akrilik, antibakterial, madhësi 150x230 & 200x300 për sallon, dhomë gjumi dhe çdo ambient. B-Brillant Tepiha.">

  <!-- LEJO INDEXIMIN -->
  <meta name="robots" content="index,follow">

  <!-- FJALË KYÇE -->
  <meta name="keywords" content="tepiha, tepiha moderne, tepiha tradicional, tepih, tapeta, tepih Lipjan, tepih Kosove, tepiha akrill, tepiha antibakterial, tepiha hali, tepiha bambo, tepiha staz, tepiha rrethore, oferta tepiha">

  <!-- CANONICAL -->
  <link rel="canonical" href="{{ url('/tepiha') }}">

  <!-- VIEWPORT -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
    :root{
      --card-radius: 16px;
      --shadow-sm: 0 4px 14px rgba(0,0,0,.08);
      --shadow-lg: 0 12px 30px rgba(0,0,0,.12);
      --brand: #dc3545;
      --dark: #0f172a;
    }

    body{
      background: radial-gradient(circle at top, #fef2f2 0, #f9fafb 40%, #f3f4f6 100%);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
      padding-top: 96px;
    }

    /* NAVBAR */
    .navbar-custom{
      position: fixed;
      top: 12px;
      left: 50%;
      transform: translateX(-50%);
      width: min(1150px, 94%);
      background: linear-gradient(135deg, #020617 0%, #111827 40%, #1f2937 100%);
      border-radius: 18px;
      box-shadow: var(--shadow-sm);
      z-index: 1000;
      padding: .55rem .85rem;
    }
    .navbar-brand img{ height:44px }
    .navbar-custom .nav-link{
      color:#e5e7eb !important;
      font-weight:600;
      letter-spacing:.2px;
      font-size:.9rem;
    }
    .navbar-custom .nav-link:hover{ color:#ffffff !important }

    .navbar-custom .navbar-toggler{
      border-color:rgba(255,255,255,.4);
    }
    .navbar-custom .navbar-toggler-icon{
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu{
      border:0;
      border-radius:14px;
      padding:.5rem;
      box-shadow: var(--shadow-lg);
      background:#ffffff;
    }
    .dropdown-item{ border-radius:8px; font-size:.9rem; }
    .dropdown-item:hover{ background:#f3f4f6; }

    .dropdown-submenu{ position:relative; }
    .dropdown-submenu > .dropdown-menu{
      top:0;
      left:100%;
      margin-left:.25rem;
    }

    @media (max-width: 991.98px){
      body{ padding-top: 86px; }
      .navbar-custom{ padding:.5rem .75rem }
      .navbar-brand img{ height:40px }

      /* MENYJA NË TELEFON – dropdown i dukshëm */
      .navbar-custom .dropdown-menu{
        background:#020617;
        box-shadow:none;
      }
      .navbar-custom .dropdown-item{
        color:#e5e7eb;
      }
      .navbar-custom .dropdown-item:hover{
        background:#111827;
        color:#ffc107;
      }

      /* submenu te “Perde” me u pa në telefon, jo me hover */
      .dropdown-submenu > .dropdown-menu{
        position:static;
        display:block;
        margin-left:1rem;
        background:transparent;
        box-shadow:none;
        padding-left:0;
      }
    }

    /* HEADER */
    .page-header{
      text-align:center;
      margin-top:18px;
      margin-bottom:10px;
    }
    .page-header h1{
      font-size: clamp(1.4rem, 1.1rem + 1.1vw, 2rem);
      font-weight: 800;
      letter-spacing:.3px;
      color:#111827;
      margin:0;
    }
    .page-sub{
      color:#6b7280;
      font-size:.95rem;
    }

    /* FILTER / INFO BAR */
    .filter-bar{
      display:flex;
      flex-wrap:wrap;
      justify-content:space-between;
      align-items:center;
      gap:.75rem;
      margin-bottom:1.25rem;
    }
    .filter-bar-left{
      font-size:.85rem;
      color:#4b5563;
    }
    .filter-chip{
      display:inline-flex;
      align-items:center;
      padding:.15rem .65rem;
      border-radius:999px;
      background:#fff;
      font-size:.8rem;
      color:#374151;
      box-shadow:0 1px 3px rgba(0,0,0,.05);
      margin-right:.25rem;
    }
    .filter-chip i{ font-size:.8rem; margin-right:.25rem; }

    .sort-select{
      font-size:.82rem;
      padding:.3rem .75rem;
      border-radius:999px;
      border:1px solid #e5e7eb;
      background:#ffffff;
      color:#374151;
    }

    /* PRODUCT GRID */
    .product-card{
      position:relative;
      border:0;
      border-radius: var(--card-radius);
      box-shadow: var(--shadow-sm);
      background:#fff;
      height:100%;
      display:flex;
      flex-direction:column;
      overflow:hidden;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .product-card:hover{
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .product-thumb-wrap{
      position:relative;
      overflow:hidden;
    }
    .product-thumb{
      width:100%;
      display:block;
      object-fit:cover;
      background:#f3f4f6;
      aspect-ratio: 4 / 5;
      transition: transform .35s ease;
    }
    .product-card:hover .product-thumb{
      transform: scale(1.04);
    }

    @media (max-width: 767.98px){
      .product-thumb{ aspect-ratio: 1 / 1; }
    }

    .bf-label{
      position:absolute;
      top:10px;
      left:10px;
      background:rgba(220,53,69,.95);
      color:#fff;
      font-size:.72rem;
      padding:.18rem .5rem;
      border-radius:999px;
      text-transform:uppercase;
      letter-spacing:.12em;
      display:inline-flex;
      align-items:center;
      gap:.25rem;
      z-index:2;
    }
    .bf-label span{ font-weight:700; }

    .size-label{
      position:absolute;
      bottom:10px;
      right:10px;
      background:rgba(15,23,42,.86);
      color:#e5e7eb;
      font-size:.75rem;
      padding:.15rem .55rem;
      border-radius:999px;
    }

    .product-body{
      padding: .9rem 1rem 1.05rem;
      text-align:center;
    }
    .product-title{
      font-size: .98rem;
      font-weight:700;
      color:#111827;
      margin-bottom:.15rem;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
    }
    .product-desc{
      font-size:.75rem;
      color:#6b7280;
      margin-bottom:.5rem;
      min-height:1.2em;
    }

    .price-row{
      display:flex;
      align-items:baseline;
      justify-content:center;
      gap:.35rem;
      margin-bottom:.1rem;
    }
    .price-new{
      color: var(--brand);
      font-weight:800;
      font-size:1rem;
    }
    .price-old{
      color:#9ca3af;
      font-size:.8rem;
      text-decoration:line-through;
    }
    .price-note{
      font-size:.72rem;
      color:#6b7280;
    }

    .stretched-link{ position:absolute; inset:0; z-index:1; }

    /* EMPTY STATE */
    .empty{
      background:#fff;
      border-radius:16px;
      box-shadow:var(--shadow-sm);
      padding:1.2rem;
      color:#6b7280;
    }

    /* PAGINATION – E RE, E MADHE, TOUCH-FRIENDLY */
    .pagination-container{
      margin-top:1.75rem;
      display:flex;
      justify-content:center;
    }
    .pagination{
      gap:.5rem;
      flex-wrap:wrap;
    }
    .pagination .page-link{
      border:0;
      color:#111827;
      font-weight:600;
      font-size:.85rem;
      box-shadow:0 2px 6px rgba(0,0,0,.06);
    }
    .page-pill{
      border-radius:999px !important;
      padding:.45rem 1.1rem;
      display:inline-flex;
      align-items:center;
      justify-content:center;
      background:#ffffff;
    }
    .page-indicator{
      border-radius:999px !important;
      background:#f3f4f6;
      padding:.4rem 1rem;
      font-size:.8rem;
      color:#4b5563;
      box-shadow:none;
    }
    .pagination .page-item.disabled .page-link{
      opacity:.45;
      box-shadow:none;
    }

    @media (max-width: 576px){
      .pagination{
        width:100%;
        justify-content:space-between;
      }
      .page-pill{
        flex:1 1 0;
        text-align:center;
      }
      .page-indicator{
        display:none; /* fshehet tek telefonat, veç Prev/Next */
      }
    }

    .seo-text{
      font-size:.95rem;
      line-height:1.7;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
    </a>

    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Products</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/tepiha"><i class="bi bi-grid-3x3-gap me-2"></i>Tepiha</a></li>

            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#"><i class="bi bi-columns-gap me-2"></i>Perde</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/anesore">Perde Anësore</a></li>
                <li><a class="dropdown-item" href="/perde-ditore">Perde Ditore</a></li>
              </ul>
            </li>

            <li><a class="dropdown-item" href="/jastekdekorues"><i class="bi bi-square me-2"></i>JastekDekorues</a></li>
            <li><a class="dropdown-item" href="/postava"><i class="bi bi-layout-text-window-reverse me-2"></i>Set çarçafesh</a></li>
            <li><a class="dropdown-item" href="/mbulesa"><i class="bi bi-layout-wtf me-2"></i>Mbulesa</a></li>
            <li><a class="dropdown-item" href="/batanije"><i class="bi bi-layers me-2"></i>Batanije</a></li>
            <li><a class="dropdown-item" href="/tepihebanjo"><i class="bi bi-droplet me-2"></i>Tepiha për Banjo</a></li>
            <li><a class="dropdown-item" href="/posteqia"><i class="bi bi-border-style me-2"></i>Lekur Pelushi</a></li>
            <li><a class="dropdown-item" href="/garnishte"><i class="bi bi-dash-square me-2"></i>Garnishte</a></li>
          </ul>
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

        <!-- Shporta + Gjurmo porosinë -->
        <li class="nav-item dropdown ms-lg-2">
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

<!-- Koka e faqes -->
<header class="page-header">
  <h1>Tepiha – Koleksioni ynë</h1>
  <div class="page-sub">Tepiha modern & klasik me zbritje sezonale. Modele për sallon, dhomë gjumi dhe çdo ambient.</div>
</header>
<form method="GET" action="{{ url('/tepiha') }}" class="mb-4">
    <div class="input-group">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Kërko brenda tepihave..."
        >
        <button class="btn btn-danger">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

<main class="container py-3 pb-5">

  <!-- (ISH) Black Friday banner – U HEK -->

  <!-- Info / Filter bar -->
  <section class="filter-bar">
    <div class="filter-bar-left">
      @php
        $totalProducts = ($products instanceof \Illuminate\Support\Collection) ? $products->count() : $products->total();
      @endphp
      <span class="me-2 fw-semibold">{{ $totalProducts }} produkte</span>
      <span class="filter-chip"><i class="bi bi-stars"></i> Tepiha modern</span>
      <span class="filter-chip"><i class="bi bi-magic"></i> Antibakterial</span>
      <span class="filter-chip d-none d-md-inline"><i class="bi bi-house-door"></i> Për sallon & dhoma gjumi</span>
    </div>
    <div>
      <select class="sort-select" disabled>
        <option>Rendit sipas: Koleksionit</option>
      </select>
    </div>
  </section>

  <!-- Empty state -->
  @if(($products instanceof \Illuminate\Support\Collection && $products->isEmpty()) || ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->count() === 0))
    <div class="empty text-center mx-auto" style="max-width:720px">
      <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
      <div class="fw-bold">S’ka ende produkte në këtë kategori.</div>
      <div class="small">Kthehu më vonë – po shtojmë vazhdimisht modele të reja.</div>
    </div>
  @endif

  <!-- Lista e produkteve -->
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
    @foreach($products as $product)
  @php
    // Çmimi aktual
    $price = $product->price;

    // Çmimi i "vjetër" (vizual)
    $oldPrice = $price ? round($price * 1.25, 2) : null;

    // Përqindja e zbritjes
    $discountPercent = ($oldPrice && $price && $oldPrice > $price)
      ? round(100 - ($price / $oldPrice * 100))
      : null;

    // ✅ FOTO (punon edhe kur image_path është JSON array)
    $src = asset('images/placeholder.jpg');

    if (!empty($product->image_path)) {
      $decoded = json_decode($product->image_path, true);
      $path = is_array($decoded) ? ($decoded[0] ?? null) : $product->image_path;

      if (!empty($path)) {
        $path = ltrim($path, '/');
        $path = preg_replace('#^storage/#', '', $path);
        $path = preg_replace('#^public/#', '', $path);

        $src = preg_match('#^https?://#i', $path)
          ? $path
          : asset('storage/' . $path);
      }
    }

    // Madhësia prej emrit (150x230, 200x300...)
    preg_match('/\d{2,3}x\d{2,3}/', $product->name, $sizeMatch);
    $sizeLabel = $sizeMatch[0] ?? null;
  @endphp

  <div class="col">
    <article class="product-card">
      <div class="product-thumb-wrap">

        @if($discountPercent)
          <div class="bf-label">
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
          onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}'">
      </div>

      <div class="product-body">
        <div class="product-title" title="{{ $product->name }}">{{ $product->name }}</div>

        <div class="product-desc">
          Tepiha antibakterial, i përshtatshëm për përdorim të përditshëm.
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

  <!-- PAGINATION E RE -->
  @if($products instanceof \Illuminate\Contracts\Pagination\Paginator || $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @if($products->hasPages())
      <div class="pagination-container">
        <nav aria-label="Navigimi i faqeve">
          <ul class="pagination mb-0">
            <!-- Previous -->
            <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link page-pill"
                 href="{{ $products->previousPageUrl() ?? '#' }}"
                 @if($products->onFirstPage()) tabindex="-1" aria-disabled="true" @endif>
                <i class="bi bi-chevron-left me-1"></i>
                Faqja paraprake
              </a>
            </li>

            <!-- Current page info (fshehet në mobile) -->
            <li class="page-item disabled d-none d-sm-block">
              <span class="page-link page-indicator">
                Faqja {{ $products->currentPage() }} nga {{ $products->lastPage() }}
              </span>
            </li>

            <!-- Next -->
            <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link page-pill"
                 href="{{ $products->nextPageUrl() ?? '#' }}"
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
  </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Submenu hover në desktop
  if (window.matchMedia('(min-width: 992px)').matches) {
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
  }

  // Event global për përditësimin e shportës
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
