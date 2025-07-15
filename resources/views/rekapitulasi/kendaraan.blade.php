@extends('layouts.main')

@section('container')

    <!-- content @s -->
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-lg mx-auto">

                        <div class="nk-block nk-block-lg">

                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h4 class="nk-block-title">Rekapitulasi Peminjaman Kendaraan</h4>
                                            <div class="nk-block-des">
                                                <p>Rekapitulasi kendaraan kantor pertanahan kabupaten cilacap</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <input type="date" id="startDate" class="form-control ml-2" placeholder="Dari Tanggal">
                                            <input type="date" id="endDate" class="form-control ml-2" placeholder="Hingga Tanggal">
                                            <button class="btn btn-primary ml-2" id="btnPrint">Cetak</button>
                                            <button class="btn btn-success ml-2" id="btnDownload">Download Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-bordered card-preview printableArea">
                                <div class="card-inner">
                                    <table class="table display nowrap" id="tableRekapitulasiKendaraan" style="width:100%;">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Kendaraan</th>
                                                <th>Peminjam</th>
                                                <th>Driver</th>
                                                <th>Tanggal</th>
                                                <th>Keperluan</th>
                                                 @if (Auth::check())
                                                @if (Auth::user()->username != "pengguna")
                                                <th>Status</th>
                                                @endif
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Tambahkan baris Anda di sini secara dinamis dari backend -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content @s -->

    <!-- Import SheetJS plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script>
        document.getElementById('btnPrint').addEventListener('click', function() {
            filterTable();
            window.print();
        });

        document.getElementById('btnDownload').addEventListener('click', function() {
            filterTable();
            downloadExcel();
        });

        function filterTable() {
            let startDate = document.getElementById('startDate').value;
            let endDate = document.getElementById('endDate').value;
            let table = document.getElementById('tableRekapitulasiKendaraan');
            let rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let dateCell = row.querySelectorAll('td')[4]; // kolom tanggal
                let date = new Date(dateCell.innerText);
                let start = new Date(startDate);
                let end = new Date(endDate);

                if (date >= start && date <= end) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function downloadExcel() {
            let table = document.getElementById('tableRekapitulasiKendaraan');
            let tableData = [];
            let headers = [];

            // Mengambil header
            for (let header of table.querySelectorAll('thead th')) {
                headers.push(header.innerText);
            }
            tableData.push(headers);

            // Mengambil data baris yang terlihat
            for (let row of table.querySelectorAll('tbody tr')) {
                if (row.style.display !== 'none') {
                    let rowData = [];
                    for (let cell of row.querySelectorAll('td')) {
                        rowData.push(cell.innerText);
                    }
                    tableData.push(rowData);
                }
            }

            // Membuat worksheet dan workbook
            let worksheet = XLSX.utils.aoa_to_sheet(tableData);
            let workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Rekapitulasi Kendaraan');

            // Mengunduh file
            XLSX.writeFile(workbook, 'Rekapitulasi_Pemakaian_Kendaraan.xlsx');
        }
    </script>


    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .printableArea, .printableArea * {
                visibility: visible;
            }
            .printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

@endsection
