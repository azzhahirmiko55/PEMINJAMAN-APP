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
    <div class="content">
        @yield('content')
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
<script defer src="https://fomo.codedthemes.com/pixel/Oo2pYDncP8R8qhhETpWKGA04b8jPhUjF"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



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
            $("#content").load(window.location.pathname + " #content > *");
            $("#header-topbar").load(window.location.pathname + " #header-topbar > *");
        }

</script>


</html>
