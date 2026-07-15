<!DOCTYPE html>  
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Shto Produkt – Admin</title>
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
        .offcanvas.sidebar .nav-link.active,.sidebar .nav-link:hover{ background:#dc3545; color:#fff!important; }
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
        <div class="title m-0">Shto Produkt</div>
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
                <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}"><i class="fas fa-address-book me-1"></i> Klientet</a>
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
                // kategorizimi – i njëjtë me menunë
                $categories = [
                  'tepiha' => 'Tepiha',
                  'perde' => 'Perde',
                  'jastekdekorues' => 'JastekDekorues',
                  'postava' => 'Postava',
                  'mbulesa' => 'Mbulesa',
                  'batanije' => 'Batanije',
                  'tepihebanjo' => 'Tepiha për Banjo',
                  'posteqia' => 'Posteqia',
                  'garnishte'    => 'Garnishte',
                ];
            @endphp

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label class="form-label">Emri *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Çmimi (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Statusi</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active',1)==1?'selected':'' }}>Aktiv</option>
                        <option value="0" {{ old('is_active',1)==0?'selected':'' }}>Jo aktiv</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Kategoria *</label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $val => $label)
                            <option value="{{ $val }}" @selected(old('category', 'tepiha') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nën-kategoria (vetëm për Perde) -->
                <div class="col-md-3" id="subcategoryWrap" style="display:none;">
                    <label class="form-label">Nën-kategoria (vetëm për Perde)</label>
                    <select name="subcategory" class="form-select">
                        <option value="">— Zgjedh —</option>
                        <option value="anesore" @selected(old('subcategory')==='anesore')>Perde anësore</option>
                        <option value="ditore"  @selected(old('subcategory')==='ditore')>Perde ditore</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Përshkrimi</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Stoku</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" min="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Barkodi</label>
                    <div class="input-group">
                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}" data-barcode-input placeholder="BRL...">
                        <button type="button" class="btn btn-outline-dark" data-generate-barcode>Gjenero</button>
                    </div>
                    <small class="text-muted">Per barkod te brendshem POS. Nese e le bosh, krijohet automatikisht.</small>
                </div>

                {{-- Dimensione / opsione --}}
                <div id="sizesCard" class="card border-0 shadow-sm mt-3" style="display:none;">
                  <div class="card-body">
                    <h6 class="mb-2">Dimensione / opsione për <span id="sizesCatLabel">Tepiha</span></h6>
                    <small class="text-muted d-block mb-3">
                      Per mbulesa cakto <strong>Cmimi me meter</strong> ne fushen e vecante, p.sh. 8 euro.
                      Per set shto <strong>3+2+1</strong> me cmimin total te setit, p.sh. 30 euro.
                      Nese klienti shkruan 3+3+2+1, sistemi e llogarit proporcionalisht: 45 euro.
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
                              'barcode' => $sizes['barcode'][$i] ?? null,
                            ];
                          }
                        }
                        $sizes = $tmp;
                      }

                      $coverMeterPrice = old('cover_meter_price');
                      $filteredSizes = [];
                      foreach($sizes as $s){
                        $label = trim((string)($s['label'] ?? ''));
                        $normalized = strtolower(preg_replace('/[\s\-_]+/', '', $label));
                        if(in_array($normalized, ['meter','metra','meteri','memeter','m'], true)){
                          if($coverMeterPrice === null || $coverMeterPrice === ''){
                            $coverMeterPrice = $s['price'] ?? '';
                          }
                          continue;
                        }
                        $filteredSizes[] = $s;
                      }
                      $sizes = $filteredSizes;
                    @endphp

                    <div id="coverMeterPriceWrap" class="row g-2 mb-3" style="display:none;">
                      <div class="col-md-4">
                        <label class="form-label mb-1">Cmimi me meter (€)</label>
                        <input name="cover_meter_price" type="number" step="0.01" min="0" class="form-control" value="{{ $coverMeterPrice }}" placeholder="p.sh. 8">
                      </div>
                      <div class="col-md-8 d-flex align-items-end">
                        <small class="text-muted">Ky cmim perdoret vetem kur klienti zgjedh me meter. Setet poshte kane cmimin e vet.</small>
                      </div>
                    </div>

                    <div id="sizesRepeater">
                      @forelse($sizes as $s)
                        <div class="row g-2 align-items-end mb-2 size-row">
                          <div class="col-md-5">
                            <label class="form-label mb-1">Dimensioni</label>
                            <input name="sizes[label][]" class="form-control" placeholder="p.sh. 80x150" value="{{ $s['label'] ?? '' }}">
                            <input type="hidden" name="sizes[barcode][]" value="{{ $s['barcode'] ?? '' }}">
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
                            <input name="sizes[label][]" class="form-control" placeholder="p.sh. 90x200">
                            <input type="hidden" name="sizes[barcode][]" value="">
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
                  </div>
                </div>

                @php
                  $oldColorInput = old('color_variants', []);
                  $colorVariants = [];
                  if(isset($oldColorInput['name']) && is_array($oldColorInput['name'])){
                    foreach($oldColorInput['name'] as $i => $name){
                      $colorVariants[] = [
                        'name' => $name,
                        'hex' => $oldColorInput['hex'][$i] ?? '#d1d5db',
                      ];
                    }
                  }
                @endphp

                <div class="card border-0 shadow-sm mt-3">
                  <div class="card-body">
                    <h6 class="mb-2">Ngjyrat / variantet</h6>
                    <small class="text-muted d-block mb-3">
                      Shto ngjyra kur produkti ka te njejtin dizajn, por foto/ngjyre tjeter. Per nje ngjyre mundesh me zgjedh 2-3 foto.
                    </small>

                    <div id="colorVariantsRepeater">
                      @forelse($colorVariants as $variant)
                        @php $rowIndex = $loop->index; @endphp
                        <div class="row g-2 align-items-end mb-2 color-variant-row">
                          <div class="col-md-3">
                            <label class="form-label mb-1">Emri ngjyres</label>
                            <input name="color_variants[name][]" class="form-control" placeholder="p.sh. Gri" value="{{ $variant['name'] ?? '' }}">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label mb-1">Ngjyra</label>
                            <input name="color_variants[hex][]" type="color" class="form-control form-control-color" value="{{ $variant['hex'] ?? '#d1d5db' }}">
                          </div>
                          <div class="col-md-5">
                            <label class="form-label mb-1">Fotot per kete ngjyre</label>
                            <input name="color_variant_images[{{ $rowIndex }}][]" type="file" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/bmp,image/gif">
                            <small class="text-muted">Mundesh me zgjedh disa foto per te njejten ngjyre.</small>
                          </div>
                          <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-outline-danger remove-color-variant">Fshi</button>
                          </div>
                        </div>
                      @empty
                        <div class="row g-2 align-items-end mb-2 color-variant-row">
                          <div class="col-md-3">
                            <label class="form-label mb-1">Emri ngjyres</label>
                            <input name="color_variants[name][]" class="form-control" placeholder="p.sh. Gri">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label mb-1">Ngjyra</label>
                            <input name="color_variants[hex][]" type="color" class="form-control form-control-color" value="#d1d5db">
                          </div>
                          <div class="col-md-5">
                            <label class="form-label mb-1">Fotot per kete ngjyre</label>
                            <input name="color_variant_images[0][]" type="file" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/bmp,image/gif">
                            <small class="text-muted">Mundesh me zgjedh disa foto per te njejten ngjyre.</small>
                          </div>
                          <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-outline-danger remove-color-variant">Fshi</button>
                          </div>
                        </div>
                      @endforelse
                    </div>

                    <button type="button" id="addColorVariant" class="btn btn-outline-primary btn-sm mt-2">+ Shto ngjyre</button>
                  </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Foto (jpg/png/webp, max 40MB)</label>
                    <input type="file" name="image[]" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/bmp,image/gif">
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
            <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}"><i class="fas fa-address-book me-1"></i> Klientet</a>
            <a class="nav-link active" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open me-1"></i> Produktet</a>
        </nav>
    </div>
