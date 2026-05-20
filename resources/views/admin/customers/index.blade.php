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
    .line-item{border:1px solid var(--line);border-radius:var(--radius);padding:.75rem;background:#fbfcfd;margin-bottom:.75rem}
    .mini-total{font-size:.85rem;color:#667085}
    .payment-helper{display:grid;grid-template-columns:repeat(3,1fr);gap:.4rem}
    .pos-total{border:1px solid var(--line);border-radius:var(--radius);background:#111827;color:#fff;padding:1rem}
    .pos-total .label{color:#cbd5e1;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;font-weight:800}
    .pos-total .value{font-size:1.45rem;font-weight:900}
    .metric-band{background:#111827;color:#fff;border-radius:var(--radius);box-shadow:var(--shadow)}
    .metric-band .metric{padding:1rem;border-right:1px solid rgba(255,255,255,.12)}
    .metric-band .metric:last-child{border-right:0}
    .metric .label{color:#cbd5e1;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;font-weight:800}
    .metric .value{font-size:1.45rem;font-weight:900;line-height:1.1}
    .month-tile{border:1px solid var(--line);border-radius:var(--radius);padding:.75rem;background:#fff;min-height:104px}
    .month-name{font-weight:850;color:#344054}
    .private-value{display:inline-flex;align-items:center;gap:.45rem;min-height:1.25em}
    .private-mask{letter-spacing:.08em}
    .private-text.d-none{display:none!important}
    .private-toggle{border:1px solid var(--line);background:#fff;color:var(--ink);border-radius:999px;width:28px;height:28px;display:inline-grid;place-items:center;padding:0;line-height:1}
    .private-toggle:hover{border-color:var(--brand);color:var(--brand)}
    .metric-band .private-toggle{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.28);color:#fff}
    .metric-band .private-toggle:hover{background:#fff;color:var(--brand)}
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
      @php
        $privateValue = function ($value) {
            return new \Illuminate\Support\HtmlString(
                '<span class="private-value" data-private-value>'
                .'<span class="private-mask">****</span>'
                .'<span class="private-text d-none">'.e($value).'</span>'
                .'<button type="button" class="private-toggle" data-private-toggle aria-label="Shfaq vleren"><i class="fa fa-eye"></i></button>'
                .'</span>'
            );
        };
      @endphp

      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Kliente gjithsej</div><div class="stat-value">{!! $privateValue(number_format($stats['customersCount'] ?? 0)) !!}</div></div>
            <div class="stat-icon"><i class="fa fa-address-book"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Blerje te regjistruara</div><div class="stat-value">{!! $privateValue(number_format($stats['purchasesCount'] ?? 0)) !!}</div></div>
            <div class="stat-icon"><i class="fa fa-receipt"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Te ardhura nga blerjet</div><div class="stat-value">{!! $privateValue(number_format($stats['revenue'] ?? 0, 2).' EUR') !!}</div></div>
            <div class="stat-icon"><i class="fa fa-euro-sign"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Kliente 30 ditet e fundit</div><div class="stat-value">{!! $privateValue(number_format($stats['latestCount'] ?? 0)) !!}</div></div>
            <div class="stat-icon"><i class="fa fa-calendar-check"></i></div>
          </div>
        </div>
      </div>

      <div class="metric-band mb-3">
        <div class="row g-0">
          <div class="col-12 col-md-3 metric">
            <div class="label">Shitje sot</div>
            <div class="value">{!! $privateValue(number_format($stats['todaySales'] ?? 0, 2).' EUR') !!}</div>
            <div class="small text-white-50">{!! $privateValue(number_format($stats['todayReceipts'] ?? 0).' fatura sot') !!}</div>
          </div>
          <div class="col-12 col-md-3 metric">
            <div class="label">Shitje kete muaj</div>
            <div class="value">{!! $privateValue(number_format($stats['monthSales'] ?? 0, 2).' EUR') !!}</div>
            <div class="small text-white-50">Nga POS dhe website</div>
          </div>
          <div class="col-12 col-md-3 metric">
            <div class="label">Shitje {{ $reportYear }}</div>
            <div class="value">{!! $privateValue(number_format($stats['yearSales'] ?? 0, 2).' EUR') !!}</div>
            <div class="small text-white-50">Paguar {!! $privateValue(number_format($stats['yearPaid'] ?? 0, 2).' EUR') !!}</div>
          </div>
          <div class="col-12 col-md-3 metric">
            <div class="label">Borxh hapur</div>
            <div class="value">{!! $privateValue(number_format($stats['openBalance'] ?? 0, 2).' EUR') !!}</div>
            <div class="small text-white-50">Per t'u ndjekur nga klientet</div>
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
              <div class="small muted mt-1">Obligative</div>
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
                <h2>Fatura e pare</h2>
                <span class="small muted">Opsionale</span>
              </div>

              <div class="mb-2">
                <label class="form-label">Data e fatures</label>
                <input type="date" name="purchased_at" value="{{ old('purchased_at', now()->toDateString()) }}" class="form-control">
              </div>

              <div data-lines>
                <div class="line-item" data-line>
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>Artikulli 1</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger d-none" data-remove-line><i class="fa fa-trash"></i></button>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">Produkti / sendi qe bleu</label>
                    <input type="text" name="items[0][item_name]" class="form-control" placeholder="p.sh. Tepih, perde, postava..." required>
                    <div class="small muted mt-1">Obligative</div>
                  </div>
                  <div class="row g-2">
                    <div class="col-6">
                      <label class="form-label">Madhesia</label>
                      <input type="text" name="items[0][size]" class="form-control" placeholder="p.sh. 200x300">
                    </div>
                    <div class="col-6">
                      <label class="form-label">Sasia</label>
                      <input type="number" name="items[0][quantity]" value="1" min="1" class="form-control" data-qty>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Cmimi</label>
                      <input type="number" step="0.01" name="items[0][unit_price]" min="0" class="form-control" data-price>
                    </div>
                    <div class="col-6">
                      <label class="form-label">Totali</label>
                      <input type="number" step="0.01" name="items[0][total]" min="0" class="form-control" data-line-total>
                    </div>
                  </div>
                  <div class="mini-total mt-2">Llogaritja: <span data-line-preview>0.00 EUR</span></div>
                </div>
              </div>

              <button type="button" class="btn btn-outline-dark w-100" data-add-line>
                <i class="fa fa-plus me-1"></i> Shto artikull tjeter ne fature
              </button>

              <div class="mt-2">
                <label class="form-label">Shenime per faturen / blerjen</label>
                <textarea name="purchase_notes" rows="2" class="form-control" placeholder="p.sh. Pagesa e pjesshme, klienti e merr produktin te premten...">{{ old('purchase_notes') }}</textarea>
              </div>

              <div class="border-top mt-3 pt-3">
                <div class="section-title mb-2">
                  <h2>Pagesa</h2>
                  <span class="small muted">Shkruaje sa dha klienti</span>
                </div>
                <div class="row g-2">
                  <div class="col-6">
                    <label class="form-label">Zbritje</label>
                    <input type="number" step="0.01" name="discount" value="0" min="0" class="form-control" data-discount>
                  </div>
                  <div class="col-6">
                    <label class="form-label">Paguar</label>
                    <input type="number" step="0.01" name="paid_amount" value="0" min="0" class="form-control" data-paid>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Menyra e pageses</label>
                    <select name="payment_method" class="form-select">
                      <option value="cash">Cash</option>
                      <option value="card">Kartel</option>
                      <option value="bank">Banke</option>
                      <option value="mixed">E perzier</option>
                    </select>
                  </div>
                </div>

                <div class="payment-helper mt-2">
                  <button type="button" class="btn btn-sm btn-outline-danger" data-pay-none>Se ka pagu</button>
                  <button type="button" class="btn btn-sm btn-outline-dark" data-pay-half>Gjysmen</button>
                  <button type="button" class="btn btn-sm btn-outline-success" data-pay-full>Krejt</button>
                </div>

                <div class="pos-total mt-3">
                  <div class="d-flex justify-content-between gap-2">
                    <div>
                      <div class="label">Totali</div>
                      <div class="value"><span data-grand-total>0.00</span> EUR</div>
                    </div>
                    <div class="text-end">
                      <div class="label">Mbetur</div>
                      <div class="value"><span data-balance>0.00</span> EUR</div>
                    </div>
                  </div>
                  <div class="small mt-2">Subtotal: <span data-subtotal>0.00</span> EUR / Zbritje: <span data-discount-preview>0.00</span> EUR</div>
                </div>
              </div>
            </div>

            <button class="btn btn-danger w-100 mt-3">
              <i class="fa fa-plus me-1"></i> Regjistro klientin
            </button>
          </form>
        </div>

        <div class="col-12 col-xl-8">
          <div class="card-soft p-3 mb-3">
            <div class="section-title">
              <h2>Raporti i shitjeve fizike</h2>
              <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex gap-2">
                <input type="hidden" name="q" value="{{ $search }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                  @for($year = now()->year + 1; $year >= 2024; $year--)
                    <option value="{{ $year }}" @selected($reportYear == $year)>{{ $year }}</option>
                  @endfor
                </select>
              </form>
            </div>

            <div class="row g-2 mb-3">
              @php
                $months = [1=>'Jan',2=>'Shk',3=>'Mar',4=>'Pri',5=>'Maj',6=>'Qer',7=>'Kor',8=>'Gus',9=>'Sht',10=>'Tet',11=>'Nen',12=>'Dhj'];
              @endphp
              @foreach($months as $monthNumber => $monthLabel)
                @php $month = $monthlySales->get($monthNumber); @endphp
                <div class="col-6 col-md-3 col-xl-2">
                  <div class="month-tile">
                    <div class="month-name">{{ $monthLabel }}</div>
                    <div class="fw-bold">{!! $privateValue(number_format((float) ($month->total_sales ?? 0), 2).' EUR') !!}</div>
                    <div class="small muted">{!! $privateValue((int) ($month->receipts_count ?? 0).' fatura') !!}</div>
                    @if((float) ($month->open_balance ?? 0) > 0)
                      <div class="small text-danger">Borxh {!! $privateValue(number_format((float) $month->open_balance, 2)) !!}</div>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>

            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Fatura</th>
                    <th>Shitje</th>
                    <th>Paguar</th>
                    <th>Borxh</th>
                    <th class="text-end">Fatura ditore</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($dailySales as $day)
                    <tr>
                      <td class="fw-semibold">{{ \Carbon\Carbon::parse($day->sale_date)->format('d.m.Y') }}</td>
                      <td>{!! $privateValue((int) $day->receipts_count) !!}</td>
                      <td class="fw-bold">{!! $privateValue(number_format((float) $day->total_sales, 2).' EUR') !!}</td>
                      <td>{!! $privateValue(number_format((float) $day->paid_sales, 2).' EUR') !!}</td>
                      <td class="{{ (float) $day->open_balance > 0 ? 'text-danger fw-bold' : 'muted' }}">{!! $privateValue(number_format((float) $day->open_balance, 2).' EUR') !!}</td>
                      <td class="text-end">
                        <div class="btn-group">
                          <a href="{{ route('admin.customers.daily-invoice', $day->sale_date) }}" class="btn btn-sm btn-outline-dark">
                            <i class="fa fa-eye me-1"></i> Hap
                          </a>
                          <a href="{{ route('admin.customers.daily-invoice', ['date' => $day->sale_date, 'print' => 1]) }}" class="btn btn-sm btn-danger" target="_blank" rel="noopener">
                            <i class="fa fa-file-pdf me-1"></i> PDF
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="empty-state">Ende nuk ka shitje te regjistruara per {{ $reportYear }}.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-soft p-3 mb-3">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2 align-items-end">
              <div class="col-12 col-md-7">
                <label class="form-label">Kerko klientin</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                  <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Emer, telefon, email, produkt ose kod porosie...">
                  <input type="hidden" name="year" value="{{ $reportYear }}">
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
                <a class="btn btn-outline-secondary" href="{{ route('admin.customers.index', ['year' => $reportYear]) }}" aria-label="Reseto"><i class="fa fa-rotate-left"></i></a>
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
<script>
(function(){
  document.addEventListener('click', event => {
    const button = event.target.closest('[data-private-toggle]');
    if (!button) return;

    const wrapper = button.closest('[data-private-value]');
    if (!wrapper) return;

    const mask = wrapper.querySelector('.private-mask');
    const text = wrapper.querySelector('.private-text');
    const icon = button.querySelector('i');
    const isHidden = text.classList.contains('d-none');

    mask.classList.toggle('d-none', isHidden);
    text.classList.toggle('d-none', !isHidden);
    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
    button.setAttribute('aria-label', isHidden ? 'Fsheh vleren' : 'Shfaq vleren');
  });
})();

(function(){
  const lines = document.querySelector('[data-lines]');
  const add = document.querySelector('[data-add-line]');
  if (!lines || !add) return;

  function renumber(){
    [...lines.querySelectorAll('[data-line]')].forEach((line, index) => {
      line.querySelector('strong').textContent = 'Artikulli ' + (index + 1);
      line.querySelectorAll('input').forEach(input => {
        input.name = input.name.replace(/items\[\d+\]/, 'items[' + index + ']');
      });
      const remove = line.querySelector('[data-remove-line]');
      remove.classList.toggle('d-none', lines.querySelectorAll('[data-line]').length === 1);
    });
    calculate();
  }

  function money(value){
    return Number(value || 0).toFixed(2);
  }

  function calculateLine(line){
    const qty = parseFloat(line.querySelector('[data-qty]')?.value || 0);
    const price = parseFloat(line.querySelector('[data-price]')?.value || 0);
    const totalInput = line.querySelector('[data-line-total]');
    const computed = qty * price;

    if (totalInput && (!totalInput.value || document.activeElement !== totalInput)) {
      totalInput.value = money(computed);
    }

    const total = parseFloat(totalInput?.value || computed || 0);
    const preview = line.querySelector('[data-line-preview]');
    if (preview) preview.textContent = money(total) + ' EUR';

    return total;
  }

  function calculate(){
    const subtotal = [...lines.querySelectorAll('[data-line]')].reduce((sum, line) => sum + calculateLine(line), 0);
    const discountInput = document.querySelector('[data-discount]');
    const paidInput = document.querySelector('[data-paid]');
    const discount = Math.min(parseFloat(discountInput?.value || 0), subtotal);
    const grand = Math.max(subtotal - discount, 0);
    const paid = parseFloat(paidInput?.value || 0);
    const balance = Math.max(grand - paid, 0);

    document.querySelector('[data-subtotal]').textContent = money(subtotal);
    document.querySelector('[data-discount-preview]').textContent = money(discount);
    document.querySelector('[data-grand-total]').textContent = money(grand);
    document.querySelector('[data-balance]').textContent = money(balance);
  }

  add.addEventListener('click', () => {
    const clone = lines.querySelector('[data-line]').cloneNode(true);
    clone.querySelectorAll('input').forEach(input => {
      input.value = input.type === 'number' && input.name.includes('[quantity]') ? '1' : '';
    });
    lines.appendChild(clone);
    renumber();
  });

  lines.addEventListener('click', event => {
    const button = event.target.closest('[data-remove-line]');
    if (!button || lines.querySelectorAll('[data-line]').length === 1) return;
    button.closest('[data-line]').remove();
    renumber();
  });

  document.addEventListener('input', event => {
    if (event.target.closest('[data-line]') || event.target.matches('[data-discount], [data-paid]')) {
      calculate();
    }
  });

  document.querySelector('[data-pay-none]')?.addEventListener('click', () => {
    const paidInput = document.querySelector('[data-paid]');
    if (paidInput) paidInput.value = '0.00';
    calculate();
  });

  document.querySelector('[data-pay-half]')?.addEventListener('click', () => {
    const grand = parseFloat(document.querySelector('[data-grand-total]')?.textContent || 0);
    const paidInput = document.querySelector('[data-paid]');
    if (paidInput) paidInput.value = money(grand / 2);
    calculate();
  });

  document.querySelector('[data-pay-full]')?.addEventListener('click', () => {
    const grand = parseFloat(document.querySelector('[data-grand-total]')?.textContent || 0);
    const paidInput = document.querySelector('[data-paid]');
    if (paidInput) paidInput.value = money(grand);
    calculate();
  });

  calculate();
})();
</script>
</body>
</html>
