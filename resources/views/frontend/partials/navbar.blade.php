


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
        <a href="#" class="nav-item nav-link">About</a>
        <a href="#" class="nav-item nav-link">Buku</a>
    </div>

    <!-- USER LOGIN -->
    <div class="d-flex align-items-center ms-auto">

        @auth
            <!-- Kalau sudah login -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">

                    <!-- ICON USER -->
                    <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center"
                        style="width:40px; height:40px;">
                        <i class="fa fa-user"></i>
                    </div>

                    <!-- NAMA USER -->
                    <span class="ms-2 fw-bold">
                        {{ Auth::user()->username }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                       <form action="{{ route('logout.anggota') }}" method="POST">
                           @csrf
                           <button class="dropdown-item">Logout</button>
                           @auth
                       <a href="{{ route('history') }}" class="nav-item nav-link">
                           History
                       </a>
                   @endauth
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

        @guest
            <!-- Kalau belum login -->
            <a href="{{ route('login_anggota') }}" class="btn btn-dark ms-3">
                Login
            </a>
        @endguest


    </div>
</div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
