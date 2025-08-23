<div class="row">
    {{-- Sesi Kendaraan --}}
    <div class="col-md-6 border-end border-gray">
        <form action="#" id="formPegawaiPeminjamanKendaraan" method="POST" class="form-validate is-alter"
            enctype="multipart/form-data">
            <div class="d-flex align-items-center m-2 w-100">
                <h4 class="modal-title mb-0 me-2">Kendaraan</h4>

                @if (isset($dPegawaiPeminjamanKendaraan->id_peminjaman))
                @php
                $status = $dPegawaiPeminjamanKendaraan->status ?? 0;
                $badgeColor = 'secondary';
                $badgeText = 'Tidak Diketahui';
                $badgeIcon = '❓';

                if ($status == 0) {
                $badgeColor = 'warning';
                $badgeText = 'Proses';
                $badgeIcon = '<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                    <use xlink:href="#reload"></use>
                </svg>';
                } elseif ($status == 1) {
                $badgeColor = 'success';
                $badgeText = 'Diterima';
                $badgeIcon = '<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                    <use xlink:href="#x"></use>
                </svg>';
                } elseif ($status == -1) {
                $badgeColor = 'danger';
                $badgeText = 'Ditolak';
                $badgeIcon = '<svg class="pc-icon" style="width:14px; height:14px; fill:currentColor;">
                    <use xlink:href="#check"></use>
                </svg>';
                }
                @endphp

                <div class="d-flex flex-column align-items-end ms-auto">
                    <span class="badge bg-{{ $badgeColor }} mb-1" style="font-size:0.8rem;">
                        {!! $badgeIcon !!} {{ $badgeText }}
                    </span>

                    <a href="#" class="btn btn-danger d-inline-flex align-items-center btn-sm btn-youtube js-delete"
                        data-url="{{ route('pegawai-peminjaman.destroy', $dPegawaiPeminjamanKendaraan->id_peminjaman) }}">
                        <svg class="pc-icon me-1">
                            <use xlink:href="#delete"></use>
                        </svg>
                        Batalkan
                    </a>
                </div>
                @endif
            </div>

            <div class="modal-body">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" name="id_peminjaman"
                        value="{{ $dPegawaiPeminjamanKendaraan->id_peminjaman??'' }}" hidden>
                    <input type="text" class="form-control" name="id_peminjam"
                        value="{{ $dPegawaiPeminjamanKendaraan->id_peminjam??$user->id_pegawai }}" hidden>
                    <input type="text" class="form-control" name="tipe_peminjaman"
                        value="{{ $dPegawaiPeminjamanKendaraan->tipe_peminjaman??'kendaraan' }}" hidden>
                    <input type="text" class="form-control" value="{{ $user->nama_pegawai }}" disabled>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Kendaraan </label>
                    <select class="form-select" aria-label="Default select example" name="id_kendaraan">
                        <option value='' selected>-- Pilih Kendaraan --</option>
                        @foreach ($dKendaraan as $item)
                        <option value="{{ $item->id_kendaraan }}" {{ $item->id_kendaraan ===
                            (!empty($dPegawaiPeminjamanKendaraan)?$dPegawaiPeminjamanKendaraan->id_kendaraan:'')
                            ?'selected':''}}>
                            {{ $item->no_plat }} - {{ $item->keterangan }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control"
                        value="{{ $dPegawaiPeminjamanKendaraan->tanggal??$tanggal_calendar }}" name="tanggal" readonly>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label class="form-label">Jam Mulai </label>
                        <input type="text" class="form-control " id="jam_mulai_kendaraan" name="jam_mulai" required
                            value="{{ !empty($dPegawaiPeminjamanKendaraan->jam_mulai)
                                        ? Carbon::parse($dPegawaiPeminjamanKendaraan->jam_mulai)->format('H:i')
                                        : '' }}" required>
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Jam Selesai</label>
                        <input type="text" class="form-control" id="jam_selesai_kendaraan" name="jam_selesai" required
                            value="{{ !empty($dPegawaiPeminjamanKendaraan->jam_selesai)
                                        ? Carbon::parse($dPegawaiPeminjamanKendaraan->jam_selesai)->format('H:i')
                                        : '' }}" required>
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Driver</label>
                    <input type="text" class="form-control" value="{{ $dPegawaiPeminjamanKendaraan->driver??'' }}"
                        name="driver">
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Keperluan</label>
                    <textarea class="form-control" name="keperluan" cols="30"
                        rows="5">{{ $dPegawaiPeminjamanKendaraan->keperluan??'' }}</textarea>
                    <div class="text-danger"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg class="pc-icon">
                        <use xlink:href="#save"></use>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
    {{-- Sesi Ruangan --}}
    <div class="col-md-6">
        <form action="#" id="formPegawaiPeminjamanRuangan" method="POST" class="form-validate is-alter"
            enctype="multipart/form-data">
            <div class="d-flex align-items-center m-2">
                <h4 class="modal-title m-2">Ruangan</h4>
                @if (isset($dPegawaiPeminjamanRuangan->id_peminjaman))
                <a href="#" class="btn btn-danger ms-auto d-inline-flex align-items-center btn-sm btn-youtube js-delete"
                    data-url="{{ route('pegawai-peminjaman.destroy', $dPegawaiPeminjamanRuangan->id_peminjaman) }}">
                    <svg class="pc-icon me-1">
                        <use xlink:href="#delete"></use>
                    </svg>
                    Batalkan
                </a>
                @endif
            </div>
            <div class="modal-body">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" name="id_peminjaman"
                        value="{{ $dPegawaiPeminjamanRuangan->id_peminjaman??'' }}" hidden>
                    <input type="text" class="form-control" name="id_peminjam"
                        value="{{ $dPegawaiPeminjamanRuangan->id_peminjam??$user->id_pegawai }}" hidden>
                    <input type="text" class="form-control" name="tipe_peminjaman"
                        value="{{ $dPegawaiPeminjamanRuangan->tipe_peminjaman??'ruangan' }}" hidden>
                    <input type="text" class="form-control" value="{{ $user->nama_pegawai }}" disabled>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Ruangan </label>
                    <select class="form-select" aria-label="Default select example" name="id_ruangan">
                        <option value='' selected>-- Pilih Ruangan --</option>
                        @foreach ($dRuangan as $ruangan)
                        <option value="{{ $ruangan->id_ruangrapat }}" {{ $ruangan->id_ruangrapat ===
                            (!empty($dPegawaiPeminjamanRuangan)?$dPegawaiPeminjamanRuangan->id_ruangan:'')
                            ?'selected':''}}>
                            {{ $ruangan->nama_ruangan }} - {{ $ruangan->warna_ruangan }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control"
                        value="{{ $dPegawaiPeminjamanRuangan->tanggal??$tanggal_calendar }}" name="tanggal" readonly>
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label class="form-label">Jam Mulai </label>
                        <input type="text" class="form-control" id="jam_mulai_ruangan" name="jam_mulai" required value="{{ !empty($dPegawaiPeminjamanRuangan->jam_mulai)
                                        ? Carbon::parse($dPegawaiPeminjamanRuangan->jam_mulai)->format('H:i')
                                        : '' }}" required>
                        <div class="text-danger"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Jam Selesai</label>
                        <input type="text" class="form-control" id="jam_selesai_ruangan" name="jam_selesai" required
                            value="{{ !empty($dPegawaiPeminjamanRuangan->jam_selesai)
                                        ? Carbon::parse($dPegawaiPeminjamanRuangan->jam_selesai)->format('H:i')
                                        : '' }}" required>
                        <div class="text-danger"></div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Jumlah Peserta</label>
                    <input type="number" class="form-control"
                        value="{{ $dPegawaiPeminjamanRuangan->jumlah_peserta??'' }}" name="jumlah_peserta"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <div class="text-danger"></div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Keperluan</label>
                    <textarea class="form-control" name="keperluan" cols="30"
                        rows="5">{{ $dPegawaiPeminjamanRuangan->keperluan??'' }}</textarea>
                    <div class="text-danger"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg class="pc-icon">
                        <use xlink:href="#save"></use>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        // Saat tipe_peminjaman berubah
        $(document).on('change', 'input[name="tipe_peminjaman"]', function () {
            let tipe = $(this).val(); // 0 atau 1
        });

    });

    $("#formPegawaiPeminjamanKendaraan").submit(function (event) {
        $("#btnSubmit").prop("disabled", true);
        $("#btnSubmit").html("...Memproses");
        event.preventDefault();
        const form = $(this);
        const formData = new FormData(this);
        const idPeminjaman = form.find('input[name="id_peminjaman"]').val() || 'add';

        const url = "{{ route('pegawai-peminjaman.update', ':id') }}".replace(':id', idPeminjaman); // Selalu arahkan ke update route
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
                    setTimeout(() => window.location.reload(), 1200);
                }
            },
            error: function (error) {
            const errors = error.responseJSON.errors;

                form.find(".text-danger").html("");
                form.find(".is-invalid").removeClass("is-invalid");

                for (const field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        const message = errors[field][0];
                        const input = form.find(`[name="${field}"]`);
                        input.addClass("is-invalid");
                        input.closest(".form-group").find(".text-danger").html(message);
                    }
                }
                $("#btnSubmit").prop("disabled", false);
                $("#btnSubmit").html("Simpan");

            },
        });
        return false;
    });

    $("#formPegawaiPeminjamanRuangan").submit(function (event) {
        $("#btnSubmit").prop("disabled", true);
        $("#btnSubmit").html("...Memproses");
        event.preventDefault();
        const form = $(this);
        const formData = new FormData(this);
        const idPeminjaman = form.find('input[name="id_peminjaman"]').val() || 'add';

        const url = "{{ route('pegawai-peminjaman.update', ':id') }}".replace(':id', idPeminjaman); // Selalu arahkan ke update route
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
                    setTimeout(() => window.location.reload(), 1200);
                }
            },
            error: function (error) {
            const errors = error.responseJSON.errors;

                form.find(".text-danger").html("");
                form.find(".is-invalid").removeClass("is-invalid");

                for (const field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        const message = errors[field][0];
                        const input = form.find(`[name="${field}"]`);
                        input.addClass("is-invalid");
                        input.closest(".form-group").find(".text-danger").html(message);
                    }
                }
                $("#btnSubmit").prop("disabled", false);
                $("#btnSubmit").html("Simpan");

            },
        });
        return false;
    });


    initTimePicker('#jam_mulai_kendaraan');
    initTimePicker('#jam_selesai_kendaraan');
    initTimePicker('#jam_mulai_ruangan');
    initTimePicker('#jam_selesai_ruangan');

$(document).on('click', '.js-delete', function(e) {
  e.preventDefault();
  const url   = $(this).data('url');

  Swal.fire({
    title: 'Hapus data ini?',
    text: 'Tindakan ini tidak bisa dibatalkan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal'
  }).then((res) => {
    if (!res.isConfirmed) return;

    $.ajax({
      url: url,
      type: 'POST',
      data: { _method: 'DELETE' },
      beforeSend: () => Swal.showLoading(),
      success: (resp) => {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: resp?.message || 'Data berhasil dihapus.',
          timer: 1500,
          showConfirmButton: false
        });
        setTimeout(() => location.reload(), 1200); // reload 1.2 detik
      },
      error: (xhr) => {
        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus.';
        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
      }
    });
  });
});


</script>
