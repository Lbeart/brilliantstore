<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Faleminderit – Porosia u krye</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{ --brand:#dc3545; --shadow:0 10px 24px rgba(0,0,0,.08); --radius:16px; }
    body{ background:#f7f8fb; font-family:'Segoe UI',system-ui,-apple-system,Roboto,Arial,sans-serif }
    .wrap{ max-width:880px }
    .card-soft{ background:#fff; border:0; border-radius:var(--radius); box-shadow:var(--shadow) }
    .icon-badge{
      width:68px;height:68px;border-radius:50%;display:flex;align-items:center;justify-content:center;
      background:#eaf6ee;color:#198754;font-size:30px;margin:0 auto 12px;
    }
    .muted{ color:#6b7280 }
    .kpi{ display:flex; gap:1rem; flex-wrap:wrap }
    .kpi > div{ flex:1 1 180px; background:#fff; border-radius:14px; padding:14px; box-shadow:0 6px 18px rgba(0,0,0,.06) }
    .kpi .label{ font-size:.9rem; color:#6b7280 }
    .kpi .value{ font-weight:800; font-size:1.2rem }
    @media (max-width:575.98px){ .btn-lg{ padding:.6rem 1rem; font-size:1rem } }
  </style>
</head>
<body>
  <div class="container wrap py-4 py-md-5">
    <div class="card card-soft p-3 p-md-4 text-center">
      <div class="icon-badge"><i class="bi bi-check2"></i></div>
      <h1 class="h4 mb-1">Porosia u krye me sukses!</h1>

      @if(session('success'))
        <div class="alert alert-success mt-2 mb-3">{{ session('success') }}</div>
      @endif

      <p class="muted mb-4">
        Faleminderit për besimin. Do t’ju kontaktojmë shumë shpejt për konfirmim dhe dërgesë.
      </p>

      @isset($orderNo)
        <div class="kpi text-start mb-4">
          <div>
            <div class="label">Numri i porosisë</div>
            <div class="value">#{{ $orderNo }}</div>
          </div>
          <div>
            <div class="label">Statusi fillestar</div>
            <div class="value">Të reja</div>
          </div>
          <div>
            <div class="label">Dorëzimi</div>
            <div class="value">1–3 ditë pune</div>
          </div>
        </div>
      @endisset

      <div class="d-grid d-sm-flex justify-content-center gap-2">
        <a href="{{ url('/') }}" class="btn btn-danger btn-lg">
          <i class="bi bi-house-door me-1"></i> Kthehu te faqja kryesore
        </a>
        <a href="{{ url('/products') }}" class="btn btn-outline-dark btn-lg">
          <i class="bi bi-bag-check me-1"></i> Vazhdo blerjet
        </a>
      </div>

      <div class="mt-4 small muted">
        Keni pyetje? Na shkruani duke iu përgjigjur emailit të konfirmimit (nëse e keni dhënë) ose na kontaktoni
        te <a href="{{ route('contact') }}">forma e kontaktit</a>.
      </div>
    </div>
  </div>
@if(session('tracking_code'))
  <div class="alert alert-info">
    Kodi i gjurmimit: <strong>{{ session('tracking_code') }}</strong>
    — <a href="{{ route('track.show', session('tracking_code')) }}">Shiko statusin e porosisë</a>
  </div>
@endif
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
