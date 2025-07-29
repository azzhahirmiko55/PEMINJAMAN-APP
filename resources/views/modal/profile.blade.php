<form action="#" id="formProfile" method="POST" class="form-validate is-alter">
    <div class="modal-body">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" placeholder="Masukkan Username" name="username"
                value="{{ $user->username }}" disabled>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="nama_pegawai"
                value="{{ $user->nama_pegawai }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Masukkan Password" name="password">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Ulangi Password</label>
            <input type="password" class="form-control" placeholder="Ulangi Password" name="password_confirmation">
            <div class="text-danger"></div>
        </div>
        <div class="d-flex mt-1 justify-content-between">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnProfile">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });

        $("#formProfile").submit(function (event) {
            $("#btnProfile").prop("disabled", true);
            $("#btnProfile").html("...Memproses");
            event.preventDefault();
            formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ route('profile.update') }}",
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
                    Swal.close();
                },
                success: function (response) {
                    if (response.success === true) {
                        hideAllModals();
                        refreshContent();
                        toastr.success(response.message, 'Sukses');
                    }
                },
                error: function (error) {
                const errors = error.responseJSON.errors;

                    $("#formProfile .text-danger").html("");

                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            const message = errors[field][0];
                            const input = $(`[name="${field}"]`);
                            input.addClass("is-invalid");
                            input
                                .closest(".form-group")
                                .find(".text-danger")
                                .html(message);
                        }
                    }
                    $("#btnProfile").prop("disabled", false);
                    $("#btnProfile").html("Simpan");

                },
            });
            return false;
        });

</script>
