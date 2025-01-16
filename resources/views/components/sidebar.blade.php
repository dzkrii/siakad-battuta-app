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

                <li class="nav-item dropdown {{ $type_menu === 'data-master' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>Data Master</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('faculties') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('faculties.index') }}"><i class="fas fa-building"></i>
                                <span>Fakultas</span></a>
                        </li>
                        <li class="{{ Request::is('study_programs') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('study_programs.index') }}"><i
                                    class="fas fa-building"></i>
                                <span>Program Studi</span></a>
                        </li>
                        <li class="{{ Request::is('admins') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admins.index') }}"><i class="fas fa-building"></i>
                                <span>Admin</span></a>
                        </li>
                        <li class="{{ Request::is('students') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('students.index') }}"><i class="fas fa-building"></i>
                                <span>Mahasiswa</span></a>
                        </li>
                        <li class="{{ Request::is('lecturers') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('lecturers.index') }}"><i class="fas fa-building"></i>
                                <span>Dosen</span></a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>
    </aside>
</div>
