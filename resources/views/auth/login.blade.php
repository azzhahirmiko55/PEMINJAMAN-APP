<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Penjadwalan App | {{ isset($page) ? $page : "Page"; }}</title>

    <link rel="icon" type="image/png" href="">

    <!-- Start CSS -->
    <link rel="stylesheet" href="{{ asset('/dashlite/css/dashlite.css?ver=3.1.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('/dashlite/css/theme.css?ver=3.1.0') }}">
    <link rel="stylesheet" href="{{ asset('custom/style.css') }}">
    <!-- End CSS -->

</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
                                <h3 class="title-for-logo" style="color: black !important;">
                                    <em class="ni ni-calendar-alt"></em> Aplikasi Peminjaman Kendaraan dan Ruang Rapat
                                </h3>
                            </a>
                        </div>
                        <form action="#" id="formLogin" method="POST" class="form-validate is-alter">
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Halaman Login</h4>
                                            <div class="nk-block-des">
                                                <p>Silahkan masukkan username dan password anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="html/index.html">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="inputUsername">Username</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control form-control-lg"
                                                    id="inputUsername" name="username" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <div class="form-control-wrap">
                                                {{-- <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a> --}}
                                                <input type="password" class="form-control form-control-lg"
                                                    id="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button id="btnLogin" type="submit"
                                                class="btn btn-lg btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; {{ date('Y') }} Aplikasi Peminjaman</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
</body>

<!-- Start JS -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
<script src="{{ asset('/dashlite/js/bundle.js?ver=3.1.0') }}"></script>
<script src="{{ asset('/dashlite/js/libs/fullcalendar.js?ver=3.1.0') }}"></script>
<?= isset($js_script) ? '<script type="text/javascript" src="'.asset($js_script).'"></script>' : ""; ?>
{{-- <script src="{{ asset('/dashlite/js/apps/calendar.js?ver=3.1.0') }}"></script> --}}
<!-- End JS -->

</html>
