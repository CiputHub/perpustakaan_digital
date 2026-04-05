@extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Detail Anggota</h3>
            <hr>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <table class="table table-borderless">


                            <tr>
                                <th width="180">Username</th>
                                <td>{{ $anggota->user->username ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th width="180">Email</th>
                                <td>{{ $anggota->user->email ?? '-' }}</td>
                            </tr>


                            <tr>
                                <th width="180">Nama</th>
                                <td>: {{ $anggota->nama }}</td>
                            </tr>

                            <tr>
                                <th>NIP</th>
                                <td>: {{ $anggota->nip }}</td>
                            </tr>

                            <tr>
                                <th>No Telepon</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $anggota->no_telepon }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Role</th>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $anggota->user->role }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th width="180">Alamat</th>
                                <td>{{ $anggota->alamat ?? '-' }}</td>
                            </tr>

                        </table>

                        <div class="mt-3">
                            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>

                          
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
