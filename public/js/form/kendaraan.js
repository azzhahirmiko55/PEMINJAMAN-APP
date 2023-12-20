$(document).ready(function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#inputTanggal').datepicker({
        format : 'yyyy-mm-dd'
    });
});

$('#inputKendaraan').select2({
    placeholder: '- Pilih Kendaraan -',
    // allowClear: true,
    ajax: {
        type: 'GET',
        url: '/selectKendaraan',
        data: function(params) {
            let query = {
                search: params.term,
                page: params.page || 1,
                jenis_kendaraan: $("input[name='jenis_kendaraan']:checked").val()
            }

            return query;
        },
        delay: 500
    }
});