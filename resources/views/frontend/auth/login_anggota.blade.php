@extends('frontend.layouts.auth')

@section('title', 'Login Anggota - Perpustakaan Digital')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <h3>Selamat Datang!</h3>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <div class="auth-body">
            {{-- ALERT ERROR --}}
            @if (session('error'))
                <div class="alert alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            {{-- ALERT SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-custom alert-success-custom">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.anggota.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"></i> Alamat Email
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password"
                           required>
                    @error('password')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>


                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="text-center">
                    <small class="text-muted">
                        Belum punya akun?
                        <a href="{{ route('register_anggota') }}" class="fw-bold" style="color: #fb8500;">
                            Daftar Sekarang
                        </a>
                    </small>
                </div>
            </form>
        </div>
    </div>
@endsection
