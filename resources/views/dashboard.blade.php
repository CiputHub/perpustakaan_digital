@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold">📊 Dashboard</h3>
                    <p class="text-muted">Selamat datang, {{ auth()->user()->name ?? 'Admin' }}</p>
                </div>
                {{--
            <a href="{{ route('laporan.index') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-table me-1"></i> Lihat Laporan
            </a> --}}
            </div>

            <!-- CARD STATISTIK -->
            <div class="row g-3">

                <div class="col-md-3">
                    <div class="card card-stats bg-primary text-white">
                        <div class="card-body">
                            <p>Total Buku</p>
                            <h3>{{ $totalBuku }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-stats bg-info text-white">
                        <div class="card-body">
                            <p>{{ $labelUser }}</p>
                            <h3>{{ $totalUser }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-stats bg-warning text-dark">
                        <div class="card-body">
                            <p>Dipinjam</p>
                            <h3>{{ $peminjamanAktif }}</h3>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-3">
                <div class="card card-stats bg-danger text-white">
                    <div class="card-body">
                        <p>Terlambat</p>
                        <h3>{{ $terlambat }}</h3>
                    </div>
                </div>
            </div> --}}



                {{-- <div class="row g-3 mt-2">

            <div class="col-md-3">
                <div class="card card-stats bg-success text-white">
                    <div class="card-body">
                        <p>Selesai</p>
                        <h3>{{ $selesai }}</h3>
                    </div>
                </div>
            </div> --}}

                <div class="col-md-3">
                    <div class="card card-stats bg-dark text-white">
                        <div class="card-body">
                            <p>Total Transaksi</p>
                            <h3>{{ $totalTransaksi }}</h3>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6">
                <div class="card card-stats bg-secondary text-white">
                    <div class="card-body">
                        <p>Total Denda</p>
                        <h3>Rp {{ number_format($totalDenda,0,',','.') }}</h3>
                    </div>
                </div>
            </div> --}}

            </div>

            <!-- TABEL -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>📚 Peminjaman Terbaru</h5>

                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Buku</th>
                                    <th>Anggota</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Kembali</th>
                                    <th>Status</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            {{ $row->buku->judul ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $row->anggota->nama ?? '-' }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            {{ $row->tanggal_pengembalian ? \Carbon\Carbon::parse($row->tanggal_pengembalian)->format('d/m/Y') : '-' }}
                                        </td>

                                        <td>
                                            @if ($row->status == 'dipinjam')
                                                <span class="badge bg-warning">Dipinjam</span>
                                            @elseif($row->status == 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @elseif($row->status == 'dikembalikan')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $row->status }}</span>
                                            @endif
                                        </td>

                                        {{-- <td>
                                <a href="{{ route('laporan.show',$row->id_peminjaman) }}"
                                   class="btn btn-sm btn-info">
                                   Detail
                                </a>
                            </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .card-stats {
            border-radius: 15px;
            transition: 0.3s;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
