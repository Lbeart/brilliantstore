@php
  $storefrontNavLocale = $pageLocale ?? session('locale', app()->getLocale());
  $storefrontNavLocale = in_array($storefrontNavLocale, ['sq', 'en', 'sr'], true) ? $storefrontNavLocale : 'sq';
  $storefrontNavCopy = [
    'sq' => ['home' => 'Home', 'products' => 'Products', 'about' => 'About', 'contact' => 'Contact', 'account' => 'Llogaria ime', 'admin' => 'Paneli admin', 'cart' => 'Shporta', 'openCart' => 'Hap shportën', 'track' => 'Gjurmo porosinë', 'menuOpen' => 'Hap menynë', 'menuClose' => 'Mbyll menynë', 'light' => 'Kalo në temën e çelët', 'dark' => 'Kalo në temën e errët'],
    'en' => ['home' => 'Home', 'products' => 'Products', 'about' => 'About', 'contact' => 'Contact', 'account' => 'My account', 'admin' => 'Admin panel', 'cart' => 'Cart', 'openCart' => 'Open cart', 'track' => 'Track order', 'menuOpen' => 'Open menu', 'menuClose' => 'Close menu', 'light' => 'Switch to light mode', 'dark' => 'Switch to dark mode'],
    'sr' => ['home' => 'Početna', 'products' => 'Proizvodi', 'about' => 'O nama', 'contact' => 'Kontakt', 'account' => 'Moj nalog', 'admin' => 'Admin panel', 'cart' => 'Korpa', 'openCart' => 'Otvori korpu', 'track' => 'Prati porudžbinu', 'menuOpen' => 'Otvori meni', 'menuClose' => 'Zatvori meni', 'light' => 'Uključi svetlu temu', 'dark' => 'Uključi tamnu temu'],
  ][$storefrontNavLocale];
  $storefrontNavCategories = [
    ['sq' => 'Tepiha', 'en' => 'Rugs', 'sr' => 'Tepisi', 'url' => route('products.tepiha')],
    ['sq' => 'Perde anësore', 'en' => 'Side curtains', 'sr' => 'Bočne zavese', 'url' => route('products.anesore')],
    ['sq' => 'Perde ditore', 'en' => 'Day curtains', 'sr' => 'Dnevne zavese', 'url' => route('products.perdeDitore')],
    ['sq' => 'Set çarçafësh', 'en' => 'Bedsheet sets', 'sr' => 'Setovi posteljine', 'url' => route('products.postava')],
    ['sq' => 'Lëkurë pelushi', 'en' => 'Plush fur', 'sr' => 'Plišano krzno', 'url' => route('products.posteqia')],
    ['sq' => 'Batanije', 'en' => 'Blankets', 'sr' => 'Ćebad', 'url' => route('products.batanije')],
    ['sq' => 'Mbulesa', 'en' => 'Covers', 'sr' => 'Prekrivači', 'url' => route('products.mbulesa')],
    ['sq' => 'Jastëkë dekorues', 'en' => 'Decorative pillows', 'sr' => 'Dekorativni jastuci', 'url' => route('products.jastekdekorues')],
    ['sq' => 'Tepiha banjoje', 'en' => 'Bath rugs', 'sr' => 'Kupatilski tepisi', 'url' => route('products.tepihebanjo')],
    ['sq' => 'Garnishte', 'en' => 'Curtain rails', 'sr' => 'Garnisne', 'url' => route('products.garnishte')],
  ];
  $storefrontCartQty = (int) session('cart_total_qty', 0);
@endphp

