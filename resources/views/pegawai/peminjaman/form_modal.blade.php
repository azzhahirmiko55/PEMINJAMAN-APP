<div class="row">
    @if ($type=='kendaraan')
    {{-- Sesi Kendaraan --}}
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
    <div class="col-md-12 ">
        @if(($dPegawaiPeminjamanKendaraan->status ?? 0) == -1 &&
        !empty($dPegawaiPeminjamanKendaraan->verifikator_catatan))
        <div class="small text-danger d-flex align-items-center gap-2 m-2">
            <svg class="pc-icon" style="width:14px;height:14px;">
                <use xlink:href="#alert"></use>
            </svg>
            <span>
                <strong>Alasan:</strong>
                {{ $dPegawaiPeminjamanKendaraan->verifikator_catatan??'' }}
            </span>
        </div>
        @endif
        <form action="#" id="formPegawaiPeminjamanKendaraan" method="POST" class="form-validate is-alter"
            enctype="multipart/form-data">
            <div class="d-flex justify-content-end align-items-center m-2 gap-2">
                <div class="d-flex align-items-end gap-2">
                    <a class="btn btn-success btn-sm d-inline-flex align-items-center" href="#!" data-modal
                        data-title="Cek Ketersediaan"
                        data-url="{{ url('/getKetersediaan/kendaraan/'.$tanggal_calendar) }}">
                        <i class="fas fa-list me-1"></i> Cek Ketersediaan
                    </a>

                    @if (isset($dPegawaiPeminjamanKendaraan->id_peminjaman))
                    <span class="badge bg-{{ $badgeColor }}" style="font-size:0.8rem;">
                        {!! $badgeIcon !!} {{ $badgeText }}
                    </span>

                    <a href="#" class="btn btn-danger btn-sm d-inline-flex align-items-center js-delete"
                        data-url="{{ route('pegawai-peminjaman.destroy', $dPegawaiPeminjamanKendaraan->id_peminjaman) }}">
                        <svg class="pc-icon me-1">
                            <use xlink:href="#delete"></use>
                        </svg>
                        Batalkan
                    </a>
                    @endif
                </div>
            </div>

            <h4 class="modal-title mb-0 mx-3">Kendaraan</h4>

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
                            ($dPegawaiPeminjamanKendaraan->id_kendaraan??'')
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
                {{-- <div class="form-group mb-3">
                    <label class="form-label">Keperluan BBM</label>
                    <textarea class="form-control" name="keperluan_bbm" cols="10"
                        rows="2">{{ $dPegawaiPeminjamanKendaraan->keperluan_bbm??'' }}</textarea>
                    <div class="text-danger"></div>
                </div> --}}
                @php
                $opsi = [
                'Ukur dan Survey Tanah',
                'Cek Keadaan Tanah',
                'Menghadiri dari Dinas terkait',
                ];
                $keperluanAwal = old('keperluan', $dPegawaiPeminjamanKendaraan->keperluan ?? '');
                $isPreset = in_array($keperluanAwal, $opsi, true);
                @endphp

                <div class="form-group mb-3">
                    <label class="form-label">Keperluan</label>

                    {{-- Radio options --}}
                    <div class="d-flex flex-column gap-1">
                        @foreach ($opsi as $label)
                        <label class="form-check">
                            <input class="form-check-input keperluan-radio" type="radio" name="keperluan_option"
                                value="{{ $label }}" {{ $isPreset && $keperluanAwal===$label ? 'checked' : '' }}>
                            <span class="form-check-label">{{ $label }}</span>
                        </label>
                        @endforeach

                        <label class="form-check">
                            <input class="form-check-input keperluan-radio" type="radio" name="keperluan_option"
                                value="__LAIN__" {{ !$isPreset && $keperluanAwal !=='' ? 'checked' : '' }}>
                            <span class="form-check-label">Lain-lain</span>
                        </label>
                    </div>

                    {{-- Textarea untuk 'Lain-lain' --}}
                    <div id="wrap-keperluan-lain" class="mt-2" {{--
                        style="{{ ($isPreset || $keperluanAwal==='') ? 'display:none' : '' }}" --}}>
                        <textarea class="form-control" id="keperluan_lain" rows="4" name="keperluan_lain"
                            placeholder="Tuliskan keperluan lainnya...">{{ !$isPreset ? $keperluanAwal : '' }}</textarea>
                    </div>

                    {{-- Hidden final value yang dikirim ke server --}}
                    <input type="hidden" name="keperluan" id="keperluan_final"
                        value="{{ $isPreset ? $keperluanAwal : (!$keperluanAwal ? '' : $keperluanAwal) }}">

                    {{-- pesan error (opsional, jika pakai validasi server-side) --}}
                    @error('keperluan_option')
                    <div class="text-danger">{{ $message }}</div>
                    @else
                    <div class="text-danger"></div>
                    @enderror

                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Detail Lokasi</label>
                    <textarea class="form-control" name="detail_lokasi" cols="10"
                        rows="2">{{ $dPegawaiPeminjamanKendaraan->detail_lokasi??'' }}</textarea>
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
    @else
    {{-- Sesi Ruangan --}}
    @php
    $status = $dPegawaiPeminjamanRuangan->status ?? 0;
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
    <div class="col-md-12 ">
        @if(($dPegawaiPeminjamanRuangan->status ?? 0) == -1 && !empty($dPegawaiPeminjamanRuangan->verifikator_catatan))
        <div class="small text-danger d-flex align-items-center gap-2 m-2">
            <svg class="pc-icon" style="width:14px;height:14px;">
                <use xlink:href="#alert"></use>
            </svg>
            <span>
                <strong>Alasan:</strong>
                {{ $dPegawaiPeminjamanRuangan->verifikator_catatan??'' }}
            </span>
        </div>
        @endif

        <form action="#" id="formPegawaiPeminjamanRuangan" method="POST" class="form-validate is-alter"
            enctype="multipart/form-data">
            <div class="d-flex justify-content-end align-items-center m-2 gap-2">
                <a class="btn btn-success btn-sm text-white d-inline-flex align-items-center" href="#!" data-modal
                    data-title="Cek Ketersediaan" data-url="{{ url('/getKetersediaan/ruangan/'.$tanggal_calendar) }}">
                    <i class="fas fa-list me-1"></i> Cek Ketersediaan
                </a>

                @if (isset($dPegawaiPeminjamanRuangan->id_peminjaman))
                <a href="#" class="btn btn-danger btn-sm d-inline-flex align-items-center js-delete"
                    data-url="{{ route('pegawai-peminjaman.destroy', $dPegawaiPeminjamanRuangan->id_peminjaman) }}">
                    <svg class="pc-icon me-1">
                        <use xlink:href="#delete"></use>
                    </svg>
                    Batalkan
                </a>
                <div>

                </div>
                <span class="badge bg-{{ $badgeColor }}" style="font-size:0.8rem;">
                    {!! $badgeIcon !!} {{ $badgeText }}
                </span>
                @endif
            </div>

            <br>
            <h4 class="modal-title mb-0 mx-2">Ruangan</h4>
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
                        value="{{ $dPegawaiPeminjamanRuangan->jumlah_peserta??0 }}" name="jumlah_peserta" min="1"
                        max="100" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <div class="text-danger"></div>
                </div>
                @php
                $opsi1 = [
                'Rapat Tim Divisi',
                'Sosialisasi',
                'Forum Koordinasi',
                'Pelatihan dan Diklat',
                ];
                $keperluanAwal1 = old('keperluan', $dPegawaiPeminjamanRuangan->keperluan ?? '');
                $isPreset1 = in_array($keperluanAwal1, $opsi1, true);
                @endphp

                <div class="form-group mb-3">
                    <label class="form-label">Keperluan</label>

                    {{-- Radio options --}}
                    <div class="d-flex flex-column gap-1">
                        @foreach ($opsi1 as $label)
                        <label class="form-check">
                            <input class="form-check-input keperluan-radio" type="radio" name="keperluan_option"
                                value="{{ $label }}" {{ $isPreset1 && $keperluanAwal1===$label ? 'checked' : '' }}>
                            <span class="form-check-label">{{ $label }}</span>
                        </label>
                        @endforeach

                        <label class="form-check">
                            <input class="form-check-input keperluan-radio" type="radio" name="keperluan_option"
                                value="__LAIN__" {{ !$isPreset1 && $keperluanAwal1 !=='' ? 'checked' : '' }}>
                            <span class="form-check-label">Lain-lain</span>
                        </label>
                    </div>

                    {{-- Textarea untuk 'Lain-lain' --}}
                    <div id="wrap-keperluan-lain" class="mt-2" {{--
                        style="{{ ($isPreset1 || $keperluanAwal1==='') ? 'display:none' : '' }}" --}}>
                        <textarea class="form-control" id="keperluan_lain" rows="4" name="keperluan_lain"
                            placeholder="Tuliskan keperluan lainnya...">{{ !$isPreset1 ? $keperluanAwal1 : '' }}</textarea>
                    </div>

                    {{-- Hidden final value yang dikirim ke server --}}
                    <input type="hidden" name="keperluan" id="keperluan_final"
                        value="{{ $isPreset1 ? $keperluanAwal1 : (!$keperluanAwal1 ? '' : $keperluanAwal1) }}">

                    {{-- pesan error (opsional, jika pakai validasi server-side) --}}
                    @error('keperluan_option')
                    <div class="text-danger">{{ $message }}</div>
                    @else
                    <div class="text-danger"></div>
                    @enderror
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
    @endif
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

document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('.keperluan-radio');
    const wrapLain = document.getElementById('wrap-keperluan-lain');
    const txtLain  = document.getElementById('keperluan_lain');
    const finalInp = document.getElementById('keperluan_final');

    function syncFinal() {
        const checked = document.querySelector('.keperluan-radio:checked');
        if (!checked) return;
        if (checked.value === '__LAIN__') {
            wrapLain.style.display = '';
            txtLain.setAttribute('required', 'required');
            finalInp.value = (txtLain.value || '').trim();
        } else {
            wrapLain.style.display = 'none';
            txtLain.removeAttribute('required');
            finalInp.value = checked.value;
        }
    }

    radios.forEach(r => r.addEventListener('change', syncFinal));
    if (txtLain) txtLain.addEventListener('input', function () {
        const checked = document.querySelector('.keperluan-radio:checked');
        if (checked && checked.value === '__LAIN__') {
            finalInp.value = (txtLain.value || '').trim();
        }
    });

    syncFinal();
});
</script>
