<form action="#" id="formPegawai" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="id_pegawai" value="{{ $dPegawai->id_pegawai??'' }}" hidden>
            <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap" name="nama_pegawai"
                value="{{ $dPegawai->nama_pegawai??'' }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Jabatan </label>
            <select class="form-select" aria-label="Default select example" name="jabatan">
                <option value='' selected>-- Pilih Jabatan --</option>
                <option value="Kasubag" {{ !empty($dPegawai)?($dPegawai->jabatan == 'Kasubag' ?'selected':''):''
                    }}>Kasubag</option>
                <option value="Staff TU" {{ !empty($dPegawai)?($dPegawai->jabatan == 'Staff TU' ?'selected':''):''
                    }}>Staff TU</option>
                <option value="Satpam" {{ !empty($dPegawai)?($dPegawai->jabatan == 'Satpam' ?'selected':''):'' }}>Satpam
                </option>
                <option value="Pegawai BPN" {{ !empty($dPegawai)?($dPegawai->jabatan == 'Pegawai BPN' ?'selected':''):''
                    }}>Pegawai BPN</option>
            </select>
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div class="ms-0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="1" name="jenis_kelamin" id="jenis_kelamin1"
                        {{!empty($dPegawai)?($dPegawai->jenis_kelamin == 1 ?'checked':''):''}}>
                    <label class="form-check-label" for="jenis_kelamin1">
                        Laki- laki
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" value="0" name="jenis_kelamin" id="jenis_kelamin2"
                        {{!empty($dPegawai)?($dPegawai->jenis_kelamin == 0?'checked':''):''}}>
                    <label class="form-check-label" for="jenis_kelamin2">
                        Perempuan
                    </label>
                </div>
            </div>
            <div class="text-danger"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
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

        $("#formPegawai").submit(function (event) {
            $("#btnSubmit").prop("disabled", true);
            $("#btnSubmit").html("...Memproses");
            event.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const idPegawai = form.find('input[name="id_pegawai"]').val() || 'add';

            const url = "{{ route('pegawai.update', ':id') }}".replace(':id', idPegawai); // Selalu arahkan ke update route
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

                    $("#formPegawai .text-danger").html("");

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
                    $("#btnSubmit").prop("disabled", false);
                    $("#btnSubmit").html("Simpan");

                },
            });
            return false;
        });

</script>
