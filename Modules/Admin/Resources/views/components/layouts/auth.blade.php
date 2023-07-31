@props([
    'title' => config('app.name', 'Laravel'),
    'description' => config('app.description', 'The Laravel Framework.'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title }}</title>
  <meta name="description" content="{{ $description }}" />

  <x-admin::layouts.vite path="Resources/assets/scss/app.scss" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ route('admin.dashboard') }}"
          class="h1"><b>Admin</b><span class="text-primary">AB</span></a>
      </div>
      <div class="card-body">
        {{ $slot }}
      </div>
    </div>
  </div>
  <x-admin::layouts.vite path="Resources/assets/js/app.js" />
</body>

</html>
