$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});

const DTMasterKendaraan = () => {
    NioApp.DataTable('#tableKendaraan', {
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: "/DTMasterKendaraan",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', width: '5%'},
            {data: 'jenis', name: 'jenis', class: 'text-center', width: '10%'},
            {data: 'plat', name: 'plat', class: 'text-center', width: '10%'},
            {data: 'keterangan', name: 'keterangan', class: 'text-left', width: '25%'},
            {data: 'status_pinjaman', name: 'status_pinjaman', class: 'text-center', width: '15%'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center', width:'5%'},
        ],
        responsive: {
            details: true
        }
    });
}

DTMasterKendaraan();

const clearFormKendaraan = () => {
    $('#formKendaraan').trigger('reset');
    $('#idKendaraan').val('');
}

const showMasterKendaraan = () => {
    clearFormKendaraan();
    $('#modalMasterKendaraan').modal('show');
}

const hideMasterKendaraan = () => {
    clearFormKendaraan();
    $('#modalMasterKendaraan').modal('hide');
}

const editMasterKendaraan = (id_kendaraan) => {
    clearFormKendaraan();
    $.ajax({
        type: 'GET',
        url: '/gtMasterKendaraan',
        data: {
            id: id_kendaraan
        },
        dataType: 'JSON',
        async: false,
        cache: false,
        success: function (response) {
            $('#modalMasterKendaraan').modal('show');
            $('#idKendaraan').val(response.id);
            $('#inputPlatNomor').val(response.plat);
            if(response.jenis === "Roda-2"){
                $('#radioRoda2').prop('checked',true);
            } else if (response.jenis === "Roda-4"){
                $('#radioRoda4').prop('checked',true);
            }
            if(response.status === 1){
                $('#statusPinjam1').prop('checked',true);
            } else if (response.status === 5){
                $('#statusPinjam5').prop('checked',true);
            }
            $('#inputKeterangan').val(response.keterangan);
            $('input.warna-checkbox[value="'+response.warna+'"]').prop('checked', true);
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

const deleteMasterKendaraan = (id_kendaraan) => {
    Swal.fire({
        title: 'Apakah anda yakin ?',
        text: 'Anda akan menghapusn data kendaraan, klik ya jika ingin melanjutkan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/deleteMasterKendaraan',
                data: {
                    id: id_kendaraan
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
                    DTMasterKendaraan();
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

$("#formKendaraan").submit(function(event) {
    event.preventDefault();
    dataFormKendaraan = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "/processMasterKendaraan",
        data: dataFormKendaraan,
        dataType: "JSON",
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.showLoading();
        },
        complete: function() {
            Swal.hideLoading();
        },
        success: function (response) {
            Swal.fire({
                title : response.message,
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                onAfterClose: () => $('#modalMasterKendaraan').modal('hide')
            });
            DTMasterKendaraan();
            clearFormKendaraan();
        },
        error: function (error) {
            Swal.fire({
                title: 'Terjadi kesalahan saat menyimpan data!',
                text: error.responseText, 
                icon: 'error',
                showConfirmButton: false
            });
        }
    });
});