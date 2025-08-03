<form action="#" id="formRuangan" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label">Nama Ruangan</label>
            <input type="text" class="form-control" name="id_ruangrapat" value="{{ $dRuangan->id_ruangrapat??'' }}"
                hidden>
            <input type="text" class="form-control" placeholder="Masukkan Nama Ruangan" name="nama_ruangan"
                value="{{ $dRuangan->nama_ruangan??'' }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Warna Ruangan</label>
            <input type="text" class="form-control" placeholder="Masukkan Warna Ruangan" name="warna_ruangan"
                value="{{ $dRuangan->warna_ruangan??'' }}">
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

        $("#formRuangan").submit(function (event) {
            $("#btnSubmit").prop("disabled", true);
            $("#btnSubmit").html("...Memproses");
            event.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const idRuangan = form.find('input[name="id_ruangrapat"]').val() || 'add';

            const url = "{{ route('ruangan.update', ':id') }}".replace(':id', idRuangan); // Selalu arahkan ke update route
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

                    $("#formRuangan .text-danger").html("");

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
