<!DOCTYPE html>   
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brillant Tepiha & Perde  | b-brillant.com</title>
  <meta name="description" content="Tepiha moderne, perde, set qarqafësh, mbulesa, jastakë dekorues dhe tepiha për banjo. Cilësi dhe dizajn për shtëpinë tuaj në Lipjan.">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Poppins (Google Fonts) -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    html, body, .navbar-custom, .navbar-custom .nav-link, .dropdown-menu, .dropdown-item {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: optimizeLegibility;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    /* NAVBAR */
    .navbar-custom {
      background: linear-gradient(90deg, #111827, #1f2933);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      padding: 0.6rem 1.5rem;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar-custom .navbar-brand img {
      height: 52px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.35));
    }

    .navbar-custom .nav-link {
      font-weight: 500;
      font-size: 0.95rem;
      color: #f8f9fa !important;
      padding: 0.6rem 0.9rem;
    }
    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus {
      color: #ffc107 !important;
    }

    .navbar-custom .navbar-toggler {
      border-color: rgba(255,255,255,0.4);
    }
    .navbar-custom .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28 255, 255, 255, 0.8 %29)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .dropdown-menu {
      border-radius: 0.75rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
      padding: 0.5rem 0;
      border: none;
    }

    .dropdown-submenu .submenu {
      display: none;
      position: absolute;
      top: 0;
      left: 100%;
      margin-left: 0.1rem;
      border-radius: 0.75rem;
      min-width: 180px;
    }
    .dropdown-submenu:hover .submenu {
      display: block;
    }

    @media (max-width: 992px) {
      .navbar-custom {
        padding: 0.5rem 1rem;
      }
      .navbar-custom .navbar-brand img {
        height: 44px;
      }

      /* Dropdown më i lexueshëm në mobile */
      .navbar-custom .dropdown-menu {
        border-radius: 0;
        box-shadow: none;
        background: #111827;
      }
      .navbar-custom .dropdown-item {
        color: #f8f9fa;
      }
      .navbar-custom .dropdown-item:hover {
        background: rgba(255,255,255,0.05);
        color: #ffc107;
      }

      /* submenu te “Perde” të hapura poshtë parent-it në mobile */
      .dropdown-submenu .submenu {
        position: static;
        display: block;
        margin-left: 0;
        padding-left: 1rem;
        background: transparent;
        box-shadow: none;
      }
    }

    /* HERO SECTION */
    .hero-section {
      position: relative;
      min-height: 70vh;
      display: flex;
      align-items: center;
      color: #fff;
      overflow: hidden;
    }
    .hero-bg {
      position: absolute;
      inset: 0;
      background: url('{{ asset('slider/foto1.jpg') }}') center center/cover no-repeat;
      filter: brightness(0.4);
      z-index: -2;
    }
    .hero-overlay {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 10% 20%, rgba(220,53,69,0.35), transparent 60%);
      z-index: -1;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.2rem 0.75rem;
      border-radius: 999px;
      background: rgba(255,255,255,0.12);
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.14em;
    }
    .hero-badge span {
      background: #ffc107;
      color: #000;
      padding: 0.05rem 0.5rem;
      border-radius: 999px;
      font-weight: 600;
    }
    .hero-title {
      font-size: clamp(2.4rem, 4vw, 3.2rem);
      font-weight: 700;
      line-height: 1.1;
      margin-top: 1rem;
    }
    .hero-title span {
      color: #ffc107;
    }
    .hero-subtitle {
      font-size: 1rem;
      max-width: 520px;
      margin-top: 1rem;
      color: #f8f9fa;
    }
    .hero-cta .btn {
      border-radius: 999px;
      padding: 0.65rem 1.6rem;
      font-weight: 500;
    }
    .hero-cta .btn-outline-light {
      border-width: 2px;
    }
    .hero-stats {
      margin-top: 1.8rem;
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      font-size: 0.9rem;
    }
    .hero-stat-number {
      font-size: 1.4rem;
      font-weight: 700;
      color: #ffc107;
    }

    /* CATEGORY CARDS */
    .section-title {
      text-align: center;
      margin-bottom: 2.5rem;
    }
    .section-title span {
      font-size: 0.85rem;
      color: #dc3545;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
    }
    .section-title h2 {
      font-weight: 700;
      margin-top: 0.4rem;
    }

    .category-card {
      border-radius: 1.5rem;
      background: #fff;
      box-shadow: 0 10px 25px rgba(0,0,0,0.06);
      overflow: hidden;
      position: relative;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      height: 100%;
    }
    .category-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    }
    .category-image-wrapper {
      position: relative;
      overflow: hidden;
    }
    .category-image-wrapper img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      display: block;
      transition: transform 0.4s ease;
    }
    .category-card:hover img {
      transform: scale(1.05);
    }
    .category-tag {
      position: absolute;
      top: 10px;
      left: 10px;
      background: rgba(0,0,0,0.7);
      color: #fff;
      padding: 0.2rem 0.7rem;
      border-radius: 999px;
      font-size: 0.75rem;
    }
    .category-body {
      padding: 1rem 1.25rem 1.3rem;
    }
    .category-body h5 {
      font-weight: 600;
    }
    .category-body p {
      font-size: 0.9rem;
      margin-bottom: 0.8rem;
      color: #6c757d;
    }
    .category-link {
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: #dc3545;
      font-weight: 600;
      text-decoration: none;
    }

    /* RUGS CAROUSEL SECTION */
    .rugs-badge {
      font-size: 0.8rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #6c757d;
    }
    .rugs-card-title {
      font-weight: 600;
    }

    /* LAST PRODUCTS */
    .product-card {
      border: none;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.06);
      height: 100%;
    }
    .product-card img {
      height: 260px;
      object-fit: cover;
      width: 100%;
    }
    .product-card .card-body {
      padding: 1rem 1.25rem 1.3rem;
    }

    /* WHY CHOOSE US */
    .why-bullet h5 {
      font-weight: 600;
      font-size: 1rem;
    }
    .why-bullet p {
      font-size: 0.9rem;
      color: #6c757d;
    }

    /* SEO TEXT */
    .seo-text {
      font-size: 0.95rem;
      line-height: 1.7;
    }

    /* FOOTER */
    footer {
      font-size: 0.9rem;
    }

   @media (max-width: 768px) {
  .hero-section {
    min-height: 60vh;
    text-align: center;
  }
  .hero-subtitle {
    margin-left: auto;
    margin-right: auto;
  }
  .hero-stats {
    justify-content: center;
  }
}

      .search-wrapper {
  background: #fff;
  border-bottom: 1px solid #e5e7eb;
  padding: 1rem 0;
}

