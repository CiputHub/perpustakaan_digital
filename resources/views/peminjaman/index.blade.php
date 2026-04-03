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
                       <table id="basic-datatables" class="display table table-striped table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>

                    <!-- BUKU -->
                    <td>{{ $row->buku->judul ?? '-' }}</td>

                    <!-- ANGGOTA -->
                    <td>{{ $row->anggota->nama ?? '-' }}</td>

                    <td>{{ $row->tanggal_pinjam }}</td>
                    <td>{{ $row->tanggal_pengembalian }}</td>

                    <!-- STATUS -->
                    <td>
                        @if($row->status == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($row->status == 'dipinjam')
                            <span class="badge bg-primary">Dipinjam</span>
                        @elseif($row->status == 'dikembalikan')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($row->status == 'terlambat')
                            <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td>
                        @if($row->status == 'menunggu')
                            <form action="{{ route('peminjaman.acc', $row->id_peminjaman) }}"
                                  method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    ACC
                                </button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
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


