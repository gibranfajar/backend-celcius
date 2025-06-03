<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }} " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pagehomes.*') ? '' : 'collapsed' }}"
                data-bs-target="#components-nav-pagehome" data-bs-toggle="collapse" href="#">
                <i class="bi bi-grid"></i>
                <span>UI Homes</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-pagehome"
                class="nav-content collapse {{ request()->routeIs('pagehomes.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('pagehomes.index') }}"
                        class="{{ request()->routeIs('pagehomes.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Men</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pagehomes.woman') }}"
                        class="{{ request()->routeIs('pagehomes.woman') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Women</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.*') ? '' : 'collapsed' }} "
                href="{{ route('categories.index') }}">
                <i class="bi bi-grid"></i>
                <span>Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('colors.*') ? '' : 'collapsed' }} "
                href="{{ route('colors.index') }}">
                <i class="bi bi-grid"></i>
                <span>Colors</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('collections.*') ? '' : 'collapsed' }} "
                href="{{ route('collections.index') }}">
                <i class="bi bi-grid"></i>
                <span>Collections</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('blogcollections.*') ? '' : 'collapsed' }} "
                href="{{ route('blogcollections.index') }}">
                <i class="bi bi-grid"></i>
                <span>Blog Collections</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('campaigns.*') ? '' : 'collapsed' }} "
                href="{{ route('campaigns.index') }}">
                <i class="bi bi-grid"></i>
                <span>Campaigns</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? '' : 'collapsed' }} "
                href="{{ route('products.index') }}">
                <i class="bi bi-grid"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders.*') ? '' : 'collapsed' }} "
                href="{{ route('orders.index') }}">
                <i class="bi bi-grid"></i>
                <span>Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vouchers.*') ? '' : 'collapsed' }} "
                href="{{ route('vouchers.index') }}">
                <i class="bi bi-grid"></i>
                <span>Vouchers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('locations.*') ? '' : 'collapsed' }} "
                href="{{ route('locations.index') }}">
                <i class="bi bi-grid"></i>
                <span>Locations</span>
            </a>
        </li>
    </ul>
</aside>
