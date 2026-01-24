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

        .img-grid{ display:flex; flex-wrap:wrap; gap:10px; }
        .img-box{
            position:relative;
            width:92px; height:92px;
            border-radius:12px;
            background:#f1f2f6;
            border:1px solid #eee;
            overflow:hidden;
        }
        .img-box img{ width:100%; height:100%; object-fit:cover; }
        .img-remove{
            position:absolute; top:6px; right:6px;
            width:28px; height:28px;
            border-radius:999px;
            border:0;
            background:#dc3545;
            color:#fff;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer;
            box-shadow:0 8px 20px rgba(0,0,0,.15);
        }
        .hint{ font-size:12px; color:#6b7280; }
        .card-soft{ background:#fff; border:0; border-radius:14px; box-shadow:0 8px 24px rgba(0,0,0,.06); }
    </style>
</head>
<body>

@php
  // ---------- Helpers për FOTO ----------
  $placeholder = asset('images/placeholder.png');

  $decode_images = function($value){
    if (empty($value)) return [];

    if (is_array($value)) return array_values(array_filter($value));

    $raw = trim((string)$value);

    // nëse vjen si URL që përmban JSON: https://domain.com/storage/[...]
    if (preg_match('/\[[^\]]+\]/', $raw, $m)) {
      $raw = $m[0];
    }

    $decoded = json_decode($raw, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
      return array_values(array_filter($decoded));
    }

    // fallback: string i vetëm
    return [$raw];
  };

  $img_src = function($path) use ($placeholder){
    if (empty($path)) return $placeholder;

    // nëse është URL absolute
    if (preg_match('#^https?://#i', $path)) return $path;

    $clean = ltrim((string)$path, '/');
    $clean = preg_replace('#^(storage|public)/#', '', $clean);

    if (str_starts_with($clean, 'images/')) return asset($clean);

    return \Illuminate\Support\Facades\Storage::disk('public')->url($clean);
  };

  // Existing images nga DB
  $existingImages = $decode_images($product->image_path ?? null);

  // --------- Category / Subcategory (perde-ditore) ----------
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

  $catValue = old('category', $product->category ?? 'tepiha');
  $subValue = old('subcategory', null);

  if (!$subValue && is_string($catValue) && str_starts_with($catValue, 'perde-')) {
    $subValue = substr($catValue, strlen('perde-')); // ditore / anesore
    $catValue = 'perde';
  }
@endphp

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

            <form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf @method('PUT')

                <div class="col-12">
                    <div class="card-soft p-3">
                        <div class="row g-3">
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
                                <select name="category" class="form-select" required id="categorySelect">
                                    @foreach($categories as $val => $label)
                                        <option value="{{ $val }}" @selected($catValue === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3" id="subcatWrap" style="{{ $catValue==='perde' ? '' : 'display:none' }}">
                                <label class="form-label">Subkategoria (Perde)</label>
                                <select name="subcategory" class="form-select" id="subcatSelect">
                                    <option value="">—</option>
                                    <option value="ditore" @selected($subValue==='ditore')>Ditorë</option>
                                    <option value="anesore" @selected($subValue==='anesore')>Anësore</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Stoku</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Përshkrimi</label>
                                <textarea name="description" rows="4" class="form-control">{{ old('description',$product->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dimensione (vetëm për Tepiha) --}}
                <div class="col-12">
                    <div class="card-soft p-3">
                        <h6 class="mb-2">Dimensione për Tepiha</h6>
                        <small class="text-muted d-block mb-3">
                            Fillo vetem nese <strong>kategoria = Tepiha</strong>. Zbraz këtë seksion për kategori tjera.
                        </small>

                        @php
                          $sizes = old('sizes', isset($product) ? ($product->sizes ?? []) : []);
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
                    </div>
                </div>

                <!-- FOTO MULTI -->
                <div class="col-12">
                    <div class="card-soft p-3">
                        <h6 class="mb-2">Fotot</h6>
                        <div class="hint mb-2">
                            ✅ Mundesh me i fshi disa foto ekzistuese (X) dhe me shto të reja. Nëse i heq krejt ekzistueset, fotot e reja i zëvendësojnë krejt.
                        </div>

                        {{-- EXISTING --}}
                        <div class="mb-3">
                            <label class="form-label mb-1">Fotot aktuale</label>

                            @if(!empty($existingImages))
                                <div class="img-grid" id="existingWrap">
                                    @foreach($existingImages as $p)
                                        @php $src = $img_src($p); @endphp
                                        <div class="img-box existing-item">
                                            <img src="{{ $src }}"
                                                 onerror="this.onerror=null;this.src='{{ $placeholder }}'">
                                            <input type="hidden" name="existing_images[]" value="{{ $p }}">
                                            <button type="button" class="img-remove remove-existing" title="Hiqe">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted">S’ka foto aktuale.</div>
                            @endif
                        </div>

                        {{-- NEW UPLOAD --}}
                        <div class="mb-2">
                            <label class="form-label">Shto foto të reja (multiple)</label>
                            <input type="file" name="image[]" class="form-control" accept="image/*" id="imageInput" multiple>
                            <div class="hint mt-1">Mundesh me zgjedh 1+ foto njëherësh.</div>
                        </div>

                        {{-- PREVIEW NEW --}}
                        <div class="mt-3">
                            <label class="form-label mb-1">Preview (fotot e reja)</label>
                            <div class="img-grid" id="newPreviewWrap">
                                <div class="text-muted" id="noNewText">S’ka foto të reja të zgjedhura.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
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

<script>
// repeater për size
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

// hiq existing image (heq edhe hidden input)
document.addEventListener('click', function(e){
  const btn = e.target.closest('.remove-existing');
  if(!btn) return;
  btn.closest('.existing-item')?.remove();
});

// preview për shumë foto të reja
const input = document.getElementById('imageInput');
const wrap = document.getElementById('newPreviewWrap');
const noText = document.getElementById('noNewText');

if(input && wrap){
  input.addEventListener('change', function(){
    wrap.innerHTML = '';
    const files = Array.from(this.files || []);
    if(files.length === 0){
      wrap.innerHTML = '<div class="text-muted">S’ka foto të reja të zgjedhura.</div>';
      return;
    }

    files.forEach(file => {
      const url = URL.createObjectURL(file);
      const box = document.createElement('div');
      box.className = 'img-box';
      box.innerHTML = `<img src="${url}" alt="preview">`;
      wrap.appendChild(box);
    });
  });
}

// category -> show/hide subcategory
const catSel = document.getElementById('categorySelect');
const subWrap = document.getElementById('subcatWrap');
const subSel = document.getElementById('subcatSelect');

if(catSel && subWrap){
  catSel.addEventListener('change', function(){
    if(this.value === 'perde'){
      subWrap.style.display = '';
    }else{
      subWrap.style.display = 'none';
      if(subSel) subSel.value = '';
    }
  });
}
</script>

</body>
</html>
