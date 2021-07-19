<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <x-head></x-head>

  <!-- css -->
  @yield('style:before')
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('style:after')
</head>


<body class="app-layout">
  <div class="wrapper" id="app">
    <x-navbar />
    <x-sidebar />

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <x-alert />
        </div>
      </div>

      <div class="content">
        <div class="container-fluid pb-3">
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
</body>

</html>
