<ul class="nav-main">
    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('dashboard') }}" href="{{ route('admin.dashboard') }}">
            <i class="nav-main-link-icon fa fa-location-arrow"></i>
            <span class="nav-main-link-name">Dashboard</span>
        </a>
    </li>
    @if (Auth::user()->role != 'operator')
        <li class="nav-main-item">
            <a class="nav-main-link {{ activeMenu('kriteria') }}" href="{{ route('admin.kriteria') }}">
                <i class="nav-main-link-icon fa fa-file"></i>
                <span class="nav-main-link-name">Dokumen</span>
            </a>
        </li>
    @endif
    <li class="nav-main-item">
        <a class="nav-main-link {{ activeMenu('pencarian') }}" href="{{ route('admin.search') }}">
            <i class="nav-main-link-icon fa fa-magnifying-glass"></i>
            <span class="nav-main-link-name">Pencarian</span>
        </a>
    </li>
    @if (Auth::user()->role == 'admin')
        <li class="nav-main-item">
            <a class="nav-main-link {{ activeMenu('user') }}" href="{{ route('admin.user') }}">
                <i class="nav-main-link-icon fa fa-user"></i>
                <span class="nav-main-link-name">Manajemen User</span>
            </a>
        </li>
    @endif
</ul>
