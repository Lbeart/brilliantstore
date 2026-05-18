<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Klientet - Setup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{--brand:#dc3545;--ink:#17202a;--muted:#667085;--line:#e5e7eb;--sidebar:#242933;--page:#f5f6f8;--radius:8px;--shadow:0 10px 26px rgba(16,24,40,.07)}
    body{margin:0;background:var(--page);color:var(--ink);font-family:'Segoe UI',system-ui,-apple-system,Roboto,Arial,sans-serif}
    .app-navbar{background:#fff;border-bottom:1px solid var(--line);box-shadow:0 6px 18px rgba(16,24,40,.04)}
    .title{color:var(--brand);font-weight:800;font-size:22px}
    .sidebar{background:var(--sidebar);min-height:calc(100vh - 58px);color:#fff}
    .sidebar .nav-link{color:#c2c8d0;border-radius:var(--radius);padding:.62rem .75rem;font-weight:650;margin-bottom:.2rem;text-decoration:none}
    .sidebar .nav-link i{width:20px}
    .sidebar .nav-link.active,.sidebar .nav-link:hover{background:var(--brand);color:#fff!important}
    .logo{width:130px;max-height:74px;object-fit:contain}
    .content{padding:1.5rem 1.75rem 2rem}
    .card-soft{background:#fff;border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow)}
    .code-box{background:#111827;color:#fff;border-radius:var(--radius);padding:1rem;font-weight:700;overflow:auto}
    .muted{color:var(--muted)}
    @media (max-width:991px){.content{padding:1rem}.sidebar.desktop{display:none}}
  </style>
</head>
<body>
<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Klientet</div>
    <a class="text-dark text-decoration-none fw-semibold" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-home me-1"></i> Dashboard
    </a>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-2 d-none d-lg-block sidebar desktop p-3">
      <div class="text-center mb-4">
        <img src="{{ asset('images/llogo.png') }}" alt="Brillant" class="logo img-fluid">
      </div>
      <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
        <a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users me-1"></i> Perdoruesit</a>
        <a class="nav-link active" href="{{ route('admin.customers.index') }}"><i class="fas fa-address-book me-1"></i> Klientet</a>
        <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open me-1"></i> Produktet</a>
        <a class="nav-link" href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart me-1"></i> Porosite</a>
        <a class="nav-link" href="{{ route('admin.stats') }}"><i class="fas fa-chart-line me-1"></i> Statistikat</a>
      </nav>
    </div>

    <main class="col-lg-10 content">
      <div class="card-soft p-4">
        <div class="d-flex align-items-start gap-3">
          <div class="fs-3 text-danger"><i class="fa fa-database"></i></div>
          <div>
            <h1 class="h4 fw-bold mb-2">Moduli i klienteve eshte gati, por databaza nuk eshte migruar ende.</h1>
            <p class="muted mb-3">Duhet te krijohen tabelat <strong>customers</strong> dhe <strong>customer_purchases</strong>. Pas migrimit, kjo faqe hapet me regjistrim, edit, delete dhe kerkim klientesh.</p>
            <div class="code-box">php artisan migrate --force</div>
            <div class="mt-3 d-flex flex-wrap gap-2">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">
                <i class="fa fa-arrow-left me-1"></i> Kthehu ne dashboard
              </a>
              <a href="{{ route('admin.customers.index') }}" class="btn btn-danger">
                <i class="fa fa-rotate-right me-1"></i> Provo prape
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Mbyll"></button>
  </div>
  <div class="offcanvas-body">
    <nav class="nav flex-column">
      <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
      <a class="nav-link active" href="{{ route('admin.customers.index') }}"><i class="fas fa-address-book me-1"></i> Klientet</a>
      <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open me-1"></i> Produktet</a>
      <a class="nav-link" href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart me-1"></i> Porosite</a>
    </nav>
  </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
