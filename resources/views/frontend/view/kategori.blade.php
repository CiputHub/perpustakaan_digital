<!-- Kategori Populer Start -->
<div id="kategori" class="container py-5 bg-light rounded-4 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-secondary px-3 py-2 rounded-pill mb-2">Kategori</span>
        <h2 class="fw-bold display-6">KATEGORI POPULER</h2>
        <p class="text-muted">Jelajahi buku berdasarkan kategori favorit Anda</p>
    </div>

    <div class="row g-4">
        @php
            $kategoris = ['Fiksi', 'Non Fiksi', 'Pendidikan', 'Teknologi', 'Agama', 'Sejarah'];
        @endphp
        @foreach($kategoris as $kat)
        <div class="col-md-4 col-lg-2">
            <div class="category-card text-center p-4 rounded-4 bg-white shadow-sm hover-category">
                <div class="category-icon mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3">
                        <i class="fas fa-tag fa-2x text-primary"></i>
                    </div>
                </div>
                <h6 class="mb-0 fw-bold">{{ $kat }}</h6>
                <small class="text-muted">12 Buku</small>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Kategori Populer End -->
