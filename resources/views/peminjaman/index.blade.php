@extends('layout')

@section('content')

<div class="container">
    <div class="page-inner">

 <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                      <h3 class="fw-bold mb-4">Data Peminjaman</h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="basic-datatables"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Anggota</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>

                            @foreach($data as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->anggota_id }}</td>
                                <td>{{ $row->tanggal_pinjam }}</td>
                                <td>{{ $row->tanggal_pengembalian }}</td>
                                <td>
                                    @if($row->status == 'dipinjam')
                                        <span class="badge bg-warning">Dipinjam</span>
                                    @elseif($row->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                            </tr>

                            @endforeach
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>
              </div>



        @endsection


