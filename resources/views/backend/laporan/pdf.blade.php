<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        p {
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background: #eee;
            padding: 6px;
        }
        td {
            padding: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PEMINJAMAN DAN DENDA</h2>
    <p>Perpustakaan Digital</p>

    <table>
        <tr>
            <td>Total Peminjaman</td>
            <td>{{ $totalPinjam }}</td>
            <td>Total Denda</td>
            <td>Rp {{ number_format($totalDenda,0,',','.') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $row->anggota->nama ?? '-' }}</td>
                <td>{{ $row->buku->judul ?? '-' }}</td>
                <td>{{ $row->tanggal_pinjam }}</td>
                <td>{{ $row->tanggal_pengembalian ?? '-' }}</td>
                <td class="text-right">
                    {{ $row->denda ? number_format($row->denda,0,',','.') : '-' }}
                </td>
                <td class="text-center">{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
