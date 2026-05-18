<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --brand:#dc3545;
      --brand-dark:#b42332;
      --ink:#17202a;
      --muted:#667085;
      --line:#e5e7eb;
      --sidebar:#242933;
      --surface:#ffffff;
      --page:#f5f6f8;
      --radius:8px;
      --shadow:0 10px 26px rgba(16,24,40,.07);
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      background:var(--page);
      color:var(--ink);
      font-family:'Segoe UI',system-ui,-apple-system,Roboto,Arial,sans-serif;
    }
    a{text-decoration:none}

    .app-navbar{
      background:rgba(255,255,255,.96);
      border-bottom:1px solid var(--line);
      box-shadow:0 6px 18px rgba(16,24,40,.04);
      backdrop-filter:saturate(180%) blur(10px);
    }
    .title{color:var(--brand);font-weight:800;font-size:22px;letter-spacing:0}
    .dropdown-toggle::after{display:none}

    .sidebar{
      background:var(--sidebar);
      min-height:calc(100vh - 58px);
      color:#fff;
      border-right:1px solid rgba(255,255,255,.08);
    }
    .sidebar .nav-link{
      color:#c2c8d0;
      border-radius:var(--radius);
      padding:.62rem .75rem;
      font-weight:650;
      margin-bottom:.2rem;
    }
    .sidebar .nav-link i{width:20px}
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover{background:var(--brand);color:#fff!important}
    .logo{width:130px;max-height:74px;object-fit:contain}

    .content{padding:1.5rem 1.75rem 2rem}
    .page-head{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin-bottom:1rem}
    .eyebrow{font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);font-weight:800}
    .page-head h1{font-size:1.35rem;font-weight:800;margin:0}
    .page-head p{color:var(--muted);margin:.2rem 0 0}

    .card-soft{
      background:var(--surface);
      border:1px solid var(--line);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
    }
    .kpi{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:.9rem;
      min-height:132px;
      transition:transform .15s ease, box-shadow .15s ease;
    }
    .kpi:hover{transform:translateY(-1px);box-shadow:0 14px 32px rgba(16,24,40,.1)}
    .kpi-icon{
      width:42px;
      height:42px;
      border-radius:var(--radius);
      display:grid;
      place-items:center;
      background:#fff1f2;
      color:var(--brand);
      flex:0 0 42px;
      font-size:18px;
    }
    .kpi .label{color:var(--muted);font-size:.9rem;font-weight:650}
    .kpi .value{font-size:1.65rem;line-height:1.1;font-weight:850;margin-top:.35rem;color:var(--ink)}
    .kpi .sub{font-size:.82rem;color:var(--muted);margin-top:.35rem}

    .quick-actions .btn,
    .toolbar .btn{border-radius:var(--radius);font-weight:700}
    .quick-actions .btn-danger{background:var(--brand);border-color:var(--brand)}
    .quick-actions .btn-danger:hover{background:var(--brand-dark);border-color:var(--brand-dark)}

    .section-title{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:.75rem;
      margin-bottom:.8rem;
    }
    .section-title h2{font-size:1rem;font-weight:800;margin:0}
    .section-title a{font-size:.9rem;font-weight:750;color:var(--brand)}

    .status-row{display:grid;gap:.75rem}
    .status-item{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:.75rem;
      padding:.8rem;
      border:1px solid var(--line);
      border-radius:var(--radius);
      background:#fff;
    }
    .status-name{display:flex;align-items:center;gap:.55rem;font-weight:750}
    .status-dot{width:10px;height:10px;border-radius:999px;background:#98a2b3}
    .status-new{background:#0d6efd}
    .status-processing{background:#f59e0b}
    .status-completed{background:#12b76a}
    .status-canceled{background:#667085}

    .table{margin:0}
    .table thead th{font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);border-bottom:1px solid var(--line)}
    .table td{vertical-align:middle}
    .tracking-code{
      display:inline-flex;
      align-items:center;
      gap:.35rem;
      padding:.18rem .45rem;
      border:1px solid var(--line);
      border-radius:999px;
      background:#f9fafb;
      color:#344054;
      font-size:.82rem;
      font-weight:700;
      white-space:nowrap;
    }
    .empty-state{padding:2rem;text-align:center;color:var(--muted)}
    .badge-status{font-size:.75rem}

    .top-product{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:.75rem;
      padding:.72rem 0;
      border-bottom:1px solid var(--line);
    }
    .top-product:last-child{border-bottom:0}
    .rank{
      width:28px;
      height:28px;
      border-radius:var(--radius);
      display:grid;
      place-items:center;
      background:#f2f4f7;
      color:#344054;
      font-weight:850;
      flex:0 0 28px;
    }

    @media (max-width:991px){
      .content{padding:1rem}
      .page-head{align-items:flex-start;flex-direction:column}
      .sidebar{min-height:100vh}
    }
    @media (max-width:767px){
      .sidebar.desktop{display:none}
      .kpi{min-height:auto}
      .quick-actions .btn{width:100%}
      .table-responsive{border-radius:var(--radius)}
    }
  </style>
</head>
<body>

@php
  $statusLabels = [
    'new' => 'Të reja',
    'processing' => 'Në proces',
    'completed' => 'Përfunduara',
    'canceled' => 'Anuluara',
  ];
  $statusBadges = [
    'new' => 'primary',
    'processing' => 'warning',
    'completed' => 'success',
    'canceled' => 'secondary',
  ];
@endphp

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Hape menunë">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Admin Dashboard</div>
    <div class="dropdown">
      <a class="text-dark text-decoration-none fw-semibold" href="#" data-bs-toggle="dropdown" aria-label="Menu admini">
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
    <div class="col-lg-2 d-none d-lg-block sidebar desktop p-3">
      <div class="text-center mb-4">
        <img src="{{ asset('images/llogo.png') }}" alt="Brillant" class="logo img-fluid">
      </div>
      <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="fas fa-home me-1"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
          <i class="fas fa-users me-1"></i> Përdoruesit
        </a>
        <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
          <i class="fas fa-address-book me-1"></i> Klientet
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

    <main class="col-lg-10 content">
      <div class="page-head">
        <div>
          <div class="eyebrow">Përmbledhje</div>
          <h1>Kontrolli i porosive, produkteve dhe gjurmimit</h1>
          <p>Shiko punën e sotme, kodet e gjurmimit dhe aksionet kryesore në një vend.</p>
        </div>
        <div class="toolbar d-flex flex-wrap gap-2">
          <a class="btn btn-outline-dark" href="{{ route('admin.orders.all') }}">
            <i class="fa fa-list me-1"></i> Krejt porositë
          </a>
          <a class="btn btn-danger" href="{{ route('admin.products.create') }}">
            <i class="fa fa-plus me-1"></i> Shto produkt
          </a>
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <a class="card-soft kpi p-3 h-100 d-flex text-reset" href="{{ route('admin.orders.index') }}">
            <div>
              <div class="label">Porosi gjithsej</div>
              <div class="value">{{ number_format($ordersCount ?? 0) }}</div>
              <div class="sub">Sot: {{ number_format($todayOrders ?? 0) }} porosi</div>
            </div>
            <div class="kpi-icon"><i class="fa fa-bag-shopping"></i></div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <a class="card-soft kpi p-3 h-100 d-flex text-reset" href="{{ route('admin.orders.index') }}?status=new">
            <div>
              <div class="label">Në pritje</div>
              <div class="value">{{ number_format($pendingOrders ?? 0) }}</div>
              <div class="sub">Të reja dhe në proces</div>
            </div>
            <div class="kpi-icon"><i class="fa fa-clock"></i></div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <a class="card-soft kpi p-3 h-100 d-flex text-reset" href="{{ route('admin.products.index') }}">
            <div>
              <div class="label">Produkte</div>
              <div class="value">{{ number_format($productsCount ?? 0) }}</div>
              <div class="sub">Menaxho stokun dhe çmimet</div>
            </div>
            <div class="kpi-icon"><i class="fa fa-box"></i></div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <a class="card-soft kpi p-3 h-100 d-flex text-reset" href="{{ route('admin.stats') }}">
            <div>
              <div class="label">Të ardhura</div>
              <div class="value">{{ number_format($revenue ?? 0, 2) }} €</div>
              <div class="sub">Muaji: {{ number_format($monthRevenue ?? 0, 2) }} €</div>
            </div>
            <div class="kpi-icon"><i class="fa fa-euro-sign"></i></div>
          </a>
        </div>
      </div>

      <div class="card-soft quick-actions p-3 mb-3">
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-danger" href="{{ route('admin.orders.index') }}?status=new">
            <i class="fa fa-bell me-1"></i> Porosi të reja
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.orders.index') }}">
            <i class="fa fa-calendar-day me-1"></i> Porositë e sotme
          </a>
          <a class="btn btn-outline-dark" href="{{ route('track.form') }}" target="_blank" rel="noopener">
            <i class="fa fa-location-dot me-1"></i> Faqja e gjurmimit
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.customers.index') }}">
            <i class="fa fa-address-book me-1"></i> Klientet
          </a>
          <a class="btn btn-outline-dark" href="{{ route('admin.stats') }}">
            <i class="fa fa-chart-line me-1"></i> Raportet
          </a>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12 col-xl-8">
          <div class="card-soft p-3 h-100">
            <div class="section-title">
              <h2>Porositë e fundit</h2>
              <a href="{{ route('admin.orders.all') }}">Shiko të gjitha</a>
            </div>
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Klienti</th>
                    <th>Kodi</th>
                    <th>Totali</th>
                    <th>Statusi</th>
                    <th class="text-end">Veprim</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders ?? [] as $order)
                    <tr>
                      <td class="fw-semibold">#{{ $order->id }}</td>
                      <td>
                        <div class="fw-semibold">{{ $order->name }}</div>
                        <div class="small text-muted">{{ $order->phone }}</div>
                      </td>
                      <td>
                        @if($order->tracking_code)
                          <span class="tracking-code"><i class="fa fa-barcode"></i>{{ $order->tracking_code }}</span>
                        @else
                          <span class="text-muted">Pa kod</span>
                        @endif
                      </td>
                      <td>{{ number_format($order->total ?? 0, 2) }} €</td>
                      <td>
                        <span class="badge bg-{{ $statusBadges[$order->status] ?? 'secondary' }} badge-status text-uppercase">
                          {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                      </td>
                      <td class="text-end">
                        <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.orders.show', $order) }}">
                          <i class="fa fa-eye me-1"></i> Hap
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="empty-state">Ende nuk ka porosi për t'u shfaqur.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-4">
          <div class="card-soft p-3 mb-3">
            <div class="section-title">
              <h2>Statuset</h2>
              <a href="{{ route('admin.orders.index') }}">Filtro</a>
            </div>
            <div class="status-row">
              @foreach($statusLabels as $key => $label)
                <a class="status-item text-reset" href="{{ route('admin.orders.index') }}?status={{ $key }}">
                  <span class="status-name">
                    <span class="status-dot status-{{ $key }}"></span>
                    {{ $label }}
                  </span>
                  <span class="fw-bold">{{ number_format($statusCounts[$key] ?? 0) }}</span>
                </a>
              @endforeach
            </div>
          </div>

          <div class="card-soft p-3">
            <div class="section-title">
              <h2>Produktet top</h2>
              <a href="{{ route('admin.stats') }}">Statistika</a>
            </div>
            @forelse($topProducts ?? [] as $product)
              <div class="top-product">
                <div class="d-flex align-items-center gap-2">
                  <div class="rank">{{ $loop->iteration }}</div>
                  <div class="fw-semibold">{{ $product->name }}</div>
                </div>
                <span class="badge bg-light text-dark">{{ (int) $product->total_qty }} copë</span>
              </div>
            @empty
              <div class="empty-state">S'ka ende të dhëna për top produkte.</div>
            @endforelse
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Mbyll"></button>
  </div>
  <div class="offcanvas-body">
    <div class="text-center mb-4">
      <img src="{{ asset('images/llogo.png') }}" alt="Brillant" class="logo img-fluid">
    </div>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home me-1"></i> Dashboard
      </a>
      <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
        <i class="fas fa-users me-1"></i> Përdoruesit
      </a>
      <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
        <i class="fas fa-address-book me-1"></i> Klientet
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

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
