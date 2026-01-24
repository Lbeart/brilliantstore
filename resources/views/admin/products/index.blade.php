<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Produktet – Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --brand:#dc3545; --ink:#111827; --muted:#6b7280; --sidebar:#343a40;
      --radius:14px; --shadow:0 8px 24px rgba(0,0,0,.06);
    }
    body{ background:#f8f9fa; font-family:'Segoe UI',system-ui,-apple-system,Roboto,Arial,sans-serif }
    /* NAV */
    .app-navbar{ background:#fff; box-shadow:0 8px 24px rgba(0,0,0,.05) }
    .title{ color:var(--brand); font-weight:700; font-size:22px }
    .dropdown-toggle::after{ display:none }
    /* SIDEBAR */
    .sidebar{ background:var(--sidebar); min-height:100vh; color:#fff }
    .sidebar .nav-link{ color:#adb5bd; border-radius:.5rem; padding:.55rem .75rem; font-weight:600 }
    .sidebar .nav-link i{ width:18px }
    .sidebar .nav-link.active, .sidebar .nav-link:hover{ background:var(--brand); color:#fff !important }
    .logo{ width:130px }
    /* CONTENT */
    .content{ padding:2rem }
    @media (max-width:991px){ .content{ padding:1rem } }
    @media (max-width:767px){ .sidebar.desktop{ display:none } }

    /* CARDS / BOX */
    .card-soft{ background:#fff; border:0; border-radius:var(--radius); box-shadow:var(--shadow) }

    /* TABLE */
    .table thead th{ white-space:nowrap }
    .thumb{ height:56px; width:56px; border-radius:10px; background:#f1f2f6; object-fit:cover }
    .badge-soft{ font-weight:600; }
    .actions .btn{ border-radius:10px }

    /* PAGINATION */
    .pagination .page-item.active .page-link{ background:#dc3545; border-color:#dc3545 }
    .pagination .page-link{ color:#dc3545 }
    .pagination .page-link:hover{ color:#b02a37 }

    /* FILTER BAR */
    .filter-bar .form-control, .filter-bar .form-select{ min-width:160px }
    .filter-bar .input-group-text { background:#fff }
    .filter-sticky{ position:sticky; top:76px; z-index:998 }

    @media (max-width: 767px){
      .controls-wrap{ flex-direction:column; align-items:stretch !important; gap:.75rem }
      .filter-bar .row > [class*="col-"]{ margin-bottom:.35rem }
    }
  </style>
</head>
<body>

@php
  // ✅ FIX FOTO (admin): trajton JSON array, URL absolute, dhe rastin .../storage/[...]
  $admin_img_url = function($raw){
    $placeholder = asset('images/placeholder.png');
    if (empty($raw)) return $placeholder;

    // nese vjen array (p.sh. cast)
    if (is_array($raw)) $raw = $raw[0] ?? null;
    if (empty($raw)) return $placeholder;

    $raw = trim((string)$raw);

    // JSON array string: ["a.png","b.png"]
    if (str_starts_with($raw, '[')) {
      $d = json_decode($raw, true);
      if (is_array($d) && !empty($d)) $raw = $d[0];
    }

    // URL që përmban JSON: https://domain.com/storage/[...]
    if (preg_match('/\[[^\]]+\]/', $raw, $m)) {
      $d = json_decode($m[0], true);
      if (is_array($d) && !empty($d)) $raw = $d[0];
    }

    if (empty($raw)) return $placeholder;

    // nese është URL absolute, merre veç path-in
    if (preg_match('#^https?://#i', $raw)) {
      $raw = parse_url($raw, PHP_URL_PATH) ?? $raw;
    }

    $clean = ltrim($raw, '/');

    // pastro prefixet: storage/ ose public/
    $clean = preg_replace('#^(storage|public)/#', '', $clean);

    // nese është image në public/images
    if (str_starts_with($clean, 'images/')) return asset($clean);

    // gjithmon kthe URL nga storage public
    return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
  };
@endphp

<!-- NAVBAR -->
<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Produktet</div>
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
    <!-- SIDEBAR DESKTOP -->
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

      <!-- TOP BAR: Search + Add -->
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 controls-wrap">
        <form id="searchForm" method="GET" class="d-flex" action="{{ route('admin.products.index') }}">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input id="qInput" type="text" name="search" class="form-control" placeholder="Kërko me emër / slug…"
                   value="{{ request('search') }}" autocomplete="off">
          </div>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
          <i class="fa fa-plus me-1"></i> Shto Produkt
        </a>
      </div>

      <!-- FILTER BAR -->
      <form method="GET" class="card-soft p-3 mb-3 filter-bar filter-sticky" action="{{ route('admin.products.index') }}">
        <div class="row g-2 align-items-end">
          <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label mb-1">Statusi</label>
            <select name="active" class="form-select" onchange="this.form.submit()">
              <option value="">Të gjithë</option>
              <option value="1" @selected(request('active')==='1')>Aktiv</option>
              <option value="0" @selected(request('active')==='0')>Jo aktiv</option>
            </select>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label mb-1">Rendit sipas</label>
            <select name="sort" class="form-select" onchange="this.form.submit()">
              @php $sort = request('sort'); @endphp
              <option value="newest"  @selected($sort==='newest' || !$sort)>Më të rejat</option>
              <option value="oldest"  @selected($sort==='oldest')>Më të vjetrat</option>
              <option value="price_hi" @selected($sort==='price_hi')>Çmimi: lart → poshtë</option>
              <option value="price_lo" @selected($sort==='price_lo')>Çmimi: poshtë → lart</option>
              <option value="name_az" @selected($sort==='name_az')>Emri: A → Z</option>
              <option value="name_za" @selected($sort==='name_za')>Emri: Z → A</option>
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1">Për faqe</label>
            <select name="per_page" class="form-select" onchange="this.form.submit()">
              @php $pp = (int)request('per_page', 12); @endphp
              @foreach([12,24,50,100] as $n)
                <option value="{{ $n }}" @selected($pp===$n)>{{ $n }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">Reseto</a>
          </div>

          <input type="hidden" name="search" value="{{ request('search') }}">
        </div>
      </form>

      @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

      <!-- TABELA -->
      <div class="card-soft p-3">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th class="text-muted">#</th>
                <th>Foto</th>
                <th>Emri</th>
                <th>Çmimi</th>
                <th>Statusi</th>
                <th class="text-end">Veprime</th>
              </tr>
            </thead>
            <tbody>
            @forelse($products as $i => $p)
              @php
                $rawImg = $p->image_path ?? $p->image ?? null;
                $srcImg = $admin_img_url($rawImg);
              @endphp
              <tr>
                <td class="text-muted">
                  {{ method_exists($products,'firstItem') && $products->firstItem() ? $products->firstItem()+$i : $loop->iteration }}
                </td>
                <td>
                  <img
                    src="{{ $srcImg }}"
                    class="thumb" alt="{{ $p->name }}"
                    loading="lazy"
                    onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}'">
                </td>
                <td>
                  <div class="fw-semibold">{{ $p->name }}</div>
                  @if(!empty($p->slug))
                    <div class="small text-muted">/{{ $p->slug }}</div>
                  @endif
                </td>
                <td>€ {{ number_format($p->price ?? 0, 2) }}</td>
                <td>
                  @if($p->is_active)
                    <span class="badge bg-success badge-soft">Aktiv</span>
                  @else
                    <span class="badge bg-secondary badge-soft">Jo aktiv</span>
                  @endif
                </td>
                <td class="text-end actions">
                  <div class="btn-group">
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-dark">
                      <i class="fa fa-pen"></i> Edito
                    </a>
                    <button class="btn btn-sm btn-outline-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="visually-hidden">Veprime</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      @if(!empty($p->slug))
                        <li>
                          <a class="dropdown-item" href="{{ route('products.show', $p->slug) }}" target="_blank">
                            <i class="fa fa-external-link-alt me-2"></i> Shiko publik
                          </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                      @endif
                      <li>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Ta fshij produktin?');">
                          @csrf @method('DELETE')
                          <button class="dropdown-item text-danger">
                            <i class="fa fa-trash me-2"></i> Fshi
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-4">S’ka produkte.</td></tr>
            @endforelse
            </tbody>
          </table>
        </div>

        @if(method_exists($products,'links'))
          <div class="mt-2 d-flex justify-content-end">
            {{ $products->onEachSide(1)->appends(request()->query())->links('pagination::bootstrap-5') }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Offcanvas Sidebar (mobile) -->
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

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Debounce kërkimi: pret 500ms
(function(){
  const form = document.getElementById('searchForm');
  const input = document.getElementById('qInput');
  if(!form || !input) return;
  let t = null;
  input.addEventListener('input', function(){
    clearTimeout(t);
    t = setTimeout(()=> form.submit(), 500);
  });
})();
</script>
</body>
</html>
