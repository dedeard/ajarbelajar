<!-- 
== Build By = Dede ardiansya
== https://github.com/dedeardiansya
 -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('web.layouts.components.head')
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}
  @yield('style')
</head>

<body class="ab-sidebar--close ab-base-layout">
  <div class="ab-layout" id="app">
    @include('web.layouts.components.header')
    @include('web.layouts.components.sidebar')
    @include('web.layouts.components.alert')

    @yield('content')

    @include('web.layouts.components.footer')
  </div>
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('script')
</body>

</html>