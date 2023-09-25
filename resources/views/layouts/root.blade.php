@props([
    'head' => '',
    'script' => '',
])

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="turbo-cache-control" content="no-cache" />
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  {{ $head }}
  @vite(['resources/fonts/feather/feather.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>

@auth
  <script>
    window.AUTH_DATA = @js(Auth::user());
    window.NOTIFICATION_COUNT = @js(
        Auth::user()->notifications()->count()
    );
    window.Alpine?.store('authStore')?.set(window.AUTH_DATA)
    window.Alpine?.store('notificationStore')?.set(window.NOTIFICATION_COUNT)
  </script>
@else
  <script>
    window.Alpine?.store('authStore')?.set(null)
    window.Alpine?.store('notificationStore')?.set(0)
  </script>
@endauth

<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-700">
  <x-alert />

  <div class="min-h-screen">
    {{ $slot }}
  </div>

  @vite(['resources/js/main.js'])
  {{ $script }}
</body>

</html>
