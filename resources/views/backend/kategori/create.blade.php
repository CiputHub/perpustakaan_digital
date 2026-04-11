 @extends('layout')

 @section('content')
     <div class="container">
         <div class="page-inner">

             <div>
                 <h3 class="text-center my-4">Tambah Data kategori</h3>
                 <hr>
             </div>

             <div class="container mt-5 mb-5">
                 <div class="row">
                     <div class="col-md-12">
                         <div class="card border-0 shadow p-3 mb-5 bg-body-tertiary rounded">
                             <div class="card-body">
                                 <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">

                                     @csrf

                                     <div class="form-group mb-3">
                                         <label class="font-weight-bold">Nama Kategori</label>
                                         <input type="text"
                                             class="form-control @error('nama_kategori') is-invalid @enderror"
                                             name="nama_kategori" value="{{ old('nama_kategori') }}"
                                             placeholder="Masukkan Nama kategori">

                                         <!-- error message untuk nama_kategori -->
                                         @error('nama_kategori')
                                             <div class="alert alert-danger mt-2">
                                                 {{ $message }}
                                             </div>
                                         @enderror
                                     </div>

                                     <button type="submit" class="btn btn-md btn-primary me-3">Simpan</button>
                                     <a href="/kategori" class="btn btn-warning">Kembali</a>

                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
