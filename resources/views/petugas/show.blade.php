@extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Detail Petugas</h3>
            <hr>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>
                                <th width="180">Username</th>
                                <td>: {{ $petugas->user->username }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>: {{ $petugas->user->email }}</td>
                            </tr>

                            <tr>
                                <th>Password</th>
                                <td>: <span class="text-muted">********</span></td>
                            </tr>

                            <tr>
                                <th>Nama</th>
                                <td>: {{ $petugas->nama }}</td>
                            </tr>

                            <tr>
                                <th>No Telepon</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $petugas->no_telepon }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Alamat</th>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $petugas->alamat }}
                                    </span>
                                </td>
                            </tr>

                        </table>

                        <div class="mt-3">
                            <a href="{{ route('petugas.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>

                            <a href="{{ route('petugas.edit', $petugas->id_petugas) }}" class="btn btn-warning">
                                Edit
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
