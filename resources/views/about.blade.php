<!DOCTYPE html>   
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brillant - About Us</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    :root{
      --brand:#dc3545;
      --dark:#0f172a;
      --shadow-sm:0 4px 14px rgba(0,0,0,.08);
      --shadow-lg:0 12px 30px rgba(0,0,0,.12);
    }

    body{
      font-family:'Poppins',system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
      background: radial-gradient(circle at top, #fef2f2 0, #f9fafb 40%, #f3f4f6 100%);
      padding-top:96px;
      color:#111827;
    }

    /* NAVBAR – njësoj stil si faqet e tjera */
    .navbar-custom{
      position:fixed;
      top:12px;
      left:50%;
      transform:translateX(-50%);
      width:min(1150px,94%);
      padding:.65rem .9rem;
      background:linear-gradient(135deg,#020617 0%,#111827 40%,#1f2937 100%);
      border-radius:18px;
      backdrop-filter:blur(10px);
      box-shadow:var(--shadow-sm);
      z-index:1000;
    }

    .navbar-custom .navbar-brand img{
      height:46px;
      width:auto;
      filter:drop-shadow(0 2px 4px rgba(0,0,0,.18));
    }

    .navbar-custom .navbar-nav{
      margin-left:auto;
      align-items:center;
      gap:.25rem;
    }

    .navbar-custom .nav-link{
      font-weight:500;
      font-size:.9rem;
      letter-spacing:.02em;
      color:#e5e7eb !important;
      padding:.55rem .9rem;
      border-radius:999px;
      transition:background-color .18s ease,color .18s ease;
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus,
    .navbar-custom .nav-link.active{
      background:rgba(248,250,252,.08);
      color:#fff !important;
    }

    .navbar-custom .btn-outline-light.btn-sm{
      padding:.35rem .9rem;
      border-radius:999px;
      font-size:.8rem;
    }

    .dropdown-menu{
      border-radius:14px;
      box-shadow:var(--shadow-lg);
      padding:.5rem 0;
      border:0;
    }
    .dropdown-menu .dropdown-item{
      font-size:.88rem;
      border-radius:8px;
      padding:.35rem .85rem;
    }
    .dropdown-menu .dropdown-item:hover{
      background:#f3f4f6;
    }

    /* Submenu për "Perde" */
    .dropdown-submenu{
      position:relative;
    }
    .dropdown-submenu .submenu{
      display:none;
      position:absolute;
      top:0;
      left:100%;
      margin-left:.1rem;
      border-radius:1rem;
      min-width:180px;
    }
    .dropdown-submenu:hover .submenu{
      display:block;
    }

    .cart-badge{
      font-size:.7rem;
      padding:.15rem .45rem;
    }

    /* RESPONSIVE NAVBAR */
    @media (max-width:991.98px){
      body{ padding-top:86px; }

      .navbar-custom{
        left:auto;
        right:auto;
        transform:none;
        inset:12px 8px auto 8px;
        width:auto;
        border-radius:14px;
        padding:.55rem .75rem;
      }

      .navbar-custom .navbar-brand img{
        height:38px;
      }

      .navbar-custom .navbar-nav{
        align-items:flex-start;
        margin-top:.5rem;
      }

      .dropdown-menu{
        position:static;
        float:none;
        width:100%;
        margin-top:.3rem;
        box-shadow:none;
        border-radius:10px;
      }
      .dropdown-submenu .submenu{
        position:static;
        margin-left:0;
        box-shadow:none;
      }
      .dropdown-menu .dropdown-item{
        padding-left:1.2rem;
      }
    }

    @media (max-width:576px){
      .navbar-custom .nav-link{
        padding:.45rem .7rem;
        font-size:.85rem;
      }
    }

    footer{
      background-color:#f8f9fa;
    }

    /* HERO ABOUT */
    .about-hero{
      padding-top:2.2rem;
      padding-bottom:2.2rem;
    }
    .about-pill{
      display:inline-flex;
      align-items:center;
      gap:.45rem;
      padding:.2rem .85rem;
      border-radius:999px;
      background:#fee2e2;
      color:#b91c1c;
      font-size:.72rem;
      letter-spacing:.16em;
      text-transform:uppercase;
      font-weight:700;
    }
    .about-pill i{
      font-size:.9rem;
    }
    .about-title{
      font-weight:800;
      font-size:clamp(1.7rem, 1.2rem + 1.3vw, 2.2rem);
      color:#0f172a;
      margin-top:.7rem;
      margin-bottom:.4rem;
    }
    .about-subtitle{
      color:#6b7280;
      font-size:.95rem;
      max-width:520px;
    }

    .about-metrics{
      display:flex;
      flex-wrap:wrap;
      gap:1.4rem;
      margin-top:1.5rem;
    }
    .metric-item h4{
      font-size:1.35rem;
      font-weight:800;
      margin-bottom:.15rem;
      color:#111827;
    }
    .metric-item span{
      font-size:.82rem;
      letter-spacing:.08em;
      text-transform:uppercase;
      color:#6b7280;
      font-weight:600;
    }

    .about-hero-img-wrap{
      position:relative;
      max-width:520px;
      margin-left:auto;
    }
    .about-hero-main{
      border-radius:22px;
      overflow:hidden;
      box-shadow:0 16px 40px rgba(15,23,42,.18);
      max-height:420px;              /* FOTO MË E VOGËL NË DESKTOP */
    }
    .about-hero-main img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }
    .about-hero-tag{
      position:absolute;
      bottom:14px;
      left:14px;
      background:rgba(15,23,42,.9);
      color:#f9fafb;
      padding:.6rem .9rem;
      border-radius:16px;
      font-size:.8rem;
      display:flex;
      align-items:center;
      gap:.55rem;
      backdrop-filter:blur(4px);
    }
    .about-hero-tag i{
      font-size:1.1rem;
      color:#facc15;
    }

    @media (max-width:991.98px){
      .about-hero-main{
        max-height:340px;           /* TABLET */
      }
    }
    @media (max-width:576px){
      .about-hero-img-wrap{
        max-width:100%;
        margin:1.5rem auto 0;
      }
      .about-hero-main{
        max-height:260px;           /* TELEFON */
      }
      .about-hero-tag{
        bottom:10px;
        left:10px;
        padding:.45rem .7rem;
        font-size:.76rem;
      }
    }

    /* OUR STORY – kartat me foto */
    .image-card{
      overflow:hidden;
      border-radius:20px;
      transition:transform .35s ease,box-shadow .3s ease;
      box-shadow:0 5px 20px rgba(0,0,0,.08);
      height:380px;
      background:#fff;
    }
    .image-card img{
      width:100%;
      height:100%;
      object-fit:cover;
      transition:transform .4s ease;
    }
    .image-card:hover{
      transform:translateY(-4px);
      box-shadow:0 14px 35px rgba(15,23,42,.16);
    }
    .image-card:hover img{
      transform:scale(1.05);
    }
    .image-card.tall{
      height:430px;
    }

    @media(max-width:768px){
      .image-card,
      .image-card.tall{
        height:260px;
      }
    }

    .our-story-text{
      font-size:1.02rem;
      font-weight:500;
      color:#374151;
      max-width:900px;
      margin:0 auto 2rem auto;
      text-align:center;
    }

    .section-title{
      text-align:center;
      margin-bottom:1.75rem;
    }
    .section-title span.badge-pill{
      text-transform:uppercase;
      letter-spacing:.16em;
      font-size:.7rem;
      border-radius:999px;
      padding:.25rem .8rem;
      background:#fee2e2;
      color:#b91c1c;
      font-weight:700;
      display:inline-block;
      margin-bottom:.4rem;
    }
    .section-title h2{
      font-weight:800;
      font-size:1.7rem;
      color:#111827;
    }
    .section-title p{
      max-width:620px;
      margin:.35rem auto 0;
      color:#6b7280;
      font-size:.9rem;
    }

    /* WHY CHOOSE US list */
    #why-us h5{
      color:#111827;
      display:flex;
      align-items:center;
      gap:.4rem;
    }
    #why-us h5::before{
      content:"";
      width:6px;
      height:6px;
      border-radius:999px;
      background:var(--brand);
      display:inline-block;
    }
    #why-us p{
      color:#4b5563;
      font-size:.95rem;
      margin-bottom:.25rem;
    }

    /* MINI CATALOG SECTION */
    .catalog-section{
  padding:3rem 0 3.5rem;
}

