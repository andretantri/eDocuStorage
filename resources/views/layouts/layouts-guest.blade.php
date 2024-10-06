<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600,700,800" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Handlee" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('image') . '/' . $logoSite }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/meanmenu.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/remodal.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/remodal-default-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/venobox.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/pelanggan/css/responsive.css') }}" />
</head>

<body>

    <!--  Start Preloader  -->

    <div class="preloader">
        <div class="status-mes">
            <div class="lds-roller">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    @include('template.guest-header')
    <!--  End Header  -->

    @if (session('error'))
        <script>
            alert("Error : {{ session('error') }}");
        </script>
    @endif

    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif


    @yield('konten')

    <!--  FOOTER START  -->
    @include('template.guest-footer')
    <!--  FOOTER END  -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('js')
    <script src="{{ asset('template/pelanggan/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/popper.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/jquery.mixitup.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/remodal.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/wow.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/venobox.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/simplePlayer.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/scrolltopcontrol.js') }}"></script>
    <script src="{{ asset('template/pelanggan/js/main.js') }}"></script>

</body>

</html>
