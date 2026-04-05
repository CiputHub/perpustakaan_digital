@include('partials.header')

<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1">

    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="dark">
                <a href="{{ url('/dashboard') }}" class="logo">
                    <img
                        src="{{ asset('assets/img/kaiadmin/logo-perpus1.png') }}"
                        alt="navbar brand"
                        class="navbar-brand"
                        height="70"
                    />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
        </div>

        @include('partials.sidebar')
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('/') }}" class="logo">
                        <img
                            src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
                            alt="navbar brand"
                            class="navbar-brand"
                            height="20"
                        />
                    </a>
                </div>
            </div>

            @include('partials.navbar')
        </div>

        {{-- CONTENT --}}
        @yield('content')

        {{-- FOOTER --}}
        @include('partials.footer')

    </div>
</div>

<!-- CORE JS -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- DATATABLE (PILIH SALAH SATU SAJA, saya pakai bawaan template) -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>


<!-- Plugins -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin -->
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>


 <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        });


    </script>
</body>
</html>
