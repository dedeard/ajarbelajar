<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <!-- css -->
    @yield('style:before')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
    @yield('style:after')
</head>

<body>
    <div class="ab-layout" id="app">
        @yield('content')
    </div>
    @yield('script:before')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/admin.js') }}"></script>
    @yield('script:after')
</body>

</html>
