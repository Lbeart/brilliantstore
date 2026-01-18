<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Edito Produkt – Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body{ background:#f8f9fa; font-family:'Segoe UI',sans-serif; }
        .app-navbar{ background:#fff; box-shadow:0 8px 24px rgba(0,0,0,.05); }
        .dropdown-toggle::after{ display:none; }
        .sidebar{ background:#343a40; min-height:100vh; color:#fff; }
        .sidebar .nav-link{ color:#adb5bd; border-radius:.375rem; padding:.5rem .75rem; }
        .sidebar .nav-link.active,.sidebar .nav-link:hover{ background:#dc3545; color:#fff!important; }
        .logo{ width:130px; }
        .content{ padding:2rem; }
        .title{ color:#dc3545; font-weight:700; font-size:22px; }
        .offcanvas.sidebar{ background:#343a40; color:#fff; }
        .offcanvas.sidebar .nav-link{ color:#adb5bd; border-radius:4px; padding:10px 15px; }
        .offcanvas.sidebar .nav-link.active,.offcanvas.sidebar .nav-link:hover{ background:#dc3545; color:#fff!important; }
        @media (max-width:991px){ .content{ padding:1rem; } }
        @media (max-width:767px){ .sidebar.desktop{ display:none; } }
    </style>
</head>
<body>
<nav class="navbar navbar-light app-navbar sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="title m-0">Edito Produkt</div>
        <div class="dropdown">
            <a class="text-dark text-decoration-none" href="#" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i> Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Dil</button>
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
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo img-fluid">
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users me-1"></i> Përdoruesit</a>
                <a class="nav-link active" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open me-1"></i> Produktet</a>
            </nav>
        </div>

        <!-- Content -->
        <div class="col-lg-10 content">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Kujdes!</strong> Kontrollo fushat e mëposhtme.
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @php
                $categories = [
                  'tepiha' => 'Tepiha',
                  'perde' => 'Perde',
                  'jastekdekorues' => 'JastekDekorues',
                  'postava' => 'Postava',
                  'mbulesa' => 'Mbulesa',
                  'batanije' => 'Batanije',
                  'tepihebanjo' => 'Tepiha për Banjo',
                  'posteqia' => 'Posteqia',
                  'garnishte' => 'Garnishte'
                ];
            @endphp

            <form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Emri *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$product->name) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Çmimi (€) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',$product->price) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Statusi</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active',$product->is_active)==1?'selected':'' }}>Aktiv</option>
                        <option value="0" {{ old('is_active',$product->is_active)==0?'selected':'' }}>Jo aktiv</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Kategoria *</label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $val => $label)
                            <option value="{{ $val }}" @selected(old('category', $product->category ?? 'tepiha') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Përshkrimi</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description',$product->description) }}</textarea>
                </div>
                  <div class="mb-3">
            <label class="form-label">Stoku</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
        </div>
        {{-- Dimensione (vetëm për Tepiha) --}}
<div class="card border-0 shadow-sm mt-3">
  <div class="card-body">
    <h6 class="mb-2">Dimensione për Tepiha</h6>
    <small class="text-muted d-block mb-3">
      Fillo vetem nese <strong>kategoria = Tepiha</strong>. Zbraz këtë seksion për kategori tjera.
    </small>

    @php
      // Për EDIT: $product->sizes. Për CREATE: old('sizes')
      $sizes = old('sizes', isset($product) ? ($product->sizes ?? []) : []);
      // kur vjen nga old() si sizes[label] / sizes[price] / sizes[stock], i rindërtojmë:
      if(isset($sizes['label'])){
        $tmp=[]; foreach(($sizes['label'] ?? []) as $i=>$lbl){
          if($lbl!==null && $lbl!==''){
            $tmp[] = [
              'label' => $lbl,
              'price' => $sizes['price'][$i] ?? null,
              'stock' => $sizes['stock'][$i] ?? null,
            ];
          }
        }
        $sizes = $tmp;
      }
    @endphp

    <div id="sizesRepeater">
      @forelse($sizes as $s)
        <div class="row g-2 align-items-end mb-2 size-row">
          <div class="col-md-5">
            <label class="form-label mb-1">Dimensioni</label>
            <input name="sizes[label][]" class="form-control" placeholder="p.sh. 80x150" value="{{ $s['label'] ?? '' }}">
          </div>
          <div class="col-md-3">
            <label class="form-label mb-1">Çmimi (€)</label>
            <input name="sizes[price][]" type="number" step="0.01" class="form-control" value="{{ $s['price'] ?? '' }}">
          </div>
          <div class="col-md-2">
            <label class="form-label mb-1">Stok</label>
            <input name="sizes[stock][]" type="number" min="0" class="form-control" value="{{ $s['stock'] ?? '' }}">
          </div>
          <div class="col-md-2 text-end">
            <button type="button" class="btn btn-outline-danger remove-size">Fshi</button>
          </div>
        </div>
      @empty
        <div class="row g-2 align-items-end mb-2 size-row">
          <div class="col-md-5">
            <label class="form-label mb-1">Dimensioni</label>
            <input name="sizes[label][]" class="form-control" placeholder="p.sh. 80x150">
          </div>
          <div class="col-md-3">
            <label class="form-label mb-1">Çmimi (€)</label>
            <input name="sizes[price][]" type="number" step="0.01" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label mb-1">Stok</label>
            <input name="sizes[stock][]" type="number" min="0" class="form-control">
          </div>
          <div class="col-md-2 text-end">
            <button type="button" class="btn btn-outline-danger remove-size">Fshi</button>
          </div>
        </div>
      @endforelse
    </div>

    <button type="button" id="addSize" class="btn btn-outline-primary btn-sm mt-2">+ Shto rresht</button>

    <script>
    document.addEventListener('click', function(e){
      if(e.target.id === 'addSize'){
        const wrap = document.getElementById('sizesRepeater');
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end mb-2 size-row';
        row.innerHTML = `
          <div class="col-md-5">
            <label class="form-label mb-1">Dimensioni</label>
            <input name="sizes[label][]" class="form-control" placeholder="p.sh. 120x180">
          </div>
          <div class="col-md-3">
            <label class="form-label mb-1">Çmimi (€)</label>
            <input name="sizes[price][]" type="number" step="0.01" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label mb-1">Stok</label>
            <input name="sizes[stock][]" type="number" min="0" class="form-control">
          </div>
          <div class="col-md-2 text-end">
            <button type="button" class="btn btn-outline-danger remove-size">Fshi</button>
          </div>`;
        wrap.appendChild(row);
      }
      if(e.target.classList.contains('remove-size')){
        e.target.closest('.size-row')?.remove();
      }
    });
    </script>
  </div>
</div>

                <div class="col-md-6">
                    <label class="form-label">Foto e re (opsionale)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($product->image_path)
                        <small class="d-block mt-2">Aktuale:</small>
                        <img src="{{ $product->image_url }}" style="height:80px;border-radius:6px">
                    @endif
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-danger">Ruaj</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kthehu</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Offcanvas mobile -->
<div class="offcanvas offcanvas-start sidebar d-lg-none" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Mbyll"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
            <a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users me-1"></i> Përdoruesit</a>
            <a class="nav-link active" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open me-1"></i> Produktet</a>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
