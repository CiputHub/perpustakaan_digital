@extends('layout')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
    <div class="page-inner">
      <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                       <h3 class="fw-bold mb-4">Data petugas</h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                           <a href="{{ route('petugas.create') }}" class="btn btn-md btn-success mb-3">Tambah </a>
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
            @foreach($data as $key => $p)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->user->email ?? '-' }}</td>
                <td>{{ $p->no_telepon }}</td>
                <td>{{ $p->alamat }}</td>

                <td>
                    <a href="{{ route('petugas.show', $p->id_petugas) }}"
                        class="btn btn-sm btn-info">Detail</a>

                        <a href="{{ route('petugas.edit', $p->id_petugas) }}"
                            class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('petugas.destroy', $p->id_petugas) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Yakin hapus data ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            @endforeach
            </tbody>
        </table>
                    </div>
                  </div>
                </div>
              </div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        @endsection







