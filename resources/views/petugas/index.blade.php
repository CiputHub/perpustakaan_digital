@extends('layout')

@section('content')

    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-4">Data Petugas</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="{{ route('petugas.create') }}" class="btn btn-md btn-success mb-3">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </a>

                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $p)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $p->nama }}</td>
                                            <td>{{ $p->user->email ?? '-' }}</td>
                                            <td>{{ $p->no_telepon ?? '-' }}</td>
                                            <td>{{ $p->alamat ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('petugas.show', $p->id_petugas) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                                <a href="{{ route('petugas.edit', $p->id_petugas) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('petugas.destroy', $p->id_petugas) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

        </div>
    </div>



@endsection
