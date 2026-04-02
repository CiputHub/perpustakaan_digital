
@include('partials.header')
<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    @include('partials.navbar')


    @yield('content')


@include('partials.footer')
    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.jscss/style.css') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js) }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js) }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js) }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js) }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js) }}"></script>
</body>

</html>
