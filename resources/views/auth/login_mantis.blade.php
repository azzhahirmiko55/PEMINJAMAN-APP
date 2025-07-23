<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Penjadwalan App | {{ isset($page) ? $page : "Page"; }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{asset('/assets/images/Logo_BPN.png') }}" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/tabler-icons.min.css') }}" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/feather.css') }}" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/fontawesome.css') }}" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('/assets/fonts/material.css') }}" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" id="main-style-link" >
    <link rel="stylesheet" href="{{ asset('/assets/css/style-preset.css') }}" >

</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        {{-- <div class="auth-header">
          <a href="#"><img src="../assets/images/logo-dark.svg" alt="img"></a>
        </div> --}}
        <div class="card my-5">
          <div class="card-body ">
            <div class="text-center mb-4">
              <h3 class="mb-0 text-center"><b>Aplikasi Peminjaman<br> Kendaraan & Ruang Rapat</b></h3>
              {{-- <a href="#" class="link-primary">Don't have an account?</a> --}}
            </div>
            {{-- <div class="form-group mb-3">
                <div class="alert alert-danger" role="alert">
                    A simple danger alert—check it out!
                </div>
            </div> --}}
            <form action="#" id="formLogin" method="POST" class="form-validate is-alter">
                @csrf
                <div class="form-group mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required>
                </div>
                <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Masukkan Password" name="password" required>
                </div>
                <div class="d-flex mt-1 justify-content-between">
                </div>
                <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">MASUK</button>
                </div>
            </form>
            <div class="saprator mt-3">
            </div>
            <div class="row">
              <div class="col-4">
                <div class="d-grid">
                  {{-- <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="../assets/images/authentication/google.svg" alt="img"> <span class="d-none d-sm-inline-block"> Google</span>
                  </button> --}}
                </div>
              </div>
              <div class="col-4">
                <div class="d-grid">
                  {{-- <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="../assets/images/authentication/twitter.svg" alt="img"> <span class="d-none d-sm-inline-block"> Twitter</span>
                  </button> --}}
                </div>
              </div>
              <div class="col-4">
                <div class="d-grid">
                  {{-- <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="../assets/images/authentication/facebook.svg" alt="img"> <span class="d-none d-sm-inline-block"> Facebook</span>
                  </button> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="auth-footer row">
          <!-- <div class=""> -->
            <div class="col my-1 text-center">
              <p class="m-0">Copyright © <a href="#">{{ date('Y') }} Aplikasi Peminjaman</a></p>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="{{ asset('/assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('/assets/js/fonts/custom-ant-icon.js') }}"></script>
  <script src="{{ asset('/assets/js/pcoded.js') }}"></script>
  <script src="{{ asset('/assets/js/plugins/feather.min.js') }}"></script>
   <!-- Buy Now Link  -->
  {{-- <script defer src="https://fomo.codedthemes.com/pixel/Oo2pYDncP8R8qhhETpWKGA04b8jPhUjF" ></script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= isset($js_script) ? '<script type="text/javascript" src="'.asset($js_script).'"></script>' : ""; ?>

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


</body>
<!-- [Body] end -->

</html>
