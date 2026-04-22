@extends('frontend.layouts.auth')

@section('title', 'Register Anggota - Perpustakaan Digital')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>Daftar Anggota</h3>
            <p>Bergabunglah dengan komunitas pembaca</p>
        </div>

        <div class="auth-body">
            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.anggota.post') }}" method="POST">
                @csrf

                <div class="row-auth">
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-user"></i> Username
                            </label>
                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   placeholder="Masukkan username"
                                   value="{{ old('username') }}"
                                   required>
                        </div>
                    </div>
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Masukkan email"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row-auth">
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Minimal 1 karakter"
                                   required>
                        </div>
                    </div>
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-user-circle"></i> Nama Lengkap
                            </label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Masukkan nama lengkap"
                                   value="{{ old('nama') }}"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row-auth">
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-id-card"></i> Nomor Induk (Opsional)
                            </label>
                            <input type="text"
                                   name="nip"
                                   class="form-control"
                                   placeholder="Nomor Induk"
                                   value="{{ old('nip') }}">
                        </div>
                    </div>
                    <div class="col-auth">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-phone"></i> No. Telepon
                            </label>
                            <input type="text"
                                   name="no_telepon"
                                   class="form-control"
                                   placeholder="Contoh: 08123456789"
                                   value="{{ old('no_telepon') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <textarea name="alamat"
                              class="form-control"
                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="text-center">
                    <small class="text-muted">
                        Sudah punya akun?
                        <a href="{{ route('login_anggota') }}" class="fw-bold" style="color: #fb8500;">
                            Login disini
                        </a>
                    </small>
                </div>
            </form>
        </div>
    </div>
@endsection
