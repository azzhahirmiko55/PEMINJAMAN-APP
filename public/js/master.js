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
        ajax: "/ajaxDTMasterKendaraan",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', width: '5%'},
            {data: 'jenis', name: 'jenis', class: 'text-center', width: '20%'},
            {data: 'plat', name: 'plat', class: 'text-center', width: '20%'},
            {data: 'keterangan', name: 'keterangan', class: 'text-left', width: '50%'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center', width:'5%'},
        ],
        responsive: {
        details: true
        },
    });
}

DTMasterKendaraan();

$("#formKendaraan").submit(function(event) {
    event.preventDefault();
    dataFormKendaraan = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "/ajaxProsesMasterKendaraan",
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
                onAfterClose: () => $('#addMasterKendaraan').modal('hide')
            });
            DTMasterKendaraan();
            $('#formKendaraan').trigger("reset");
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