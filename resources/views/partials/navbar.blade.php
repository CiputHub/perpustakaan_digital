<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">

        <!-- Brand/Logo -->
        <a class="navbar-brand" href="#">
            <span class="fw-bold">Perpustakaan</span>
        </a>

        <!-- Tombol Toggle untuk Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <!-- Search Icon Mobile -->
            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." class="form-control" />
                        </div>
                    </form>
                </ul>
            </li>

            <!-- Profile & Logout (Tanpa Foto) -->
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <!-- Icon User Saja (Tanpa Foto) -->
                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fa fa-user text-white" style="font-size: 18px;"></i>
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hi,</span>
                        @auth
                            <span class="fw-bold">{{ auth()->user()->username ?? auth()->user()->name }}</span>
                        @else
                            <span class="fw-bold">Guest</span>
                        @endauth
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <!-- Icon User Large -->
                                <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="fa fa-user text-white" style="font-size: 30px;"></i>
                                </div>
                                <div class="u-text text-center">
                                    <h4>{{ auth()->user()->username ?? (auth()->user()->name ?? 'User') }}</h4>
                                    <p class="text-muted">{{ auth()->user()->email ?? '' }}</p>
                                    <p class="badge bg-primary">
                                        {{ auth()->user()->role ?? 'User' }}
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            {{-- <a class="dropdown-item" href="#">
                                <i class="fa fa-user me-2"></i> My Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-cog me-2"></i> Account Setting
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <!-- Form Logout -->
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fa fa-sign-out me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Optional CSS untuk styling -->
<style>
    .avatar-sm {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #4e73df;
        border-radius: 50%;
    }

    .avatar-lg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #4e73df;
        border-radius: 50%;
        margin: 0 auto;
    }

    .dropdown-user .user-box {
        padding: 15px;
        text-align: center;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    .profile-username {
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .profile-username {
            display: none;
        }
    }
</style>