.catalog-grid{
  display:grid;
  grid-template-columns:repeat(3, minmax(0,1fr));
  gap:1.5rem;
}

@media(max-width:991.98px){
  .catalog-grid{
    grid-template-columns:repeat(2, minmax(0,1fr));
  }
}

@media(max-width:576px){
  .catalog-grid{
    grid-template-columns:1fr;
  }
}

/* KARTAT – I BËJMË MË TË LARTA */
.catalog-card{
  position:relative;
  border-radius:20px;
  overflow:hidden;
  min-height:340px;           /* ishte 220, tash ma e madhe */
  box-shadow:var(--shadow-sm);
  background:#111827;
  color:#f9fafb;
}

@media (min-width:992px){
  .catalog-card{
    min-height:400px;         /* desktop – edhe ma e gjatë */
  }
}

.catalog-card img{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  object-fit:cover;           /* e mban foton bukur, edhe nese osht vertikale */
  object-position:center;     /* e centron tepin / perden në mes */
  filter:brightness(.65);
  transform:scale(1.03);
  transition:transform .4s ease,filter .3s ease;
}

.catalog-card::after{
  content:"";
  position:absolute;
  inset:0;
  background:linear-gradient(to top, rgba(15,23,42,.85), rgba(15,23,42,.1));
}

