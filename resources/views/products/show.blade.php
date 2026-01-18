<!DOCTYPE html> 
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>{{ $product->name }} – Detaje</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <meta name="description" content="{{ Str::limit(strip_tags($product->description ?? $product->name), 160) }}">
  <meta property="og:title" content="{{ $product->name }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:description" content="{{ Str::limit(strip_tags($product->description ?? $product->name), 160) }}">
  @if($product->image_path)
    <meta property="og:image" content="{{ asset('storage/'.$product->image_path) }}">
  @endif

  <style>
    :root{
      --card-radius:14px;
      --shadow-sm:0 4px 14px rgba(0,0,0,.08);
      --shadow-lg:0 12px 30px rgba(0,0,0,.10);
      --brand:#dc3545;
      --dark:#0f172a;
    }

    html,body{max-width:100%;overflow-x:hidden}
    *,*::before,*::after{box-sizing:border-box}
    img{max-width:100%;height:auto;display:block}

    body{
      background: radial-gradient(circle at top, #fef2f2 0, #f9fafb 40%, #f3f4f6 100%);
      font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif;
      padding-top:92px
    }

    /* NAVBAR */
    .navbar-custom{
      position:fixed;top:12px;left:50%;transform:translateX(-50%);
      width:min(1150px,94%);
      background:linear-gradient(135deg,#020617 0%,#111827 40%,#1f2937 100%);
      border-radius:18px;
      box-shadow:var(--shadow-sm);
      z-index:1000;
      padding:.65rem .9rem
    }
    .navbar-brand img{height:44px}
    .navbar-custom .nav-link{color:#fff!important;font-weight:600;letter-spacing:.2px}
    .navbar-custom .nav-link:hover{color:#e5e7eb!important}
    .dropdown-menu{
      border:0;border-radius:14px;padding:.5rem;
      box-shadow:var(--shadow-lg);background:#fff
    }
    .dropdown-item{border-radius:8px}
    .dropdown-item:hover{background:#f3f4f6}

    /* BACK BUTTON */
    .back-btn{
      position:fixed;top:90px;left:24px;z-index:1100;
      border:none;border-radius:999px;padding:.5rem .9rem;
      background:#fff;
      box-shadow:0 6px 20px rgba(0,0,0,.08);
      display:flex;align-items:center;gap:.4rem;
      color:#111827;font-size:.85rem
    }
    .back-btn:hover{background:#f7f7f7}

    /* HERO IMAGE */
    .product-hero{
      background:#fff;border-radius:16px;
      box-shadow:var(--shadow-sm);
      padding:16px;
      display:flex;align-items:center;justify-content:center;
      min-height:320px;position:relative
    }
    .product-hero img{
      width:100%;max-height:720px;
      object-fit:contain;border-radius:12px;
      user-select:none;-webkit-user-drag:none;
      touch-action: none;
    }
    .zoom-lens{
      position:absolute;display:none;width:180px;height:180px;
      border:1px solid rgba(0,0,0,.15);
      background:rgba(255,255,255,.18);
      backdrop-filter:blur(1px);
      border-radius:10px;pointer-events:none;
      box-shadow:0 6px 18px rgba(0,0,0,.08);
      cursor:crosshair
    }
    .zoom-pane{
      position:absolute;display:none;top:0;left:100%;margin-left:16px;
      width:380px;height:380px;border:1px solid #eee;
      border-radius:12px;background:#fff;
      box-shadow:var(--shadow-lg);background-repeat:no-repeat;
      overflow:hidden
    }
    @media (min-width:1400px){
      .zoom-pane{width:420px;height:420px}
    }

    /* PRODUCT INFO SIDE */
    h1,h2{color:#111827;font-weight:800}
    .bf-chip{
      display:inline-flex;
      align-items:center;
      gap:.35rem;
      font-size:.75rem;
      text-transform:uppercase;
      letter-spacing:.14em;
      background:#fee2e2;
      color:#7f1d1d;
      padding:.18rem .8rem;
      border-radius:999px;
      font-weight:700;
      margin-bottom:.5rem;
    }
    .bf-chip i{font-size:.9rem}

    .price-block{
      background:#fff;
      border-radius:14px;
      box-shadow:var(--shadow-sm);
      padding:12px 14px;
      margin-bottom:10px;
    }
    .price-now{color:var(--brand);font-weight:800;font-size:1.55rem}
    .price-old{
      color:#9ca3af;
      text-decoration:line-through;
      font-size:.9rem;
    }
    .price-badge{
      font-size:.7rem;
      text-transform:uppercase;
      letter-spacing:.12em;
      background:#e0f2fe;
      color:#075985;
      padding:.15rem .7rem;
      border-radius:999px;
      font-weight:700;
    }

    .stock-row{
      display:flex;
      align-items:center;
      gap:.5rem;
      font-size:.9rem;
      margin-bottom:12px;
    }
    .stock-label{
      font-weight:600;
      padding:.2rem .65rem;
      border-radius:999px;
      font-size:.8rem;
    }
    .stock.in{color:#198754;font-weight:600}
    .stock.out{color:#dc3545;font-weight:600}
    .stock-pill-in{background:#dcfce7;color:#166534}
    .stock-pill-out{background:#fee2e2;color:#991b1b}

    .section-card{
      background:#fff;
      border-radius:16px;
      box-shadow:var(--shadow-sm);
      padding:18px;
    }

    /* QTY & BUTTONS */
    .qty-btn{
      width:40px;height:40px;
      border:1px solid #dee2e6;
      background:#fff;border-radius:.375rem;
    }
    .qty-input{
      width:60px;height:40px;
      text-align:center;
      border:1px solid #dee2e6;border-radius:.375rem;
    }

    .btn-whatsapp{
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      background:#16a34a;
      border-color:#16a34a;
    }
    .btn-whatsapp:hover{
      background:#15803d;
      border-color:#15803d;
    }

    /* FULLSCREEN IMAGE MODAL */
    .img-modal{
      position:fixed;inset:0;
      background:rgba(0,0,0,.88);
      display:none;z-index:2000;
      align-items:center;justify-content:center
    }
    .img-modal.open{display:flex}
    .img-modal img{
      max-width:100%;max-height:100%;
      object-fit:contain;touch-action:pan-x pan-y;
      position:relative;z-index:2000
    }
    .img-modal .close-btn{
      position:absolute;top:14px;right:14px;
      background:#fff;border:none;border-radius:999px;
      padding:.55rem .75rem;
      box-shadow:0 6px 18px rgba(0,0,0,.25);
      display:flex;align-items:center;justify-content:center;
      z-index:2100;
    }

    /* RESPONSIVE */
    @media (max-width:991.98px){
      body{padding-top:86px}
      .navbar-custom{
        left:auto;right:auto;transform:none;
        inset:12px 8px auto 8px;width:auto;
        border-radius:12px;padding:.55rem .7rem
      }
      .navbar-brand img{height:38px}
      .container{padding-left:12px;padding-right:12px}
      .product-hero{padding:10px;min-height:auto}
      .product-hero img{max-height:420px;cursor:zoom-in}
      .zoom-pane,.zoom-lens{display:none!important}
      .back-btn{
        top:78px;left:8px;
        padding:.4rem .7rem;font-size:14px
      }
      .section-card{padding:14px}
    }
    @media (max-width:576px){
      h1,h2,.h2{font-size:1.25rem}
      .price-now{font-size:1.25rem}
      .qty-btn,.qty-input{width:36px;height:36px;font-size:14px}
      .qty-input{width:50px}
      .btn{padding:.45rem .85rem;font-size:14px}
    }
    @media (max-width:991.98px){
      .zoom-pane{
        left:8px;
        right:8px;
        top:8px;
        width:auto;
        height:260px;
        margin:0;
        z-index:20;
        display:none;
      }

      .zoom-lens{
        width:120px;
        height:120px;
        border-radius:50%;
        display:none;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" aria-label="Kryemeny">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('images/brillant.png') }}" alt="Brillant">
    </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>

        <li class="nav-item">
          @php
            $rawcat = strtolower($product->category ?? '');
            $cat = str_replace([' ', '_'], '-', $rawcat);
            $map = [
              'tepiha'         => 'products.tepiha',
              'mbulesa'        => 'products.mbulesa',
              'perde-ditore'   => 'products.perdeDitore',
              'perde-anesore'  => 'products.anesore',
              'jastekdekorues' => 'products.jastekdekorues',
              'postava'        => 'products.postava',
              'garnishte'      => 'products.garnishte',
              'tepihebanjo'    => 'products.tepihebanjo',
              'batanije'       => 'products.batanije',
            ];
          @endphp
          @if(isset($map[$cat]))
            <a class="nav-link" href="{{ route($map[$cat]) }}">{{ ucwords(str_replace(['-', '_'], ' ', $cat)) }}</a>
          @else
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          @endif
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>

        @auth
          <li class="nav-item dropdown ms-lg-2">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
               href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
              <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              @if(auth()->user()->role === 'admin')
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li><hr class="dropdown-divider"></li>
              @endif
              <li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">Log out</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-lg-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Log in</a>
          </li>
        @endauth

        {{-- Shporta + Gjurmo --}}
        <li class="nav-item dropdown ms-lg-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
             href="#" id="cartDropdown" role="button"
             data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
            <i class="bi bi-bag"></i> Shporta
            <span class="badge bg-danger rounded-pill ms-1 cart-badge">
              {{ session('cart_total_qty', 0) }}
            </span>
          </a>

          <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="cartDropdown" style="min-width: 320px;">
            <div class="small text-muted mb-2">Gjurmo porosinë</div>
            <form class="d-flex align-items-stretch gap-2"
                  onsubmit="event.preventDefault();
                            const el=this.querySelector('#trackCodeNav');
                            const v=(el?.value||'').trim();
                            if(v){ window.location='{{ url('/track') }}/'+encodeURIComponent(v); }">
              <div class="input-group input-group-sm">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input id="trackCodeNav" type="text" class="form-control"
                       placeholder="p.sh. BRL-LKNJ-0YXN" autocomplete="off" required>
                <button class="btn btn-danger" type="submit">Gjurmo</button>
              </div>
            </form>

            <div class="mt-3 d-grid">
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('cart.index') }}">
                <i class="bi bi-bag"></i> Shiko shportën
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<button class="back-btn" type="button" onclick="history.back()">
  <i class="bi bi-arrow-left"></i> Kthehu prapa
</button>

<div class="container mt-4 mb-5">
  <div class="row g-4 align-items-start">
    <!-- FOTO -->
    <div class="col-lg-7">
      <div class="product-hero">
        @if($product->image_path)
          <img id="productImage" src="{{ asset('storage/'.$product->image_path) }}"
               data-zoom="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
        @else
          <img id="productImage" src="{{ asset('images/placeholder-product.png') }}"
               data-zoom="{{ asset('images/placeholder-product.png') }}" alt="{{ $product->name }}">
        @endif
        <div class="zoom-lens" id="zoomLens" aria-hidden="true"></div>
        <div class="zoom-pane" id="zoomPane" aria-hidden="true"></div>
      </div>
    </div>

    <!-- INFO -->
    <div class="col-lg-5">
      <span class="bf-chip">
        <i class="bi bi-stars"></i>
        OFERTË SPECIALE
      </span>

      <h1 class="h2 mb-2">{{ $product->name }}</h1>

      @php
        $basePrice = (float)$product->price;
        $oldBase   = $basePrice ? round($basePrice * 1.25, 2) : null;
        $discount  = ($oldBase && $basePrice && $oldBase > $basePrice)
          ? round(100 - ($basePrice / $oldBase * 100))
          : 20;
      @endphp

      <div id="priceContainer" class="price-block mb-2">
        <div class="d-flex align-items-baseline flex-wrap gap-2">
          <div class="price-now">{{ number_format($basePrice, 2) }} €</div>
          @if($oldBase)
            <div class="price-old">{{ number_format($oldBase, 2) }} €</div>
          @endif
          <span class="price-badge">-{{ $discount }}% Zbritje</span>
        </div>
      </div>

      <div id="stockContainer" class="stock-row mb-3">
        @php $inStock = ($product->stock ?? 0) > 0; @endphp
        <span class="stock-label {{ $inStock ? 'stock-pill-in' : 'stock-pill-out' }}">
          {{ $inStock ? 'Në stok' : 'S’ka në stok' }}
        </span>
        <span class="stock {{ $inStock ? 'in' : 'out' }}">
          {{ $inStock ? (int)$product->stock . ' copë' : 'Momentalisht pa stok' }}
        </span>
      </div>

      @php
        $sizes=[];
        if(!empty($product->sizes)){
          $decoded=json_decode($product->sizes,true);
          if(is_array($decoded)) $sizes=$decoded;
        }
      @endphp
      @if(count($sizes)>0)
        <div class="mb-3">
          <label for="sizeSelect" class="form-label">Zgjidh dimensionin:</label>
          <select id="sizeSelect" class="form-select">
            @foreach($sizes as $size)
              <option value="{{ (float)($size['price'] ?? $product->price) }}"
                      data-stock="{{ (int)($size['stock'] ?? 0) }}">
                {{ $size['label'] }} - {{ number_format((float)($size['price'] ?? $product->price),2) }} € ({{ (int)($size['stock'] ?? 0) }} në stok)
              </option>
            @endforeach
          </select>
        </div>
      @endif

      <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-2">
          <button class="qty-btn" id="qtyMinus" type="button" aria-label="Zvogëlo">−</button>
          <input class="qty-input" id="qty" type="number" min="1" value="1" aria-label="Sasia">
          <button class="qty-btn" id="qtyPlus" type="button" aria-label="Rrit">+</button>
        </div>

        @php
          $waBase='https://wa.me/38344960661';
          $msg=rawurlencode("Përshëndetje! Dua ta porosis produktin:\n- {$product->name}\n- Dimensioni: \n- Çmimi: ".number_format($product->price,2)." €\n- Sasia: ");
        @endphp
        <a id="waBtn" class="btn btn-whatsapp px-4 text-white" target="_blank" rel="noopener"
           href="{{ $waBase }}?text={{ $msg }}1">
          <i class="bi bi-whatsapp"></i> KONTAKTO
        </a>
      </div>

      <button id="addToCartBtn" class="btn btn-outline-danger px-4">
        <i class="bi bi-bag-plus"></i> Shto në shportë
      </button>

      @if($product->description)
        <div class="section-card mt-4" id="desc">
          <h2 class="h5 mb-2">Përshkrimi</h2>
          <p class="mb-0">{{ $product->description }}</p>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Fullscreen modal (e lejmë në HTML siç e ke, por s’e përdorim) -->
<div class="img-modal" id="imgModal" aria-hidden="true">
  <button class="close-btn" type="button" id="modalClose" aria-label="Mbyll">
    <i class="bi bi-x-lg"></i>
  </button>
  <img id="modalImg" alt="Zoom">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
(() => {
  const sizeSelect=document.getElementById('sizeSelect');
  const priceContainer=document.getElementById('priceContainer');
  const stockContainer=document.getElementById('stockContainer');
  const waBtn=document.getElementById('waBtn');
  const qty=document.getElementById('qty');
  const minus=document.getElementById('qtyMinus');
  const plus=document.getElementById('qtyPlus');

  const basePriceDefault = parseFloat({{ json_encode((float)$product->price) }});
  const baseStockDefault = parseInt({{ json_encode((int)($product->stock ?? 0)) }},10) || 0;

  function selDim(){
    if(!sizeSelect) return '';
    return (sizeSelect.options[sizeSelect.selectedIndex].text.split(' - ')[0]||'');
  }
  function selPrice(){
    if(!sizeSelect) return basePriceDefault;
    return parseFloat(sizeSelect.value||basePriceDefault);
  }
  function selStock(){
    if(!sizeSelect) return baseStockDefault;
    return parseInt(sizeSelect.options[sizeSelect.selectedIndex].dataset.stock||0,10);
  }
  function cleanQty(){
    const v=parseInt(qty.value||1,10);
    qty.value=Math.max(1,isNaN(v)?1:v);
  }

  function updateUI(){
    const price=selPrice();
    const stock=selStock();

    const oldPrice = price ? (price * 1.25) : null;
    const discount = (oldPrice && price && oldPrice > price)
      ? Math.round(100 - (price / oldPrice * 100))
      : 20;

    priceContainer.innerHTML = `
      <div class="d-flex align-items-baseline flex-wrap gap-2">
        <div class="price-now">${price.toFixed(2)} €</div>
        ${oldPrice ? `<div class="price-old">${oldPrice.toFixed(2)} €</div>` : ''}
        <span class="price-badge">-${discount}% Zbritje</span>
      </div>
    `;

    if(stock > 0){
      stockContainer.innerHTML = `
        <span class="stock-label stock-pill-in">Në stok</span>
        <span class="stock in">${stock} copë</span>
      `;
    }else{
      stockContainer.innerHTML = `
        <span class="stock-label stock-pill-out">S’ka në stok</span>
        <span class="stock out">Momentalisht pa stok</span>
      `;
    }

    const baseMsg = `Përshëndetje! Dua ta porosis produktin:\n- {{ addslashes($product->name) }}\n- Dimensioni: ${selDim()||'—'}\n- Çmimi: ${price.toFixed(2)} €\n- Sasia: `;
    waBtn.href = `https://wa.me/38344960661?text=${encodeURIComponent(baseMsg)}${qty.value}`;
  }

  minus?.addEventListener('click',()=>{
    cleanQty();
    qty.value=Math.max(1,parseInt(qty.value,10)-1);
    updateUI();
  });
  plus?.addEventListener('click',()=>{
    cleanQty();
    qty.value=parseInt(qty.value,10)+1;
    updateUI();
  });
  qty?.addEventListener('input',()=>{
    cleanQty();
    updateUI();
  });
  sizeSelect?.addEventListener('change',updateUI);
  updateUI();

  /* =========================
     ZOOM (DESKTOP + MOBILE)
     MOBILE: zoom vetëm kur e prek me gisht, si desktop
     ========================= */
  const img  = document.getElementById('productImage');
  const lens = document.getElementById('zoomLens');
  const pane = document.getElementById('zoomPane');

  if(!img || !lens || !pane) return;

  const isDesktop = () => window.matchMedia('(min-width:992px)').matches;
  const isMobile  = () => window.matchMedia('(max-width:991.98px)').matches;

  let natW=0, natH=0;
  const zoom = 1.35;

  function setDisplay(el, value){
    // kjo e thyen edhe CSS display:none!important
    el.style.setProperty('display', value, 'important');
  }

  function initZoom(){
    const src = img.dataset.zoom || img.src;
    pane.style.backgroundImage = `url('${src}')`;

    const im = new Image();
    im.onload = () => {
      natW = im.naturalWidth;
      natH = im.naturalHeight;
      pane.style.backgroundRepeat = 'no-repeat';
      pane.style.backgroundSize = `${natW*zoom}px ${natH*zoom}px`;
    };
    im.src = src;
  }

  function pos(e){
    const r = img.getBoundingClientRect();
    const x = e.touches ? e.touches[0].clientX : e.clientX;
    const y = e.touches ? e.touches[0].clientY : e.clientY;
    return { x:x-r.left, y:y-r.top };
  }

  function move(e){
    const p = pos(e);

    let L = p.x - lens.offsetWidth/2;
    let T = p.y - lens.offsetHeight/2;

    L = Math.max(0, Math.min(L, img.clientWidth - lens.offsetWidth));
    T = Math.max(0, Math.min(T, img.clientHeight - lens.offsetHeight));

    lens.style.left = L+'px';
    lens.style.top  = T+'px';

    const rx = natW / img.clientWidth;
    const ry = natH / img.clientHeight;

    pane.style.backgroundPosition = `${-(L*rx)*zoom}px ${-(T*ry)*zoom}px`;
  }

  function showZoom(){
    setDisplay(lens,'block');
    setDisplay(pane,'block');
  }
  function hideZoom(){
    setDisplay(lens,'none');
    setDisplay(pane,'none');
  }

  /* DESKTOP (hover) */
  img.addEventListener('mouseenter', () => {
    if(!isDesktop()) return;
    showZoom();
  });
  img.addEventListener('mouseleave', () => {
    if(!isDesktop()) return;
    hideZoom();
  });
  img.addEventListener('mousemove', (e) => {
    if(!isDesktop()) return;
    move(e);
  });

  /* MOBILE (touch) — vetëm kur e prek */
  img.addEventListener('touchstart', (e) => {
    if(!isMobile()) return;
    showZoom();
    move(e);
  }, { passive:false });

  img.addEventListener('touchmove', (e) => {
    if(!isMobile()) return;
    e.preventDefault();
    move(e);
  }, { passive:false });

  img.addEventListener('touchend', () => {
    if(!isMobile()) return;
    hideZoom();
  });

  img.addEventListener('touchcancel', () => {
    if(!isMobile()) return;
    hideZoom();
  });

  window.addEventListener('resize', () => {
    hideZoom();
    initZoom();
  });

  if(img.complete) initZoom();
  else img.addEventListener('load', initZoom);
})();
</script>

<script>
// ---- CART ----
const addBtn = document.getElementById('addToCartBtn');

function currentSizeLabel(){
  const s = document.getElementById('sizeSelect');
  return s ? (s.options[s.selectedIndex].text.split(' - ')[0] || '') : null;
}
function currentPrice(){
  const s = document.getElementById('sizeSelect');
  return s ? parseFloat(s.value) : parseFloat({{ json_encode((float)$product->price) }});
}

addBtn?.addEventListener('click', async () => {
  const payload = {
    product_id: {{ $product->id }},
    qty: parseInt(document.getElementById('qty').value || '1', 10),
    size: currentSizeLabel(),
    price: currentPrice()
  };

  try {
    const res = await fetch(`{{ route('cart.add') }}`, {
      method: 'POST',
      headers: {
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if(data.ok){
      document.querySelectorAll('.cart-badge').forEach(b => b.textContent = data.totalQty);
      document.dispatchEvent(new CustomEvent('cart:updated', { detail: { totalQty: data.totalQty }}));
      showToast(data.message || 'U shtua në shportë');
    } else {
      showToast(data.message || 'Diçka shkoi keq', true);
    }
  } catch (e) {
    showToast('Gabim lidhjeje', true);
  }
});

function showToast(text, isErr){
  let el = document.getElementById('cartToast');
  if(!el){
    el = document.createElement('div');
    el.id='cartToast';
    el.className='toast align-items-center text-bg-' + (isErr?'danger':'success');
    el.role='alert'; el.ariaLive='assertive'; el.ariaAtomic='true';
    el.style.position='fixed'; el.style.bottom='16px'; el.style.right='16px'; el.style.zIndex='3000';
    el.innerHTML=`<div class="d-flex"><div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>`;
    document.body.appendChild(el);
  }
  el.querySelector('.toast-body').textContent = text;
  const t = new bootstrap.Toast(el, { delay: 1800 });
  t.show();
}
</script>

</body>
</html>
