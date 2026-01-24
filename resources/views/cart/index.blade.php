<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Shporta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand:#dc3545;
      --ink:#111827;
      --muted:#6b7280;
      --radius:14px;
      --shadow:0 8px 24px rgba(0,0,0,.06);
    }
    body{ background:#f7f8fb }

    .page-wrap{ max-width:1100px }

    .card-soft{ background:#fff;border:0;border-radius:var(--radius);box-shadow:var(--shadow) }
    .summary-sticky{ position:sticky; top:18px }

    .cart-thumb{ width:64px;height:64px;border-radius:10px;object-fit:cover;background:#f1f2f6 }
    .qty-input{ width:78px; text-align:center }
    .muted{ color:var(--muted) }
    .price{ font-weight:700 }

    /* Mobile cards */
    @media (min-width: 992px){
      .cart-table{ display:block }
      .cart-cards{ display:none }
    }
    @media (max-width: 991.98px){
      .cart-table{ display:none }
      .cart-cards{ display:block }
      .summary-sticky{ position:static }
    }
  </style>
</head>
<body>
<div class="container page-wrap py-4">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Shporta</h1>
    <a class="btn btn-outline-secondary btn-sm" href="{{ url('/') }}">
      <i class="bi bi-arrow-left"></i> Vazhdo blerjet
    </a>
  </div>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  @php
    $cart = $cart ?? session('cart', []);

    // ✅ mos e bo function global (shmang conflict). Boje si closure variable.
    $cart_img_url = function($raw){
      $placeholder = asset('images/placeholder-product.png');

      if (empty($raw)) return $placeholder;

      // nese vjen array direkt
      if (is_array($raw)) $raw = $raw[0] ?? null;
      if (empty($raw)) return $placeholder;

      $raw = trim((string)$raw);

      // nese është JSON array string: ["a.jpg","b.jpg"]
      if (str_starts_with($raw, '[')) {
        $d = json_decode($raw, true);
        if (is_array($d) && !empty($d)) $raw = $d[0];
      }

      if (empty($raw)) return $placeholder;

      // nese është URL absolute, merre veç path-in
      if (preg_match('#^https?://#i', $raw)) {
        $raw = parse_url($raw, PHP_URL_PATH) ?? $raw;
      }

      $clean = ltrim($raw, '/');

      // pastro prefixet qe shpesh dalin prej DB
      $clean = preg_replace('#^(storage|public)/#', '', $clean);

      // nese është image në public/images
      if (str_starts_with($clean, 'images/')) return asset($clean);

      // ✅ gjithmon url korrekt nga disk public
      return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
    };

    $subtotal = 0;
    foreach ($cart as $it) { $subtotal += (float)($it['price'] ?? 0) * (int)($it['qty'] ?? 1); }
    $shipping = 0.00;
    $grandTotal = isset($totalPrice) ? (float)$totalPrice : (float)$subtotal;
  @endphp

  @if(empty($cart) || (is_countable($cart) && count($cart)===0))
    <div class="card-soft p-3 text-center">
      <div class="mb-1">Shporta është bosh.</div>
      <a class="btn btn-danger" href="{{ url('/') }}">Fillo blerjet</a>
    </div>
  @else

  <div class="row g-3">
    <!-- Lista e artikujve -->
    <div class="col-lg-8">
      <div class="card-soft p-3 cart-table">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr class="small text-uppercase text-muted">
                <th>Produkti</th>
                <th style="width:120px">Çmimi</th>
                <th style="width:140px">Dimensioni</th>
                <th style="width:170px">Sasia</th>
                <th style="width:120px">Totali</th>
                <th style="width:70px"></th>
              </tr>
            </thead>
            <tbody>
            @foreach($cart as $key => $item)
              @php
                $name = $item['name'] ?? 'Produkt';
                $price= (float)($item['price'] ?? 0);
                $qty  = (int)($item['qty'] ?? 1);
                $size = $item['size'] ?? ($item['dimension'] ?? '—');
                $line = $price * $qty;
                $img  = $item['image'] ?? ($item['image_path'] ?? null);
                $src  = $cart_img_url($img);
              @endphp
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="cart-thumb"
                         src="{{ $src }}"
                         alt="{{ $name }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">

                    {{-- ✅ DEBUG (hiqe masi ta rregullojme) --}}
                    <div style="max-width:380px">
                      <div class="fw-semibold">{{ $name }}</div>
                      <small class="text-muted d-block">RAW: {{ is_string($img) ? $img : (is_array($img) ? json_encode($img) : 'NULL') }}</small>
                      <small class="text-muted d-block">SRC: {{ $src }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ number_format($price,2) }} €</td>
                <td class="text-muted">{{ $size }}</td>
                <td>
                  <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center gap-2 cart-line-form">
                    @csrf
                    <input type="hidden" name="key" value="{{ $key }}">
                    <div class="input-group" style="max-width:170px">
                      <button class="btn btn-outline-secondary btn-sm qty-minus" type="button"><i class="bi bi-dash"></i></button>
                      <input type="number" min="1" name="qty" class="form-control form-control-sm qty-input" value="{{ $qty }}" inputmode="numeric">
                      <button class="btn btn-outline-secondary btn-sm qty-plus" type="button"><i class="bi bi-plus"></i></button>
                    </div>
                    <button class="btn btn-outline-dark btn-sm">Ruaj</button>
                  </form>
                </td>
                <td class="price">{{ number_format($line,2) }} €</td>
                <td class="text-end">
                  <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Me të vërtetë ta heqim këtë artikull?')">
                    @csrf
                    <input type="hidden" name="key" value="{{ $key }}">
                    <button class="btn btn-outline-danger btn-sm" title="Hiq">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-end">Nëntotali:</th>
                <th class="price">{{ number_format($subtotal,2) }} €</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Mobile cards -->
      <div class="cart-cards">
        <div class="vstack gap-2">
          @foreach($cart as $key => $item)
            @php
              $name = $item['name'] ?? 'Produkt';
              $price= (float)($item['price'] ?? 0);
              $qty  = (int)($item['qty'] ?? 1);
              $size = $item['size'] ?? ($item['dimension'] ?? '—');
              $line = $price * $qty;
              $img  = $item['image'] ?? ($item['image_path'] ?? null);
              $src  = $cart_img_url($img);
            @endphp
            <div class="card-soft p-2">
              <div class="d-flex align-items-center gap-2">
                <img class="cart-thumb"
                     src="{{ $src }}"
                     alt="{{ $name }}"
                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">

                <div class="flex-grow-1">
                  <div class="fw-semibold">{{ $name }}</div>

                  {{-- ✅ DEBUG (hiqe masi ta rregullojme) --}}
                  <small class="text-muted d-block">RAW: {{ is_string($img) ? $img : (is_array($img) ? json_encode($img) : 'NULL') }}</small>
                  <small class="text-muted d-block">SRC: {{ $src }}</small>

                  <div class="small muted">Dimensioni: {{ $size }}</div>
                  <div class="small muted">Çmimi: {{ number_format($price,2) }} €</div>
                </div>

                <div class="text-end">
                  <div class="price">{{ number_format($line,2) }} €</div>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-2">
                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center gap-2 cart-line-form w-100">
                  @csrf
                  <input type="hidden" name="key" value="{{ $key }}">
                  <div class="input-group" style="max-width:200px">
                    <button class="btn btn-outline-secondary btn-sm qty-minus" type="button"><i class="bi bi-dash"></i></button>
                    <input type="number" min="1" name="qty" class="form-control form-control-sm qty-input" value="{{ $qty }}" inputmode="numeric">
                    <button class="btn btn-outline-secondary btn-sm qty-plus" type="button"><i class="bi bi-plus"></i></button>
                  </div>
                  <button class="btn btn-outline-dark btn-sm ms-auto">Ruaj</button>
                </form>

                <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Me të vërtetë ta heqim këtë artikull?')" class="ms-2">
                  @csrf
                  <input type="hidden" name="key" value="{{ $key }}">
                  <button class="btn btn-outline-danger btn-sm" title="Hiq">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      @if(Route::has('cart.clear'))
        <form action="{{ route('cart.clear') }}" method="POST" class="mt-2" onsubmit="return confirm('Ta zbrazim krejt shportën?')">
          @csrf
          <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-circle"></i> Zbraz shportën</button>
        </form>
      @endif
    </div>

    <!-- Përmbledhja -->
    <div class="col-lg-4">
      <div class="card-soft p-3 summary-sticky">
        <h6 class="mb-3">Përmbledhja</h6>
        <div class="d-flex justify-content-between mb-1">
          <span class="muted">Nëntotali</span>
          <span>{{ number_format($subtotal,2) }} €</span>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span class="muted">Transporti</span>
          <span>{{ number_format($shipping,2) }} €</span>
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between fs-5 fw-bold">
          <span>Totali</span>
          <span class="text-danger">{{ number_format($grandTotal + $shipping,2) }} €</span>
        </div>

        <div class="mt-3 d-grid gap-2">
          <a href="{{ route('checkout.index') }}" class="btn btn-danger btn-lg">
            Vazhdo te pagesa
          </a>
          <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            Vazhdo blerjet
          </a>
        </div>

        <div class="small text-center muted mt-2">Dorëzimi 1–3 ditë pune. Pagesa: kesh në dorëzim.</div>
      </div>
    </div>
  </div>

  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // +/- për sasi
  document.querySelectorAll('.cart-line-form').forEach(function(form){
    const minus = form.querySelector('.qty-minus');
    const plus  = form.querySelector('.qty-plus');
    const input = form.querySelector('.qty-input');
    if(minus && input){
      minus.addEventListener('click', function(){
        let v = parseInt(input.value||'1',10);
        if(isNaN(v) || v<2) v=2;
        input.value = v-1;
      });
    }
    if(plus && input){
      plus.addEventListener('click', function(){
        let v = parseInt(input.value||'1',10);
        if(isNaN(v) || v<1) v=1;
        input.value = v+1;
      });
    }
  });
</script>
</body>
</html>