.catalog-card-body{
  position:relative;
  z-index:1;
  padding:1.1rem 1.25rem;
  height:100%;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}

.catalog-card-title{
  font-weight:700;
  font-size:1.05rem;
  margin-bottom:.1rem;
}

.catalog-card-sub{
  font-size:.8rem;
  color:#e5e7eb;
}

.catalog-card-meta{
  font-size:.78rem;
  color:#d1d5db;
}

.catalog-card:hover img{
  transform:scale(1.07);
  filter:brightness(.8);
}

.catalog-btn{
  border-radius:999px;
  font-size:.78rem;
  padding:.4rem .95rem;
}

  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Kryemeny">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
    </a>

    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item me-lg-2"><a class="nav-link" href="/">Home</a></li>

        <li class="nav-item me-lg-2 dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Products</a>
          <ul class="dropdown-menu">
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
            <li><a class="dropdown-item" href="/garnishte"><i class="bi bi-dash-square me-2"></i>Garnishte</a></li>
          </ul>
        </li>

        <li class="nav-item me-lg-2">
          <a class="nav-link active" href="#">About Us</a>
        </li>

        <li class="nav-item me-lg-2">
          <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
        </li>

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

        {{-- Shporta + Gjurmo --}}
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

<h1>A jemi live</h1>


<!-- ABOUT HERO -->
<section class="about-hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <span class="about-pill">
          <i class="bi bi-patch-check-fill"></i>
          BRILLANT HOME TEXTILES
        </span>
        <h1 class="about-title">Creating warm, elegant homes since 2008.</h1>
        <p class="about-subtitle">
          Nga tepihët modern dhe tradicional, deri te perdet, mbulesat dhe tekstili për dhomë gjumi –
          Brillant ndihmon familjet të krijojnë ambiente të ngrohta, praktike dhe shumë më stil,
          në Lipjan dhe në gjithë Kosovën.
        </p>

        <div class="about-metrics">
          <div class="metric-item">
            <h4>16+</h4>
            <span>VITE EKSPERIENCË</span>
          </div>
          <div class="metric-item">
            <h4>3000+</h4>
            <span>KLIENTË TË KËNAQUR</span>
          </div>
          <div class="metric-item">
            <h4>5000+</h4>
            <span>PRODUKTE TEKSTILI</span>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="about-hero-img-wrap">
          <div class="about-hero-main">
            <!-- Ndërro me foton tënde (slider/about-hero.jpg) -->
            <img src="{{ asset('slider/paris.jpg') }}" alt="Brillant showroom & carpets">
          </div>
          <div class="about-hero-tag">
            <i class="bi bi-house-heart-fill"></i>
            <div>
              <strong>Tekstil për shtëpi reale</strong><br>
              <small>Tepiha, perde dhe tekstil të përshtatur për stilin e jetës suaj të përditshme.</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- OUR STORY -->
