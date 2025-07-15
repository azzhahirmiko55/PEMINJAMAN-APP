$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#id-tanggal-peminjaman").datepicker({
        format : 'yyyy-mm-dd',
        startDate: new Date()
    });

    $("#event-start-time").timepicker({
      timeFormat: 'HH:mm:ss'
    });

    $("#event-end-time").timepicker({
      timeFormat: 'HH:mm:ss'
    });

    loadCalendar();
});

$('#id-ruangrapat').select2({
    placeholder: '- Pilih Ruang Rapat -',
    ajax: {
        type: 'GET',
        url: '/selectRuangRapat',
        data: function(params) {
            let query = {};
            if($('#event-start-time').val() && $('#event-end-time').val()){
                query = {
                    search: params.term,
                    page: params.page || 1,
                    tanggal : $('#id-tanggal-peminjaman').val(),
                    start_time: $('#event-start-time').val(),
                    end_time: $('#event-end-time').val()
                }
            } else {
                alert('Silahkan input tanggal & jam mulai dan tanggal & jam selesai peminjaman');
            }
            return query;
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
    $('#preview-jam-mulai').text('');
    $('#preview-jam-selesai').text('');
    $('#preview-peminjam').text('');
    $('#preview-driver').text('');
    $('#preview-keperluan').text('');
    $('#id-peminjaman-preview').val('');
}

const showPreviewPeminjaman = (id_peminjaman) => {
    $.ajax({
        type: 'GET',
        url: '/gtPeminjamanRuangrapat',
        data: {
            id: id_peminjaman
        },
        dataType: 'JSON',
        cache: false,
        success: function (response) {
            clearPreviewPeminjaman();

            $('#modal-preview-peminjaman').modal('show');

            $('#id-peminjaman-preview').val(response.id);
            $('#preview-peminjaman-header').addClass(response.warna);
            $('#preview-peminjaman-title').text(response.ruangan);
            $('#preview-tanggal-peminjaman').text(response.convert_tanggal);
            $('#preview-jam-mulai').text(response.jam_mulai);
            $('#preview-jam-selesai').text(response.jam_selesai);
            $('#preview-peminjam').text(response.peminjam);
            $('#preview-jumlah').text(response.jumlah_peserta);
            $('#preview-keperluan').text(response.keperluan);
        },
    });
}

const loadCalendar = () => {

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'local',
        initialView : 'dayGridMonth',
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'title prev,next',
            center: null,
            right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: '/gtCalendarPeminjamanRuangrapat',
        height: 800,
        contentHeight: 780,
        aspectRatio: 3,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 2
            }
        },
        selectable: true,
        select: function (res) {
            let currentDate = new Date().toJSON().slice(0, 10);

            if(res.startStr < currentDate){
                Swal.fire({
                    title: "Perhatian!",
                    text: "Tidak boleh meminjam ruangan kurang dari tanggal saat ini!",
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

$('#form-peminjaman').submit(function(event) {
    event.preventDefault();
    formData = new FormData($(this)[0]);
    $.ajax({
        url: "/processPinjamRuangrapat",
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
                onAfterClose: function () {
                    $('#modal-peminjaman').modal('hide');
                    clearFormPeminjaman();  // Clear the form after success
                }
            });
            loadCalendar();
        },
        error: function (error) {
            Swal.fire({
                title: 'Terjadi kesalahan saat menyimpan data!',
                text: error.responseText,
                icon: 'error',
                showConfirmButton: false
            });
        }
  });
  return false;
});
