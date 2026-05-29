<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">

        <span class="brand-text font-weight-light">
            Hably Store
        </span>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>Dashboard</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('sales.index') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>Penjualan</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('products.index') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-box"></i>

                        <p>Produk</p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>