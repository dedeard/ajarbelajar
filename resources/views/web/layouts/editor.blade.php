<!-- 
== Build By = Dede ardiansya
== https://github.com/dedeardiansya
 -->

 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('web.layouts.components.head')
  <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
  <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}
  @yield('style')
</head>

<body>
  @yield('content')
  <script src="{{ asset('js/editor.js') }}"></script>
  @yield('script')
</body>
</html>