<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Lista e PÃ«rdoruesve</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body{ background:#f8f9fa; font-family:'Segoe UI',sans-serif }
    .app-navbar{ background:#fff; box-shadow:0 8px 24px rgba(0,0,0,.05) }
    .dropdown-toggle::after{ display:none }
    .sidebar{ background:#343a40; min-height:100vh; color:#fff }
    .sidebar .nav-link{ color:#adb5bd; border-radius:.375rem; padding:.5rem .75rem }
    .sidebar .nav-link.active,.sidebar .nav-link:hover{ background:#dc3545; color:#fff !important }
    .logo{ width:130px }
    .content{ padding:2rem }
    .title{ color:#dc3545; font-weight:700; font-size:22px }
    .offcanvas.sidebar{ background:#343a40; color:#fff }
    .offcanvas.sidebar .nav-link{ color:#adb5bd; padding:10px 15px; border-radius:4px }
    .offcanvas.sidebar .nav-link.active,.offcanvas.sidebar .nav-link:hover{ background:#dc3545; color:#fff !important }
    @media (max-width:991px){ .content{ padding:1rem } }
    @media (max-width:767px){
      .sidebar.desktop{ display:none }
      .controls-wrap{ flex-direction:column; align-items:stretch !important; gap:.75rem }
      .filters .col-12{ margin-bottom:.5rem }
    }
    .table thead th{ white-space:nowrap }
    .small-muted{ color:#6b7280; font-size:.9rem }
  </style>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Lista e PÃ«rdoruesve</div>
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
    <!-- Sidebar desktop -->
    <div class="col-lg-2 d-none d-lg-block sidebar desktop p-3">
      <div class="text-center mb-4">
        <img src="{{ asset('images/llogo.png') }}" alt="Logo" class="logo img-fluid">
      </div>
      @include('admin.partials.navigation')
    </div>

    <!-- Content -->
    <div class="col-lg-10 content">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap controls-wrap">
        <div>
          <div class="h5 m-0">Lista e PÃ«rdoruesve</div>
          <div class="small-muted">Shfaq {{ $users->firstItem() ?? 0 }}â€“{{ $users->lastItem() ?? 0 }} nga {{ $users->total() ?? $users->count() }}</div>
        </div>
      </div>

      <!-- Filtrat -->
      <form method="GET" action="{{ route('admin.users') }}" class="card p-3 mb-3">
        <div class="row g-2 align-items-end filters">
          <div class="col-12 col-md-4">
            <label class="form-label mb-1">KÃ«rko</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-search"></i></span>
              <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control" placeholder="EmÃ«r ose emailâ€¦" id="searchInput">
            </div>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1">Roli</label>
            <select name="role" class="form-select" onchange="this.form.submit()">
              <option value="">TÃ« gjithÃ«</option>
              <option value="admin" @selected(($role ?? request('role'))==='admin')>Admin</option>
              <option value="user"  @selected(($role ?? request('role'))==='user')>User</option>
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1">Rendit</label>
            <select name="sort" class="form-select" onchange="this.form.submit()">
              @php $s = $sort ?? request('sort','newest'); @endphp
              <option value="newest"  @selected($s==='newest')>MÃ« tÃ« rinjtÃ«</option>
              <option value="oldest"  @selected($s==='oldest')>MÃ« tÃ« vjetrit</option>
              <option value="name_az" @selected($s==='name_az')>Emri Aâ€“Z</option>
              <option value="name_za" @selected($s==='name_za')>Emri Zâ€“A</option>
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1">PÃ«r faqe</label>
            <select name="perPage" class="form-select" onchange="this.form.submit()">
              @php $pp = (int)($perPage ?? request('perPage', 25)); @endphp
              @foreach([10,25,50,100] as $n)
                <option value="{{ $n }}" @selected($pp===$n)>{{ $n }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary w-100" type="submit">Filtro</button>
              <a class="btn btn-outline-dark w-100" href="{{ route('admin.users') }}">Reset</a>
            </div>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th style="width:70px">#</th>
              <th>Emri</th>
              <th>Email</th>
              <th style="width:180px">Krijuar mÃ«</th>
              <th style="width:120px">Statusi</th>
              <th style="width:160px">Veprime</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td class="text-start">{{ $user->name }}</td>
                <td class="text-start">{{ $user->email }}</td>
                <td>{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                <td>
                  @if(Cache::has('user-is-online-' . $user->id))
                    <span class="badge bg-success">Online</span>
                  @else
                    <span class="badge bg-secondary">Offline</span>
                  @endif
                </td>
                <td class="text-nowrap">
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edito</a>
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('A je i sigurt qÃ« do me fshi?')">Fshi</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6">Sâ€™ka pÃ«rdorues.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($users, 'links'))
        <div class="d-flex justify-content-end">
          {{ $users->appends(request()->query())->links() }}
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Offcanvas Sidebar mobile -->
<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div class="text-center mb-4">
      <img src="{{ asset('images/llogo.png') }}" alt="Logo" class="logo img-fluid">
    </div>
    @include('admin.partials.navigation')
  </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Debounce pÃ«r kÃ«rkim â€“ autosubmit pas 400ms
const searchInput = document.getElementById('searchInput');
let t;
if (searchInput) {
  searchInput.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(() => {
      searchInput.form.requestSubmit();
    }, 400);
  });
}
</script>
</body>
</html>
