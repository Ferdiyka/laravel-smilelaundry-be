<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Smile Laundry</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown ">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown ">
                <a href="{{ route('user.index') }}" class="nav-link"><i class="far fa-user"></i><span>Users</span>
                </a>
            </li>
            <li class="nav-item dropdown ">
                <a href="{{ route('product.index') }}" class="nav-link"><i class="fas fa-columns"></i><span>Product</span>
                </a>
            </li>
            {{-- <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li>
                </ul>
            </li> --}}
    </aside>
</div>
