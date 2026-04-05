@extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">📊 Data Laporan Peminjaman</h3>
                        <p class="text-muted mb-0">Laporan lengkap peminjaman buku perpustakaan digital</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary rounded-pill px-4" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak PDF
                        </button>
                        {{-- <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary bg-gradient text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Total Peminjaman</small>
                                <h3 class="fw-bold mb-0">{{ $totalPinjam ?? $data->count() }}</h3>
                            </div>
                            <i class="fas fa-book fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Sedang Dipinjam</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'dipinjam')->count() }}</h3>
                            </div>
                            <i class="fas fa-spinner fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Selesai</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'dikembalikan')->count() }}</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Terlambat</small>
                                <h3 class="fw-bold mb-0">{{ $data->where('status', 'terlambat')->count() }}</h3>
                            </div>
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan dengan DataTable -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>Daftar Laporan Peminjaman
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search for reports...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="table-responsive">
                   <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>

                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th style="width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $row)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $row->anggota->nama ?? '-' }}</div>
                                    <small class="text-muted">{{ $row->anggota->email ?? '' }}</small>
                                </td>
                                <td>{{ $row->buku->judul ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td>
                                    @if($row->tanggal_pengembalian)
                                        {{ \Carbon\Carbon::parse($row->tanggal_pengembalian)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                               
                                <td>
                                    @if($row->denda && $row->denda > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($row->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->status == 'menunggu')
                                        <span class="badge bg-warning px-3 py-2 rounded-pill">⏳ Menunggu</span>
                                    @elseif($row->status == 'dipinjam')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">📖 Dipinjam</span>
                                    @elseif($row->status == 'dikembalikan')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">✅ Selesai</span>
                                    @elseif($row->status == 'terlambat')
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">⚠️ Terlambat</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('laporan.show',$row->id_peminjaman) }}"
                                    class="btn btn-info btn-sm rounded-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('laporan.edit',$row->id_peminjaman) }}"
                                    class="btn btn-warning btn-sm rounded-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- <button onclick="confirmDelete({{ $row->id_peminjaman }})"
                                        class="btn btn-danger btn-sm rounded-circle">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 pb-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan <span id="showingStart">1</span> - <span id="showingEnd">{{ min(10, $data->count()) }}</span>
                        dari <span id="totalEntries">{{ $data->count() }}</span> entri
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah Peminjaman -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($data as $i => $row)
                            <option value="{{ $row->id_anggota }}">{{ $row->nama }} ({{ $row->nomor_induk ?? $row->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($data as $i => $row)
                            <option value="{{ $row->id_buku }}">{{ $row->buku->judul }} (Stok: {{ $row->buku->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali (Opsional)</label>
                        <input type="date" name="tanggal_pengembalian" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
{{-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-danger text-white border-0 rounded-top-4">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data peminjaman ini?</p>
                <p class="text-muted small mb-0">Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer border-0">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<style>
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }
    .bg-gradient {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #0a58ca 100%);
    }
    .bg-success.bg-gradient {
        background: linear-gradient(135deg, var(--bs-success) 0%, #198754 100%);
    }
    .bg-danger.bg-gradient {
        background: linear-gradient(135deg, var(--bs-danger) 0%, #dc3545 100%);
    }
    .bg-warning.bg-gradient {
        background: linear-gradient(135deg, var(--bs-warning) 0%, #ffc107 100%);
    }
    .table th {
        font-weight: 600;
        white-space: nowrap;
    }
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#laporan-datatables').DataTable({
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "→",
                previous: "←"
            }
        },
        order: [[4, 'desc']], // Urutkan berdasarkan tanggal pinjam terbaru
        columnDefs: [
            { orderable: false, targets: [9] } // Kolom aksi tidak bisa diurutkan
        ]
    });

    // Custom search input
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Update showing info
    table.on('draw', function() {
        var info = table.page.info();
        $('#showingStart').text(info.start + 1);
        $('#showingEnd').text(info.end);
        $('#totalEntries').text(info.recordsTotal);
    });
});

function confirmDelete(id) {
    var form = document.getElementById('deleteForm');
    form.action = "{{ url('laporan') }}/" + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

@endsection
