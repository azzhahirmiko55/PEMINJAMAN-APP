$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#id-tanggal-peminjaman").datepicker({
        format : 'yyyy-mm-dd',
        startDate: new Date(),
        endDate: '+1d'
    });
  
    loadCalendar();
});

$('#id-kendaraan').select2({
    placeholder: '- Pilih Kendaraan -',
    // allowClear: true,
    ajax: {
        type: 'GET',
        url: '/selectKendaraan',
        data: function(params) {
            let query = {
                search: params.term,
                page: params.page || 1,
                jenis_kendaraan: $("input[name='jenis_kendaraan']:checked").val(),
                tanggal: $("#id-tanggal-peminjaman").val()
            }

            return query;
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
        data: {
            id: id_peminjaman
        },
        dataType: 'JSON',
        async: false,
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
        dayRender: function(date, cell){
            var tomorrow = new Date.today().addDays(1).toString("dd-mm-yyyy"); 
            if (date > tomorrow){
                $(cell).addClass('disabled');
            }
        },
        selectable: true,
        select: function (res) {
            let currentDate = new Date().toJSON().slice(0, 10);

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            let format_tomorrow = tomorrow.toJSON().slice(0, 10);

            // console.log(format_tomorrow);

            if(res.startStr < currentDate){
                Swal.fire({
                    title: "Perhatian!",
                    text: "Tidak boleh meminjam kendaraan kurang dari tanggal saat ini!",
                    icon: "warning"
                });
            } else {
                if(res.startStr > format_tomorrow){
                    Swal.fire({
                        title: "Perhatian!",
                        text: "Peminjaman hanya boleh dilakukan sehari sebelum tanggal pinjam!",
                        icon: "warning"
                    });
                } else {
                    $('#modal-peminjaman').modal('show'); 
                    $('#id-tanggal-peminjaman').val(res.startStr);
                }
            }

        },
        eventClick: function (res) {
            showPreviewPeminjaman(res.event._def.publicId);
        }
    });
    calendar.render();
}

$('#form-peminjaman').submit(function(event) {
    $('#btn-simpan-peminjaman').prop('disabled', true);
    event.preventDefault();
    formData = new FormData($(this)[0]);
    $.ajax({
        url: "/processPinjamKendaraan",
        type: "post",
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
            Swal.fire({
                icon: 'success',
                title: response.message,
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                onAfterClose: () => $('#modal-peminjaman').modal('hide')
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