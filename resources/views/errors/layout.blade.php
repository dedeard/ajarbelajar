<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="current-url" content="{{ url()->current() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @auth
  <meta name="api-token" content="{{ Auth::user()->apiToken() }}">
  @endauth
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icons/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icons/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icons/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('icons/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('icons/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icons/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="msapplication-TileColor" content="#677ae4">
  <meta name="msapplication-TileImage" content="{{ asset('icons/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#677ae4">
  <title>@yield('title')</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('remark/fonts/web-icons/web-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/fonts/font-awesome/font-awesome.min.css') }}">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

  <!-- Core -->
  <link rel="stylesheet" href="{{ asset('remark/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/css/bootstrap-extend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/css/site.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="{{ asset('remark/vendor/breakpoints/breakpoints.js') }}"></script>
  <script>
  Breakpoints();
  </script>
</head>

<body class="page-error layout-full p-0">
    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
      <div class="page-content vertical-align-middle">
        <header>
          <h1 class="display-1">@yield('code')</h1>
          <p class="lead">@yield('title')</p>
        </header>
        <a class="btn btn-primary btn-round" href="{{ route('home') }}">KEMBALI KE HOME</a>
      </div>
    </div>
  </body>

</html>