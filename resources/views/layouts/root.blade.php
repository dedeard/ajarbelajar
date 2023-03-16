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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  @vite(['resources/fonts/feather/feather.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-700">
  <x-alert />

  <main class="min-h-screen">
    {{ $slot }}
  </main>

  @vite(['resources/js/main.js'])
  {{ $script }}
</body>

</html>
