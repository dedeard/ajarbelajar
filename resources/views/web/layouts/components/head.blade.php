<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="current-url" content="{{ url()->current() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="google-site-verification" content="muR53cbe3_dN-_UFdd8UVCB9pT7a8CkBj7iqpclnhw0" />
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icons/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icons/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icons/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('icons/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('icons/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icons/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="msapplication-TileImage" content="{{ asset('icons/ms-icon-144x144.png') }}">
<meta name="msapplication-TileColor" content="#677ae4">
<meta name="theme-color" content="#677ae4">

<!-- Fonts -->
<link rel="stylesheet" href="{{ asset('remark/fonts/web-icons/web-icons.min.css') }}">
<link rel="stylesheet" href="https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?u8vidh">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

@auth
<meta name="api-token" content="{{ Auth::user()->apiToken() }}">
@endauth
<script>
  @auth
    var AUTH_ID = {{ Auth::user()->id }};
    var NOTIFICATION_COUNT = {{ Auth::user()->unreadNotifications()->count() }};
  @else
    var AUTH_ID = null;
  @endauth
</script>