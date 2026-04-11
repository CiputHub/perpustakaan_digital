@extends('layout')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-4">Data Kategori</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success mb-3">Tambah </a>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $key => $k)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $k->nama_kategori }}</td>

                                            <td>

                                                <a href="{{ route('kategori.edit', $k->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('kategori.destroy', $k->id) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin hapus data ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Hapus
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
        </div>
    </div>
@endsection
