@extends('backend.layout')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-4">Data anggota</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nip</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $a)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $a->nama }}</td>
                                            <td>{{ $a->nip }}</td>
                                            <td>{{ $a->no_telepon }}</td>
                                            <td>{{ $a->alamat }}</td>

                                            <td>
                                                <a href="{{ route('anggota.show', $a->id_anggota) }}"
                                                    class="btn btn-sm btn-info">Detail</a>

                                            </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection
