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
    $("#id-kendaraan").val(null).trigger("change");
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
        editable: true,
        droppable: true,
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
                    text: "Tidak boleh meminjam kendaraan kurang dari tanggal saat ini!",
                    icon: "warning"
                });
            } else {
                clearFormPeminjaman();
                $('#modal-peminjaman').modal('show'); 
                $('#id-tanggal-peminjaman').val(res.startStr);
            }

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
                        url: "/processPindahPeminjaman",
                        type : "POST",
                        data :{
                            id: res.event._def.publicId,
                            days: res.delta.days,
                            eventtype: 'drop'
                        },
                        dataType : "json",
                        success: function(response) {
                            if(response.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: response.message,
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                loadCalendar();
                            }
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
            showPreviewPeminjaman(res.event._def.publicId);
        }
    });
    calendar.render();
}

const deletePeminjaman = () => {
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
                url: "/deletePeminjaman",
                type : "POST",
                data :{
                    id: $('#id-peminjaman-preview').val()
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
            $('#modal-preview-peminjaman').modal('show');
        }
    });
}

const editPeminjaman = () => {
    $.ajax({
        type: 'GET',
        url: '/gtPeminjamanKendaraan',
        data: {
            id: $('#id-peminjaman-preview').val()
        },
        dataType: 'JSON',
        async: false,
        cache: false,
        success: function (response) {
            $('#modal-preview-peminjaman').modal('hide');
            showFormPeminjaman();

            $('#id-peminjaman').val($('#id-peminjaman-preview').val());

            $('#id-peminjam').val(response.peminjam);
            $('#id-driver').val(response.driver);

            $('#id-tanggal-peminjaman').val(response.tanggal);
            $('#id-keperluan').val(response.keperluan);

            $('input.jen-ken[value="'+response.jenis+'"]').prop('checked', true);

            $("#id-kendaraan").val(null).trigger("change");
            $("#id-kendaraan").find('option').remove();
            $('#id-kendaraan').append(
                $('<option/>', {
                    value: response.id_kendaraan,
                    html: response.plat+' - '+response.keterangan,
                    selected: true
                })
            ).trigger('change');
            
        },
    });
}

$('#form-peminjaman').submit(function(event) {
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