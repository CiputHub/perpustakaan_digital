@if(auth()->check())
    @include('partials.navbar')
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpustakaan</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body style="background: #f5f7fb;">

<div class="container d-flex align-items-center justify-content-center" style="height:100vh;">
    @yield('content')
</div>

</body>
</html>
