<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Penjadwalan App | {{ isset($page) ? $page : "Page" }}</title>

    <link rel="icon" type="image/png" href="">

    <!-- Start CSS -->
    <link rel="stylesheet" href="{{ asset('/dashlite/css/dashlite.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('/dashlite/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/style.css') }}">
    <!-- End CSS -->

</head>

<body class="nk-body npc-invest bg-lighter ">

    <div class="nk-app-root">
        <div class="nk-wrap">
            <!-- wrap @s -->
            @include('partials.navbar')

            @yield('container')

            <!-- footer @s -->
            <div class="nk-footer bg-white">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        {{-- <div class="nk-footer-copyright"> &copy; 2022 Dashlite. Template by <a
                                href="https://softnio.com" target="_blank">Softnio</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- footer @e -->
            <!-- wrap @e -->
        </div>
    </div>
    <!-- app-root @e -->

</body>

<script src="{{ asset('/dashlite/js/bundle.js?ver=3.1.0') }}"></script>
<script src="{{ asset('/dashlite/js/scripts.js?ver=3.1.0') }}"></script>
{{-- <script src="{{ asset('/js/charts/gd-invest.js?ver=3.1.0') }}"></script>
<script src="{{ asset('/js/charts/gd-invest.js?ver=3.1.0') }}"></script> --}}
<script type="text/javascript" src="{{ asset('/js/js/bundle.js?ver=3.1.0') }}"></script>
<script src="{{ asset('/dashlite/js/libs/fullcalendar.js?ver=3.1.0') }}"></script>
<?= isset($js_script) ? '<script type="text/javascript" src="'.asset($js_script).'"></script>' : ""; ?>

</html>
