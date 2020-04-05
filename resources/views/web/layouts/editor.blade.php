<!-- 
== Build By = Dede ardiansya
== https://github.com/dedeardiansya
 -->

 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('web.layouts.components.head')
  <link rel="stylesheet" href="{{ mix('css/theme.css') }}">
  <link rel="stylesheet" href="{{ mix('css/editor.css') }}">
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}
  @yield('style')
</head>

<body>
  @yield('content')
  <script src="{{ mix('js/editor.js') }}"></script>
  @yield('script')
</body>
</html>