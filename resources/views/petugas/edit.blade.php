@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="text-center mb-4">
                <h3>Edit Data Petugas</h3>
                <hr>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form action="{{ route('petugas.update', $petugas->id_petugas) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- AKUN LOGIN --}}
                                <h5 class="mb-3">Akun Login</h5>

                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username"
                                        value="{{ old('username', $petugas->user->username) }}" class="form-control"
                                        autocomplete="off">
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $petugas->user->email) }}"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Password (kosongkan jika tidak diubah)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                            👁
                                        </button>
                                    </div>
                                </div>

                                <hr>

                                {{-- DATA PETUGAS --}}
                                <h5 class="mb-3">Data Petugas</h5>

                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama', $petugas->nama) }}"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Nomor Telepon</label>
                                    <input type="text" name="no_telepon"
                                        value="{{ old('no_telepon', $petugas->no_telepon) }}" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control">{{ old('alamat', $petugas->alamat) }}</textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>

                                    <a href="{{ route('petugas.index') }}" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT SHOW PASSWORD --}}
    <script>
        function togglePassword() {
            let input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
@endsection
