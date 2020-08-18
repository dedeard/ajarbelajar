<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('partials.head')

  <!-- css -->
  @yield('style:before')
  <link rel="stylesheet" href="{{ mix('css/theme.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @yield('style:after')
</head>

<body class="app-layout">
  <div class="app-layout" id="app">
    @include('partials.header')
    @include('partials.sidebar')
    <div class="pt-2">
      @include('partials.alert')
      @yield('content')
    </div>
  </div>
  @yield('script:before')
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('script:after')
</body>

</html>
