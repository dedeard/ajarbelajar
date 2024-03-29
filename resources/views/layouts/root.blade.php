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
        Auth::user()->notifications()->unread()->count()
    );
    window.FAVORITE_DATA = @js(
        Auth::user()->favorites()->select('lesson_id')->get()->map(fn($el) => $el->lesson_id)
    );
    window.Alpine?.store('authStore')?.set(window.AUTH_DATA)
    window.Alpine?.store('notificationStore')?.set(window.NOTIFICATION_COUNT)
    window.Alpine?.store('favoriteStore')?.set(window.FAVORITE_DATA)
  </script>
@else
  <script>
    window.Alpine?.store('authStore')?.set(null)
    window.Alpine?.store('notificationStore')?.set(0)
    window.Alpine?.store('favoriteStore')?.set([])
  </script>
@endauth

<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-700">
  <x-ui.alert />

  <div class="min-h-screen">
    {{ $slot }}
  </div>

  {{ $script }}
</body>

</html>
