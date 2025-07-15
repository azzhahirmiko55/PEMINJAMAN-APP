$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});

const DTMasterKaryawan = () => {
    NioApp.DataTable('#tableKaryawan', {
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: "/DTMasterKaryawan",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', width: '5%'},
            {data: 'karyawan', name: 'karyawan', class: 'text-left', width: '40%'},
            {data: 'jabatan', name: 'jabatan', class: 'text-center', width: '40%'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center', width:'5%'},
        ],
        responsive: {
            details: true
        }
    });
}

DTMasterKaryawan();

const clearFormKaryawan = () => {
    $('#formKaryawan').trigger('reset');
    $('#idKaryawan').val('');
}

const showMasterKaryawan = () => {
    clearFormKaryawan();
    $('#modalMasterKaryawan').modal('show');
}

const hideMasterKaryawan = () => {
    clearFormKaryawan();
    $('#modalMasterKaryawan').modal('hide');
}

const editMasterKaryawan = (id_karyawan) => {
    clearFormKaryawan();
    $.ajax({
        type: 'GET',
        url: '/gtMasterKaryawan',
        data: {
            id: id_karyawan
        },
        dataType: 'JSON',
        async: false,
        cache: false,
        success: function (response) {
            $('#modalMasterKaryawan').modal('show');
            $('#idKaryawan').val(response.id);
            $('#inputKaryawan').val(response.karyawan);
            $('#inputJabatan').val(response.jabatan);
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

const deleteMasterKaryawan = (id_karyawan) => {
    Swal.fire({
        title: 'Apakah anda yakin ?',
        text: 'Anda akan menghapus data karyawan, klik ya jika ingin melanjutkan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/deleteMasterKaryawan',
                data: {
                    id: id_karyawan
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
                    DTMasterKaryawan();
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

$("#formKaryawan").submit(function(event) {
    event.preventDefault();
    dataFormKaryawan = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "/processMasterKaryawan",
        data: dataFormKaryawan,
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
                onAfterClose: () => $('#modalMasterKaryawan').modal('hide')
            });
            DTMasterKaryawan();
            clearFormKaryawan();
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
