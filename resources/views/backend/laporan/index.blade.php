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
                            <button class="btn btn-primary rounded-pill px-4" onclick="printReport()">
                                <i class="fas fa-print me-2"></i>Cetak / PDF
                            </button>
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
                    <div class="card border-0 shadow-sm rounded-4 bg-danger bg-gradient text-white">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="opacity-75">Total Denda</small>
                                    <h3 class="fw-bold mb-0">Rp
                                        {{ number_format($totalDenda ?? $data->sum('denda'), 0, ',', '.') }}</h3>
                                </div>
                                <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Area yang akan di-print -->
            <div id="printArea" class="print-area">
                <div class="text-center mb-4 print-header">
                    <h2 class="fw-bold">📚 LAPORAN PEMINJAMAN BUKU</h2>
                    <p class="text-muted">Perpustakaan Digital</p>
                    {{-- <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p> --}}
                    <hr class="my-3">
                </div>

                <!-- Tabel Laporan -->
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
                                    <input type="text" id="searchInput" class="form-control border-start-0"
                                        placeholder="Search for reports...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="table-responsive">
                            <table id="laporan-datatables" class="display table table-striped table-hover w-100">
                                <thead class="table-dark">
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
                                                    <span class="text-danger fw-bold">Rp
                                                        {{ number_format($row->denda, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->status == 'menunggu')
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
                                                <a href="{{ route('laporan.show', $row->id_peminjaman) }}"
                                                    class="btn btn-info btn-sm rounded-circle" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('laporan.edit', $row->id_peminjaman) }}"
                                                    class="btn btn-warning btn-sm rounded-circle" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        {{-- <th colspan="5" class="text-end fw-bold">Total Denda:</th> --}}
                                        <th class="fw-bold text-danger">Rp
                                            {{ number_format($data->sum('denda'), 0, ',', '.') }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan <span id="showingStart">1</span> - <span
                                    id="showingEnd">{{ min(10, $data->count()) }}</span>
                                dari <span id="totalEntries">{{ $data->count() }}</span> entri
                            </small>
                            <div class="text-muted small">
                                <i class="fas fa-money-bill-wave me-1 text-danger"></i>
                                <strong>Total Denda Keseluruhan: Rp
                                    {{ number_format($data->sum('denda'), 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer untuk print -->
                <div class="print-footer text-center mt-4 pt-3">
                    <hr>
                    <small class="text-muted">
                        Laporan ini dibuat secara otomatis oleh sistem Perpustakaan Digital<br>
                        *Dokumen ini sah tanpa tanda tangan
                    </small>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Print Preview -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="fas fa-print me-2"></i>Cetak Laporan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                    <h6>Export ke PDF</h6>
                                    <p class="small text-muted">Simpan laporan sebagai file PDF</p>
                                    <button class="btn btn-danger rounded-pill px-4" onclick="exportToPDF()">
                                        <i class="fas fa-download me-2"></i>Export PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body text-center">
                                    <i class="fas fa-print fa-3x text-primary mb-2"></i>
                                    <h6>Cetak Langsung</h6>
                                    <p class="small text-muted">Cetak laporan ke printer</p>
                                    <button class="btn btn-primary rounded-pill px-4" onclick="printDirect()">
                                        <i class="fas fa-print me-2"></i>Cetak Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Style untuk Print -->
    <style>
        @media print {

            /* Sembunyikan semua elemen selain printArea */
            body * {
                visibility: hidden;
            }

            #printArea,
            #printArea * {
                visibility: visible;
            }

            #printArea {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                margin: 0;
                padding: 20px;
                background: white;
                z-index: 9999;
            }

            /* Style tabel saat print */
            #printArea table {
                width: 100% !important;
                border-collapse: collapse;
                font-size: 12px;
            }

            #printArea table,
            #printArea th,
            #printArea td {
                border: 1px solid #ddd;
            }

            #printArea th {
                background: #f5f5f5;
                text-align: center;
                padding: 8px;
            }

            #printArea td {
                padding: 6px 8px;
            }

            #printArea .badge {
                border: none;
                padding: 2px 8px;
            }

            #printArea .print-header {
                margin-bottom: 20px;
            }

            #printArea .print-footer {
                margin-top: 30px;
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
            }

            /* Sembunyikan elemen yang tidak perlu saat print */
            .btn,
            .card-header .input-group,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_paginate,
            .card-footer {
                display: none !important;
            }

            /* Pastikan tabel tidak terpotong */
            .table-responsive {
                overflow: visible !important;
            }

            @page {
                size: landscape;
                margin: 1.5cm;
            }
        }

        /* Style untuk PDF Export (screen) */
        .print-area-preview {
            padding: 30px;
            background: white;
        }

        .print-area-preview table {
            width: 100%;
            border-collapse: collapse;
        }

        .print-area-preview th,
        .print-area-preview td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .print-area-preview th {
            background: #f5f5f5;
        }

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

        .bg-danger.bg-gradient {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
        }

        .table th {
            font-weight: 600;
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_filter {
            display: none;
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#laporan-datatables').DataTable({
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
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
                order: [
                    [3, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [7]
                }]
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

        // Fungsi untuk print langsung
        function printDirect() {
            window.print();
        }

        // Fungsi untuk menampilkan modal print
        function printReport() {
            new bootstrap.Modal(document.getElementById('printModal')).show();
        }

        // Fungsi untuk export ke PDF menggunakan html2pdf
        function exportToPDF() {
            // Sembunyikan modal terlebih dahulu
            bootstrap.Modal.getInstance(document.getElementById('printModal')).hide();

            // Ambil elemen yang akan diexport
            const element = document.getElementById('printArea');

            // Clone element untuk menghindari perubahan pada tampilan asli
            const cloneElement = element.cloneNode(true);
            cloneElement.classList.add('print-area-preview');

            // Buat container sementara
            const tempDiv = document.createElement('div');
            tempDiv.style.position = 'absolute';
            tempDiv.style.top = '-9999px';
            tempDiv.style.left = '-9999px';
            tempDiv.appendChild(cloneElement);
            document.body.appendChild(tempDiv);

            // Konfigurasi PDF
            const opt = {
                margin: [0.5, 0.5, 0.5, 0.5],
                filename: 'laporan_peminjaman_' + new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            // Export ke PDF
            html2pdf().set(opt).from(cloneElement).save().then(() => {
                // Hapus container sementara
                document.body.removeChild(tempDiv);
            }).catch(() => {
                document.body.removeChild(tempDiv);
                alert('Gagal mengekspor PDF. Silakan coba lagi.');
            });
        }

        // Fungsi untuk mengubah status badge menjadi teks biasa saat print
        window.onbeforeprint = function() {
            document.querySelectorAll('#printArea .badge').forEach(badge => {
                badge.style.border = 'none';
                badge.style.background = 'transparent';
                badge.style.color = 'black';
                badge.style.padding = '0';
            });
        };

        window.onafterprint = function() {
            location.reload();
        };
    </script>
@endsection
