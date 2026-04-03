@extends('frontend.layouts.auth')

@section('content')

<div class="card auth-card shadow-lg border-0">
    <div class="card-body p-4">

        <h3 class="text-center mb-4 fw-bold">Register Anggota</h3>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.anggota.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <hr>

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control">
            </div>

            <div class="mb-3">
                <label>No Telp</label>
                <input type="text" name="no_telepon" class="form-control">
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary w-100">Register</button>
        </form>

        <!-- LINK LOGIN -->
        <div class="text-center mt-3">
            <small>
                Sudah punya akun?
                <a href="{{ route('login_anggota') }}" class="fw-bold text-decoration-none">
                    Login disini
                </a>
            </small>
        </div>

    </div>
</div>

@endsection
