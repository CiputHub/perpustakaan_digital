@extends('layout')

@section('content')
<div class="container">
    <h3>Edit Peminjaman</h3>

    <form action="{{ route('laporan.update',$data->id_peminjaman) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Anggota</label>
        <select name="anggota_id" class="form-control">
            @foreach($anggota as $a)
            <option value="{{ $a->id_anggota }}"
                {{ $data->anggota_id == $a->id_anggota ? 'selected':'' }}>
                {{ $a->nama }}
            </option>
            @endforeach
        </select>

        <label>Buku</label>
        <select name="buku_id" class="form-control">
            @foreach($buku as $b)
            <option value="{{ $b->id_buku }}"
                {{ $data->buku_id == $b->id_buku ? 'selected':'' }}>
                {{ $b->judul }}
            </option>
            @endforeach
        </select>

        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam"
            value="{{ $data->tanggal_pinjam }}" class="form-control">

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="menunggu">Menunggu</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="dikembalikan">Dikembalikan</option>
        </select>

        <button class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
