<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


  <style>
    body { margin: 0; padding: 0; }

    .carousel-wrapper { position: relative; }
    .carousel-item img { height: 95vh; object-fit: cover; }
    .carousel-caption { bottom: 30%; }
    .carousel-caption h2 {
      font-size: 4rem;
      font-weight: bold;
      color: #dc3545;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 0.5rem;
    }
    .carousel-caption p { font-size: 1.5rem; color: #fff; }

    .navbar-custom {
      position: absolute;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
       width: min(1250px, 78%);
      padding: 0.75rem 2rem;
      background-color: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(8px);
      border-radius: 2rem;
      font-family: 'Poppins', sans-serif;
      z-index: 1000;
    }
    .navbar-custom .navbar-brand img {
      width: 250px;
      height: auto;
      margin-right: 1rem;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .navbar-custom .navbar-nav {
      display: flex;
      margin-left: auto;
      align-items: center;
    }
    .navbar-custom .nav-link {
      font-weight: 500;
      font-size: 0.9rem;
      color: #444 !important;
      margin-left: 1rem;
      padding: 0.75rem 1rem;
    }
    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus { color: #dc3545 !important; }

    .dropdown-menu {
      border-radius: 1rem;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      padding: 0.5rem 0;
    }

    @media (max-width: 992px) {
      .navbar-custom { padding: 0.5rem 1.5rem; }
      .navbar-custom .navbar-brand img { width: 55px; }
      .navbar-custom .nav-link {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        margin-left: 0.75rem;
      }
    }

    @media (max-width: 768px) {
      .navbar-custom {
        top: 10px;
        width: 95%;
        padding: 0.5rem 1rem;
      }
      .navbar-custom .navbar-brand img {
        width: 250px;
        margin-right: 0.5rem;
      }
      .navbar-custom .nav-link {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
        margin-left: 0.5rem;
      }
      .navbar-custom .navbar-nav {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
      }
      .dropdown-menu {
        position: static;
        float: none;
        width: 100%;
        margin-top: 0.5rem;
      }
      .dropdown-menu .dropdown-item { padding-left: 1.5rem; }
    }
    @media (max-width: 768px) {
  .carousel-caption h2 {
    font-size: 2rem;
  }

  .carousel-caption p {
    font-size: 1rem;
  }
}
.dropdown-menu {
        position: static;
        float: none;
        width: 100%;
        margin-top: 0.5rem;
      }

      .dropdown-menu .dropdown-item {
        padding-left: 1.5rem;
      }
    }
    .dropdown-submenu .submenu {
  display: none;
  position: absolute;
  top: 0;
  left: 100%;
  margin-left: 0.1rem;
  border-radius: 1rem;
  min-width: 180px;
}

.dropdown-submenu:hover .submenu {
  display: block;
}
  </style>
</head>
<body>

<!-- Carousel + Navbar -->
<div class="carousel-wrapper">
  <div id="catalogCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('slider/foto1.jpg') }}" class="d-block w-100" alt="Slide 1">
       <div class="carousel-caption d-block text-center">
          <h2>Elegance</h2>
          <p>Design your home with our exclusive collection.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('slider/foto2.jpg') }}" class="d-block w-100" alt="Slide 2">
       <div class="carousel-caption d-block text-center">
          <h2>Home</h2>
          <p>Elevate your space with premium textiles.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('slider/foto3.jpg') }}" class="d-block w-100" alt="Slide 3">
       <div class="carousel-caption d-block text-center">
          <h2>Design</h2>
          <p>Crafted elegance for every room.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#catalogCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Prev</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#catalogCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid justify-content-center">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="{{ asset('images/brillant.png') }}" alt="Logo">
      </a>
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item me-3"><a class="nav-link" href="/">Home</a></li>
          <li class="nav-item dropdown me-3">
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
          <li class="nav-item me-3"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact us</a></li>
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
</div>

<!-- Contact Info Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-start">
      <!-- Info Box -->
      <div class="col-md-5">
        <h2 class="fw-bold mb-4 text-danger">Get in Touch</h2>
        <p class="mb-4 text-muted">Feel free to reach out to us. We're happy to help you anytime!</p>

        <div class="d-flex align-items-start mb-4">
          <i class="bi bi-envelope-fill fs-4 text-danger me-3"></i>
          <div>
            <h6 class="mb-1 fw-semibold">Email</h6>
            <p class="mb-0">leart.bytyqii98@gmail.com</p>
          </div>
        </div>

        <div class="d-flex align-items-start mb-4">
          <i class="bi bi-telephone-fill fs-4 text-danger me-3"></i>
          <div>
            <h6 class="mb-1 fw-semibold">Phone</h6>
            <p class="mb-0">+383 44 996 926</p>
            <p class="mb-0">+383 44 960 661</p>
          </div>
        </div>

        <div class="d-flex align-items-start mb-4">
          <i class="bi bi-geo-alt-fill fs-4 text-danger me-3"></i>
          <div>
            <h6 class="mb-1 fw-semibold">Address</h6>
            <p class="mb-0">Gjergj Fishta Street, 14000 Lipjan, Kosovo</p>
          </div>
        </div>
      </div>

      <!-- Map -->
      <div class="col-md-7 mt-4 mt-md-0">
        <div class="ratio ratio-16x9" style="min-height: 300px;">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d183.78392415478646!2d21.12132974236901!3d42.52252334917351!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1751018263759!5m2!1sen!2s"
    style="border:0;" allowfullscreen="" loading="lazy"
    class="w-100 h-100"></iframe>
</div>

      </div>
    </div>
  </div>
</section>

<!-- Contact Form -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Send us a message</h2>
      <p class="text-muted">Have questions? Fill out the form below and we’ll get back to you soon.</p>
    </div>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('contact.send') }}" method="POST" class="row g-3">
      @csrf
      <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="Your Name" required></div>
      <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Your Email" required></div>
      <div class="col-12"><input type="text" name="subject" class="form-control" placeholder="Subject" required></div>
      <div class="col-12"><textarea name="message" class="form-control" rows="6" placeholder="Your Message" required></textarea></div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-danger px-5">Send Message</button>
      </div>
    </form>
  </div>
</section>
<script>
  // përditëson të gjitha badge-t e shportës në faqe
  window.updateCartBadges = function(totalQty){
    document.querySelectorAll('.cart-badge').forEach(function(badge){
      badge.textContent = totalQty;
      // animim i vogël (opsional)
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