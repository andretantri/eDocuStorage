<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title') :: {{ $siteTitle }}</title>

    <meta name="description" content="{{ $siteTitle }}">
    <meta name="author" content="Andre Tantri Yanuar">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $siteTitle }}">
    <meta property="og:site_name" content="e-DocuStorage">
    <meta property="og:description" content="e-DocuStorage Adalah Sistem Informasi Penyedia Dokumen">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="shortcut icon" href="{{ asset('logo-polinus.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('logo-polinus.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-polinus.png') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('template/assets/css/dashmix.min.css') }}">
    @yield('css')
</head>

<body>
    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">

            <!-- Page Content -->
            @yield('konten')
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at {{ asset('template/assets/_js/main/app.js') }}
    -->
    @yield('js')
    <script src="{{ asset('template/assets/js/dashmix.app.min.js') }}"></script>

    <!-- jQuery (required for jQuery Validation plugin) -->
    <script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('template/assets/js/plugins/vide/jquery.vide.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('template/assets/js/pages/op_auth_lock.min.js') }}"></script>
</body>

</html>
