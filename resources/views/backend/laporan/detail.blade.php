@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">

            <div class="text-center mb-4">
                <h3 class="fw-bold">📋 Detail Peminjaman</h3>
                <p class="text-muted">Informasi lengkap peminjaman buku</p>
                <hr>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">

                            <div class="row">

                                <!-- Informasi Peminjaman -->
                                <div class="col-md-12">

                                    <!-- Status Badge -->
                                    <div class="text-end mb-3">
                                        @if ($data->status == 'menunggu')
                                            <span class="badge bg-warning px-3 py-2 rounded-pill">
                                                <i class="fas fa-clock me-1"></i> Menunggu
                                            </span>
                                        @elseif($data->status == 'dipinjam')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                                <i class="fas fa-book-open me-1"></i> Dipinjam
                                            </span>
                                        @elseif($data->status == 'dikembalikan')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                <i class="fas fa-check-circle me-1"></i> Dikembalikan
                                            </span>
                                        @elseif($data->status == 'terlambat')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Tabel Detail -->
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="180" class="text-muted">
                                                <i class="fas fa-user me-2 text-primary"></i>Nama Anggota
                                            </th>
                                            <td>: <span class="fw-semibold">{{ $data->anggota->nama ?? '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-id-card me-2 text-primary"></i>Nomor Induk
                                            </th>
                                            <td>: {{ $data->anggota->nip ?? ($data->anggota->nis ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-envelope me-2 text-primary"></i>Email
                                            </th>
                                            <td>:{{ optional($data->user)->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-bottom"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-book me-2 text-primary"></i>Judul Buku
                                            </th>
                                            <td>: <span class="fw-semibold">{{ $data->buku->judul ?? '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-user-edit me-2 text-primary"></i>Penulis
                                            </th>
                                            <td>: {{ $data->buku->penulis ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-building me-2 text-primary"></i>Penerbit
                                            </th>
                                            <td>: {{ $data->buku->penerbit ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-bottom"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Pinjam
                                            </th>
                                            <td>: <span
                                                    class="fw-semibold">{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d/m/Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-calendar-check me-2 text-primary"></i>Tanggal Kembali
                                            </th>
                                            <td>:
                                                @if ($data->tanggal_pengembalian)
                                                    <span
                                                        class="fw-semibold">{{ \Carbon\Carbon::parse($data->tanggal_pengembalian)->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-muted">Belum dikembalikan</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">
                                                <i class="fas fa-money-bill-wave me-2 text-primary"></i>Denda
                                            </th>
                                            <td>:
                                                @if ($data->denda && $data->denda > 0)
                                                    <span class="text-danger fw-bold">Rp
                                                        {{ number_format($data->denda, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Tombol Aksi -->
                                    <div class="mt-4 d-flex gap-2">
                                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary rounded-pill px-4">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal Konfirmasi Pengembalian -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-success text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="fas fa-undo-alt me-2"></i>Konfirmasi Pengembalian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengembalikan buku ini?</p>
                    <p class="text-muted small mb-0">Buku akan dikembalikan dan stok akan bertambah.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <form id="returnForm" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success rounded-pill">Ya, Kembalikan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rounded-4 {
            border-radius: 1rem !important;
        }

        .rounded-top-4 {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }

        .table th {
            width: 180px;
            font-weight: 500;
        }

        .table td {
            font-weight: 500;
        }
    </style>

    <script>
        function confirmReturn(id) {
            const form = document.getElementById('returnForm');
            form.action = "{{ url('laporan') }}/" + id + "/kembalikan";
            new bootstrap.Modal(document.getElementById('returnModal')).show();
        }
    </script>
@endsection
