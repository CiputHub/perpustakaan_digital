@extends('backend.auth.layout')

@section('content')
    @if (session('error'))
        <div class="alert alert-custom alert-danger-custom">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-custom" style="background: #dcfce7; color: #16a34a;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>
                <i class="fas fa-envelope"></i> Alamat Email
            </label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
            @error('email')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>
                <i class="fas fa-lock"></i> Password
            </label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Masukkan password" required>
            @error('password')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>


        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i> Masuk
        </button>

    </form>
@endsection
