$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});

const DTRekapitulasiKendaraan = () => {
    NioApp.DataTable('#tableRekapitulasiKendaraan', {
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: "/DTRekapitulasiKendaraan",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center', width: '5%'},
            // {data: 'jenis', name: 'jenis', class: 'text-center', width: '10%'},
            {data: 'ket_kendaraan', name: 'ket_kendaraan', class: 'text-left', width: '10%'},
            {data: 'peminjam', name: 'peminjam', class: 'text-left', width: '25%'},
            {data: 'driver', name: 'driver', class: 'text-left', width: '15%'},
            {data: 'tanggal', name: 'tanggal', class: 'text-center', width: '15%'},
            {data: 'keperluan', name: 'keperluan', class: 'text-center', width: '15%'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center', width:'5%'},
        ],
        responsive: {
            details: true
        },
    });
}

DTRekapitulasiKendaraan();

const pembatalanPeminjaman = (id_peminjaman) => {
    Swal.fire({
        title: 'Apakah anda yakin ?',
        text: 'Anda akan membatalkan peminjaman kendaraan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/cancelPeminjamanKendaraan',
                data: {
                    id: id_peminjaman
                },
                dataType: 'JSON',
                async: false,
                cache: false,
                success: function (response) {
                    Swal.fire({
                        title : response.message,
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    DTRekapitulasiKendaraan();
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Terjadi kesalahan saat mengambil data!',
                        text: error.responseText, 
                        icon: 'error',
                        showConfirmButton: false
                    });
                }
            });
        }
    })   
}