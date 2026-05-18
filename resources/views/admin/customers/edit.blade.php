<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Edito klientin - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{--brand:#dc3545;--brand-dark:#b42332;--ink:#17202a;--muted:#667085;--line:#e5e7eb;--sidebar:#242933;--surface:#fff;--page:#f5f6f8;--radius:8px;--shadow:0 10px 26px rgba(16,24,40,.07)}
    *{box-sizing:border-box}
    body{margin:0;background:var(--page);color:var(--ink);font-family:'Segoe UI',system-ui,-apple-system,Roboto,Arial,sans-serif}
    a{text-decoration:none}
    .app-navbar{background:#fff;border-bottom:1px solid var(--line);box-shadow:0 6px 18px rgba(16,24,40,.04)}
    .title{color:var(--brand);font-weight:800;font-size:22px}
    .dropdown-toggle::after{display:none}
    .sidebar{background:var(--sidebar);min-height:calc(100vh - 58px);color:#fff}
    .sidebar .nav-link{color:#c2c8d0;border-radius:var(--radius);padding:.62rem .75rem;font-weight:650;margin-bottom:.2rem}
    .sidebar .nav-link i{width:20px}
    .sidebar .nav-link.active,.sidebar .nav-link:hover{background:var(--brand);color:#fff!important}
    .logo{width:130px;max-height:74px;object-fit:contain}
    .content{padding:1.5rem 1.75rem 2rem}
    .page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:1rem}
    .eyebrow{font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);font-weight:800}
    .page-head h1{font-size:1.35rem;font-weight:850;margin:0}
    .page-head p{color:var(--muted);margin:.2rem 0 0}
    .card-soft{background:var(--surface);border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow)}
    .form-label{font-weight:700;color:#344054}
    .form-control,.form-select{border-color:var(--line);border-radius:var(--radius)}
    .btn{border-radius:var(--radius);font-weight:750}
    .btn-danger{background:var(--brand);border-color:var(--brand)}
    .btn-danger:hover{background:var(--brand-dark);border-color:var(--brand-dark)}
    .section-title{display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-bottom:.9rem}
    .section-title h2{font-size:1rem;font-weight:850;margin:0}
    .table{margin:0}
    .table thead th{font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);border-bottom:1px solid var(--line);white-space:nowrap}
    .table td{vertical-align:middle}
    .muted{color:var(--muted)}
    .empty-state{padding:2rem;text-align:center;color:var(--muted)}
    @media (max-width:991px){.content{padding:1rem}.page-head{flex-direction:column}.sidebar{min-height:100vh}}
    @media (max-width:767px){.sidebar.desktop{display:none}}
  </style>
</head>
<body>

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Edito klientin</div>
    <div class="dropdown">
      <a class="text-dark text-decoration-none fw-semibold" href="#" data-bs-toggle="dropdown">
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
    <div class="col-lg-2 d-none d-lg-block sidebar desktop p-3">
      <div class="text-center mb-4">
        <img src="{{ asset('images/llogo.png') }}" alt="Brillant" class="logo img-fluid">
      </div>
      <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="fas fa-home me-1"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
          <i class="fas fa-users me-1"></i> Perdoruesit
        </a>
        <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
          <i class="fas fa-address-book me-1"></i> Klientet
        </a>
        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
          <i class="fas fa-box-open me-1"></i> Produktet
        </a>
        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
          <i class="fas fa-shopping-cart me-1"></i> Porosite
        </a>
        <a class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}" href="{{ route('admin.stats') }}">
          <i class="fas fa-chart-line me-1"></i> Statistikat
        </a>
      </nav>
    </div>

    <main class="col-lg-10 content">
      <div class="page-head">
        <div>
          <div class="eyebrow">Klienti #{{ $customer->id }}</div>
          <h1>{{ $customer->name }}</h1>
          <p>{{ $customer->phone ?: 'Pa telefon' }} @if($customer->email) / {{ $customer->email }} @endif</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-dark">
          <i class="fa fa-arrow-left me-1"></i> Kthehu
        </a>
      </div>

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if($errors->any())
        <div class="alert alert-danger">Kontrollo fushat, ka disa te dhena qe mungojne ose nuk jane ne formatin e duhur.</div>
      @endif

      <div class="row g-3">
        <div class="col-12 col-xl-4">
          <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="card-soft p-3">
            @csrf @method('PUT')
            <div class="section-title">
              <h2>Te dhenat e klientit</h2>
            </div>
            <div class="mb-2">
              <label class="form-label">Emri dhe mbiemri</label>
              <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control" required>
            </div>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Telefoni</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control">
              </div>
            </div>
            <div class="row g-2 mt-0">
              <div class="col-md-7">
                <label class="form-label">Adresa</label>
                <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="form-control">
              </div>
              <div class="col-md-5">
                <label class="form-label">Qyteti</label>
                <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="form-control">
              </div>
            </div>
            <div class="mt-2">
              <label class="form-label">Shenime</label>
              <textarea name="notes" rows="4" class="form-control">{{ old('notes', $customer->notes) }}</textarea>
            </div>
            <button class="btn btn-danger w-100 mt-3">
              <i class="fa fa-save me-1"></i> Ruaj ndryshimet
            </button>
          </form>

          <form method="POST" action="{{ route('admin.customers.purchases.store', $customer) }}" class="card-soft p-3 mt-3">
            @csrf
            <div class="section-title">
              <h2>Shto blerje</h2>
            </div>
            <div class="mb-2">
              <label class="form-label">Produkti / sendet qe bleu</label>
              <input type="text" name="item_name" value="{{ old('item_name') }}" class="form-control" required>
            </div>
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label">Madhesia</label>
                <input type="text" name="size" value="{{ old('size') }}" class="form-control">
              </div>
              <div class="col-6">
                <label class="form-label">Data</label>
                <input type="date" name="purchased_at" value="{{ old('purchased_at', now()->toDateString()) }}" class="form-control">
              </div>
              <div class="col-4">
                <label class="form-label">Sasia</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" class="form-control">
              </div>
              <div class="col-4">
                <label class="form-label">Cmimi</label>
                <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" min="0" class="form-control">
              </div>
              <div class="col-4">
                <label class="form-label">Totali</label>
                <input type="number" step="0.01" name="total" value="{{ old('total') }}" min="0" class="form-control">
              </div>
            </div>
            <div class="mt-2">
              <label class="form-label">Shenime per blerjen</label>
              <textarea name="purchase_notes" rows="2" class="form-control">{{ old('purchase_notes') }}</textarea>
            </div>
            <button class="btn btn-outline-dark w-100 mt-3">
              <i class="fa fa-plus me-1"></i> Shto blerjen
            </button>
          </form>
        </div>

        <div class="col-12 col-xl-8">
          <div class="card-soft p-3">
            <div class="section-title">
              <h2>Historiku i blerjeve</h2>
              <span class="small muted">{{ $customer->purchases->count() }} blerje</span>
            </div>
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Produkti</th>
                    <th>Sasia</th>
                    <th>Cmimi</th>
                    <th>Totali</th>
                    <th>Burimi</th>
                    <th class="text-end">Veprim</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($customer->purchases as $purchase)
                    <tr>
                      <td class="small muted">{{ $purchase->purchased_at?->format('d.m.Y') }}</td>
                      <td>
                        <div class="fw-bold">{{ $purchase->item_name }}</div>
                        @if($purchase->size)<div class="small muted">{{ $purchase->size }}</div>@endif
                        @if($purchase->notes)<div class="small muted">{{ $purchase->notes }}</div>@endif
                      </td>
                      <td>{{ $purchase->quantity }}</td>
                      <td>{{ number_format((float) $purchase->unit_price, 2) }} EUR</td>
                      <td class="fw-bold">{{ number_format((float) $purchase->total, 2) }} EUR</td>
                      <td>
                        @if($purchase->order)
                          <a href="{{ route('admin.orders.show', $purchase->order) }}" class="btn btn-sm btn-outline-dark">
                            Porosia #{{ $purchase->order->id }}
                          </a>
                        @else
                          <span class="badge bg-light text-dark">Manuale</span>
                        @endif
                      </td>
                      <td class="text-end">
                        <form method="POST" action="{{ route('admin.customers.purchases.destroy', [$customer, $purchase]) }}" onsubmit="return confirm('Ta fshij kete blerje?');">
                          @csrf @method('DELETE')
                          <button class="btn btn-sm btn-outline-danger">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="empty-state">Ky klient ende nuk ka blerje te regjistruara.</td></tr>
                  @endforelse
                </tbody>
              </table>
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
    <div class="text-center mb-4">
      <img src="{{ asset('images/llogo.png') }}" alt="Brillant" class="logo img-fluid">
    </div>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home me-1"></i> Dashboard
      </a>
      <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
        <i class="fas fa-users me-1"></i> Perdoruesit
      </a>
      <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
        <i class="fas fa-address-book me-1"></i> Klientet
      </a>
      <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
        <i class="fas fa-box-open me-1"></i> Produktet
      </a>
      <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
        <i class="fas fa-shopping-cart me-1"></i> Porosite
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
