<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>POS - Admin</title>
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
    .stat{display:flex;align-items:center;justify-content:space-between;gap:1rem;min-height:96px}
    .stat-icon{width:40px;height:40px;border-radius:var(--radius);display:grid;place-items:center;background:#fff1f2;color:var(--brand)}
    .stat-label{color:var(--muted);font-size:.83rem;font-weight:750}
    .stat-value{font-size:1.35rem;font-weight:900;line-height:1.1}
    .form-label{font-weight:750;color:#344054}
    .form-control,.form-select{border-color:var(--line);border-radius:var(--radius)}
    .btn{border-radius:var(--radius);font-weight:750}
    .btn-danger{background:var(--brand);border-color:var(--brand)}
    .btn-danger:hover{background:var(--brand-dark);border-color:var(--brand-dark)}
    .section-title{display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-bottom:.85rem}
    .section-title h2{font-size:1rem;font-weight:850;margin:0}
    .scanner{border:2px solid var(--brand);box-shadow:0 0 0 .25rem rgba(220,53,69,.08)}
    .cart-table th{font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);white-space:nowrap}
    .cart-table td{vertical-align:middle}
    .qty-input{width:84px}
    .price-input{width:108px}
    .empty-cart{padding:2rem;text-align:center;color:var(--muted);border:1px dashed var(--line);border-radius:var(--radius);background:#fbfcfd}
    .total-panel{background:#111827;color:#fff;border-radius:var(--radius);padding:1rem}
    .total-panel .label{color:#cbd5e1;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;font-weight:850}
    .total-panel .value{font-size:1.75rem;font-weight:950;line-height:1.1}
    .quick-product{display:flex;align-items:center;justify-content:space-between;gap:.75rem;width:100%;border:1px solid var(--line);background:#fff;border-radius:var(--radius);padding:.72rem;text-align:left}
    .quick-product:hover{border-color:var(--brand);color:var(--brand)}
    .receipt-row{border-bottom:1px solid var(--line);padding:.75rem 0}
    .receipt-row:last-child{border-bottom:0}
    .badge-soft{background:#f2f4f7;color:#344054;border:1px solid var(--line)}
    .type-toggle{display:grid;grid-template-columns:1fr 1fr;gap:.5rem}
    .type-toggle input{position:absolute;opacity:0}
    .type-toggle label{border:1px solid var(--line);border-radius:var(--radius);padding:.65rem;text-align:center;font-weight:850;cursor:pointer;background:#fff}
    .type-toggle input:checked + label{border-color:var(--brand);background:#fff1f2;color:var(--brand)}
    @media (max-width:991px){.content{padding:1rem}.page-head{flex-direction:column}.sidebar{min-height:100vh}}
    @media (max-width:767px){.sidebar.desktop{display:none}.stat{min-height:auto}.qty-input,.price-input{width:100%}}
  </style>
</head>
<body>

@php
  $today = now()->toDateString();
  $receiptTypeLabels = ['regular' => 'I rregullt', 'non_regular' => 'Jo i rregullt'];
  $paymentLabels = ['cash' => 'Cash', 'card' => 'Kartel', 'bank' => 'Banke', 'mixed' => 'E perzier'];
  $quickProductPayload = $quickProducts->map(function ($product) {
      $sizes = $product->sizes;
      if (is_string($sizes)) {
          $decoded = json_decode($sizes, true);
          if (is_string($decoded)) {
              $decoded = json_decode($decoded, true);
          }
          $sizes = is_array($decoded) ? $decoded : [];
      }

      return [
          'id' => $product->id,
          'name' => $product->name,
          'sku' => $product->sku,
          'barcode' => $product->barcode,
          'price' => (float) $product->price,
          'stock' => (int) ($product->stock ?? 0),
          'sizes' => is_array($sizes) ? array_values(array_filter($sizes, fn ($row) => is_array($row))) : [],
      ];
  })->values();
@endphp

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Hape menun">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">POS</div>
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
        <a class="nav-link {{ request()->routeIs('admin.pos*') ? 'active' : '' }}" href="{{ route('admin.pos.index') }}">
          <i class="fas fa-cash-register me-1"></i> POS
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
          <div class="eyebrow">Point of sale</div>
          <h1>Shitje me barkod, fature dhe raport ditor</h1>
          <p>Regjistro shitjen ne dyqan dhe hap faturen menjehere pas pageses.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          @if(($summary['receipts_count'] ?? 0) > 0)
            <a href="{{ route('admin.customers.daily-invoice', $today) }}" class="btn btn-outline-dark">
              <i class="fa fa-calendar-day me-1"></i> Raporti ditor
            </a>
          @else
            <button type="button" class="btn btn-outline-secondary" disabled>
              <i class="fa fa-calendar-day me-1"></i> Raporti ditor
            </button>
          @endif
          <a href="{{ route('admin.products.create') }}" class="btn btn-danger">
            <i class="fa fa-plus me-1"></i> Shto mall
          </a>
        </div>
      </div>

      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
      @if($errors->any())
        <div class="alert alert-danger">
          Kontrollo fushat e POS-it. {{ $errors->first() }}
        </div>
      @endif

      <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Fatura sot</div><div class="stat-value">{{ number_format($summary['receipts_count'] ?? 0) }}</div></div>
            <div class="stat-icon"><i class="fa fa-receipt"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Shitje sot</div><div class="stat-value">{{ number_format((float) ($summary['total'] ?? 0), 2) }} EUR</div></div>
            <div class="stat-icon"><i class="fa fa-euro-sign"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Paguar</div><div class="stat-value">{{ number_format((float) ($summary['paid'] ?? 0), 2) }} EUR</div></div>
            <div class="stat-icon"><i class="fa fa-money-bill-wave"></i></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
          <div class="card-soft stat p-3">
            <div><div class="stat-label">Borxh</div><div class="stat-value">{{ number_format((float) ($summary['balance'] ?? 0), 2) }} EUR</div></div>
            <div class="stat-icon"><i class="fa fa-scale-balanced"></i></div>
          </div>
        </div>
      </div>

      <form id="posForm" method="POST" action="{{ route('admin.pos.checkout') }}">
        @csrf
        <div id="hiddenItems"></div>
        <div class="row g-3">
          <div class="col-12 col-xl-8">
            <div class="card-soft p-3 mb-3">
              <div class="section-title">
                <h2>Shporta</h2>
                <button type="button" class="btn btn-sm btn-outline-danger" data-clear-cart>
                  <i class="fa fa-trash me-1"></i> Pastro
                </button>
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                <input type="text" class="form-control scanner" data-scan-input placeholder="Barkod, SKU ose emer produkti" autocomplete="off" autofocus>
                <button type="button" class="btn btn-danger" data-scan-button>
                  <i class="fa fa-plus me-1"></i> Shto
                </button>
              </div>
              <div data-scan-message class="small text-muted mb-2"></div>

              <div data-cart-empty class="empty-cart">
                Shporta eshte bosh.
              </div>

              <div class="table-responsive d-none" data-cart-wrap>
                <table class="table cart-table align-middle">
                  <thead>
                    <tr>
                      <th>Produkti</th>
                      <th>Dimensioni</th>
                      <th>Sasia</th>
                      <th>Cmimi</th>
                      <th class="text-end">Totali</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody data-cart-body></tbody>
                </table>
              </div>
            </div>

            <div class="card-soft p-3">
              <div class="section-title">
                <h2>Produktet e fundit</h2>
                <a href="{{ route('admin.products.index') }}" class="small fw-bold text-danger">Lista</a>
              </div>
              <div class="row g-2">
                @forelse($quickProductPayload as $product)
                  <div class="col-12 col-md-6">
                    <button type="button" class="quick-product" data-quick-product="{{ $product['id'] }}">
                      <span>
                        <span class="fw-bold">{{ $product['name'] }}</span><br>
                        <span class="small text-muted">{{ $product['barcode'] ?: $product['sku'] }}</span>
                      </span>
                      <span class="fw-bold">{{ number_format((float) $product['price'], 2) }} EUR</span>
                    </button>
                  </div>
                @empty
                  <div class="col-12 text-muted">Nuk ka produkte aktive.</div>
                @endforelse
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-4">
            <div class="card-soft p-3 mb-3">
              <div class="section-title"><h2>Klienti</h2></div>
              <div class="mb-2">
                <label class="form-label">Emri</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Klient POS">
              </div>
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label">Telefoni</label>
                  <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}">
                </div>
                <div class="col-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                </div>
                <div class="col-7">
                  <label class="form-label">Adresa</label>
                  <input type="text" name="customer_address" class="form-control" value="{{ old('customer_address') }}">
                </div>
                <div class="col-5">
                  <label class="form-label">Qyteti</label>
                  <input type="text" name="customer_city" class="form-control" value="{{ old('customer_city') }}">
                </div>
              </div>
            </div>

            <div class="card-soft p-3 mb-3">
              <div class="section-title"><h2>Pagesa</h2></div>
              <div class="mb-3">
                <label class="form-label">Kuponi</label>
                <div class="type-toggle">
                  <input type="radio" name="receipt_type" value="regular" id="typeRegular" checked>
                  <label for="typeRegular">I rregullt</label>
                  <input type="radio" name="receipt_type" value="non_regular" id="typeNonRegular">
                  <label for="typeNonRegular">Jo i rregullt</label>
                </div>
              </div>
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label">Data</label>
                  <input type="datetime-local" name="sold_at" class="form-control" value="{{ now()->format('Y-m-d\\TH:i') }}">
                </div>
                <div class="col-6">
                  <label class="form-label">Metoda</label>
                  <select name="payment_method" class="form-select">
                    <option value="cash">Cash</option>
                    <option value="card">Kartel</option>
                    <option value="bank">Banke</option>
                    <option value="mixed">E perzier</option>
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label">Zbritje</label>
                  <input type="number" step="0.01" min="0" name="discount" class="form-control" value="0" data-discount>
                </div>
                <div class="col-6">
                  <label class="form-label">Paguar</label>
                  <input type="number" step="0.01" min="0" name="paid_amount" class="form-control" value="0" data-paid>
                </div>
              </div>

              <div class="d-flex gap-2 mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" data-pay-none>0</button>
                <button type="button" class="btn btn-sm btn-outline-dark flex-fill" data-pay-half>1/2</button>
                <button type="button" class="btn btn-sm btn-outline-success flex-fill" data-pay-full>Krejt</button>
              </div>

              <div class="mt-3">
                <label class="form-label">Shenime</label>
                <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
              </div>

              <div class="total-panel mt-3">
                <div class="d-flex justify-content-between gap-2">
                  <div>
                    <div class="label">Total</div>
                    <div class="value"><span data-total>0.00</span> EUR</div>
                  </div>
                  <div class="text-end">
                    <div class="label">Mbetur</div>
                    <div class="value"><span data-balance>0.00</span> EUR</div>
                  </div>
                </div>
                <div class="small mt-2">Subtotal <span data-subtotal>0.00</span> EUR / Zbritje <span data-discount-preview>0.00</span> EUR</div>
              </div>

              <button class="btn btn-danger w-100 mt-3" type="submit">
                <i class="fa fa-receipt me-1"></i> Ruaj dhe hap faturen
              </button>
            </div>

            <div class="card-soft p-3">
              <div class="section-title">
                <h2>Faturat e fundit</h2>
                <span class="badge badge-soft">{{ $summary['regular_count'] ?? 0 }} / {{ $summary['non_regular_count'] ?? 0 }}</span>
              </div>
              @forelse($receipts as $receipt)
                <div class="receipt-row">
                  <div class="d-flex justify-content-between gap-2">
                    <div>
                      <div class="fw-bold">{{ $receipt->code }}</div>
                      <div class="small text-muted">{{ optional($receipt->customer)->name ?? 'Klient POS' }}</div>
                    </div>
                    <div class="text-end">
                      <div class="fw-bold">{{ number_format((float) $receipt->total, 2) }} EUR</div>
                      <div class="small text-muted">{{ $receiptTypeLabels[$receipt->receipt_type] ?? $receipt->receipt_type }}</div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="small text-muted">{{ $paymentLabels[$receipt->payment_method] ?? $receipt->payment_method }}</span>
                    <a href="{{ route('admin.customers.invoice', [$receipt->customer_id, $receipt->code]) }}" class="btn btn-sm btn-outline-dark">Hap</a>
                  </div>
                </div>
              @empty
                <div class="text-muted">Ende nuk ka fatura sot.</div>
              @endforelse
            </div>
          </div>
        </div>
      </form>
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
      <a class="nav-link {{ request()->routeIs('admin.pos*') ? 'active' : '' }}" href="{{ route('admin.pos.index') }}">
        <i class="fas fa-cash-register me-1"></i> POS
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
  const lookupUrl = @json(route('admin.pos.lookup'));
  const quickProducts = @json($quickProductPayload);
  const cart = [];
  const scanInput = document.querySelector('[data-scan-input]');
  const scanButton = document.querySelector('[data-scan-button]');
  const message = document.querySelector('[data-scan-message]');
  const cartWrap = document.querySelector('[data-cart-wrap]');
  const cartEmpty = document.querySelector('[data-cart-empty]');
  const cartBody = document.querySelector('[data-cart-body]');
  const hiddenItems = document.getElementById('hiddenItems');
  const discountInput = document.querySelector('[data-discount]');
  const paidInput = document.querySelector('[data-paid]');
  const form = document.getElementById('posForm');

  function money(value){
    return Number(value || 0).toFixed(2);
  }

  function setMessage(text, type){
    if (!message) return;
    message.textContent = text || '';
    message.className = 'small mb-2 ' + (type === 'error' ? 'text-danger' : 'text-muted');
  }

  function productById(id){
    return quickProducts.find(product => Number(product.id) === Number(id));
  }

  function addProduct(product){
    const size = Array.isArray(product.sizes) && product.sizes.length ? product.sizes[0] : null;
    const sizeLabel = size ? String(size.label || '') : '';
    const price = size && size.price !== null && size.price !== '' ? Number(size.price) : Number(product.price || 0);
    const key = [product.id, sizeLabel, price].join('|');
    const existing = cart.find(line => line.key === key);

    if (existing) {
      existing.quantity += 1;
    } else {
      cart.push({
        key,
        product_id: product.id,
        item_name: product.name,
        barcode: product.barcode || product.sku || '',
        stock: Number(product.stock || 0),
        sizes: Array.isArray(product.sizes) ? product.sizes : [],
        size: sizeLabel,
        quantity: 1,
        unit_price: price
      });
    }

    renderCart();
    setMessage(product.name + ' u shtua.', 'ok');
  }

  async function lookup(){
    const q = (scanInput?.value || '').trim();
    if (!q) return;

    setMessage('Duke kerkuar...', 'ok');
    try {
      const response = await fetch(lookupUrl + '?q=' + encodeURIComponent(q), {
        headers: {'Accept': 'application/json'}
      });
      const payload = await response.json();
      if (!response.ok) {
        throw new Error(payload.message || 'Produkti nuk u gjet.');
      }
      addProduct(payload.product);
      scanInput.value = '';
      scanInput.focus();
    } catch (error) {
      setMessage(error.message, 'error');
      scanInput.select();
    }
  }

  function renderCart(){
    cartBody.innerHTML = '';
    hiddenItems.innerHTML = '';
    cartWrap.classList.toggle('d-none', cart.length === 0);
    cartEmpty.classList.toggle('d-none', cart.length > 0);

    cart.forEach((line, index) => {
      const total = line.quantity * line.unit_price;
      const tr = document.createElement('tr');
      const sizeOptions = line.sizes.length
        ? '<select class="form-select form-select-sm" data-line-size="' + index + '">' + line.sizes.map(size => {
            const label = String(size.label || '');
            const selected = label === line.size ? ' selected' : '';
            const price = size.price !== null && size.price !== undefined ? Number(size.price) : line.unit_price;
            return '<option value="' + escapeHtml(label) + '" data-price="' + money(price) + '"' + selected + '>' + escapeHtml(label) + '</option>';
          }).join('') + '</select>'
        : '<input class="form-control form-control-sm" value="' + escapeHtml(line.size || '') + '" data-line-size-text="' + index + '">';

      tr.innerHTML = ''
        + '<td><div class="fw-bold">' + escapeHtml(line.item_name) + '</div><div class="small text-muted">' + escapeHtml(line.barcode || '-') + (line.stock <= 0 ? ' / stok 0' : ' / stok ' + line.stock) + '</div></td>'
        + '<td>' + sizeOptions + '</td>'
        + '<td><input type="number" min="1" class="form-control form-control-sm qty-input" value="' + line.quantity + '" data-line-qty="' + index + '"></td>'
        + '<td><input type="number" min="0" step="0.01" class="form-control form-control-sm price-input" value="' + money(line.unit_price) + '" data-line-price="' + index + '"></td>'
        + '<td class="text-end fw-bold">' + money(total) + ' EUR</td>'
        + '<td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger" data-line-remove="' + index + '"><i class="fa fa-trash"></i></button></td>';

      cartBody.appendChild(tr);

      addHidden(index, 'product_id', line.product_id || '');
      addHidden(index, 'barcode', line.barcode || '');
      addHidden(index, 'item_name', line.item_name || '');
      addHidden(index, 'size', line.size || '');
      addHidden(index, 'quantity', line.quantity);
      addHidden(index, 'unit_price', money(line.unit_price));
    });

    calculateTotals();
  }

  function addHidden(index, field, value){
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'items[' + index + '][' + field + ']';
    input.value = value;
    hiddenItems.appendChild(input);
  }

  function calculateTotals(){
    const subtotal = cart.reduce((sum, line) => sum + line.quantity * line.unit_price, 0);
    const discount = Math.min(Number(discountInput?.value || 0), subtotal);
    const total = Math.max(subtotal - discount, 0);
    const paid = Number(paidInput?.value || 0);
    const balance = Math.max(total - paid, 0);

    document.querySelector('[data-subtotal]').textContent = money(subtotal);
    document.querySelector('[data-discount-preview]').textContent = money(discount);
    document.querySelector('[data-total]').textContent = money(total);
    document.querySelector('[data-balance]').textContent = money(balance);
  }

  function escapeHtml(value){
    return String(value ?? '').replace(/[&<>"']/g, char => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    }[char]));
  }

  scanInput?.addEventListener('keydown', event => {
    if (event.key === 'Enter') {
      event.preventDefault();
      lookup();
    }
  });
  scanButton?.addEventListener('click', lookup);

  document.addEventListener('click', event => {
    const quick = event.target.closest('[data-quick-product]');
    if (quick) {
      const product = productById(quick.getAttribute('data-quick-product'));
      if (product) addProduct(product);
    }

    const remove = event.target.closest('[data-line-remove]');
    if (remove) {
      cart.splice(Number(remove.getAttribute('data-line-remove')), 1);
      renderCart();
    }
  });

  document.querySelector('[data-clear-cart]')?.addEventListener('click', () => {
    cart.splice(0, cart.length);
    renderCart();
    scanInput?.focus();
  });

  document.addEventListener('input', event => {
    if (event.target.matches('[data-discount], [data-paid]')) {
      calculateTotals();
    }
  });

  document.addEventListener('change', event => {
    const qty = event.target.closest('[data-line-qty]');
    if (qty) {
      cart[Number(qty.getAttribute('data-line-qty'))].quantity = Math.max(Number(qty.value || 1), 1);
      renderCart();
      return;
    }

    const price = event.target.closest('[data-line-price]');
    if (price) {
      cart[Number(price.getAttribute('data-line-price'))].unit_price = Math.max(Number(price.value || 0), 0);
      renderCart();
      return;
    }

    const sizeText = event.target.closest('[data-line-size-text]');
    if (sizeText) {
      cart[Number(sizeText.getAttribute('data-line-size-text'))].size = sizeText.value;
      renderCart();
      return;
    }

    const sizeSelect = event.target.closest('[data-line-size]');
    if (!sizeSelect) return;
    const line = cart[Number(sizeSelect.getAttribute('data-line-size'))];
    const selected = sizeSelect.options[sizeSelect.selectedIndex];
    line.size = sizeSelect.value;
    line.unit_price = Number(selected.getAttribute('data-price') || line.unit_price || 0);
    line.key = [line.product_id, line.size, line.unit_price].join('|');
    renderCart();
  });

  document.querySelector('[data-pay-none]')?.addEventListener('click', () => {
    paidInput.value = '0.00';
    calculateTotals();
  });
  document.querySelector('[data-pay-half]')?.addEventListener('click', () => {
    paidInput.value = money(Number(document.querySelector('[data-total]').textContent || 0) / 2);
    calculateTotals();
  });
  document.querySelector('[data-pay-full]')?.addEventListener('click', () => {
    paidInput.value = money(Number(document.querySelector('[data-total]').textContent || 0));
    calculateTotals();
  });

  form?.addEventListener('submit', event => {
    if (cart.length === 0) {
      event.preventDefault();
      setMessage('Shto te pakten nje produkt ne shporte.', 'error');
      scanInput?.focus();
    }
  });

  renderCart();
})();
</script>
</body>
</html>