</div>

<!-- Scripts -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.products.partials.image-compressor')

<script>
function reindexColorVariantRows(){
  document.querySelectorAll('#colorVariantsRepeater .color-variant-row').forEach((row, index) => {
    row.querySelectorAll('input[type="file"][name^="color_variant_images"]').forEach(input => {
      input.name = `color_variant_images[${index}][]`;
    });
  });
}

/* Repeater i dimensioneve */
document.addEventListener('click', function(e){
  if(e.target && e.target.id === 'addSize'){
    const wrap = document.getElementById('sizesRepeater');
    const row = document.createElement('div');
    row.className = 'row g-2 align-items-end mb-2 size-row';
    row.innerHTML = `
      <div class="col-md-5">
        <label class="form-label mb-1">Dimensioni</label>
        <input name="sizes[label][]" class="form-control" placeholder="p.sh. 120x180">
        <input type="hidden" name="sizes[barcode][]" value="">
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
  if(e.target && e.target.classList.contains('remove-size')){
    e.target.closest('.size-row')?.remove();
  }
  if(e.target && e.target.id === 'addColorVariant'){
    const wrap = document.getElementById('colorVariantsRepeater');
    const index = wrap ? wrap.querySelectorAll('.color-variant-row').length : 0;
    const row = document.createElement('div');
    row.className = 'row g-2 align-items-end mb-2 color-variant-row';
    row.innerHTML = `
      <div class="col-md-3">
        <label class="form-label mb-1">Emri ngjyres</label>
        <input name="color_variants[name][]" class="form-control" placeholder="p.sh. Gri">
      </div>
      <div class="col-md-2">
        <label class="form-label mb-1">Ngjyra</label>
        <input name="color_variants[hex][]" type="color" class="form-control form-control-color" value="#d1d5db">
      </div>
      <div class="col-md-5">
        <label class="form-label mb-1">Fotot per kete ngjyre</label>
        <input name="color_variant_images[${index}][]" type="file" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/bmp,image/gif">
        <small class="text-muted">Mundesh me zgjedh disa foto per te njejten ngjyre.</small>
      </div>
      <div class="col-md-2 text-end">
        <button type="button" class="btn btn-outline-danger remove-color-variant">Fshi</button>
      </div>`;
    wrap.appendChild(row);
    reindexColorVariantRows();
  }
  if(e.target && e.target.classList.contains('remove-color-variant')){
    e.target.closest('.color-variant-row')?.remove();
    reindexColorVariantRows();
  }
});

/* Toggle nën-kategori & dimensione sipas kategorisë */
document.addEventListener('DOMContentLoaded', function () {
  const categorySel = document.querySelector('select[name="category"]');
  const subWrap     = document.getElementById('subcategoryWrap');
  const subSel      = document.querySelector('select[name="subcategory"]');
  const sizesCard   = document.getElementById('sizesCard');
  const sizesLabel  = document.getElementById('sizesCatLabel');
  const coverMeterPriceWrap = document.getElementById('coverMeterPriceWrap');

  function toggleByCategory() {
    const cat = (categorySel.value || '').toLowerCase();

    // Nën-kategoria: vetëm kur është 'perde'
    if (cat === 'perde') {
      subWrap.style.display = '';
    } else {
      subWrap.style.display = 'none';
      if (subSel) subSel.value = '';
    }

    // Dimensione / opsione per kategori qe kane variante.
    const showSizes = (cat === 'tepiha' || cat === 'postava' || cat === 'mbulesa' || cat==='batanije' || cat==='posteqia' || cat==='garnishte');
    sizesCard.style.display = showSizes ? '' : 'none';
    sizesLabel.textContent = categorySel.options[categorySel.selectedIndex]?.text || 'Produkt';
    if (coverMeterPriceWrap) coverMeterPriceWrap.style.display = cat === 'mbulesa' ? '' : 'none';
  }

  categorySel?.addEventListener('change', toggleByCategory);
  toggleByCategory(); // init në load (respekton old() kur ka errora)
});

document.addEventListener('click', function (e) {
  if (!e.target.matches('[data-generate-barcode]')) return;
  const input = document.querySelector('[data-barcode-input]');
  if (!input) return;
  const random = Math.random().toString(36).slice(2, 7).toUpperCase();
  const date = new Date();
  const stamp = String(date.getFullYear()).slice(2)
    + String(date.getMonth() + 1).padStart(2, '0')
    + String(date.getDate()).padStart(2, '0');
  input.value = 'BRL' + stamp + random;
  input.focus();
});
</script>
</body>
</html>
