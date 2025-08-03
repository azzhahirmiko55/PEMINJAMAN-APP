$(document).ready(function () {
    // Setup CSRF Token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Handle toggle status
    $(".btnToggleStatus").on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let status = $(this).data("status");
        let url = $(this).data("url");

        Swal.fire({
            title: "Yakin ingin mengubah status?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
            preConfirm: () => {
                return $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        current_status: status,
                    },
                    beforeSend: function () {
                        Swal.showLoading();
                    },
                    success: function (response) {
                        if (response.status === true) {
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                timer: 1500,
                                showConfirmButton: false,
                                didClose: () => {
                                    refreshContent();
                                },
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: response.message,
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan",
                            text: xhr.responseJSON.message || "Gagal mengubah status.",
                        });
                    },
                    complete: function () {
                        Swal.hideLoading();
                    }
                });
            }
        });
    });
});
