<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Gjurmo porosinë - Brillant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">

  <style>
    body{
      min-height:100vh;
      display:grid;
      place-items:center;
      margin:0;
      background:
        linear-gradient(135deg, rgba(15,23,42,.78), rgba(15,23,42,.52)),
        url("{{ asset('slider/foto1.jpg') }}") center/cover no-repeat;
      font-family:system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .track-card{
      width:min(520px, calc(100% - 28px));
      padding:28px;
      border-radius:22px;
      background:#fff;
      box-shadow:0 24px 70px rgba(0,0,0,.22);
    }
    .logo{
      width:74px;
      height:74px;
      object-fit:contain;
      display:block;
      margin:0 auto 14px;
    }
    .form-control{
      min-height:52px;
      border-radius:14px;
      font-weight:700;
      text-transform:uppercase;
    }
    .btn-danger{
      min-height:52px;
      border-radius:14px;
      font-weight:800;
    }
  </style>
</head>
<body>
  <main class="track-card">
    <img class="logo" src="{{ asset('images/llogo.png') }}" alt="Brillant">
    <h1 class="h3 fw-bold text-center mb-2">Gjurmo porosinë</h1>
    <p class="text-muted text-center mb-4">Shkruaj kodin e gjurmimit që e ke marrë pas porosisë.</p>

    <form id="trackForm">
      <label class="form-label fw-bold" for="trackingCode">Kodi i gjurmimit</label>
      <input id="trackingCode" class="form-control mb-3" type="text" placeholder="p.sh. BRL-ABCD-1234" autocomplete="off" required>
      <button class="btn btn-danger w-100" type="submit">
        <i class="bi bi-geo-alt me-1"></i> Shiko statusin
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="{{ route('home') }}" class="text-danger fw-bold text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kthehu në ballinë
      </a>
    </div>
  </main>

  <script>
    document.getElementById('trackForm').addEventListener('submit', function(e){
      e.preventDefault();
      const code = document.getElementById('trackingCode').value.trim();
      if(!code) return;
      window.location.href = "{{ url('/track') }}/" + encodeURIComponent(code);
    });
  </script>
</body>
</html>
