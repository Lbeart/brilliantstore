<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Lekur Pelushi  – Katalogu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
      aspect-ratio: 1 / 1; /* mobile katrore */
    }
    @media (min-width: 768px){ .product-thumb{ aspect-ratio: 4 / 5; } } /* desktop 4:5 */

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
            <li><a class="dropdown-item active" href="/posteqia"><i class="bi bi-border-style me-2"></i>Posteqia</a></li>
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
        {{-- === Shporta me dropdown "Gjurmo porosinë" (vendose menjëherë pas/ në vend të item-it të Shportës) === --}}
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

<!-- Header -->
<header class="page-header">
  <h1>Lekur Pelushi</h1>
  <div class="page-sub">Koleksion i freskët – gati për porosi.</div>
  
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


<!-- Grid nga DB -->
<main class="container py-4 pb-5">
  @if(($products instanceof \Illuminate\Support\Collection && $products->isEmpty()) || ($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->count() === 0))
    <div class="empty text-center mx-auto" style="max-width:720px">
      <i class="bi bi-box-seam fs-3 text-muted d-block mb-2"></i>
      <div class="fw-bold">S’ka ende produkte në këtë kategori.</div>
      <div class="small">Kthehu më vonë – po shtojmë vazhdimisht.</div>
    </div>
  @else
    <div class="row g-4">
      @foreach ($products as $p)
        <div class="col-6 col-md-4 col-lg-3">
          <article class="product-card">
            <img
  class="product-thumb"
  src="{{ $p->image_path ? asset('storage/'.$p->image_path) : asset('images/placeholder.jpg') }}"
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
<section class="seo-text mt-5" style="font-size:16px; line-height:1.6;">
  <div class="container">
    <h2>Posteqia &amp; Lëkur Pelushi – Butësi, Komoditet dhe Dizajn Luksoz</h2>

    <p>Posteqiat dhe lëkurat e pelushit nga Brillant janë zgjidhja perfekte për të shtuar butësi, komfort dhe estetikë luksoze në shtëpinë tuaj. Të ndërtuara nga materiale të buta, të ngrohta dhe shumë cilësore, ato ofrojnë një ndjesi relaksi në çdo hapësirë.</p>

    <p>Koleksioni ynë përfshin lëkura pelushi të cilat janë ideale për dhoma gjumi, kënde leximi, sallon, karrige, divane ose si dekor pranë krevatit. Materiali i butë “flokë pelushi” i jep ambientit një pamje moderne dhe të ngrohtë, duke krijuar një atmosferë të këndshme dhe relaksuese.</p>

    <p>Posteqiat janë të lehta për t’u pastruar, rezistente ndaj përdorimit të përditshëm dhe të disponueshme në ngjyra të ndryshme për t’u kombinuar me çdo stil dekorimi. Ato janë gjithashtu perfekte për foto aesthetike, dhoma rinore dhe kënde të brendshme Instagram-friendly.</p>

    <p>Zgjidhni posteqia dhe lëkur pelushi nga Brillant për të shtuar elegancë, butësi dhe komoditet në çdo dhomë. Dërgesë e shpejtë në të gjithë Kosovën.</p>
  </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
