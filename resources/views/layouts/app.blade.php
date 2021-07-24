<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- css -->
  @yield('style:before')
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('style:after')
</head>


<body class="layout-navbar-fixed layout-fixed">
  <div class="wrapper" id="app">
    <x-navbar />
    <x-sidebar />

    <div class="content-wrapper">
      <div class="content py-3">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>

    <!-- Main Footer -->
    <x-footer></x-footer>
  </div>
  @yield('script:before')
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('script:after')

  <x-alert />
</body>

</html>
