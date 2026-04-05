@extends('layout')

@section('content')
<div class="container">
    <h3>Detail Peminjaman</h3>

    <div class="card p-4">
        <p><b>Nama:</b> {{ $data->anggota->nama ?? '-' }}</p>
        <p><b>Buku:</b> {{ $data->buku->judul ?? '-' }}</p>
        <p><b>Tanggal Pinjam:</b> {{ $data->tanggal_pinjam }}</p>
        <p><b>Kembali:</b> {{ $data->tanggal_pengembalian ?? '-' }}</p>
        <p><b>Status:</b> {{ $data->status }}</p>
    </div>

    <a href="{{ route('laporan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
