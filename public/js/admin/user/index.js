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
                            text:
                                xhr.responseJSON.message ||
                                "Gagal mengubah status.",
                        });
                    },
                    complete: function () {
                        Swal.hideLoading();
                    },
                });
            },
        });
    });

    // Handle toggle reset
    $(".btnToggleReset").on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let url = $(this).data("url");

        Swal.fire({
            title: "Yakin ingin mereset password?",
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
                            // console.log(response);

                            const passEscaped = $("<div>")
                                .text(response.data)
                                .html();
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                html: `
                                        <div class="text-start">
                                            <div class="mb-1">Password baru:</div>
                                            <div class="input-group">
                                            <input type="text" id="pwNew" class="form-control text-center" readonly value="${passEscaped}">
                                            <button type="button" class="btn btn-outline-primary" id="btnCopy">Salin</button>
                                            </div>
                                            <small class="text-muted d-block mt-2">
                                            Simpan password ini dengan aman. Silakan informasikan kepada pengguna.
                                            </small>
                                        </div>
                                        `,
                                didOpen: () => {
                                    const btn =
                                        document.getElementById("btnCopy");
                                    const inp =
                                        document.getElementById("pwNew");
                                    btn?.addEventListener("click", async () => {
                                        try {
                                            await navigator.clipboard.writeText(
                                                inp.value
                                            );
                                            btn.innerText = "Tersalin";
                                        } catch (err) {
                                            // Fallback lama
                                            inp.select();
                                            document.execCommand("copy");
                                            btn.innerText = "Tersalin";
                                        }
                                    });
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
                            text:
                                xhr.responseJSON.message ||
                                "Gagal mengubah status.",
                        });
                    },
                    complete: function () {
                        Swal.hideLoading();
                    },
                });
            },
        });
    });
});
