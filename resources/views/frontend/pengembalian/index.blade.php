@extends('frontend.layouts.clean')

@section('content')

<div class="container py-5">

    <div class="card shadow rounded-4 p-4">
        <h4 class="fw-bold mb-4">📖 Form Pengembalian Buku</h4>

        <hr>

        <p><b>📚 Judul:</b> {{ $pinjam->buku->judul }}</p>
        <p><b>✍️ Penulis:</b> {{ $pinjam->buku->penulis }}</p>
        <p><b>📅 Tanggal Pinjam:</b> {{ $pinjam->tanggal_pinjam }}</p>
        <p><b>📅 Tanggal Kembali:</b> {{ $pinjam->tanggal_pengembalian }}</p>

        <hr>

        <p><b>👤 Peminjam:</b> {{ $pinjam->anggota->nama }}</p>

        @if($hariTelat > 0)
            <div class="alert alert-danger">
                ❌ Terlambat {{ $hariTelat }} hari <br>
                💰 Denda: <b>Rp {{ number_format($denda, 0, ',', '.') }}</b><br>
                ⚠️ Denda dibayar langsung di perpustakaan
            </div>
        @else
            <div class="alert alert-success">
                ✅ Tidak ada denda
            </div>
        @endif

       <form action="{{ route('peminjaman.kembalikan', $pinjam->id_peminjaman) }}" method="POST">
            @csrf
            @method('PUT')

            <button class="btn btn-success"
                onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                ✔ Kembalikan Sekarang
            </button>

            <a href="{{ route('history') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>

</div>

@endsection
