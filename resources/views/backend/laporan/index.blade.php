@extends('backend.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h3 class="fw-bold mb-1">📋 Laporan Peminjaman</h3>
                        <p class="text-muted mb-0">Data lengkap peminjaman buku</p>
                    </div>
                    <div class="d-flex gap-2">
                        <form method="GET" action="{{ route('laporan.index') }}" class="d-flex gap-2" id="filterForm">
                            <select name="filter" class="form-select rounded-pill" style="width: 140px;" onchange="this.form.submit()">
                                <option value="">📅 Semua</option>
                                <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>📆 Hari Ini</option>
                                <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>📊 Minggu Ini</option>
                                <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>📅 Bulan Ini</option>
                            </select>
                            <a href="{{ route('laporan.export.pdf', request()->query()) }}" class="btn btn-danger rounded-pill px-3">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card bg-primary">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Total Peminjaman</span>
                        <h3 class="stat-value">{{ $data->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-warning">
                    <div class="stat-icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Dipinjam</span>
                        <h3 class="stat-value">{{ $data->where('status', 'dipinjam')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Selesai</span>
                        <h3 class="stat-value">{{ $data->where('status', 'dikembalikan')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card bg-danger">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Total Denda</span>
                        <h3 class="stat-value">Rp {{ number_format($data->sum('denda'), 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="data-card">
            <div class="data-card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0">
                        <i class="fas fa-table-list me-2 text-primary"></i> Data Peminjaman
                    </h5>

                </div>
            </div>
            <div class="data-card-body">
                <div class="table-responsive">
                    <table class="data-table" id="basic-datatables">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Denda</th>
                                <th>Status</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $row)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $row->anggota->nama ?? '-' }}</div>
                                    <small class="text-muted">{{ $row->anggota->email ?? '' }}</small>
                                </td>
                                <td>{{ $row->buku->judul ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($row->tanggal_pengembalian)
                                        {{ \Carbon\Carbon::parse($row->tanggal_pengembalian)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->denda && $row->denda > 0)
                                        <span class="denda">Rp {{ number_format($row->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 'menunggu')
                                        <span class="badge-status warning">Menunggu</span>
                                    @elseif($row->status == 'dipinjam')
                                        <span class="badge-status primary">Dipinjam</span>
                                    @elseif($row->status == 'dikembalikan')
                                        <span class="badge-status success">Selesai</span>
                                    @elseif($row->status == 'terlambat')
                                        <span class="badge-status danger">Terlambat</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('laporan.show', $row->id_peminjaman) }}" class="action-btn view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('laporan.edit', $row->id_peminjaman) }}" class="action-btn edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="data-card-footer">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total <span id="totalEntries">{{ $data->count() }}</span> data peminjaman
                    </small>
                    <div class="pagination-info" id="paginationInfo"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: 1px solid #f0f0f0;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .stat-card.bg-primary { background: linear-gradient(135deg, #4e73df, #224abe); }
    .stat-card.bg-warning { background: linear-gradient(135deg, #f6c23e, #dda20a); }
    .stat-card.bg-success { background: linear-gradient(135deg, #1cc88a, #13855c); }
    .stat-card.bg-danger { background: linear-gradient(135deg, #e74a3b, #be2617); }

    .stat-card .stat-icon {
        width: 55px;
        height: 55px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-card .stat-info {
        flex: 1;
    }

    .stat-card .stat-label {
        font-size: 12px;
        opacity: 0.8;
        color: white;
        display: block;
    }

    .stat-card .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: white;
        line-height: 1.2;
    }

    /* Data Card */
    .data-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .data-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        background: white;
    }

    .data-card-body {
        padding: 0;
        overflow-x: auto;
    }

    .data-card-footer {
        padding: 16px 24px;
        border-top: 1px solid #f0f0f0;
        background: #fafbfc;
    }



    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e5e7eb;
        border-radius: 30px;
        font-size: 14px;
        transition: all 0.3s;
        background: white;
    }

    .search-input:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78,115,223,0.1);
    }

    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .data-table thead th {
        padding: 14px 16px;
        background: #f8f9fc;
        font-weight: 600;
        color: #4a5568;
        border-bottom: 2px solid #e9ecef;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        color: #2d3748;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f8f9fc;
    }

    /* Badge Status */
    .badge-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-status.primary {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-status.success {
        background: #e8f5e9;
        color: #388e3c;
    }

    .badge-status.warning {
        background: #fff3e0;
        color: #ed6c02;
    }

    .badge-status.danger {
        background: #ffebee;
        color: #d32f2f;
    }

    /* Denda */
    .denda {
        color: #dc2626;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .action-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        text-decoration: none;
    }

    .action-btn.view {
        background: #e3f2fd;
        color: #1976d2;
    }

    .action-btn.view:hover {
        background: #1976d2;
        color: white;
    }

    .action-btn.edit {
        background: #fff3e0;
        color: #ed6c02;
    }

    .action-btn.edit:hover {
        background: #ed6c02;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card {
            padding: 15px;
        }

        .stat-card .stat-icon {
            width: 45px;
            height: 45px;
            font-size: 20px;
        }

        .stat-card .stat-value {
            font-size: 18px;
        }

        .search-wrapper {
            width: 100%;
        }

        .data-card-header {
            padding: 16px;
        }

        .data-card-footer {
            padding: 12px 16px;
        }

        .data-table thead th,
        .data-table tbody td {
            padding: 10px 12px;
            font-size: 12px;
        }
    }
</style>


<!-- Print Area untuk PDF (tetap dipertahankan) -->
<div id="printArea" style="display: none;">
    <div class="text-center mb-4">
        <h2>LAPORAN PEMINJAMAN BUKU</h2>
        <p>Perpustakaan Digital</p>
        <hr>
    </div>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $row)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $row->anggota->nama ?? '-' }}</td>
                <td>{{ $row->buku->judul ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td>{{ $row->tanggal_pengembalian ? \Carbon\Carbon::parse($row->tanggal_pengembalian)->format('d/m/Y') : '-' }}</td>
                <td>{{ $row->denda ? 'Rp ' . number_format($row->denda,0,',','.') : '-' }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function printDirect() {
    var printContent = document.getElementById('printArea').innerHTML;
    var originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
}

function exportToPDF() {
    alert('Fitur PDF akan segera hadir');
}

var table = $('#laporanTable').DataTable({
    pageLength: 10,
    order: [[3, 'desc']],
    columnDefs: [
        { orderable: false, targets: [0, 7] }
    ],
    dom: 'lrtip'
});


table.on('order.dt search.dt draw.dt', function () {
    table.column(0, { search: 'applied', order: 'applied' })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
}).draw();
</script>

@endsection
