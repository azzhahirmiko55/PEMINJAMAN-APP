$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#id-tanggal-peminjaman").datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        endDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000)  // Tomorrow's date
    });

    loadCalendar();
});

$('#id-kendaraan').select2({
    placeholder: '- Pilih Kendaraan -',
    // allowClear: true,
    ajax: {
        type: 'GET',
        url: '/selectKendaraan',
        data: function (params) {
            return {
                search: params.term,
                page: params.page || 1,
                jenis_kendaraan: $("input[name='jenis_kendaraan']:checked").val(),
                tanggal: $("#id-tanggal-peminjaman").val()
            };
        },
        delay: 500
    }
});

$('#id-karyawan').select2({
    placeholder: '- Pilih Karyawan -',
    // allowClear: true,
    ajax: {
        type: 'GET',
        url: '/selectKaryawan',
        data: function (params) {
            return {
                search: params.term,
                page: params.page || 1,
            };
        },
        delay: 500
    }
});

$('#id-driver').select2({
    placeholder: '- Pilih Driver -',
    // allowClear: true,
    ajax: {
        type: 'GET',
        url: '/selectKaryawan',
        data: function (params) {
            return {
                search: params.term,
                page: params.page || 1,
            };
        },
        delay: 500
    }
});

const clearFormPeminjaman = () => {
    $('#form-peminjaman').trigger('reset');
    $('#id-peminjaman').val('');
}

const showFormPeminjaman = () => {
    clearFormPeminjaman();
    $('#modal-peminjaman').modal('show');
}

const hideModalPeminjaman = () => {
    $('#modal-peminjaman').modal('hide');
}

const clearPreviewPeminjaman = () => {
    $('#preview-peminjaman-header').removeClass().addClass('modal-header');
    $('#preview-peminjaman-title').text('');
    $('#preview-tanggal-peminjaman').text('');
    $('#preview-peminjam').text('');
    $('#preview-driver').text('');
    $('#preview-keperluan').text('');
    $('#id-peminjaman-preview').val('');
}

const showPreviewPeminjaman = (id_peminjaman) => {
    $.ajax({
        type: 'GET',
        url: '/gtPeminjamanKendaraan',
        data: { id: id_peminjaman },
        dataType: 'JSON',
        cache: false,
        success: function (response) {
            clearPreviewPeminjaman();

            $('#modal-preview-peminjaman').modal('show');

            $('#id-peminjaman-preview').val(response.id);
            $('#preview-peminjaman-header').addClass(response.warna);
            $('#preview-peminjaman-title').text(response.ket_kendaraan);
            $('#preview-tanggal-peminjaman').text(response.convert_tanggal);
            $('#preview-peminjam').text(response.peminjam);
            $('#preview-driver').text(response.driver);
            $('#preview-keperluan').text(response.keperluan);
        },
        error: function () {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load peminjaman preview!',
                icon: 'error',
            });
        }
    });
}

const loadCalendar = () => {

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'local',
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'title prev,next',
            center: null,
            right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '/gtCalendarPeminjamanKendaraan',
        height: 800,
        eventRender: [],
        contentHeight: 780,
        aspectRatio: 3,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 2
            }
        },
        dayRender: function (date, cell) {
            var tomorrow = moment().add(1, 'days');
            if (moment(date).isAfter(tomorrow, 'day')) {
                $(cell).addClass('disabled');
            }
        },
        selectable: true,
        select: function (res) {
            let currentDate = moment().format('YYYY-MM-DD');
            let tomorrow = moment().add(1, 'days').format('YYYY-MM-DD');

            if (res.startStr < currentDate) {
                Swal.fire({
                    title: "Perhatian!",
                    text: "Tidak boleh meminjam kendaraan kurang dari tanggal saat ini!",
                    icon: "warning"
                });
            } else if (res.startStr > tomorrow) {
                Swal.fire({
                    title: "Perhatian!",
                    text: "Peminjaman hanya boleh dilakukan sehari sebelum tanggal pinjam!",
                    icon: "warning"
                });
            } else {
                $('#modal-peminjaman').modal('show');
                $('#id-tanggal-peminjaman').val(res.startStr);
            }
        },
        eventClick: function (res) {
            showPreviewPeminjaman(res.event._def.publicId);
        }
    });
    calendar.render();
}

$('#form-peminjaman').submit(function (event) {
    $('#btn-simpan-peminjaman').prop('disabled', true);
    event.preventDefault();
    let formData = new FormData($(this)[0]);
    $.ajax({
        url: "/processPinjamKendaraan",
        type: "post",
        data: formData,
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
            Swal.fire({
                icon: 'success',
                title: response.message,
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                onAfterClose: () => {
                    $('#modal-peminjaman').modal('hide');
                    clearFormPeminjaman();  // Clear the form after success
                }
            });
            loadCalendar();
            $('#btn-simpan-peminjaman').prop('disabled', false);
        },
        error: function (error) {
            Swal.fire({
                title: 'Terjadi kesalahan saat menyimpan data!',
                text: error.responseText,
                icon: 'error',
                showConfirmButton: false
            });
            $('#btn-simpan-peminjaman').prop('disabled', false);
        }
    });
    return false;
});

