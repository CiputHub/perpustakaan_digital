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
                            @foreach ($data as $i => $row)
                                <option value="{{ $row->id_anggota }}">{{ $row->nama }}
                                    ({{ $row->nomor_induk ?? $row->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach ($data as $i => $row)
                                <option value="{{ $row->id_buku }}">{{ $row->buku->judul }} (Stok:
                                    {{ $row->buku->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali (Opsional)</label>
                        <input type="date" name="tanggal_pengembalian" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
