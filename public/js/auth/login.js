$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$("#formLogin").submit(function (event) {
    Swal.showLoading();
    $("#btnLogin").prop("disabled", true);
    $("#btnLogin").html("...Login");
    event.preventDefault();
    formData = new FormData($(this)[0]);

    $.ajax({
        url: "/processLogin",
        type: "POST",
        data: formData,
        async: false,
        cache: false,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.showLoading();
        },
        complete: function () {
            Swal.hideLoading();
        },
        success: function (response) {
            if (response.status === true) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    timer: 1500,
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didClose: () => {
                        window.location = response.redirect;
                    },
                });
            }
        },
        error: function (error) {
            const message = error.responseJSON.message;

            Swal.fire({
                title: message,
                text: error.message,
                icon: "error",
                showConfirmButton: true,
            });
        },
    });
    return false;

    document.addEventListener("DOMContentLoaded", function () {
        document
            .getElementById("loginForm")
            .addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch(this.action, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": formData.get("_token"),
                    },
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status) {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });
    });
});

$("#formRegisterUsername").submit(function (event) {
    $("#btnRegisterUsername").prop("disabled", true);
    $("#btnRegisterUsername").html("...Proses");
    event.preventDefault();
    formData = new FormData($(this)[0]);

    $.ajax({
        url: "/lupa_password_cek_user",
        type: "POST",
        data: formData,
        async: false,
        cache: false,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Memeriksa...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });
        },
        complete: function () {
            setTimeout(function () {
                Swal.close();
                $("#btnRegisterUsername").prop("disabled", false);
                $("#btnRegisterUsername").html("Selanjutnya");
            }, 2000);
        },
        success: function (response) {
            if (response.status === true) {
                setTimeout(function () {
                    $("#formRegisterUsername").addClass("d-none");
                    $("#formRegisterPassword").removeClass("d-none");
                    $("input[name='id_user']").val(response.data.id_user);
                }, 500);
            }
        },
        error: function (error) {
            const message = error.responseJSON;
            Swal.fire({
                title: message,
                icon: "error",
                showConfirmButton: true,
            });
        },
    });
    return false;
});

$("#formRegisterPassword").submit(function (event) {
    $("#btnRegisterPassword").prop("disabled", true);
    $("#btnRegisterPassword").html("...Proses");
    event.preventDefault();
    formData = new FormData($(this)[0]);

    $.ajax({
        url: "/lupa_password_update_pass",
        type: "POST",
        data: formData,
        async: false,
        cache: false,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Memeriksa...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });
        },
        complete: function () {
            setTimeout(function () {
                Swal.close();
            }, 2000);
        },
        success: function (response) {
            if (response.status === true) {
                // console.log(response);
                Swal.fire({
                    title: "Berhasil disimpan",
                    icon: "success",
                    showConfirmButton: true,
                });
                setTimeout(function () {
                    window.location.href = "/login";
                }, 2300);
            }
        },
        error: function (error) {
            const message = error.responseJSON;
            Swal.fire({
                title: message,
                icon: "error",
                showConfirmButton: true,
            });
        },
    });
    return false;
});
