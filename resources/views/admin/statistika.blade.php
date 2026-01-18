<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Statistikat – Admin</title>
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
    .kpi .label{color:#6b7280;font-size:.9rem}
    .kpi .value{font-weight:800;font-size:1.6rem}
    .kpi .sub{color:#6b7280;font-size:.85rem}

    .chart-card{min-height:380px; display:flex; flex-direction:column;}
    .chart-toolbar{display:flex; flex-wrap:wrap; gap:.5rem; align-items:center; justify-content:space-between; margin-bottom:.5rem}
    .chart-wrap{position:relative; flex:1 1 auto; min-height:280px}
    .chart-wrap canvas{position:absolute; inset:0; width:100% !important; height:100% !important}

    @media (max-width: 991px){ .content{padding:1rem} }
    @media (max-width: 767px){ .sidebar.desktop{display:none} .chart-card{min-height:320px} }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Statistikat</div>
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

    <!-- CONTENT -->
    <div class="col-lg-10 content">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="h5 m-0">Përmbledhje</h1>
        <form method="get" class="d-flex flex-wrap gap-2">
          <input type="date" name="from" value="{{ request('from') }}" class="form-control">
          <input type="date" name="to"   value="{{ request('to')   }}" class="form-control">
          <button class="btn btn-outline-secondary">Filtro</button>
          <a href="{{ route('admin.stats') }}" class="btn btn-outline-dark">Reseto</a>
        </form>
      </div>

      <!-- KPI cards -->
      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 kpi h-100">
            <div class="label">Porosi sot</div>
            <div class="value">{{ $kpi['today_orders'] ?? '—' }}</div>
            <div class="sub">krahasuar me dje: {{ $kpi['today_vs_yesterday'] ?? '—' }}</div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 kpi h-100">
            <div class="label">Të ardhura sot</div>
            <div class="value">{{ isset($kpi['today_revenue']) ? number_format($kpi['today_revenue'],2).' €' : '—' }}</div>
            <div class="sub">mesatare/porosi: {{ isset($kpi['today_avg']) ? number_format($kpi['today_avg'],2).' €' : '—' }}</div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 kpi h-100">
            <div class="label">Këtë muaj</div>
            <div class="value">{{ $kpi['month_orders'] ?? '—' }}</div>
            <div class="sub">të ardhura: {{ isset($kpi['month_revenue']) ? number_format($kpi['month_revenue'],2).' €' : '—' }}</div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft p-3 kpi h-100">
            <div class="label">Këtë vit</div>
            <div class="value">{{ $kpi['year_orders'] ?? '—' }}</div>
            <div class="sub">të ardhura: {{ isset($kpi['year_revenue']) ? number_format($kpi['year_revenue'],2).' €' : '—' }}</div>
          </div>
        </div>
      </div>

      <!-- CHARTS -->
      <div class="row g-3">
        <!-- Daily -->
        <div class="col-12 col-xl-6">
          <div class="card-soft p-3 chart-card">
            <div class="chart-toolbar">
              <h6 class="m-0">Porosi ditore (30 ditët e fundit)</h6>
              <div class="btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="dailyMetric" id="dailyOrders" value="orders" checked>
                <label class="btn btn-outline-secondary" for="dailyOrders">Porosi</label>
                <input type="radio" class="btn-check" name="dailyMetric" id="dailyRevenue" value="revenue">
                <label class="btn btn-outline-secondary" for="dailyRevenue">€</label>
                <button class="btn btn-outline-dark ms-2" id="dailyCSV"><i class="fa fa-file-csv me-1"></i> CSV</button>
                <button class="btn btn-outline-dark" id="dailyPNG"><i class="fa fa-download me-1"></i> PNG</button>
              </div>
            </div>
            <div class="chart-wrap"><canvas id="chartDaily"></canvas></div>
          </div>
        </div>

        <!-- Monthly -->
        <div class="col-12 col-xl-6">
          <div class="card-soft p-3 chart-card">
            <div class="chart-toolbar">
              <h6 class="m-0">Të ardhura / Porosi mujore (12 muaj)</h6>
              <div class="btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="monthlyMetric" id="monthlyOrders" value="orders">
                <label class="btn btn-outline-secondary" for="monthlyOrders">Porosi</label>
                <input type="radio" class="btn-check" name="monthlyMetric" id="monthlyRevenue" value="revenue" checked>
                <label class="btn btn-outline-secondary" for="monthlyRevenue">€</label>
                <button class="btn btn-outline-dark ms-2" id="monthlyCSV"><i class="fa fa-file-csv me-1"></i> CSV</button>
                <button class="btn btn-outline-dark" id="monthlyPNG"><i class="fa fa-download me-1"></i> PNG</button>
              </div>
            </div>
            <div class="chart-wrap"><canvas id="chartMonthly"></canvas></div>
          </div>
        </div>

        <!-- Yearly -->
        <div class="col-12">
          <div class="card-soft p-3 chart-card">
            <div class="chart-toolbar">
              <h6 class="m-0">Porosi / Të ardhura vjetore (5 vite)</h6>
              <div class="btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="yearlyMetric" id="yearlyOrders" value="orders" checked>
                <label class="btn btn-outline-secondary" for="yearlyOrders">Porosi</label>
                <input type="radio" class="btn-check" name="yearlyMetric" id="yearlyRevenue" value="revenue">
                <label class="btn btn-outline-secondary" for="yearlyRevenue">€</label>
                <button class="btn btn-outline-dark ms-2" id="yearlyCSV"><i class="fa fa-file-csv me-1"></i> CSV</button>
                <button class="btn btn-outline-dark" id="yearlyPNG"><i class="fa fa-download me-1"></i> PNG</button>
              </div>
            </div>
            <div class="chart-wrap"><canvas id="chartYearly"></canvas></div>
          </div>
        </div>
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
// ====== DATA nga serveri ======
const daily   = @json($daily);
const monthly = @json($monthly);
const yearly  = @json($yearly);

// ====== helpers ======
function euroFmt(v){ return new Intl.NumberFormat('sq-AL', {minimumFractionDigits:2, maximumFractionDigits:2}).format(v); }

function buildDataset(metric, values){
  const isMoney = metric === 'revenue';
  return {
    label: isMoney ? 'Të ardhura (€)' : 'Porosi',
    data: values,
    fill: true,
    tension: 0.25,
    borderWidth: 2,
    pointRadius: 0,
  };
}

function exportCSV(filename, labels, values, header){
  let csv = 'Label,'+header+'\n';
  labels.forEach((l,i)=>{ csv += `"${l}",${values[i]}\n`; });
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a'); a.href = url; a.download = filename; a.click();
  URL.revokeObjectURL(url);
}

function downloadPNG(chart, name){
  const link = document.createElement('a');
  link.href = chart.toBase64Image();
  link.download = name;
  link.click();
}

// ====== CHART OPTIONS (responsive) ======
const commonOptions = (isMoney=false) => ({
  responsive: true,
  maintainAspectRatio: false,
  interaction: { mode: 'index', intersect: false },
  plugins: {
    legend: { display: false },
    tooltip: {
      callbacks: {
        label: ctx => {
          const v = ctx.parsed.y ?? 0;
          return (isMoney ? '€ ' + euroFmt(v) : v + ' porosi');
        }
      }
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        callback: (val) => isMoney ? '€ ' + euroFmt(val) : val
      }
    },
    x: { grid: { display:false } }
  }
});

// ====== DAILY ======
const dailyCtx = document.getElementById('chartDaily').getContext('2d');
let dailyMetric = 'orders';
let dailyChart = new Chart(dailyCtx, {
  type: 'line',
  data: { labels: daily.labels, datasets: [buildDataset(dailyMetric, daily[dailyMetric])] },
  options: commonOptions(false)
});
document.querySelectorAll('input[name="dailyMetric"]').forEach(r=>{
  r.addEventListener('change', e=>{
    dailyMetric = e.target.value;
    dailyChart.data.datasets = [buildDataset(dailyMetric, daily[dailyMetric])];
    dailyChart.options = commonOptions(dailyMetric==='revenue');
    dailyChart.update();
  });
});
document.getElementById('dailyCSV').addEventListener('click', e=>{
  e.preventDefault();
  exportCSV('daily_'+dailyMetric+'.csv', daily.labels, daily[dailyMetric], dailyMetric==='revenue'?'Revenue':'Orders');
});
document.getElementById('dailyPNG').addEventListener('click', e=>{
  e.preventDefault(); downloadPNG(dailyChart, 'daily_'+dailyMetric+'.png');
});

// ====== MONTHLY ======
const monthlyCtx = document.getElementById('chartMonthly').getContext('2d');
let monthlyMetric = 'revenue';
let monthlyChart = new Chart(monthlyCtx, {
  type: 'bar',
  data: { labels: monthly.labels, datasets: [buildDataset(monthlyMetric, monthly[monthlyMetric])] },
  options: commonOptions(true)
});
document.querySelectorAll('input[name="monthlyMetric"]').forEach(r=>{
  r.addEventListener('change', e=>{
    monthlyMetric = e.target.value;
    monthlyChart.data.datasets = [buildDataset(monthlyMetric, monthly[monthlyMetric])];
    monthlyChart.options = commonOptions(monthlyMetric==='revenue');
    monthlyChart.update();
  });
});
document.getElementById('monthlyCSV').addEventListener('click', e=>{
  e.preventDefault();
  exportCSV('monthly_'+monthlyMetric+'.csv', monthly.labels, monthly[monthlyMetric], monthlyMetric==='revenue'?'Revenue':'Orders');
});
document.getElementById('monthlyPNG').addEventListener('click', e=>{
  e.preventDefault(); downloadPNG(monthlyChart, 'monthly_'+monthlyMetric+'.png');
});

// ====== YEARLY ======
const yearlyCtx = document.getElementById('chartYearly').getContext('2d');
let yearlyMetric = 'orders';
let yearlyChart = new Chart(yearlyCtx, {
  type: 'line',
  data: { labels: yearly.labels, datasets: [buildDataset(yearlyMetric, yearly[yearlyMetric])] },
  options: commonOptions(false)
});
document.querySelectorAll('input[name="yearlyMetric"]').forEach(r=>{
  r.addEventListener('change', e=>{
    yearlyMetric = e.target.value;
    yearlyChart.data.datasets = [buildDataset(yearlyMetric, yearly[yearlyMetric])];
    yearlyChart.options = commonOptions(yearlyMetric==='revenue');
    yearlyChart.update();
  });
});
document.getElementById('yearlyCSV').addEventListener('click', e=>{
  e.preventDefault();
  exportCSV('yearly_'+yearlyMetric+'.csv', yearly.labels, yearly[yearlyMetric], yearlyMetric==='revenue'?'Revenue':'Orders');
});
document.getElementById('yearlyPNG').addEventListener('click', e=>{
  e.preventDefault(); downloadPNG(yearlyChart, 'yearly_'+yearlyMetric+'.png');
});
</script>
</body>
</html>
