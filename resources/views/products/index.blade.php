<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Dyqani – Produktet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{ background:#f8f9fa; font-family:'Segoe UI',sans-serif; }
    .card-img-top{ object-fit:cover; height:220px; }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">Produktet</h3>
    <a href="{{ url('/') }}" class="btn btn-outline-dark">Kreu</a>
  </div>

  @if($products->count()===0)
    <div class="alert alert-info">S’ka produkte për momentin.</div>
  @endif

  <div class="row g-3">
    @foreach($products as $p)
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm">
          <img class="card-img-top" src="{{ $p->image_url }}" alt="{{ $p->name }}">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-1">{{ $p->name }}</h5>
            <div class="text-danger fw-bold mb-2">€ {{ number_format($p->price,2) }}</div>
            @if($p->description)
              <p class="card-text text-muted" style="flex:1 1 auto;">
                {{ \Illuminate\Support\Str::limit($p->description, 120) }}
              </p>
            @endif
            <a href="{{ route('shop.show',$p->slug) }}" class="btn btn-danger mt-auto">Shiko</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="d-flex justify-content-end mt-3">
    {{ $products->links() }}
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
