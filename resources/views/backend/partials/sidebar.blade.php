<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">

            @php
                $role = Auth::user()->role ?? null;
            @endphp

            {{-- Dashboard (SEMUA ROLE) --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- PEMINJAMAN (petugas) --}}
            @if (in_array($role, ['petugas']))
                <li class="nav-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                    <a href="{{ route('peminjaman.index') }}">
                        <i class="fas fa-book"></i>
                        <p>Peminjaman</p>
                    </a>
                </li>
            @endif

            {{-- BUKU (kepala + petugas) --}}
            @if ($role == 'petugas')
                <li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <a href="{{ route('buku.index') }}">
                        <i class="fas fa-book-open"></i>
                        <p>Buku</p>
                    </a>
                </li>
            @endif

            {{-- PETUGAS (khusus kepala perpus) --}}
            @if ($role == 'kepala_perpus')
                <li class="nav-item {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                    <a href="{{ route('petugas.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Petugas</p>
                    </a>
                </li>
            @endif

            {{-- Anggota (khusus petugas) --}}
            @if ($role == 'petugas')
                <li class="nav-item {{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                    <a href="{{ route('anggota.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Anggota</p>
                    </a>
                </li>
            @endif

            {{-- laporan ( petugas, kepala perpus) --}}
            @if (in_array($role, ['kepala_perpus', 'petugas']))
                <li class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}">
                        <i class="fas fa-address-book"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            @endif

            {{-- kategori (petugas) --}}
            @if (in_array($role, ['petugas']))
                <li class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}">
                        <i class="fas fa-folder-open"></i>
                        <p>Kategori</p>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
