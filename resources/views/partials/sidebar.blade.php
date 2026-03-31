 <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">

             <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}">
        <i class="fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
    <a href="{{ route('peminjaman.index') }}">
        <i class="fas fa-book"></i>
        <p>Peminjaman</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
    <a href="{{ route('buku.index') }}">
        <i class="fas fa-book-open"></i>
        <p>Buku</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
    <a href="{{ route('petugas.index') }}">
        <i class="fas fa-user"></i>
        <p>petugas</p>
    </a>
</li>


            </ul>
          </div>
        </div>
