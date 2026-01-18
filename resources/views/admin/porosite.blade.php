<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Porositë – Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body{background:#f8f9fa;font-family:'Segoe UI',sans-serif}
    .app-navbar{background:#fff;box-shadow:0 8px 24px rgba(0,0,0,.05)}
    .dropdown-toggle::after{display:none}
    .sidebar{background:#343a40;min-height:100vh;color:#fff}
    .sidebar .nav-link{color:#adb5bd;border-radius:.375rem;padding:.5rem .75rem}
    .sidebar .nav-link.active,.sidebar .nav-link:hover{background:#dc3545;color:#fff!important}
    .logo{width:130px}
    .content{padding:2rem}
    .title{color:#dc3545;font-weight:700;font-size:22px}
    .offcanvas.sidebar{background:#343a40;color:#fff}
    .offcanvas.sidebar .nav-link{color:#adb5bd;padding:10px 15px;border-radius:4px}
    .offcanvas.sidebar .nav-link.active,.offcanvas.sidebar .nav-link:hover{background:#dc3545;color:#fff!important}
    .card-soft{background:#fff;border:0;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.06)}
    .badge-status{font-size:.8rem}
    .filter-bar .form-select,.filter-bar .form-control{min-width:160px}
    @media (max-width: 991px){ .content{padding:1rem} }
    @media (max-width: 767px){ .sidebar.desktop{display:none} }

    /* Card view (mobile) */
    .order-card{border:0;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.06)}
    .order-card .label{color:#6b7280}
    .order-card .value{font-weight:600}
  </style>
</head>
<body>

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Porositë</div>
    <div class="dropdown">
      <a class="text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
        <i class="fas fa-user-circle me-1"></i> Admin
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <form method="POST" action="{{ route('logout') }}"> @csrf
            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Dil</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar desktop -->
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
        <a class="nav-link" href="{{ route('admin.products.index') }}">
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

    <!-- Content -->
    <div class="col-lg-10 content">
      <div class="mb-3">
        <h1 class="h5 m-0">Lista e Porosive</h1>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

     <!-- Filter bar -->
<form method="get" class="card-soft p-3 mb-3 filter-bar">
  <div class="row g-2 align-items-end">
    <!-- Kërko: emër / telefon / email -->
    <div class="col-12 col-md-5">
      <label class="form-label mb-1">Kërko</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input
          type="text"
          name="q"
          value="{{ request('q') }}"
          class="form-control"
          placeholder="Emri, telefoni ose emaili…"
        >
      </div>
    </div>

    <!-- Statusi -->
    <div class="col-12 col-sm-6 col-md-3">
      <label class="form-label mb-1">Statusi</label>
      <select name="status" class="form-select" onchange="this.form.submit()">
        <option value="">Të gjitha</option>
        @foreach(['new'=>'Të reja','processing'=>'Në proces','completed'=>'Përfunduara','canceled'=>'Anuluara'] as $k=>$v)
          <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
        @endforeach
      </select>
    </div>

    <!-- Butoni Kërko -->
    <div class="col-6 col-md-2">
      <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
      <button class="btn btn-outline-secondary w-100" type="submit">Kërko</button>
    </div>

    <!-- Shiko të gjitha (reset) -->
    <div class="col-6 col-md-2">
      <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
      <a href="{{ route('admin.orders.all') }}" class="btn btn-secondary w-100">
  Shiko të gjitha
</a>
    </div>
  </div>
</form>


      <!-- Desktop table -->
      <div class="card-soft p-3 d-none d-lg-block">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width:70px">#</th>
                <th>Klienti</th>
                <th>Kontakti</th>
                <th style="width:120px">Totali</th>
                <th style="width:100px">Artikuj</th>
                <th style="width:140px">Statusi</th>
                <th style="width:160px">Data</th>
                <th style="width:90px"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $o)
                <tr>
                  <td>{{ $o->id }}</td>
                  <td>
                    <div class="fw-semibold">{{ $o->name }}</div>
                    <div class="text-muted small">{{ $o->address }}@if($o->city), {{ $o->city }}@endif @if($o->zip) ({{ $o->zip }})@endif</div>
                  </td>
                  <td class="small">
                    <div><i class="fa fa-phone me-1"></i>{{ $o->phone }}</div>
                    @if($o->email)<div><i class="fa fa-envelope me-1"></i>{{ $o->email }}</div>@endif
                  </td>
                  <td>{{ number_format($o->total,2) }} €</td>
                  <td>{{ $o->items_count ?? ($o->items_count ?? $o->items()->count()) }}</td>
                  <td>
                    @php
                      $map=['new'=>'primary','processing'=>'warning','completed'=>'success','canceled'=>'secondary'];
                    @endphp
                    <span class="badge bg-{{ $map[$o->status] ?? 'secondary' }} badge-status text-uppercase">{{ $o->status }}</span>
                    <form method="POST" action="{{ route('admin.orders.status',$o) }}" class="mt-1 d-flex gap-2 align-items-center auto-submit">
                      @csrf
                      <select name="status" class="form-select form-select-sm" style="width:160px">
                        @foreach(['new'=>'Të reja','processing'=>'Në proces','completed'=>'Përfunduara','canceled'=>'Anuluara'] as $k=>$v)
                          <option value="{{ $k }}" @selected($o->status===$k)>{{ $v }}</option>
                        @endforeach
                      </select>
                      <button class="btn btn-sm btn-outline-dark">Ruaj</button>
                    </form>
                  </td>
                  <td class="small text-muted">{{ $o->created_at->format('d.m.Y H:i') }}</td>
                  <td class="text-end">
                    <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-outline-dark">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="8" class="text-center text-muted py-4">S’ka porosi.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-2">{{ $orders->links() }}</div>
      </div>

      <!-- Mobile cards -->
      <div class="d-lg-none">
        @forelse($orders as $o)
          <div class="card order-card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="small text-muted">#{{ $o->id }}</div>
                  <div class="fw-semibold">{{ $o->name }}</div>
                </div>
                @php $map=['new'=>'primary','processing'=>'warning','completed'=>'success','canceled'=>'secondary']; @endphp
                <span class="badge bg-{{ $map[$o->status] ?? 'secondary' }} text-uppercase">{{ $o->status }}</span>
              </div>

              <div class="mt-2 small text-muted">
                {{ $o->address }}@if($o->city), {{ $o->city }}@endif @if($o->zip) ({{ $o->zip }})@endif
              </div>

              <div class="row row-cols-2 g-2 mt-2">
                <div><span class="label">Tel:</span> <span class="value">{{ $o->phone }}</span></div>
                <div><span class="label">Artikuj:</span> <span class="value">{{ $o->items_count ?? ($o->items_count ?? $o->items()->count()) }}</span></div>
                <div><span class="label">Totali:</span> <span class="value">{{ number_format($o->total,2) }} €</span></div>
                <div><span class="label">Data:</span> <span class="value">{{ $o->created_at->format('d.m.Y H:i') }}</span></div>
                @if($o->email)
                  <div class="col-12"><span class="label">Email:</span> <span class="value">{{ $o->email }}</span></div>
                @endif
              </div>

              <div class="d-flex gap-2 mt-3">
                <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-outline-dark flex-grow-1">
                  <i class="fa fa-eye"></i> Shiko
                </a>
                <form method="POST" action="{{ route('admin.orders.status',$o) }}" class="d-flex gap-2 flex-grow-1 auto-submit">
                  @csrf
                  <select name="status" class="form-select">
                    @foreach(['new'=>'Të reja','processing'=>'Në proces','completed'=>'Përfunduara','canceled'=>'Anuluara'] as $k=>$v)
                      <option value="{{ $k }}" @selected($o->status===$k)>{{ $v }}</option>
                    @endforeach
                  </select>
                  <button class="btn btn-danger">Ruaj</button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="card card-soft p-3 text-center text-muted">S’ka porosi.</div>
        @endforelse

        <div class="mt-2">{{ $orders->links() }}</div>
      </div>

    </div>
  </div>
</div>

<!-- Offcanvas Sidebar mobile -->
<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
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
      <a class="nav-link" href="{{ route('admin.products.index') }}">
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
<script>
// autosubmit për "Ndrysho statusin" te select
document.querySelectorAll('form.auto-submit select[name="status"]').forEach(sel=>{
  sel.addEventListener('change', e=>{
    const form = e.target.closest('form');
    if(form){
      const btn = form.querySelector('button[type="submit"]');
      if(btn){ btn.disabled = true; btn.innerHTML = 'Ruaj...'; }
      form.submit();
    }
  });
});
</script>
</body>
</html>
