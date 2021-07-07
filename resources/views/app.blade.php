<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Real Estate Html Template">
    <meta name="author" content="">
    <meta name="generator" content="Jekyll">
    <title>Homely</title>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('vendors/fontawesome-pro-5/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/bootstrap-select/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/slick/slick.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/magnific-popup/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/chartjs/Chart.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/dropzone/css/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/animate.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/timepicker/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/mapbox-gl/mapbox-gl.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/dataTables/jquery.dataTables.min.css')}}">
    <!-- Themes core CSS -->
    <link rel="stylesheet" href="{{asset('css/theme/themes.css')}}">
    <!-- Favicons -->
    <link rel="icon" href="images/favicon.ico">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="Signup and Login">
    <meta name="twitter:description" content="Real Estate Html Template">
    <meta name="twitter:image" content="images/homeid-social-logo.png">
    <!-- Facebook -->
    <meta property="og:url" content="signup-and-login.html">
    <meta property="og:title" content="Signup and Login">
    <meta property="og:description" content="Real Estate Html Template">
    <meta property="og:type" content="website">
    <meta property="og:image" content="images/homeid-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

</head>

<body class="antialiased">

    <div id="app"></div>


    <script src="{{asset('js/app.js')}}" defer></script>

    @include('layouts.footer')
</body>

</html>