<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Smile Laundry</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">SL</a>
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
                <a href="{{ route('product.index') }}" class="nav-link"><i class="fas fa-columns"></i><span>Products</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="far fa-file-alt"></i><span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item dropdown ">
                        <a href="{{ route('order.index') }}" class="nav-link"><i class="fa-solid fa-file-invoice"></i><span>Order</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown ">
                        <a href="{{ route('order.detail') }}" class="nav-link"><i class="fa-solid fa-circle-info"></i><span>Order Detail</span>
                        </a>
                    </li>
                </ul>
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
