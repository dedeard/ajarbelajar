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

<body class="preload">
  <div class="ab-layout">
    @include('web.layouts.components.header')
    @include('web.layouts.components.sidebar')
    @include('web.layouts.components.alert')

    @yield('content')

    @include('web.layouts.components.footer')
  </div>
  @include('web.layouts.components.script')
  @yield('script')
</body>

</html>