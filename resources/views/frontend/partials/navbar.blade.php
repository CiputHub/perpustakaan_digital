


    <!-- Navbar Start -->
    <div class="container-fluid bg-secondary px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="nav-bar">
            <nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4 py-lg-0">
                <h4 class="d-lg-none m-0">Menu</h4>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav me-auto">
        <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
        <a href="{{ url('/semua-buku') }}" class="nav-item nav-link">Semua Buku</a>
        <a href="#" class="nav-item nav-link">Buku</a>
    </div>

    <!-- USER LOGIN -->
    <div class="d-flex align-items-center ms-auto">

    @if(Auth::guard('anggota')->check())
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown">

                <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center"
                    style="width:40px; height:40px;">
                    <i class="fa fa-user"></i>
                </div>

                <span class="ms-2 fw-bold">
                    {{ Auth::guard('anggota')->user()->anggota->nama }}
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a href="{{ route('history') }}" class="dropdown-item">History</a>
                </li>
                <li>
                    <form action="{{ route('logout_anggota') }}" method="POST">
                        @csrf
                        <button class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

    @else
        <a href="{{ route('login_anggota') }}" class="btn btn-dark ms-3">
            Login
        </a>
    @endif

</div>
</div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
