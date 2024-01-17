$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
});

const DTMasterRuangRapat = () => {
    NioApp.DataTable('#tableRuangRapat', {
        processing: true,
        serverSide: true,
        bDestroy: true,
        ajax: "/DTMasterRuangRapat",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', width: '5%'},
            {data: 'ruangan', name: 'jenis', class: 'text-center', width: '10%'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center', width:'5%'},
        ],
        responsive: {
            details: true
        }
    });
}

DTMasterRuangRapat();

const clearFormRuangRapat = () => {
    $('#formRuangRapat').trigger('reset');
    $('#idRuangRapat').val('');
}

const showMasterRuangRapat = () => {
    clearFormRuangRapat();
    $('#modalMasterRuangRapat').modal('show');
}

const hideMasterRuangRapat = () => {
    clearFormRuangRapat();
    $('#modalMasterRuangRapat').modal('hide');
}

const editMasterRuangRapat = (id_ruangrapat) => {
    clearFormRuangRapat();
    $.ajax({
        type: 'GET',
        url: '/gtMasterRuangRapat',
        data: {
            id: id_ruangrapat
        },
        dataType: 'JSON',
        async: false,
        cache: false,
        success: function (response) {
            $('#modalMasterRuangRapat').modal('show');
            $('#idRuangRapat').val(response.id);
            $('#inputRuangan').val(response.ruangan);
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

const deleteMasterRuangRapat = (id_ruangrapat) => {
    Swal.fire({
        title: 'Apakah anda yakin ?',
        text: 'Anda akan menghapus data Ruang Rapat, klik ya jika ingin melanjutkan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/deleteMasterRuangRapat',
                data: {
                    id: id_ruangrapat
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
                    DTMasterRuangRapat();
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

$("#formRuangRapat").submit(function(event) {
    event.preventDefault();
    dataFormRuangRapat = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "/processMasterRuangRapat",
        data: dataFormRuangRapat,
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
                onAfterClose: () => $('#modalMasterRuangRapat').modal('hide')
            });
            DTMasterRuangRapat();
            clearFormRuangRapat();
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