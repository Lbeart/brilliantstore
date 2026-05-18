<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Edito klientin - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{--brand:#dc3545;--brand-dark:#b42332;--ink:#17202a;--muted:#667085;--line:#e5e7eb;--sidebar:#242933;--surface:#fff;--page:#f5f6f8;--radius:8px;--shadow:0 10px 26px rgba(16,24,40,.07)}
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
    .muted{color:var(--muted)}
    .empty-state{padding:2rem;text-align:center;color:var(--muted)}
    .line-item{border:1px solid var(--line);border-radius:var(--radius);padding:.75rem;background:#fbfcfd;margin-bottom:.75rem}
    .pos-total{border:1px solid var(--line);border-radius:var(--radius);background:#111827;color:#fff;padding:1rem}
    .pos-total .label{color:#cbd5e1;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;font-weight:800}
    .pos-total .value{font-size:1.6rem;font-weight:900}
    .mini-total{font-size:.85rem;color:#667085}
    @media (max-width:991px){.content{padding:1rem}.page-head{flex-direction:column}.sidebar{min-height:100vh}}
    @media (max-width:767px){.sidebar.desktop{display:none}}
  </style>
</head>
<body>

<nav class="navbar navbar-light app-navbar sticky-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
      <i class="fas fa-bars"></i>
    </button>
    <div class="title m-0">Edito klientin</div>
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
          <div class="eyebrow">Klienti #{{ $customer->id }}</div>
          <h1>{{ $customer->name }}</h1>
          <p>{{ $customer->phone ?: 'Pa telefon' }} @if($customer->email) / {{ $customer->email }} @endif</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-dark">
          <i class="fa fa-arrow-left me-1"></i> Kthehu
        </a>
      </div>

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if($errors->any())
        <div class="alert alert-danger">Kontrollo fushat, ka disa te dhena qe mungojne ose nuk jane ne formatin e duhur.</div>
      @endif

      <div class="row g-3">
        <div class="col-12 col-xl-4">
          <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="card-soft p-3">
            @csrf @method('PUT')
            <div class="section-title">
              <h2>Te dhenat e klientit</h2>
            </div>
            <div class="mb-2">
              <label class="form-label">Emri dhe mbiemri</label>
              <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control" required>
            </div>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Telefoni</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control">
              </div>
            </div>
            <div class="row g-2 mt-0">
              <div class="col-md-7">
                <label class="form-label">Adresa</label>
                <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="form-control">
              </div>
              <div class="col-md-5">
                <label class="form-label">Qyteti</label>
                <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="form-control">
              </div>
            </div>
            <div class="mt-2">
              <label class="form-label">Shenime</label>
              <textarea name="notes" rows="4" class="form-control">{{ old('notes', $customer->notes) }}</textarea>
            </div>
            <button class="btn btn-danger w-100 mt-3">
              <i class="fa fa-save me-1"></i> Ruaj ndryshimet
            </button>
          </form>

          <form method="POST" action="{{ route('admin.customers.purchases.store', $customer) }}" class="card-soft p-3 mt-3">
            @csrf
            <div class="section-title">
              <h2>POS - shitje e re</h2>
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
                  <label class="form-label">Zgjidh produkt nga stoku</label>
                  <select name="items[0][product_id]" class="form-select mb-2" data-product-select>
                    <option value="">Produkt custom / jo nga stoku</option>
                    @foreach($products ?? [] as $product)
                      <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price ?? 0 }}">
                        {{ $product->name }} @if($product->sku) / {{ $product->sku }} @endif - {{ number_format($product->price ?? 0, 2) }} EUR
                      </option>
                    @endforeach
                  </select>
                  <label class="form-label">Produkti / sendi qe bleu</label>
                  <input type="text" name="items[0][item_name]" class="form-control" data-item-name required>
                </div>
                <div class="row g-2">
                  <div class="col-6">
                    <label class="form-label">Madhesia</label>
                    <input type="text" name="items[0][size]" class="form-control">
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
              <label class="form-label">Shenime per blerjen</label>
              <textarea name="purchase_notes" rows="2" class="form-control">{{ old('purchase_notes') }}</textarea>
            </div>

            <div class="row g-2 mt-1">
              <div class="col-6">
                <label class="form-label">Zbritje</label>
                <input type="number" step="0.01" name="discount" value="0" min="0" class="form-control" data-discount>
              </div>
              <div class="col-6">
                <label class="form-label">Paguar</label>
                <input type="number" step="0.01" name="paid_amount" min="0" class="form-control" data-paid>
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

            <div class="pos-total mt-3">
              <div class="d-flex justify-content-between gap-2">
                <div>
                  <div class="label">Totali per pagese</div>
                  <div class="value"><span data-grand-total>0.00</span> EUR</div>
                </div>
                <div class="text-end">
                  <div class="label">Mbetur</div>
                  <div class="value"><span data-balance>0.00</span> EUR</div>
                </div>
              </div>
              <div class="small mt-2">Subtotal: <span data-subtotal>0.00</span> EUR / Zbritje: <span data-discount-preview>0.00</span> EUR</div>
            </div>

            <button class="btn btn-outline-dark w-100 mt-3">
              <i class="fa fa-receipt me-1"></i> Ruaj faturen
            </button>
          </form>
        </div>

        <div class="col-12 col-xl-8">
          <div class="card-soft p-3">
            @php
              $receiptGroups = $customer->purchases->groupBy(fn($purchase) => $purchase->receipt_code ?: 'BRL-MAN-'.$purchase->id);
            @endphp
            <div class="section-title">
              <h2>Faturat dhe historiku</h2>
              <span class="small muted">{{ $receiptGroups->count() }} fatura / {{ $customer->purchases->count() }} artikuj</span>
            </div>
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Fatura</th>
                    <th>Artikujt</th>
                    <th>Totali</th>
                    <th>Burimi</th>
                    <th class="text-end">Veprim</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($receiptGroups as $receiptCode => $purchases)
                    @php
                      $firstPurchase = $purchases->first();
                      $receiptTotal = $purchases->sum('total');
                    @endphp
                    <tr>
                      <td class="small muted">{{ $firstPurchase->purchased_at?->format('d.m.Y') }}</td>
                      <td>
                        <div class="fw-bold">{{ $receiptCode }}</div>
                        @if($firstPurchase->notes)<div class="small muted">{{ $firstPurchase->notes }}</div>@endif
                      </td>
                      <td>
                        @foreach($purchases as $purchase)
                          <div class="mb-1">
                            <span class="fw-semibold">{{ $purchase->item_name }}</span>
                            <span class="small muted">x{{ $purchase->quantity }} @if($purchase->size) / {{ $purchase->size }} @endif</span>
                            <form method="POST" action="{{ route('admin.customers.purchases.destroy', [$customer, $purchase]) }}" class="d-inline" onsubmit="return confirm('Ta fshij kete artikull nga fatura?');">
                              @csrf @method('DELETE')
                              <button class="btn btn-sm btn-link text-danger p-0 ms-1">fshi</button>
                            </form>
                          </div>
                        @endforeach
                      </td>
                      <td class="fw-bold">{{ number_format((float) $receiptTotal, 2) }} EUR</td>
                      <td>
                        @php $receipt = $firstPurchase->customer_receipt_id ? $customer->receipts->firstWhere('id', $firstPurchase->customer_receipt_id) : null; @endphp
                        @if($receipt)
                          @php
                            $paymentLabels = ['cash' => 'Cash', 'card' => 'Kartel', 'bank' => 'Banke', 'mixed' => 'E perzier'];
                            $statusLabels = ['paid' => 'Paguar', 'partial' => 'Pjese', 'unpaid' => 'Pa paguar'];
                            $statusColors = ['paid' => 'success', 'partial' => 'warning', 'unpaid' => 'danger'];
                          @endphp
                          <div class="small">
                            <span class="badge bg-{{ $statusColors[$receipt->payment_status] ?? 'secondary' }}">{{ $statusLabels[$receipt->payment_status] ?? $receipt->payment_status }}</span>
                            <div class="muted mt-1">{{ $paymentLabels[$receipt->payment_method] ?? $receipt->payment_method }} / Paguar {{ number_format((float) $receipt->paid_amount, 2) }} EUR</div>
                            @if((float) $receipt->balance > 0)
                              <div class="text-danger fw-bold">Borxh {{ number_format((float) $receipt->balance, 2) }} EUR</div>
                            @endif
                          </div>
                        @elseif($firstPurchase->order)
                          <a href="{{ route('admin.orders.show', $firstPurchase->order) }}" class="btn btn-sm btn-outline-dark">
                            Porosia #{{ $firstPurchase->order->id }}
                          </a>
                        @else
                          <span class="badge bg-light text-dark">Manuale</span>
                        @endif
                      </td>
                      <td class="text-end">
                        <div class="btn-group">
                          <a href="{{ route('admin.customers.invoice', [$customer, $receiptCode]) }}" class="btn btn-sm btn-outline-dark">
                            <i class="fa fa-eye me-1"></i> Fatura
                          </a>
                          <a href="{{ route('admin.customers.invoice.pdf', [$customer, $receiptCode]) }}" class="btn btn-sm btn-danger">
                            <i class="fa fa-file-pdf me-1"></i> PDF
                          </a>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="empty-state">Ky klient ende nuk ka fatura te regjistruara.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
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
  const lines = document.querySelector('[data-lines]');
  const add = document.querySelector('[data-add-line]');
  if (!lines || !add) return;

  function renumber(){
    [...lines.querySelectorAll('[data-line]')].forEach((line, index) => {
      line.querySelector('strong').textContent = 'Artikulli ' + (index + 1);
      line.querySelectorAll('input, select').forEach(input => {
        if (input.name) input.name = input.name.replace(/items\[\d+\]/, 'items[' + index + ']');
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

    if (paidInput && paidInput.value === '') {
      paidInput.value = money(grand);
    }

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
    clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    lines.appendChild(clone);
    renumber();
  });

  lines.addEventListener('click', event => {
    const button = event.target.closest('[data-remove-line]');
    if (!button || lines.querySelectorAll('[data-line]').length === 1) return;
    button.closest('[data-line]').remove();
    renumber();
  });

  lines.addEventListener('change', event => {
    const select = event.target.closest('[data-product-select]');
    if (!select) return;

    const option = select.selectedOptions[0];
    const line = select.closest('[data-line]');
    if (!line || !option || !option.value) return;

    line.querySelector('[data-item-name]').value = option.dataset.name || '';
    line.querySelector('[data-price]').value = money(option.dataset.price || 0);
    calculateLine(line);
    calculate();
  });

  document.addEventListener('input', event => {
    if (event.target.closest('[data-line]') || event.target.matches('[data-discount], [data-paid]')) {
      calculate();
    }
  });

  calculate();
})();
</script>
</body>
</html>
