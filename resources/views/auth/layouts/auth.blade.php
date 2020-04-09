<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="current-url" content="{{ url()->current() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  @yield('meta')
  {!! SEOMeta::generate() !!}
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  @if(env('APP_ENV') === 'local')
  <link rel="stylesheet" href="{{ asset('remark/fonts/web-icons/web-icons.min.css') }}">
  <link rel="stylesheet" href="{{ mix('css/theme.css') }}">
  @endif
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="ab-auth--layout bg-light p-0">
<header class="py-4 d-flex bg-white shadow-sm">
  <a href="/" class="d-block m-auto">
    <img src="{{ asset('img/logo/logo.svg') }}" height="40" alt="Logo Ajarbelajar" />
  </a>
</header>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-5 col-md-8 mx-auto">
      <div class="my-4"></div>
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="container">
            <div class="row">
              <div class="col-6 pl-0">
                <a href="{{ route('login') }}" class="font-weight-bold btn btn-primary btn--label btn-block @if(Route::is('login')) disabled @endif">MASUK</a>
              </div>
              <div class="col-6 pr-0">
                <a href="{{ route('register') }}" class="font-weight-bold btn btn-primary btn--label btn-block @if(Route::is('register')) disabled @endif">DAFTAR</a>
              </div>
            </div>
          </div>
          <div class="my-4"></div>
          <div class="py-3">
            <h3 class="text-uppercase text-center font-weight-bold text-secondary">
              @yield('heading')
            </h3>
            @yield('content')
          </div>
        </div>
      </div>
      <div class="my-4"></div>
    </div>
  </div>
</div>
<footer class="ab-auth--footer bg-white border-top py-4">
  <div class="container">
    <div class="text-center font-weight-bolder text-uppercase">
      <i class="fa fa-copyright"></i> Ajarbelajar 2020
    </div>
  </div>
</footer>
</body>
</html>