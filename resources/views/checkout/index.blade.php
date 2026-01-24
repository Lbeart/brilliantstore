<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <title>Finalizo Porosinë – Brillant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root{
      --brand:#dc3545;
      --ink:#111827;
      --muted:#6b7280;
      --shadow-sm:0 6px 18px rgba(0,0,0,.08);
      --radius:14px;
    }
    body{ background:#f7f8fb }
    .page-wrap{ max-width:1100px }

    .card-soft{ background:#fff; border:0; border-radius:var(--radius); box-shadow:var(--shadow-sm) }
    .card-title{ font-weight:800; color:var(--ink) }

    .summary-thumb{ width:64px; height:64px; border-radius:10px; object-fit:cover; background:#f1f2f6 }
    .price{ font-weight:700 }
    .text-muted-2{ color:var(--muted) }

    .summary-sticky{ position:sticky; top:16px; }

    .form-label{ font-weight:600 }
    .is-invalid ~ .invalid-feedback{ display:block }

    .hint{ font-size:.85rem; color:var(--muted) }

    /* Mobile helpers */
    @media (max-width:991.98px){
      .summary-sticky{ position:static }
      .mobile-summary-toggle{ position:sticky; top:0; z-index:2 }
    }
  </style>
</head>
<body>
  <div class="container page-wrap py-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h4 mb-0">Finalizo Porosinë</h1>
      <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Vazhdo blerjet
      </a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

    @php
      $cart = $cart ?? session('cart', []);
    @endphp

    @if(empty($cart) || (is_countable($cart) && count($cart)===0))
      <div class="alert alert-info">Shporta është bosh.</div>
      <a class="btn btn-danger" href="{{ url('/') }}">Kthehu te produktet</a>
    @else
      @php
        // ✅ FIX FOTO (si te shporta): trajton JSON array, URL absolute, dhe rastin .../storage/[...]
        $order_img_url = function($raw){
          $placeholder = asset('images/placeholder-product.png');
          if (empty($raw)) return $placeholder;

          // nese vjen array direkt
          if (is_array($raw)) $raw = $raw[0] ?? null;
          if (empty($raw)) return $placeholder;

          $raw = trim((string)$raw);

          // nese është JSON array string: ["a.png","b.png"]
          if (str_starts_with($raw, '[')) {
            $d = json_decode($raw, true);
            if (is_array($d) && !empty($d)) $raw = $d[0];
          }

          // ✅ nese është URL që përmban JSON array: https://domain.com/storage/[...]
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

          // pastro prefixet që dalin shpesh: storage/ ose public/
          $clean = preg_replace('#^(storage|public)/#', '', $clean);

          // nese është image në public/images
          if (str_starts_with($clean, 'images/')) return asset($clean);

          // URL e saktë prej storage public (domain.com/storage/...)
          return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
        };

        // Totale
        $items = $cart;
        $subtotal = 0;
        foreach ($items as $it) { $subtotal += (float)($it['price'] ?? 0) * (int)($it['qty'] ?? 1); }
        $grandTotal = isset($totalPrice) ? (float)$totalPrice : (float)$subtotal;
        $shipping = 0.00;
      @endphp

      <div class="row g-4">
        <!-- Forma (majtas) -->
        <div class="col-lg-7">
          <div class="card card-soft p-3 p-md-4">
            <h2 class="h5 card-title mb-3">Të dhënat e dorëzimit</h2>

            <form action="{{ route('checkout.store') }}" method="POST" novalidate id="checkoutForm">
              @csrf

              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label" for="name">Emri dhe mbiemri</label>
                  <input
                    type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    required maxlength="100" autocomplete="name"
                    value="{{ old('name') }}" placeholder="p.sh. Ardit Krasniqi" />
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label" for="phone">Telefoni</label>
                  <input
                    type="tel" id="phone" name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    required inputmode="tel" autocomplete="tel"
                    pattern="^[0-9+()\-\s]{7,20}$" maxlength="20"
                    value="{{ old('phone') }}" placeholder="p.sh. 044 123 456" />
                  <div class="hint">Lejohen numra, hapësira dhe simbolet + ( ) -</div>
                  @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label" for="email">Email (opsional)</label>
                  <input
                    type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    autocomplete="email"
                    value="{{ old('email') }}" placeholder="p.sh. emri@shembull.com" />
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label" for="address">Adresa e dorëzimit</label>
                  <textarea
                    id="address" name="address" rows="3"
                    class="form-control @error('address') is-invalid @enderror"
                    required autocomplete="address-line1"
                    placeholder="Rruga, nr., hyrja, kati">{{ old('address') }}</textarea>
                  @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label" for="city">Qyteti</label>
                  <input
                    type="text" id="city" name="city"
                    class="form-control @error('city') is-invalid @enderror"
                    autocomplete="address-level2" maxlength="60"
                    value="{{ old('city') }}" placeholder="p.sh. Prishtinë" />
                  @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 col-md-6">
                  <label class="form-label" for="zip">Kodi postar (opsional)</label>
                  <input
                    type="text" id="zip" name="zip"
                    class="form-control @error('zip') is-invalid @enderror"
                    inputmode="numeric" autocomplete="postal-code" maxlength="10"
                    pattern="^[0-9]{3,10}$"
                    value="{{ old('zip') }}" placeholder="p.sh. 10000" />
                  @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label" for="notes">Shënime (opsional)</label>
                  <textarea
                    id="notes" name="notes" rows="2" maxlength="300"
                    class="form-control @error('notes') is-invalid @enderror"
                    placeholder="Orari i preferuar, ngjyra/masa specifike, etj.">{{ old('notes') }}</textarea>
                  <div class="hint"><span id="notesCount">0</span>/300 karaktere</div>
                  @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label" for="payment">Mënyra e pagesës</label>
                  <select id="payment" name="payment" class="form-select @error('payment') is-invalid @enderror" required autocomplete="off">
                    <option value="cash" selected>Kesh në dorëzim</option>
                  </select>
                  @error('payment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="terms" required>
                  <label class="form-check-label" for="terms">
                    Pranoj <a href="{{ url('/terms') }}" target="_blank" rel="noopener">kushtet</a> dhe <a href="{{ url('/privacy') }}" target="_blank" rel="noopener">privatësinë</a>.
                  </label>
                  <div class="invalid-feedback">Duhet t’i pranoni kushtet për të vazhduar.</div>
                </div>

                <div class="col-12 d-grid">
                  <button id="submitBtn" class="btn btn-danger btn-lg">
                    <span class="spinner-border spinner-border-sm me-2 d-none" id="btnSpinner" role="status" aria-hidden="true"></span>
                    Dërgo Porosinë
                  </button>
                </div>
              </div>

              <input type="hidden" name="cart_meta" value='@json($items, JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT)' />
              <input type="hidden" name="total" value='{{ $grandTotal + $shipping }}' />
            </form>
          </div>
        </div>

        <!-- Përmbledhja (djathtas) -->
        <div class="col-lg-5">
          <button class="btn btn-outline-dark w-100 d-lg-none mb-2 mobile-summary-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#orderSummary" aria-expanded="false" aria-controls="orderSummary">
            <i class="bi bi-receipt-cutoff me-1"></i> Shiko përmbledhjen
          </button>

          <div id="orderSummary" class="card card-soft p-3 p-md-4 summary-sticky collapse d-lg-block">
            <h2 class="h5 card-title mb-3">Përmbledhja e porosisë</h2>

            <div class="vstack gap-3 mb-3">
              @foreach($items as $it)
                @php
                  $img   = $it['image'] ?? ($it['image_path'] ?? null);
                  $qty   = (int)($it['qty'] ?? 1);
                  $price = (float)($it['price'] ?? 0);
                  $line  = $price * $qty;
                  $name  = $it['name'] ?? 'Produkt';
                  $size  = $it['size'] ?? ($it['dimension'] ?? null);

                  $src = $order_img_url($img);
                @endphp
                <div class="d-flex align-items-center">
                  <img class="summary-thumb me-3"
                       src="{{ $src }}"
                       alt="{{ $name }}"
                       onerror="this.onerror=null;this.src='{{ asset('images/placeholder-product.png') }}'">
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                      <div class="me-2">
                        <div class="fw-semibold">{{ $name }}</div>
                        @if($size)<div class="small text-muted-2">Dimensioni: {{ $size }}</div>@endif
                        <div class="small text-muted-2">Sasia: {{ $qty }}</div>
                      </div>
                      <div class="text-end">
                        <div class="small text-muted-2">{{ number_format($price,2) }} €</div>
                        <div class="price">{{ number_format($line,2) }} €</div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <hr class="my-3" />

            <div class="d-flex justify-content-between mb-1">
              <span>Nëntotali</span><span>{{ number_format($subtotal,2) }} €</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span>Transporti</span><span>{{ number_format($shipping,2) }} €</span>
            </div>
            <div class="d-flex justify-content-between fs-5 fw-bold mt-2">
              <span>Totali</span><span class="text-danger">{{ number_format($grandTotal + $shipping,2) }} €</span>
            </div>

            <div class="mt-3">
              <a class="btn btn-outline-secondary w-100" href="{{ url('/cart') }}">
                <i class="bi bi-pencil-square"></i> Ndrysho shportën
              </a>
            </div>

            <div class="mt-2 text-center small text-muted">
              Dorëzimi 1–3 ditë pune. Pagesa: kesh në dorëzim.
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const form    = document.getElementById('checkoutForm');
    const btn     = document.getElementById('submitBtn');
    const spinner = document.getElementById('btnSpinner');
    const notes   = document.getElementById('notes');
    const notesC  = document.getElementById('notesCount');

    if (notes && notesC){
      const syncCount = () => notesC.textContent = notes.value.length;
      notes.addEventListener('input', syncCount); syncCount();
    }

    if(form){
      form.addEventListener('submit',function(e){
        if(!form.checkValidity()){
          e.preventDefault(); e.stopPropagation(); form.classList.add('was-validated'); return;
        }
        btn.disabled=true; spinner.classList.remove('d-none');
      });

      const phone = document.getElementById('phone');
      if (phone){
        phone.addEventListener('blur', () => { phone.value = phone.value.trim().replace(/\s{2,}/g,' '); });
      }
    }
  </script>
</body>
</html>
