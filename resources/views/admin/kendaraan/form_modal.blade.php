<form action="#" id="formKendaraan" method="POST" class="form-validate is-alter" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        <div class="form-group mb-3">
            <label class="form-label">Nomor Plat</label>
            <input type="text" class="form-control" name="id_kendaraan" value="{{ $dKendaraan->id_kendaraan??'' }}"
                hidden>
            <input type="text" class="form-control" placeholder="Masukkan Nomor Plat" name="no_plat"
                value="{{ $dKendaraan->no_plat??'' }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Jenis Kendaraan</label>
            <select class="form-select" aria-label="Default select example" name="jenis_kendaraan">
                <option value='' selected>-- Pilih Jenis --</option>
                <option value="Roda-2" {{ !empty($dKendaraan)?($dKendaraan->jenis_kendaraan == 'Roda-2'
                    ?'selected':''):''
                    }}>Roda-2</option>
                <option value="Roda-4" {{ !empty($dKendaraan)?($dKendaraan->jenis_kendaraan == 'Roda-4'
                    ?'selected':''):''
                    }}>Roda-4</option>
            </select>
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Warna Kendaraan</label>
            <input type="text" class="form-control" placeholder="Masukkan Warna Kendaraan" name="warna_kendaraan"
                value="{{ $dKendaraan->warna_kendaraan??'' }}">
            <div class="text-danger"></div>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan">{{ $dKendaraan->keterangan??'' }}</textarea>
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

        $("#formKendaraan").submit(function (event) {
            $("#btnSubmit").prop("disabled", true);
            $("#btnSubmit").html("...Memproses");
            event.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const idKendaraan = form.find('input[name="id_kendaraan"]').val() || 'add';

            const url = "{{ route('kendaraan.update', ':id') }}".replace(':id', idKendaraan); // Selalu arahkan ke update route
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

                    $("#formKendaraan .text-danger").html("");

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
