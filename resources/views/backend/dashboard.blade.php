@extends('backend.layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold">📊 Dashboard</h3>
                    <p class="text-muted">Selamat datang, {{ auth()->user()->name ?? 'Admin' }}</p>
                </div>
            </div>


            <div class="row g-3">

                <div class="col-md-3">
                    <div class="card card-stats bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 opacity-75">Total Buku</p>
                                    <h3 class="fw-bold mb-0">{{ $totalBuku }}</h3>
                                </div>
                                {{-- <i class="fas fa-book fa-2x opacity-50"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card card-stats bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 opacity-75">Total Anggota</p>
                                    <h3 class="fw-bold mb-0">{{ $totalAnggota ?? $totalUser }}</h3>
                                </div>
                                {{-- <i class="fas fa-users fa-2x opacity-50"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card card-stats bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 opacity-75">Dipinjam</p>
                                    <h3 class="fw-bold mb-0">{{ $peminjamanAktif }}</h3>
                                </div>
                                {{-- <i class="fas fa-spinner fa-2x opacity-50"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card card-stats bg-dark text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1 opacity-75">Total Transaksi</p>
                                    <h3 class="fw-bold mb-0">{{ $totalTransaksi }}</h3>
                                </div>
                                {{-- <i class="fas fa-chart-line fa-2x opacity-50"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if (auth()->user()->role == 'kepala_perpus')
                <div class="row g-3 mt-3">

                    <div class="col-md-3">
                        <div class="card card-stats bg-secondary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 opacity-75">Total Petugas</p>
                                        <h3 class="fw-bold mb-0">{{ $totalPetugas ?? 0 }}</h3>
                                    </div>
                                    {{-- <i class="fas fa-user-tie fa-2x opacity-50"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="card card-stats bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 opacity-75">Terlambat</p>
                                        <h3 class="fw-bold mb-0">{{ $terlambat }}</h3>
                                    </div>
                                    {{-- <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="card card-stats bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 opacity-75">Selesai</p>
                                        <h3 class="fw-bold mb-0">{{ $selesai }}</h3>
                                    </div>
                                    {{-- <i class="fas fa-check-circle fa-2x opacity-50"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="card card-stats bg-gradient-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 opacity-75">Total Denda</p>
                                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                                    </div>
                                    {{-- <i class="fas fa-money-bill-wave fa-2x opacity-50"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TABEL PEMINJAMAN TERBARU -->
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
                                @forelse ($data as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->buku->judul ?? '-' }}</td>
                                        <td>{{ $row->anggota->nama ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y') }}</td>
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data peminjaman</td>
                                    </tr>
                                @endforelse
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
            cursor: pointer;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        }

        .card-stats .card-body {
            padding: 1.25rem;
        }
    </style>
@endsection
