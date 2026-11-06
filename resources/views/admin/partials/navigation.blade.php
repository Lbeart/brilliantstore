<nav class="nav flex-column admin-navigation" aria-label="Navigimi i administratës">
  <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
    <i class="fas fa-home me-1"></i> Dashboard
  </a>
  <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}" @if(request()->routeIs('admin.users*')) aria-current="page" @endif>
    <i class="fas fa-users me-1"></i> Përdoruesit
  </a>
  <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}" @if(request()->routeIs('admin.customers*')) aria-current="page" @endif>
    <i class="fas fa-address-book me-1"></i> Klientët
  </a>
  <a class="nav-link {{ request()->routeIs('admin.pos*') ? 'active' : '' }}" href="{{ route('admin.pos.index') }}" @if(request()->routeIs('admin.pos*')) aria-current="page" @endif>
    <i class="fas fa-cash-register me-1"></i> Arkë &amp; barkode
  </a>
  <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}" @if(request()->routeIs('admin.products*')) aria-current="page" @endif>
    <i class="fas fa-box-open me-1"></i> Produktet
  </a>
  <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}" @if(request()->routeIs('admin.orders*')) aria-current="page" @endif>
    <i class="fas fa-shopping-cart me-1"></i> Porositë
  </a>
  <a class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}" href="{{ route('admin.stats') }}" @if(request()->routeIs('admin.stats')) aria-current="page" @endif>
    <i class="fas fa-chart-line me-1"></i> Statistikat
  </a>
</nav>
