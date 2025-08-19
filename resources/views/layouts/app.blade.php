<!DOCTYPE html>
<html lang="en">

<head>
    <title>Peminjaman App | {{ isset($page) ? $page : "Page"; }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{asset('/assets/images/Logo_BPN.png') }}" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('/assets/css/style-preset.css') }}">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- FullCalendar Core + Bootstrap Theme -->
    <script src=" https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js "></script>

    {{-- Flat Picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .swal2-container {
            z-index: 2000 !important;
        }

        .fc-day-today {
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 4px;
        }

        .fc-hoverable:hover {
            background-color: rgba(13, 110, 253, 0.05);
            cursor: pointer;
        }
    </style>



</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- sidebar @s -->
    @include('partials.sidebar')
    <!-- sidebar @s -->
    <!-- topbar @s -->
    @include('partials.topbar')
    <!-- topbar @s -->
    <div class="content" id="content">
        <div class="pc-container">
            <div class="pc-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">{{ isset($page) ? $page : "Page"; }}</h5>
                                </div>
                                <ul class="breadcrumb">
                                    @if ($page != "Dashboard")
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0)">{{ isset($page) ? $page :
                                            "Page"; }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->

                <!-- [ Main Content ] start -->

                <div class="row">
                    <!-- [ sample-page ] start -->

                    @yield('content')
                    <!-- [ sample-page ] end -->
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>

    <!-- footer @s -->
    @include('partials.footer')
    <!-- footer @e -->

    <!-- Modal Profile -->
    <div class="modal fade" id="ModalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="background: none !important;border: none !important;">
                        <svg class="pc-icon">
                            <use xlink:href="#close"></use>
                        </svg>
                    </button>
                </div>
                <div class="modal-content" id="modal-profile-content">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Global -->
    <div class="modal fade" id="ModalGlobal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="GlobalModalTitle"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="background: none !important;border: none !important;">
                        <svg class="pc-icon">
                            <use xlink:href="#close"></use>
                        </svg>
                    </button>
                </div>
                <div class="modal-content" id="GlobalModalBody">

                </div>
            </div>
        </div>
    </div>
</body>


<!-- [Page Specific JS] start -->
<script src="{{ asset('/assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/dashboard-default.js') }}"></script>
<!-- [Page Specific JS] end -->
<!-- Required Js -->
<script src="{{ asset('/assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('/assets/js/fonts/custom-ant-icon.js') }}"></script>
<script src="{{ asset('/assets/js/pcoded.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/feather.min.js') }}"></script>
<!-- Buy Now Link  -->
{{-- <script defer src="https://fomo.codedthemes.com/pixel/Oo2pYDncP8R8qhhETpWKGA04b8jPhUjF"></script> --}}


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

{{-- flat picker --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    layout_change('light');
</script>

<script>
    change_box_container('false');
</script>

<script>
    layout_rtl_change('false');
</script>

<script>
    preset_change('preset-1');
</script>

<script>
    font_change('Public-Sans');
</script>
<?= isset($js_script) ? '<script type="text/javascript" src="'.asset($js_script).'"></script>' : ""; ?>


@stack('scripts')
<script>
    $(document).ready(function () {

    $(document).on('click', '#btn-edit-profile', function () {
        $.get("/profile/edit", function (res) {
            $("#modal-profile-content").html(res);

            const modalEl = document.getElementById('ModalProfile');
            const modalInstance = new bootstrap.Modal(modalEl);
            modalInstance.show();;
        });
    });

    $(document).on('click', '#submit-profile', function () {
        let formData = $("#form-edit-profile").serialize();

        $.post("/profile/update", formData)
            .done(function (response) {
                // alert(response.message); // ganti swal atau toastr jika mau
                $("#ModalProfile").modal('hide');
            })
            .fail(function (xhr) {
                alert("Gagal menyimpan data: " + xhr.responseJSON.message);
            });
    });

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-dismiss="modal"]').forEach(function (btn) {
            btn.addEventListener('click', function () {

                let modalElement = btn.closest('.modal');
                if (modalElement) {
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    } else {
                        new bootstrap.Modal(modalElement).hide();
                    }
                }
            });
        });
    });

    function hideAllModals() {
        const modalProfile = document.getElementById('ModalProfile');
        if (modalProfile) {
            const instance = bootstrap.Modal.getInstance(modalProfile) || new bootstrap.Modal(modalProfile);
            instance.hide();
        }

        document.querySelectorAll('.modal.show').forEach(function (modalEl) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            } else {
                new bootstrap.Modal(modalEl).hide();
            }
        });
    }

    function refreshContent() {
        $("#content").load(window.location.pathname + " #content > *", function () {
            // Re-inisialisasi DataTable setelah konten berhasil dimuat
            $("#content table.dataTable").each(function () {
                // Hapus instance sebelumnya jika ada
                if ($.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable().clear().destroy();
                }
                initDataTable($(this).attr('id'));
            });
        });
        $("#header-topbar").load(window.location.pathname + " #header-topbar > *");
    }

    function initDataTable(tableId) {
        $('#' + tableId).DataTable({
            responsive: true,
            autoWidth: false,
            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "«",
                    previous: "‹",
                    next: "›",
                    last: "»"
                },
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)"
            }
        });
    }

</script>

{{-- Global Modal --}}
<script>
    function showGlobalModal(title, url) {
        $('#GlobalModalTitle').text(title);
        $('#GlobalModalBody').html('<div class="text-center p-3"><div class="spinner-border"></div></div>');

        $.get(url, function (res) {
            $('#GlobalModalBody').html(res);

            const modalEl = document.getElementById('ModalGlobal');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.show();
        });
    }

    $(document).on('click', '[data-modal]', function (e) {
        e.preventDefault();
        const title = $(this).data('title') || 'Modal';

        const url = $(this).data('url');
        showGlobalModal(title, url);
    });
</script>

<script>
    // ------- Helper: ambil elemen dari selector/element -------
function _asEl(target) {
  if (!target) return null;
  return (typeof target === 'string') ? document.querySelector(target) : target;
}

// ------- Time Picker (24 jam) -------
function initTimePicker(target, options = {}) {
  const el = _asEl(target);
  if (!el || el._flatpickr) return el? el._flatpickr : null;
  const defaults = {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    minuteIncrement: 1,
    allowInput: true,
    disableMobile: true
  };
  return flatpickr(el, Object.assign({}, defaults, options));
}

// ------- Date Picker (YYYY-MM-DD) -------
function initDatePicker(target, options = {}) {
  const el = _asEl(target);
  if (!el || el._flatpickr) return el? el._flatpickr : null;
  const defaults = {
    dateFormat: "Y-m-d",
    allowInput: true,
    disableMobile: true
  };
  return flatpickr(el, Object.assign({}, defaults, options));
}

// ------- Opsi A: Auto init semua input ber-class tertentu saat halaman siap -------
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('input.time-picker').forEach(el => initTimePicker(el));
  document.querySelectorAll('input.date-picker').forEach(el => initDatePicker(el));
});

// ------- Opsi B: Init-on-focus (malas inisialisasi) -------
document.addEventListener('focusin', function (e) {
  if (e.target.matches('input.time-picker')) {
    const fp = initTimePicker(e.target);
    if (fp) fp.open(); // langsung buka saat fokus
  }
  if (e.target.matches('input.date-picker')) {
    const fp = initDatePicker(e.target);
    if (fp) fp.open();
  }
});
</script>

</html>
