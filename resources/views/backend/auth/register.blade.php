@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!DOCTYPE html>
<html>

<head>
    <title>Register Kepala Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="col-md-6 mx-auto">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Register Kepala Perpustakaan</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <h5>Akun Login</h5>

                        <input type="text" name="username" class="form-control mb-2" placeholder="Username">
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password">

                        <hr>

                        <h5>Data Kepala Perpus</h5>

                        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap">
                        <input type="text" name="no_telp" class="form-control mb-2" placeholder="No Telepon">
                        <textarea name="alamat" class="form-control mb-3" placeholder="Alamat"></textarea>

                        <button class="btn btn-primary w-100">Register</button>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

</body>

</html>