<header class="site-header storefront-site-header">
  <div class="nav-container nav storefront-nav">
    <a class="brand storefront-brand" href="{{ route('home') }}" aria-label="Brillant home">
      <img src="{{ asset('images/brillant.png') }}" alt="Brillant" width="205" height="56">
    </a>

    <nav id="storefrontMainMenu" class="nav-links storefront-menu" aria-label="Navigimi kryesor">
      <a href="{{ route('home') }}">{{ $storefrontNavCopy['home'] }}</a>
      <details class="nav-dropdown">
        <summary>{{ $storefrontNavCopy['products'] }} <i class="bi bi-caret-down-fill" aria-hidden="true"></i></summary>
        <div class="dropdown-menu">
          @foreach($storefrontNavCategories as $category)
            <a href="{{ $category['url'] }}">{{ $category[$storefrontNavLocale] }}</a>
          @endforeach
        </div>
      </details>
      <a href="{{ route('about') }}">{{ $storefrontNavCopy['about'] }}</a>
      <a href="{{ route('contact') }}">{{ $storefrontNavCopy['contact'] }}</a>
      <a class="account-mobile-link" href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('account.dashboard')) : route('login') }}">
        <i class="bi bi-person-circle" aria-hidden="true"></i>
        {{ auth()->check() && auth()->user()->role === 'admin' ? $storefrontNavCopy['admin'] : $storefrontNavCopy['account'] }}
      </a>
      <div class="mobile-menu-lang" aria-label="Ndrysho gjuhën">
        <div class="lang-switch">
          @foreach(['sq' => 'SQ', 'en' => 'EN', 'sr' => 'SR'] as $localeCode => $localeLabel)
            <a href="{{ url('/lang/'.$localeCode) }}" class="{{ $storefrontNavLocale === $localeCode ? 'active' : '' }}" lang="{{ $localeCode }}" @if($storefrontNavLocale === $localeCode) aria-current="page" @endif>{{ $localeLabel }}</a>
          @endforeach
        </div>
      </div>
    </nav>

    <div class="nav-actions storefront-actions">
      <div class="lang-switch storefront-desktop-lang" aria-label="Ndrysho gjuhën">
        @foreach(['sq' => 'SQ', 'en' => 'EN', 'sr' => 'SR'] as $localeCode => $localeLabel)
          <a href="{{ url('/lang/'.$localeCode) }}" class="{{ $storefrontNavLocale === $localeCode ? 'active' : '' }}" lang="{{ $localeCode }}" @if($storefrontNavLocale === $localeCode) aria-current="page" @endif>{{ $localeLabel }}</a>
        @endforeach
      </div>
      <button class="icon-btn site-theme-toggle" type="button" data-theme-toggle data-theme-prefix="bi" aria-label="{{ $storefrontNavCopy['light'] }}" title="{{ $storefrontNavCopy['light'] }}" aria-pressed="false">
        <i class="bi bi-moon" data-theme-icon data-theme-prefix="bi" aria-hidden="true"></i>
      </button>
      <a class="login-btn storefront-login" href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('account.dashboard')) : route('login') }}">
        <i class="bi bi-person-circle" aria-hidden="true"></i>
        {{ auth()->check() && auth()->user()->role === 'admin' ? $storefrontNavCopy['admin'] : $storefrontNavCopy['account'] }}
      </a>
      <details class="nav-dropdown cart-dropdown storefront-cart-dropdown">
        <summary class="icon-btn cart-link">
          <i class="bi bi-bag" aria-hidden="true"></i>
          <span>{{ $storefrontNavCopy['cart'] }}</span>
          <span class="cart-badge" data-storefront-cart-count>{{ $storefrontCartQty }}</span>
          <i class="bi bi-caret-down-fill cart-more" aria-hidden="true"></i>
        </summary>
        <div class="dropdown-menu">
          <a href="{{ route('cart.index') }}">{{ $storefrontNavCopy['openCart'] }}</a>
          <a href="{{ route('track.form') }}">{{ $storefrontNavCopy['track'] }}</a>
        </div>
      </details>
      <a class="icon-btn cart-link mobile-cart" href="{{ route('cart.index') }}" aria-label="{{ $storefrontNavCopy['cart'] }}">
        <i class="bi bi-bag" aria-hidden="true"></i>
        <span class="cart-badge" data-storefront-cart-count>{{ $storefrontCartQty }}</span>
      </a>
      <button class="icon-btn menu-toggle" type="button" aria-label="{{ $storefrontNavCopy['menuOpen'] }}" data-open-label="{{ $storefrontNavCopy['menuOpen'] }}" data-close-label="{{ $storefrontNavCopy['menuClose'] }}" aria-controls="storefrontMainMenu" aria-expanded="false">
        <i class="bi bi-list" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<script defer src="{{ asset('js/storefront-nav.js') }}?v=20261107.2"></script>
