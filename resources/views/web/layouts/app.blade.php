<!-- 
== Build By = Dede ardiansya
== https://github.com/dedeardiansya
 -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('web.layouts.components.head')
  <link rel="stylesheet" href="{{ mix('css/theme.css') }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}
  @yield('style')
</head>

<body class="ab-sidebar--close">
  <div class="ab-layout" id="app">
    <div class="v-loading" v-if="VLoading"></div>
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