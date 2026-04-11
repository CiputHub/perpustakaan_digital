@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-4">Data Buku</h3>
                    </div>
                    <div class="card-body">
                        {{-- ALERT SUCCESS --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- ALERT ERROR --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <a href="{{ route('buku.create') }}" class="btn btn-md btn-success mb-3">Tambah </a>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Gambar</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Stok</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buku as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->judul }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('/storage/buku/' . $row->gambar) }}" class="rounded"
                                                    style="width: 90px">
                                            </td>
                                            <td>{{ $row->penulis }}</td>
                                            <td>{{ $row->penerbit }}</td>
                                            <td>{{ $row->stok }}</td>
                                            <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>

                                            <td>
                                                <a href="{{ route('buku.show', $row->id_buku) }}"
                                                    class="btn btn-sm btn-info">Detail</a>

                                                <a href="{{ route('buku.edit', $row->id_buku) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('buku.destroy', $row->id_buku) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin hapus data ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    @php
                                                        $dipakai = \App\Models\Peminjaman::where(
                                                            'buku_id',
                                                            $row->id_buku,
                                                        )
                                                            ->whereIn('status', ['dipinjam', 'terlambat'])
                                                            ->exists();
                                                    @endphp
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
