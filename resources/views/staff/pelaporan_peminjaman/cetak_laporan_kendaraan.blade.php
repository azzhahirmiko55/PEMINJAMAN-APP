<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pelaporan Penggunaan Kendaraan</title>
    <style>
        @page {
            margin: 20px 25px;
        }

        body {
            font-family: "Times New Roman", Times, serif;
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
    <!-- Header Instansi -->
    <table style="width:100%; border:none; margin-bottom:10px;">
        <tr>
            <td style="width:80px; text-align:center; border:none;">
                <img src="{{public_path('/assets/images/Logo_BPN.png') }}" alt="Logo" style="width:70px; height:auto;">
            </td>
            <td style="text-align:center; border:none;">
                <div style="font-weight:bold; font-size:14px;">
                    KEMENTERIAN AGRARIA DAN TATA RUANG/<br>
                    BADAN PERTANAHAN NASIONAL<br>
                    KANTOR PERTANAHAN KABUPATEN CILACAP<br>
                    PROVINSI JAWA TENGAH
                </div>
                <div style="font-size:11px; margin-top:4px;">
                    Jl. Kauman No.12 Telp. (0282) 533171, Fax (0282) 533146,
                    Email : bpnclp@yahoo.co.id
                </div>
            </td>
        </tr>
    </table>

    <hr style="border:1px solid #000; margin:8px 0;">

    <div class="title">Pelaporan Penggunaan Kendaraan</div>
    <div class="sub">
        Periode: <strong>{{ $periodeLabel }}</strong><br>
        Dicetak: {{ $printedAt }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="w-50">No.</th>
                <th>Nama Pegawai</th>
                <th>Total Penggunaan</th>
                <th>Kendaraan Roda 2</th>
                <th>Kendaraan Roda 4</th>
                <th>Total Disetujui</th>
                <th>Total Tolak</th>
                <th>Total Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($dRekapKendaraan as $row)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $row->nama_pegawai }}</td>
                <td class="text-center">{{ (int)$row->total_peminjaman }}</td>
                <td class="text-center">{{ (int)$row->kendaraan_roda2 }}</td>
                <td class="text-center">{{ (int)$row->kendaraan_roda4 }}</td>
                <td class="text-center">{{ (int)$row->total_disetujui }}</td>
                <td class="text-center">{{ (int)$row->total_tolak }}</td>
                <td class="text-center">{{ (int)$row->total_pengembalian }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <table style="width:100%; border:none; margin-top:30px;">
        <tr>
            <!-- Kolom kiri -->
            <td style="width:50%; text-align:center; border:none;">
                Mengetahui,<br>
                <strong>Kasubag</strong><br>
                <br><br><br><br>
                ( Agus Pudjiono SH. MM. )
            </td>

            <!-- Kolom kanan -->
            <td style="width:50%; text-align:center; border:none;">
                Cilacap, {{ $printedAt }}<br>
                <strong>Staff TU</strong><br>
                <br><br><br><br>
                ( {{ $user->nama_pegawai }} )
            </td>
        </tr>
    </table>

</body>

</html>