<section class="py-5">
  <div class="container">
    <div class="section-title">
      <span class="badge-pill">Our Story</span>
      <h2>Over 16 Years of Craft & Comfort</h2>
      <p>From a small family business to a trusted home-textile brand, we’ve grown together with our customers.</p>
    </div>

    <p class="our-story-text">
      Për më shumë se 16 vite, Brillant ka sjellë në treg tepiha, perde dhe tekstile cilësore për çdo lloj shtëpie.
      Edhe pse patëm një pauzë njëvjeçare, pasioni ynë për punën nuk është shuar kurrë.
      U rikthyem më të fortë – me koleksione të reja, dizajn modern dhe standarde edhe më të larta cilësie.
    </p>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="image-card">
          <img src="{{ asset('slider/hali4.jpg') }}" alt="Elegant Carpet">
        </div>
      </div>
      <div class="col-md-4">
        <div class="image-card tall">
          <img src="{{ asset('slider/machine.png') }}" alt="Production Machine">
        </div>
      </div>
      <div class="col-md-4">
        <div class="image-card">
          <img src="{{ asset('slider/carpetmachine.jpg') }}" alt="Textile Sewing">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section id="why-us" class="py-5 bg-light">
  <div class="container">
    <div class="section-title">
      <span class="badge-pill">Why choose us</span>
      <h2>— WHY CHOOSE BRILLANT —</h2>
      <p>Ne kombinojmë dizajnin modern, materialet cilësore dhe një shërbim profesional për të krijuar shtëpi të ngrohta dhe elegante.</p>
    </div>

    <div class="row align-items-center gy-4">
      <div class="col-md-6 mb-3 mb-md-0">
        <img src="{{ asset('slider/raffaello.jpg') }}" class="img-fluid rounded shadow-sm" alt="Why Choose Us">
      </div>
      <div class="col-md-6">
        <ul class="list-unstyled">
          <li class="mb-4">
            <h5 class="fw-bold">American System Curtains</h5>
            <p>Perde moderne me sistem montimi amerikan, të lehta për përdorim dhe tepër elegante për çdo dhomë.</p>
          </li>
          <li class="mb-4">
            <h5 class="fw-bold">Antibacterial Acrylic Rugs</h5>
            <p>Tepiha akrilik me mbrojtje antibakteriale, të qëndrueshëm dhe të lehtë për mirëmbajtje – ideal për familje.</p>
          </li>
          <li class="mb-4">
            <h5 class="fw-bold">Fashionable Curtains</h5>
            <p>Perde trendi si bamboo, sugar voile dhe stile unike që kombinohen me interierët modern dhe klasik.</p>
          </li>
          <li class="mb-4">
            <h5 class="fw-bold">Commitment to Quality</h5>
            <p>Çdo produkt kalon nëpër kontroll rigoroz cilësie, në mënyrë që klienti të marrë gjithmonë rezultatin më të mirë.</p>
          </li>
          <li class="mb-4">
            <h5 class="fw-bold">Plush Bed Covers</h5>
            <p>Mbulesat tona prej pelushi ofrojnë komoditet maksimal dhe janë prodhuar nga materiale të riciklueshme,
              duke balancuar luksin me kujdesin për mjedisin.</p>
          </li>
          <li class="mb-4">
            <h5 class="fw-bold">Water-Resistant Terry Plush Sheets</h5>
            <p>Çarçafë pelushi me shtresë rezistuese ndaj ujit – praktikë, higjienë dhe elegancë në një produkt të vetëm.</p>
          </li>
          <li>
            <h5 class="fw-bold">Modern Accessories & Support</h5>
            <p>Kënaqësia juaj është prioriteti ynë. Ofron zgjidhje të personalizuara dhe mbështetje miqësore për çdo projekt të shtëpisë suaj.</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- MINI CATALOG / COLLECTIONS -->
