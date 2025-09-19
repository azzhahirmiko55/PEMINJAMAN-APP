<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pelaporan Peminjaman Ruangan</title>
    <style>
        /* CSS dasar untuk PDF (DomPDF) */
        @page {
            margin: 20px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
        }

        .sub {
            text-align: center;
            margin-bottom: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
        }

        th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .w-50 {
            width: 50px;
        }
    </style>
</head>

<body>
    <div class="title">Pelaporan Peminjaman Ruangan</div>
    <div class="sub">
        Periode: <strong>{{ $periodeLabel }}</strong><br>
        Dicetak: {{ $printedAt }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="w-50">No.</th>
                <th>Nama Pegawai</th>
                <th>Ruangan</th>
                <th>Total Peminjaman</th>
                <th>Total Disetujui</th>
                <th>Total Tolak</th>
                <th>Total Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($dRekapRuangan as $row)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $row->nama_pegawai }}</td>
                <td class="text-center">{{ $row->nama_ruangan }}</td>
                <td class="text-center">{{ (int)$row->total_peminjaman }}</td>
                <td class="text-center">{{ (int)$row->total_disetujui }}</td>
                <td class="text-center">{{ (int)$row->total_tolak }}</td>
                <td class="text-center">{{ (int)$row->total_pengembalian }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
