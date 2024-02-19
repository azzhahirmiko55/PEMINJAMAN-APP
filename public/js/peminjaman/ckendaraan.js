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
    $('#preview-event-header').removeClass().addClass('modal-header');
    $('#preview-event-title').text('');
    $('#preview-event-start').text('');
    $('#preview-event-end').text('');
    $('#preview-event-description').text('');
    $('#id-peminjaman-preview').val('');
} 

const showPreviewPeminjaman = (id_peminjaman) => {
    $.ajax({
        type: 'GET',
        url: '/gtPeminjaman',
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
            $('#preview-event-header').addClass(response.warna);
            $('#preview-event-title').text(response.title);
            $('#preview-event-start').text(response.convert_start);
            $('#preview-event-end').text(response.convert_end);
            $('#preview-event-description').text(response.description);
            $('#preview-event-room').text(response.ruangan);
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
        events: '/gtCalendarPeminjaman',
        height: 800,
        eventRender: [], 
        contentHeight: 780,
        aspectRatio: 3,
        editable: true,
        droppable: true,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 2
            }
        },
        selectable: true,
        select: function (res) {
            $('#modalPenjadwalan').modal('show'); 
            $('#event-start-date').val(res.startStr);
            $('#event-end-date').val(res.endStr);
        },
        eventDrop: function (res) {
            // console.log(res);
            Swal.fire({
                title: 'Apakah Anda Yakin ?',
                text: "Anda akan memindahkan jadwal",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/processJadwal",
                        type : "POST",
                        data :{
                            id: res.event._def.publicId,
                            days: res.delta.days,
                            eventtype: 'drop'
                        },
                        dataType : "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
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
                } else {
                    loadCalendar();
                }
            });
        },
        eventClick: function (res) {
            showPreviewPenjadwalan(res.event._def.publicId);
        }
    });
    calendar.render();
}

const deleteJadwal = () => {
    $('#modalPreviewPenjadwalan').modal('hide');
    Swal.fire({
        title: 'Apakah Anda Yakin ?',
        text: "Anda akan menghapus jadwal",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/deleteJadwal",
                type : "POST",
                data :{
                    id: $('#idPenjadwalanPreview').val()
                },
                dataType : "json",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false
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
        } else {
            $('#modalPreviewPenjadwalan').modal('show');
        }
    });
}

const editJadwal = () => {
    $.ajax({
        type: 'GET',
        url: '/gtPenjadwalan',
        data: {
            id: $('#idPenjadwalanPreview').val()
        },
        dataType: 'JSON',
        async: false,
        cache: false,
        success: function (response) {
            $('#modalPreviewPenjadwalan').modal('hide');
            showFormPenjadwalan();

            $('#idPenjadwalan').val($('#idPenjadwalanPreview').val());

            $('#event-title').val(response.title);
            $('#event-description').val(response.description);

            $('#event-start-date').val(response.start_date);
            $('#event-start-time').val(response.start_time);
            $('#event-end-date').val(response.end_date);
            $('#event-end-time').val(response.end_time);

            $("#event-room").val(response.id_room).trigger("change");
            
            $('input.warna-checkbox[value="'+response.warna+'"]').prop('checked', true);
        
        },
    });
}

$('#formAddPenjadwalan').submit(function(event) {
    event.preventDefault();
    formData = new FormData($(this)[0]);
    $.ajax({
        url: "/processJadwal",
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
                onAfterClose: () => $('#modalPenjadwalan').modal('hide')
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