<!-- 
== Build By = Dede ardiansya
== https://github.com/dedeardiansya
 -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('web.layouts.components.head')
  <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}
  @yield('style')
</head>

<body class="ab-sidebar--close">
  <div class="ab-layout">
    @include('web.layouts.components.header')
    @include('web.layouts.components.sidebar')
    @include('web.layouts.components.alert')

    @yield('content')

    @include('web.layouts.components.footer')
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('script')
</body>

</html>