<form action="#" id="formUser" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="id_user" value="{{ $dUser->id_user??'' }}" hidden>
            <input type="text" class="form-control" placeholder="Masukkan Username" name="username"
                value="{{ $dUser->username??'' }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Pegawai </label>
            <select class="form-select" aria-label="Default select example" name="id_pegawai">
                <option value='' selected>-- Pilih Pegawai --</option>
                @foreach ($dPegawai as $item)
                <option value="{{ $item->id_pegawai }}" {{ $item->id_pegawai == (!empty($dUser)?$dUser->id_pegawai:'')
                    ?'selected':''}}>
                    {{ $item->nama_pegawai }}</option>
                @endforeach
            </select>
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" aria-label="Default select example" name="role">
                <option value='' selected>-- Pilih Role --</option>
                <option value="0" {{ !empty($dUser)?($dUser->role == 0 ?'selected':''):'' }}>Admin</option>
                <option value="1" {{ !empty($dUser)?($dUser->role == 1 ?'selected':''):'' }}>Kasubag</option>
                <option value="2" {{ !empty($dUser)?($dUser->role == 2 ?'selected':''):'' }}>Staff TU</option>
                <option value="3" {{ !empty($dUser)?($dUser->role == 3 ?'selected':''):'' }}>Satpam</option>
                <option value="4" {{ !empty($dUser)?($dUser->role == 4 ?'selected':''):'' }}>Pegawai BPN</option>
            </select>
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
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnUser">Simpan</button>
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

        $("#formUser").submit(function (event) {
            $("#btnUser").prop("disabled", true);
            $("#btnUser").html("...Memproses");
            event.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const idUser = form.find('input[name="id_user"]').val() || 'add';

            const url = "{{ route('user.update', ':id') }}".replace(':id', idUser); // Selalu arahkan ke update route
            formData.append('_method', 'PUT'); // spoof method PUT

            $.ajax({
                url: url,
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

                    $("#formUser .text-danger").html("");

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
                    $("#btnUser").prop("disabled", false);
                    $("#btnUser").html("Simpan");

                },
            });
            return false;
        });

</script>
