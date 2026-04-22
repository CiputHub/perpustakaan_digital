@extends('frontend.layouts.clean')

@section('content')
    <div class="container py-5">
        <div class="card shadow p-4">

            <h4 class="mb-4">📚 Form Peminjaman Buku</h4>

            {{-- ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('pinjam.store') }}" method="POST">
                @csrf

                <input type="hidden" name="buku_id" value="{{ $buku->id_buku }}">

                <!-- INFO BUKU -->
                <div class="mb-3">
                    <strong>Judul:</strong> {{ $buku->judul }}
                </div>
                <div class="mb-3">
                    <strong>Penulis:</strong> {{ $buku->penulis }}
                </div>
                <div class="mb-3">
                    <strong>Stok:</strong> {{ $buku->stok }}
                </div>

                <hr>

                <!-- INFO ANGGOTA -->
                <div class="mb-3">
                    <strong>Peminjam:</strong> {{ $anggota->nama }}
                </div>

                <!-- TANGGAL -->
                <div class="row">
                    <div class="col-md-6">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal Kembali (Min 1 hari - Max 7 hari)</label>
                        <input type="date" name="tanggal_pengembalian" class="form-control"
                            min="{{ date('Y-m-d', strtotime('+1 days')) }}"
                            max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                            required>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-success">📥 Pinjam Sekarang</button>
                    <a href="{{ url('/') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Validasi tambahan via JavaScript
        document.querySelector('input[name="tanggal_pengembalian"]').addEventListener('change', function() {
            let selectedDate = new Date(this.value);
            let minDate = new Date();
            minDate.setDate(minDate.getDate() + 1);
            let maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 7);

            selectedDate.setHours(0,0,0,0);
            minDate.setHours(0,0,0,0);
            maxDate.setHours(0,0,0,0);

            if (selectedDate < minDate) {
                alert('Tanggal kembali minimal 1 hari dari sekarang (besok)!');
                this.value = minDate.toISOString().split('T')[0];
            } else if (selectedDate > maxDate) {
                alert('Tanggal kembali maksimal 7 hari dari sekarang!');
                this.value = maxDate.toISOString().split('T')[0];
            }
        });
    </script>
@endsection