.search-box {
  max-width: 700px;
  margin: auto;
  position: relative;
}

.search-box input {
  border-radius: 999px;
  padding-left: 3rem;
  height: 48px;
  font-size: 0.95rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.search-box i {
  position: absolute;
  top: 50%;
  left: 18px;
  transform: translateY(-50%);
  color: #6b7280;
}

.category-side {
  border-radius: 1rem;
  background: #f9fafb;
  padding: 1rem;
}

.category-side a {
  display: flex;
  justify-content: space-between;
  padding: 0.6rem 0;
  color: #111827;
  font-weight: 500;
  text-decoration: none;
}

.category-side a:hover {
  color: #dc3545;
}
    
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="{{ asset('images/brillant.png') }}" alt="Brillant Logo">
      </a>

      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarContent" aria-controls="navbarContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-lg-center me-lg-3">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="catalogDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
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
          <li class="nav-item me-lg-2">
            <a class="nav-link" href="{{ route('contact') }}">Contact us</a>
          </li>

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
            <li class="nav-item ms-lg-2">
              <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill">Log in</a>
            </li>
          @endauth

          <!-- CART / GJURMO POROSINË -->
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
<div class="search-wrapper">
  <div class="container">
    <div class="row align-items-center g-3">

      <!-- CATEGORIES LEFT -->
      <div class="col-lg-3 d-none d-lg-block">
        <div class="category-side shadow-sm">
          <a href="/tepiha">
            <span><i class="bi bi-grid me-2"></i> Tepiha</span>
            <i class="bi bi-chevron-right"></i>
          </a>
          <a href="/mobije">
            <span><i class="bi bi-house me-2"></i> Mobilje</span>
            <i class="bi bi-chevron-right"></i>
          </a>
          <a href="/anesore">
            <span><i class="bi bi-layout-text-window me-2"></i> Perde</span>
            <i class="bi bi-chevron-right"></i>
          </a>
        </div>
      </div>

      <!-- SEARCH CENTER -->
      <div class="col-lg-6 col-md-12">
        <form action="{{ route('search') }}" method="GET" class="search-box">
          <i class="bi bi-search"></i>
          <input
            type="text"
            name="q"
            class="form-control"
            placeholder="Kërko produkte..."
            value="{{ request('q') }}"
            required
          >
        </form>
      </div>

      <!-- CHAT RIGHT -->
      <div class="col-lg-3 text-end d-none d-lg-block">
        <a href="https://wa.me/38344996926" target="_blank"
           class="btn btn-success rounded-pill px-4">
          <i class="bi bi-whatsapp me-1"></i> Chat
        </a>
      </div>

    </div>
  </div>
</div>
  <!-- HERO SECTION -->
  <section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="hero-badge">
            <span>KOLEKSION I RI</span> Tepiha & perde për çdo ambient
          </div>
          <h1 class="hero-title">
            Tepiha & perde <span>premium</span> për shtëpi moderne.
          </h1>
          <p class="hero-subtitle">
            Zgjidh dizajnin ideal për sallon, dhomë gjumi apo zyrë.
            Tekstura cilësore, ngjyra që nuk zbehen dhe shërbim profesional nga Brillant në Lipjan.
          </p>
          <div class="hero-cta mt-4 d-flex flex-wrap gap-2">
            <a href="/tepiha" class="btn btn-danger text-white">
              Shiko tepihat
            </a>
            <a href="/anesore" class="btn btn-outline-light">
              Shiko perdet
            </a>
          </div>
          <div class="hero-stats">
            <div>
              <div class="hero-stat-number">3000+</div>
              <div>Klientë të kënaqur në Kosovë</div>
            </div>
            <div>
              <div class="hero-stat-number">15+ vjet</div>
              <div>Përvojë në tekstile shtëpie</div>
            </div>
          </div>
        </div>

        <!-- KARTA: OFERTA E JAVËS ME KAROSEL -->
        <div class="col-lg-5 mt-4 mt-lg-0">
          <div class="card border-0 rounded-4 shadow-lg bg-white">
            <div class="card-body p-3 p-md-4">
              <p class="rugs-badge mb-2">ZBRITJE SEZONALE</p>
              <h5 class="fw-bold mb-3">Oferta e javës</h5>

              <div id="weeklyOffersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">

                  <!-- SLIDE 1 – TEPIHA -->
                  <div class="carousel-item active">
                    <div class="d-flex gap-3 align-items-center">
                      <img src="{{ asset('slider/side.bmp') }}" alt="Tepiha Modern 150x230"
                           class="rounded-3 flex-shrink-0"
                           style="width: 110px; height: 110px; object-fit: cover;">
                      <div class="flex-grow-1">
                        <span class="badge bg-danger-subtle text-danger border border-danger mb-1">Tepiha</span>
                        <p class="mb-1 fw-semibold">Tepiha Modern 150x230 cm</p>
                        <p class="mb-1 small text-muted">Antibakterial, Akrill, lehtë për pastrim.</p>
                        <div class="d-flex align-items-baseline gap-2">
                          <span class="fw-bold text-danger">€75.00</span>
                          <span class="text-muted text-decoration-line-through small">€95.00</span>
                        </div>
                        <a href="/tepiha" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-1">
                          Shko te tepihat <i class="bi bi-arrow-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- SLIDE 2 – TEPIHA TJETËR -->
                  <div class="carousel-item">
                    <div class="d-flex gap-3 align-items-center">
                      <img src="{{ asset('slider/hali4.jpg') }}" alt="Tepiha 200x300"
                           class="rounded-3 flex-shrink-0"
                           style="width: 110px; height: 110px; object-fit: cover;">
                      <div class="flex-grow-1">
                        <span class="badge bg-danger-subtle text-danger border border-danger mb-1">Tepiha</span>
                        <p class="mb-1 fw-semibold">Tepiha Hali 200x300 cm</p>
                        <p class="mb-1 small text-muted">Rezistent, me fibra cilësore për sallon.</p>
                        <div class="d-flex align-items-baseline gap-2">
                          <span class="fw-bold text-danger">€95.00</span>
                          <span class="text-muted text-decoration-line-through small">€120.00</span>
                        </div>
                        <a href="/tepiha" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-1">
                          Shiko modelet Hali <i class="bi bi-arrow-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- SLIDE 3 – SET ÇARÇAFËSH -->
                  <div class="carousel-item">
                    <div class="d-flex gap-3 align-items-center">
                      <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh"
                           class="rounded-3 flex-shrink-0"
                           style="width: 110px; height: 110px; object-fit: cover;">
                      <div class="flex-grow-1">
                        <span class="badge bg-warning-subtle text-warning border border-warning mb-1">Set çarçafësh</span>
                        <p class="mb-1 fw-semibold">Set çarçafësh pambuk</p>
                        <p class="mb-1 small text-muted">Material i butë, ngjyra që nuk zbehen, ideale për përdorim ditor.</p>
                        <div class="d-flex align-items-baseline gap-2">
                          <span class="fw-bold text-danger">€25.00</span>
                          <span class="text-muted text-decoration-line-through small">€59.00</span>
                        </div>
                        <a href="/postava" class="small text-decoration-none text-danger d-inline-flex align-items-center gap-1 mt-1">
                          Shko te setet e çarçafëve <i class="bi bi-arrow-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>

                <!-- Indicators -->
                <div class="mt-3 d-flex justify-content-center gap-2">
                  <button type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide-to="0" class="active rounded-pill border-0" style="width:8px;height:8px;background:#dc3545;"></button>
                  <button type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide-to="1" class="rounded-pill border-0" style="width:8px;height:8px;background:#ced4da;"></button>
                  <button type="button" data-bs-target="#weeklyOffersCarousel" data-bs-slide-to="2" class="rounded-pill border-0" style="width:8px;height:8px;background:#ced4da;"></button>
                </div>
              </div>

              <a href="/tepiha" class="btn btn-outline-dark w-100 mt-3 rounded-pill btn-sm">
                Shiko të gjitha ofertat
              </a>
            </div>
          </div>
        </div>
        <!-- /KARTA: OFERTA E JAVËS -->

      </div>
    </div>
  </section>

  <!-- MAIN CONTENT -->
  <main class="py-5">
    <div class="container">

      <!-- KATEGORITË KRYESORE -->
      <section class="mb-5">
        <div class="section-title">
          <span>KATEGORITË KRYESORE</span>
          <h2>Çfarë po kërkon sot?</h2>
        </div>
        <div class="row g-4">
          <div class="col-md-3 col-sm-6">
            <a href="/tepiha" class="text-decoration-none text-dark">
              <div class="category-card">
                <div class="category-image-wrapper">
                  <img src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha">
                  <span class="category-tag">Tepiha</span>
                </div>
                <div class="category-body">
                  <h5>Tepiha modern & klasik</h5>
                  <p>Modele për sallon, korridor, dhoma fëmijësh dhe banjo.</p>
                  <span class="category-link">Shiko tepihat →</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/anesore" class="text-decoration-none text-dark">
              <div class="category-card">
                <div class="category-image-wrapper">
                  <img src="{{ asset('slider/raffaello.jpg') }}" alt="Perde">
                  <span class="category-tag">Perde</span>
                </div>
                <div class="category-body">
                  <h5>Perde anësore & ditore</h5>
                  <p>Tekstile cilësore me sisteme amerikane dhe dizajn modern.</p>
                  <span class="category-link">Shiko perdet →</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/postava" class="text-decoration-none text-dark">
              <div class="category-card">
                <div class="category-image-wrapper">
                  <img src="{{ asset('slider/bedshet.jpg') }}" alt="Set çarçafësh">
                  <span class="category-tag">Shtrat</span>
                </div>
                <div class="category-body">
                  <h5>Set çarçafësh & kompleta krevati</h5>
                  <p>Material i butë, i qëndrueshëm dhe ngjyra që nuk zbehen.</p>
                  <span class="category-link">Shiko setet →</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="/mbulesa" class="text-decoration-none text-dark">
              <div class="category-card">
                <div class="category-image-wrapper">
                  <img src="{{ asset('slider/paris.jpg') }}" alt="Mbulesa & batanije">
                  <span class="category-tag">Komfor</span>
                </div>
                <div class="category-body">
                  <h5>Mbulesa & batanije</h5>
                  <p>Batanije të ngrohta, mbulesa karrigesh dhe garnitura dekoruese.</p>
                  <span class="category-link">Shiko mbulesat →</span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </section>

      <!-- MODERN RUGS CAROUSEL -->
      <section class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-3">
          <div>
            <div class="rugs-badge mb-1">TEPIHA MODERN</div>
            <h2 class="rugs-card-title mb-0">Tepiha moderne në ofertë</h2>
            <p class="text-muted small mb-0">Modele të zgjedhura nga koleksioni ynë.</p>
          </div>
          <a href="/tepiha" class="btn btn-danger btn-sm rounded-pill mt-3 mt-md-0">Shiko të gjithë katalogun e tepihave</a>
        </div>

        <div id="modernRugsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
          <div class="carousel-inner">
            @php
              $rugs = [
                ['side.bmp',  'Modern Rose 120x170 cm',  '€45.00'],
                ['hali4.jpg', 'Modern Hali 300x200 cm',  '€95.00'],
                ['gold.bmp',  'Modern Gold 300x200 cm',  '€55.00'],
                ['gold1.bmp', 'Modern Gold 300x200 cm',  '€55.00'],
                ['gold2.bmp', 'Modern Gold 300x200 cm',  '€55.00'],
                ['rose1.jpg', 'rose 300x200 cm',         '€105.00'],
                ['rose2.bmp', 'rose 150x230 cm',         '€75.00'],
                ['rose3.bmp', 'rose 150x230 cm',         '€75.00'],
                ['hali5.jpg', 'hali 150x230 cm',         '€65.00'],
                ['hali3.jpg', 'hali 150x230 cm',         '€65.00'],
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
                      <img
                        src="{{ asset('slider/'.$item[0]) }}"
                        alt="{{ $item[1] }}"
                        class="img-fluid rounded shadow-sm mb-2"
                        style="height: 200px; width: auto; object-fit: contain;">
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
      </section>

      <!-- LATEST PRODUCTS (DYNAMIC) -->
      <!-- LATEST PRODUCTS (DYNAMIC) -->
<section class="mb-5">
  <div class="section-title">
    <span>PRODUKTET E FUNDIT</span>
    <h2>Zbuloni çfarë ka ardhur rishtazi</h2>
  </div>

  <div class="row g-4">
    @if(isset($items) && $items->count())
      @foreach($items->take(3) as $item)
        <div class="col-md-4">
          <div class="card product-card">
            @if($item->image_path)
              <img src="{{ asset('storage/'.$item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
            @else
              <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:260px;">
                <span class="text-white">Pa foto</span>
              </div>
            @endif

            <div class="card-body">
              <h5 class="card-title fw-bold text-danger mb-1">
                {{ $item->name }}
              </h5>
              <p class="card-text text-muted mb-0">
                {{ \Illuminate\Support\Str::limit($item->description, 100) }}
              </p>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</section>

      <!-- WHY CHOOSE US -->
      <section class="py-5 bg-white rounded-4 px-3 px-md-4">
        <div class="row align-items-center gy-4">
          <div class="col-md-5">
            <div class="section-title text-md-start text-center mb-3 mb-md-0">
              <span>PSE BRILLANT?</span>
              <h2>Tekstil i zgjedhur, shërbim i kujdesshëm.</h2>
            </div>
            <img src="{{ asset('slider/raffaello.jpg') }}" class="img-fluid rounded-4 shadow-sm" alt="Why Choose Us">
          </div>
          <div class="col-md-7">
            <div class="why-bullet mb-3">
              <h5>American System Curtains</h5>
              <p>Perde me sistem amerikan, montim i lehtë dhe pamje elegante për çdo ambient modern.</p>
            </div>
            <div class="why-bullet mb-3">
              <h5>Antibacterial Acrylic Rugs</h5>
              <p>Tepiha akrilik me mbrojtje antibakteriale, rezistent ndaj shtypjes dhe i lehtë për t’u pastruar.</p>
            </div>
            <div class="why-bullet mb-3">
              <h5>Plush bed covers & sheets</h5>
              <p>Mbulesa dhe çarçafë pelushi të butë, të rehatshëm dhe miqësorë me mjedisin, me materiale të riciklueshme.</p>
            </div>
            <div class="why-bullet mb-0">
              <h5>Shërbim profesional në Lipjan</h5>
              <p>
                Matje në terren, konsulencë për zgjedhjen e modelit dhe qepje profesionale.
                Fokus i plotë në cilësi dhe kënaqësi të klientit.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- SEO TEXT SECTION -->
      <section class="seo-text mt-5">
        <h2>Brillant – Tepiha, Perde dhe Dekorime për Shtëpi</h2>
        <p>Brillant është destinacioni juaj i besueshëm për tepiha modern, perde cilësore, mbulesa të bukura dhe dekorime për shtëpi. Me përvojë shumëvjeçare, synimi ynë është t’ju ofrojmë produkte të cilësisë së lartë që i bëjnë ambientet tuaja më të bukura, më komode dhe më funksionale.</p>

        <p>Koleksioni ynë i tapetave përfshin tepihë modern, tepihë klasik, tepihë rrethor, tepihë për sallon dhe tapeta për banjo – të përzgjedhur me kujdes për të garantuar dizajn, qëndrueshmëri dhe cilësi të lartë. Për më shumë ngrohtësi dhe stil, ofrojmë edhe batanije premium, kompleta krevati dhe sete qarqafësh.</p>

        <p>Në kategorinë e perdeve dhe mbulesave, do të gjeni materiale të cilësisë së lartë, ngjyra që nuk zbehen dhe dizajne elegante që i përshtaten çdo ambienti. Po ashtu, ofrojmë jastëkë dekorues, garnishte dhe shumë produkte të tjera që e kompletojnë dekorimin e shtëpisë.</p>

        <p>Brillant – cilësi, stil dhe shërbim profesional në Lipjan. Porosit online lehtë dhe shpejt, me dërgesë të sigurt në gjithë Kosovën.</p>
      </section>

    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-light text-dark pt-5 pb-3 mt-5 border-top">
    <div class="container">
      <div class="row">
        <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
          <img src="{{ asset('images/llogo.png') }}" alt="brillant" width="150" class="mb-2">
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <h6 class="text-uppercase fw-bold mb-3">Products</h6>
          <ul class="list-unstyled">
            <li><a href="/tepiha" class="text-dark text-decoration-none">Carpet & Rugs</a></li>
            <li><a href="/tepiha" class="text-dark text-decoration-none">Decorative Carpets</a></li>
            <li><a href="/tepihebanjo" class="text-dark text-decoration-none">Bath Mats & Rugs</a></li>
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

      <div class="row mt-4">
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

  <script>
    // përditëso badge në të gjitha menutë
    window.updateCartBadges = function(totalQty){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = totalQty);
    };

    // dëgjo event-in global kur ndryshon shporta
    document.addEventListener('cart:updated', e => {
      if (e.detail && typeof e.detail.totalQty !== 'undefined') {
        updateCartBadges(e.detail.totalQty);
      }
    });
  </script>
</body>
</html>
