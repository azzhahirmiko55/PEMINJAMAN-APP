$("#formKendaraan").submit(function(event) {
    event.preventDefault();
    dataFormKendaraan = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: "/ajax_proses_master_kendaraan",
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
                type: 'success',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
});