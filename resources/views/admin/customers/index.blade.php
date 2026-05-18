<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Klientet - Admin</title>
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
    .stat{display:flex;align-items:center;justify-content:space-between;gap:1rem;min-height:108px}
    .stat-icon{width:40px;height:40px;border-radius:var(--radius);display:grid;place-items:center;background:#fff1f2;color:var(--brand)}
    .stat-label{color:var(--muted);font-size:.86rem;font-weight:700}
    .stat-value{font-size:1.55rem;font-weight:850;line-height:1.1}
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
    .purchase-pill{display:inline-flex;align-items:center;gap:.35rem;padding:.24rem .5rem;margin:.12rem;border:1px solid var(--line);border-radius:999px;background:#f9fafb;color:#344054;font-size:.82rem;font-weight:650}
    .muted{color:var(--muted)}
    .empty-state{padding:2rem;text-align:center;color:var(--muted)}
    .customer-card{border:1px solid var(--line);border-radius:var(--radius);background:#fff}
    @media (max-width:991px){.content{padding:1rem}.page-head{flex-direction:column}.sidebar{min-height:100vh}}
    @media (max-width:767px){.sidebar.desktop{display:none}.stat{min-height:auto}.actions{width:100%;display:flex}.actions .btn,.actions form{flex:1}.actions form button{width:100%}}
  </style>
</head>
<body>

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Hape menun">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Klientet</div>
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
          <div class="eyebrow">Regjistri i klienteve</div>
          <h1>Regjistro, kerko dhe menaxho klientet qe blejne te Brillant</h1>
          <p>Ruaj kontaktin, produktet qe kane blere, shumen dhe daten e blerjes ne nje vend.</p>
        </div>
        <a class="btn btn-outline-dark" href="{{ route('admin.orders.all') }}">
          <i class="fa fa-list me-1"></i> Shiko porosite
        </a>
      </div>

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if($errors->any())
        <div class="alert alert-danger">Kontrollo fushat, ka disa te dhena qe mungojne ose nuk jane ne formatin e duhur.</div>
      @endif

      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Kliente gjithsej</div><div class="stat-value">{{ number_format($stats['customersCount'] ?? 0) }}</div></div>
            <div class="stat-icon"><i class="fa fa-address-book"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Blerje te regjistruara</div><div class="stat-value">{{ number_format($stats['purchasesCount'] ?? 0) }}</div></div>
            <div class="stat-icon"><i class="fa fa-receipt"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Te ardhura nga blerjet</div><div class="stat-value">{{ number_format($stats['revenue'] ?? 0, 2) }} EUR</div></div>
            <div class="stat-icon"><i class="fa fa-euro-sign"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Kliente 30 ditet e fundit</div><div class="stat-value">{{ number_format($stats['latestCount'] ?? 0) }}</div></div>
            <div class="stat-icon"><i class="fa fa-calendar-check"></i></div>
          </div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12 col-xl-4">
          <form method="POST" action="{{ route('admin.customers.store') }}" class="card-soft p-3">
            @csrf
            <div class="section-title">
              <h2>Shto klient</h2>
            </div>

            <div class="mb-2">
              <label class="form-label">Emri dhe mbiemri</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Telefoni</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
              </div>
            </div>
            <div class="row g-2 mt-0">
              <div class="col-md-7">
                <label class="form-label">Adresa</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
              </div>
              <div class="col-md-5">
                <label class="form-label">Qyteti</label>
                <input type="text" name="city" value="{{ old('city') }}" class="form-control">
              </div>
            </div>
            <div class="mb-3 mt-2">
              <label class="form-label">Shenime per klientin</label>
              <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
            </div>

            <div class="border-top pt-3">
              <div class="section-title mb-2">
                <h2>Blerja e pare</h2>
                <span class="small muted">Opsionale</span>
              </div>
              <div class="mb-2">
                <label class="form-label">Produkti / sendet qe bleu</label>
                <input type="text" name="item_name" value="{{ old('item_name') }}" class="form-control" placeholder="p.sh. Tepih, perde, postava...">
              </div>
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label">Madhesia</label>
                  <input type="text" name="size" value="{{ old('size') }}" class="form-control" placeholder="p.sh. 200x300">
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
            </div>

            <button class="btn btn-danger w-100 mt-3">
              <i class="fa fa-plus me-1"></i> Regjistro klientin
            </button>
          </form>
        </div>

        <div class="col-12 col-xl-8">
          <div class="card-soft p-3 mb-3">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2 align-items-end">
              <div class="col-12 col-md-7">
                <label class="form-label">Kerko klientin</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                  <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Emer, telefon, email, produkt ose kod porosie...">
                </div>
              </div>
              <div class="col-6 col-md-3">
                <label class="form-label">Rendit</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                  <option value="latest" @selected($sort === 'latest')>Blerja e fundit</option>
                  <option value="top" @selected($sort === 'top')>Me shume vlere</option>
                  <option value="name_az" @selected($sort === 'name_az')>Emri A-Z</option>
                  <option value="oldest" @selected($sort === 'oldest')>Me te vjetrit</option>
                </select>
              </div>
              <div class="col-6 col-md-2 d-flex gap-2">
                <button class="btn btn-outline-dark w-100" type="submit">Kerko</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.customers.index') }}" aria-label="Reseto"><i class="fa fa-rotate-left"></i></a>
              </div>
            </form>
          </div>

          <div class="card-soft p-3 d-none d-lg-block">
            <div class="section-title">
              <h2>Lista e klienteve</h2>
              <span class="small muted">Shfaq {{ $customers->firstItem() ?? 0 }}-{{ $customers->lastItem() ?? 0 }} nga {{ $customers->total() }}</span>
            </div>
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Klienti</th>
                    <th>Kontakti</th>
                    <th>Blerjet e fundit</th>
                    <th>Totali</th>
                    <th class="text-end">Veprime</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($customers as $customer)
                    <tr>
                      <td>
                        <div class="fw-bold">{{ $customer->name }}</div>
                        <div class="small muted">{{ $customer->address }}@if($customer->city), {{ $customer->city }}@endif</div>
                      </td>
                      <td class="small">
                        @if($customer->phone)<div><i class="fa fa-phone me-1"></i>{{ $customer->phone }}</div>@endif
                        @if($customer->email)<div><i class="fa fa-envelope me-1"></i>{{ $customer->email }}</div>@endif
                        @if(!$customer->phone && !$customer->email)<span class="muted">Pa kontakt</span>@endif
                      </td>
                      <td>
                        @forelse($customer->purchases as $purchase)
                          <span class="purchase-pill">{{ $purchase->item_name }} x{{ $purchase->quantity }}</span>
                        @empty
                          <span class="muted">Ende pa blerje</span>
                        @endforelse
                      </td>
                      <td>
                        <div class="fw-bold">{{ number_format($customer->purchases_sum_total ?? 0, 2) }} EUR</div>
                        <div class="small muted">{{ $customer->purchases_count }} blerje</div>
                      </td>
                      <td class="text-end">
                        <div class="btn-group">
                          <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-outline-dark">
                            <i class="fa fa-pen me-1"></i> Edito
                          </a>
                          <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" onsubmit="return confirm('Ta fshij klientin?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                              <i class="fa fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="5" class="empty-state">Nuk u gjet asnje klient.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="d-lg-none">
            @forelse($customers as $customer)
              <div class="customer-card p-3 mb-3">
                <div class="d-flex justify-content-between gap-2">
                  <div>
                    <div class="fw-bold">{{ $customer->name }}</div>
                    <div class="small muted">{{ $customer->phone ?: 'Pa telefon' }}</div>
                  </div>
                  <div class="text-end">
                    <div class="fw-bold">{{ number_format($customer->purchases_sum_total ?? 0, 2) }} EUR</div>
                    <div class="small muted">{{ $customer->purchases_count }} blerje</div>
                  </div>
                </div>
                <div class="mt-2">
                  @forelse($customer->purchases as $purchase)
                    <span class="purchase-pill">{{ $purchase->item_name }} x{{ $purchase->quantity }}</span>
                  @empty
                    <span class="muted">Ende pa blerje</span>
                  @endforelse
                </div>
                <div class="actions d-flex gap-2 mt-3">
                  <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-dark">
                    <i class="fa fa-pen me-1"></i> Edito
                  </a>
                  <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" onsubmit="return confirm('Ta fshij klientin?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger">
                      <i class="fa fa-trash me-1"></i> Fshi
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <div class="card-soft empty-state">Nuk u gjet asnje klient.</div>
            @endforelse
          </div>

          <div class="mt-3 d-flex justify-content-end">
            {{ $customers->links('pagination::bootstrap-5') }}
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
