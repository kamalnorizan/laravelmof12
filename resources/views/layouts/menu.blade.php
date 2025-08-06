<ul class="menu-inner py-1">
    <!-- Page -->
    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
        <a href="/" class="menu-link">
            <i class="menu-icon tf-icons ri-home-smile-line"></i>
            <div data-i18n="home">Home</div>
        </a>
    </li>
    @can('view invoices')
        <li class="menu-item  {{ request()->is('invoices') ? 'active' : '' }}">
            <a href="{{ route('invoices.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-file-3-line"></i>
                <div data-i18n="invoices">Invoices</div>
            </a>
        </li>
    @endcan
    @can('view users')
        <li class="menu-item  {{ request()->is('users') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-user-line"></i>
                <div data-i18n="users">
                    Users
                </div>
                <div class="badge bg-danger rounded-pill ms-auto">{{ $pendingUserCount }}</div>
            </a>
        </li>
    @endcan
</ul>
