@extends('layout')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
<div class="page-inner">

<h3 class="mb-4">Tambah Petugas</h3>

<div class="card p-4 shadow-sm">

<form action="{{ route('petugas.store') }}" method="POST" autocomplete="off">
@csrf

<h5 class="mb-3">Akun Login</h5>

<div class="mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" autocomplete="off">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" autocomplete="new-password">
</div>

<hr>

<h5 class="mb-3">Data Petugas</h5>

<div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control">
</div>

<div class="mb-3">
    <label>No Telepon</label>
    <input type="text" name="no_telepon" class="form-control">
</div>

<div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control"></textarea>
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('petugas.index') }}" class="btn btn-secondary">
                                    Kembali
                                </a>

</form>

</div>
</div>
</div>

@endsection
