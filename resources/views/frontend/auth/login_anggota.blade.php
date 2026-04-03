@extends('frontend.layouts.auth')

@section('content')

<div class="card auth-card shadow-lg border-0">
    <div class="card-body p-4">

        <h3 class="text-center mb-4 fw-bold">Login Anggota</h3>

        {{-- ALERT --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.anggota.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button class="btn btn-success w-100">Login</button>
        </form>

        <!-- LINK REGISTER -->
        <div class="text-center mt-3">
            <small>
                Belum punya akun?
                <a href="{{ route('register_anggota') }}" class="fw-bold text-decoration-none">
                    Daftar disini
                </a>
            </small>
        </div>

    </div>
</div>

@endsection
