<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Dashboard – Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --brand:#dc3545;
      --ink:#111827;
      --muted:#6b7280;
      --sidebar:#343a40;
      --radius:14px;
      --shadow:0 8px 24px rgba(0,0,0,.06);
    }

    body{ background:#f8f9fa; font-family:'Segoe UI', system-ui, -apple-system, Roboto, Arial, sans-serif }

    /* NAV */
    .app-navbar{ background:#fff; box-shadow:0 8px 24px rgba(0,0,0,.05) }
    .title{ color:var(--brand); font-weight:700; font-size:22px }
    .dropdown-toggle::after{ display:none }

    /* SIDEBAR */
    .sidebar{ background:var(--sidebar); min-height:100vh; color:#fff }
    .sidebar .nav-link{ color:#adb5bd; border-radius:.5rem; padding:.55rem .75rem; font-weight:600 }
    .sidebar .nav-link i{ width:18px }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover{ background:var(--brand); color:#fff !important }

    .logo{ width:130px }

    /* CONTENT */
    .content{ padding:2rem }
    @media (max-width:991px){ .content{ padding:1rem } }
    @media (max-width:767px){ .sidebar.desktop{ display:none } }

    /* CARDS */
    .card-soft{ background:#fff; border:0; border-radius:var(--radius); box-shadow:var(--shadow) }

    /* KPI */
    .kpi{ display:flex; align-items:center; gap:.9rem }
    .kpi-icon{
      width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center;
      background:#f1f2f6; color:var(--brand); font-size:18px; flex:0 0 44px;
    }
    .kpi .label{ color:var(--muted); font-size:.9rem; margin-bottom:2px }
    .kpi .value{ color:var(--ink); font-weight:800; font-size:1.6rem; line-height:1 }
    .kpi a.stretched-link{ border-radius:var(--radius) }
    .kpi:hover .kpi-icon{ background:#ffe8ea }

    /* QUICK LINKS */
    .quick .btn{ border-radius:10px; font-weight:600 }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Hape menunë">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Dashboard</div>
    <div class="dropdown">
      <a class="text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
        <i class="fas fa-user-circle me-1"></i> Admin
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <form method="POST" action="{{ route('logout') }}"> @csrf
            <button type="submit" class="dropdown-item">
              <i class="fas fa-sign-out-alt me-2"></i> Dil
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- SIDEBAR (desktop) -->
    <div class="col-lg-2 d-none d-lg-block sidebar desktop p-3">
      <div class="text-center mb-4">
        <img src="{{ asset('images/llogo.png') }}" alt="Logo" class="logo img-fluid">
      </div>
      <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="fas fa-home me-1"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
          <i class="fas fa-users me-1"></i> Përdoruesit
        </a>
        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
          <i class="fas fa-box-open me-1"></i> Produktet
        </a>
        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
          <i class="fas fa-shopping-cart me-1"></i> Porositë
        </a>
        <a class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}" href="{{ route('admin.stats') }}">
          <i class="fas fa-chart-line me-1"></i> Statistikat
        </a>
      </nav>
    </div>

    <!-- CONTENT -->
    <div class="col-lg-10 content">
      <!-- KPIs -->
      <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 h-100 position-relative">
            <div class="kpi">
              <div class="kpi-icon"><i class="fa fa-user"></i></div>
              <div>
                <div class="label">Përdorues</div>
                <div class="value">{{ $usersCount ?? '—' }}</div>
              </div>
            </div>
            <a class="stretched-link" href="{{ route('admin.users') }}" aria-label="Shko te Përdoruesit"></a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 h-100 position-relative">
            <div class="kpi">
              <div class="kpi-icon"><i class="fa fa-bag-shopping"></i></div>
              <div>
                <div class="label">Porosi</div>
                <div class="value">{{ $ordersCount ?? '—' }}</div>
              </div>
            </div>
            <a class="stretched-link" href="{{ route('admin.orders.index') }}" aria-label="Shko te Porositë"></a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 h-100 position-relative">
            <div class="kpi">
              <div class="kpi-icon"><i class="fa fa-box"></i></div>
              <div>
                <div class="label">Produkte</div>
                <div class="value">{{ $productsCount ?? '—' }}</div>
              </div>
            </div>
            <a class="stretched-link" href="{{ route('admin.products.index') }}" aria-label="Shko te Produktet"></a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 h-100 position-relative">
            <div class="kpi">
              <div class="kpi-icon"><i class="fa fa-euro-sign"></i></div>
              <div>
                <div class="label">Të ardhura</div>
                <div class="value">
                  @if(isset($revenue)) {{ number_format($revenue,2) }} € @else — @endif
                </div>
              </div>
            </div>
            <a class="stretched-link" href="{{ route('admin.stats') }}" aria-label="Shko te Statistikat"></a>
          </div>
        </div>
      </div>

      <!-- QUICK ACTIONS -->
      <div class="card-soft p-3 mb-4 quick">
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-outline-dark" href="{{ route('admin.orders.index') }}?status=new">
            <i class="fa fa-clock me-1"></i> Porosi të reja
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.orders.index') }}">
            <i class="fa fa-list me-1"></i> Shiko të gjitha porositë
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.products.create') }}">
            <i class="fa fa-plus me-1"></i> Shto produkt
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.stats') }}">
            <i class="fa fa-chart-line me-1"></i> Statistika
          </a>
        </div>
      </div>

      <!-- WELCOME -->
      <div class="card-soft p-3">
        <h5 class="mb-2">Mirësevjen!</h5>
        <p class="mb-0">Jeni kyçur si <span class="fw-bold text-danger">Admin</span>. Përdorni menunë anësore për të menaxhuar porositë, produktet dhe statistikat.</p>
      </div>
    </div>
  </div>
</div>

<!-- Offcanvas Sidebar (mobile) -->
<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Mbyll"></button>
  </div>
  <div class="offcanvas-body">
    <div class="text-center mb-4">
      <img src="{{ asset('images/llogo.png') }}" alt="Logo" class="logo img-fluid">
    </div>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home me-1"></i> Dashboard
      </a>
      <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
        <i class="fas fa-users me-1"></i> Përdoruesit
      </a>
      <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
        <i class="fas fa-box-open me-1"></i> Produktet
      </a>
      <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
        <i class="fas fa-shopping-cart me-1"></i> Porositë
      </a>
      <a class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}" href="{{ route('admin.stats') }}">
        <i class="fas fa-chart-line me-1"></i> Statistikat
      </a>
    </nav>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