<section class="catalog-section">
  <div class="container">
    <div class="section-title">
      <span class="badge-pill">Collections</span>
      <h2>Discover our main collections</h2>
      <p>Zbuloni koleksione të kuruara të tepiha-ve, perdeve dhe tekstileve të dhomës së gjumit – që kombinohen lehtë mes vete.</p>
    </div>

    <div class="catalog-grid">
      <!-- Tepiha -->
      <article class="catalog-card">
        <img src="{{ asset('slider/tepihali600cream.png') }}" alt="Tepiha">
        <div class="catalog-card-body">
          <div>
            <div class="catalog-card-title">Tepiha & Tapeta</div>
            <div class="catalog-card-sub">Tepiha modern, klasik dhe rrethor për sallon, dhoma gjumi dhe korridor.</div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3">
            <span class="catalog-card-meta">Madhësi: 120x170 · 150x230 · 200x300</span>
            <a href="/tepiha" class="btn btn-light btn-sm catalog-btn">
              Shiko koleksionin
            </a>
          </div>
        </div>
      </article>

      <!-- Perde -->
      <article class="catalog-card">
        <img src="{{ asset('slider/panamagray1.jpg') }}" alt="Perde">
        <div class="catalog-card-body">
          <div>
            <div class="catalog-card-title">Perde & Garnishte</div>
            <div class="catalog-card-sub">Perde anësore, perde ditore dhe sisteme amerikane për çdo dritare.</div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3">
            <span class="catalog-card-meta">Stile: klasike · moderne · minimaliste</span>
            <a href="/anesore" class="btn btn-light btn-sm catalog-btn">
              Perde anësore
            </a>
          </div>
        </div>
      </article>

      <!-- Dhoma gjumi -->
      <article class="catalog-card">
        <img src="{{ asset('slider/paris.jpg') }}" alt="Dhoma gjumi">
        <div class="catalog-card-body">
          <div>
            <div class="catalog-card-title">Dhoma gjumi & komoditet</div>
            <div class="catalog-card-sub">Set çarçafesh, mbulesa, batanije dhe tekstil pelushi për rehati gjatë gjithë vitit.</div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3">
            <span class="catalog-card-meta">Materiale: pambuk · pelush · mikrofiber</span>
            <a href="/postava" class="btn btn-light btn-sm catalog-btn">
              Shiko dhomat e gjumit
            </a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="pt-5 pb-3 mt-2">
  <div class="container text-center">
    <img src="{{ asset('images/llogo.png') }}" alt="Brillant Logo" width="150" class="mb-3">
    <p class="text-muted mb-1">© {{ date('Y') }} Brillant. All rights reserved.</p>
    <small class="text-muted">Crafted by RDR Digital L.L.C</small>
  </div>
</footer>

<script>
  // përditëson të gjitha badge-t e shportës në faqe
  window.updateCartBadges = function(totalQty){
    document.querySelectorAll('.cart-badge').forEach(function(badge){
      badge.textContent = totalQty;
      badge.style.transition = 'transform .18s';
      badge.style.transform = 'scale(1.12)';
      setTimeout(()=> badge.style.transform = 'scale(1)', 180);
    });
  };

  // dëgjo event-in global kur ndryshon shporta (p.sh. nga AJAX)
  document.addEventListener('cart:updated', function(e){
    if (e.detail && typeof e.detail.totalQty !== 'undefined') {
      updateCartBadges(e.detail.totalQty);
    }
  });
</script>

</body>
</html>
