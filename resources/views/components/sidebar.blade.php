<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">

            <!-- Menu yang hanya tampil jika yang login adalah admin -->
            @if (Auth::guard('admin')->check())
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fire"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ Request::is('faculties') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('faculties.index') }}"><i class="fas fa-building"></i>
                        <span>Fakultas</span></a>
                </li>
            @endif

        </ul>
    </aside>
</div>
