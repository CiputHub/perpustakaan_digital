@extends('frontend.layouts.clean')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">📖 Data Peminjaman</h3>
                <p class="text-muted mb-0">Berisi buku dan history pinjaman</p>
            </div>
            <a href="{{ url('/') }}" class="btn btn-secondary">← Kembali</a>
        </div>

        <!-- Statistik Ringkas -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary bg-gradient text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">Total Pinjaman</small>
                                <h3 class="fw-bold mb-0">{{ $data->count() }}</h3>
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
                                <small class="opacity-75">Dipinjam</small>
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
                            <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Grid seperti di foto -->
        <div class="row g-4">
            @forelse($data as $row)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                        <!-- Gambar Buku -->
                        <div class="position-relative">
                            <img src="{{ $row->buku->gambar ? asset('storage/buku/' . $row->buku->gambar) : asset('default-book.jpg') }}"
                                class="card-img-top rounded-top-4" alt="{{ $row->buku->judul }}"
                                style="height: 200px; object-fit: cover;">

                            <!-- Badge Status -->
                            <div class="position-absolute top-0 end-0 m-3">
                                @if ($row->status == 'menunggu')
                                    <span class="badge bg-warning rounded-pill px-3 py-2">⏳ Menunggu</span>
                                @elseif($row->status == 'dipinjam')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">📖 Dipinjam</span>
                                @elseif($row->status == 'dikembalikan')
                                    <span class="badge bg-success rounded-pill px-3 py-2">✅ Selesai</span>
                                @elseif($row->status == 'terlambat')
                                    <span class="badge bg-danger rounded-pill px-3 py-2">⚠️ Terlambat</span>
                                @endif
                            </div>
                        </div>

                        <!-- Body Card -->
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-2">{{ $row->buku->judul }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-user me-1"></i> {{ $row->buku->penulis ?? 'Tidak diketahui' }}
                            </p>

                            <!-- Info Peminjaman -->
                            <div class="bg-light rounded-3 p-3 mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">📅 Tanggal Pinjam</small>
                                        <span
                                            class="fw-semibold">{{ date('d/m/Y', strtotime($row->tanggal_pinjam)) }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">📅 Tanggal Kembali</small>
                                        <span
                                            class="fw-semibold">{{ date('d/m/Y', strtotime($row->tanggal_pengembalian)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Denda jika terlambat -->
                            @if ($row->status == 'terlambat' && ($row->denda ?? 0) > 0)
                                <div class="alert alert-danger py-2 mb-3 rounded-3">
                                    <small><i class="fas fa-money-bill-wave me-1"></i> Denda: Rp
                                        {{ number_format($row->denda, 0, ',', '.') }}</small>
                                </div>
                            @endif

                            <!-- Button Kembalikan (hanya untuk dipinjam/terlambat) -->
                            @if (in_array($row->status, ['dipinjam', 'terlambat']))
                                @if (in_array($row->status, ['dipinjam', 'terlambat']))
                                    <form action="{{ url('/peminjaman/' . $row->id_peminjaman . '/kembali') }}" method="POST">
                                        @csrf
                                        <a href="{{ route('peminjaman.formKembali', $row->id_peminjaman) }}"
                                            class="btn btn-danger w-100 rounded-pill py-2">
                                            <i class="fas fa-undo-alt me-2"></i> Kembalikan
                                        </a>
                                        </button>
                                    </form>
                                @endif
                            @elseif($row->status == 'dikembalikan')
                                <div class="text-center text-success small">
                                    <i class="fas fa-check-circle me-1"></i> Buku sudah dikembalikan
                                </div>
                            @else
                                <div class="text-center text-muted small">
                                    <i class="fas fa-clock me-1"></i> Menunggu konfirmasi
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada history peminjaman</h5>
                            <p class="text-muted small">Mulai pinjam buku sekarang!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Konfirmasi Pengembalian -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-danger text-white border-0 rounded-top-4">
                    <h5 class="modal-title">📖 Konfirmasi Pengembalian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengembalikan buku:</p>
                    <h5 class="fw-bold text-center py-2" id="modalBookTitle">-</h5>

                    <div class="alert alert-warning mt-3" id="dendaInfo" style="display: none;">
                        <i class="fas fa-clock me-2"></i>
                        <span id="dendaText"></span>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                    <form id="returnForm" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Kembalikan Buku</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmReturn(id, judul, tanggalKembali) {

            document.getElementById('modalBookTitle').innerText = judul;

            let today = new Date();
            let tglKembali = new Date(tanggalKembali);

            let denda = 0;
            let hari = 0;

            if (today > tglKembali) {
                let diff = today - tglKembali;
                hari = Math.ceil(diff / (1000 * 60 * 60 * 24));
                denda = hari * 2000;
            }

            const dendaInfo = document.getElementById('dendaInfo');
            const dendaText = document.getElementById('dendaText');

            if (denda > 0) {
                dendaInfo.style.display = 'block';
                dendaText.innerHTML = `
            Terlambat <b>${hari} hari</b><br>
            Denda: <b>Rp ${denda.toLocaleString('id-ID')}</b><br>
            ⚠️ Dibayar langsung saat pengembalian di perpustakaan
        `;
            } else {
                dendaInfo.style.display = 'block';
                dendaText.innerHTML = `Tidak ada denda 👍`;
            }

            // ROUTE SESUAI WEB.PHP KAMU
            document.getElementById('returnForm').action = `/peminjaman/${id}/kembali`;

            new bootstrap.Modal(document.getElementById('returnModal')).show();
        }
    </script>

    @push('styles')
        <style>
            .hover-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .hover-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
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

            .card-img-top {
                border-top-left-radius: 1rem;
                border-top-right-radius: 1rem;
            }

            .badge {
                font-weight: 500;
                font-size: 0.75rem;
                backdrop-filter: blur(4px);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .btn-danger {
                transition: all 0.2s ease;
            }

            .btn-danger:hover {
                transform: scale(1.02);
            }

            @media (max-width: 768px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            }
        </style>
    @endpush

@endsection
