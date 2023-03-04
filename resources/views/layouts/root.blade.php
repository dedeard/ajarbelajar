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
  {{ $head }}

  @vite(['resources/fonts/feather/feather.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-700">
  <x-alert />

  <div class="min-h-screen">
    {{ $slot }}
  </div>

  @auth
    <script>
      document.addEventListener('alpine:init', () => {
        Alpine.store('auth', {
          user: {
            id: {{ Auth::user()->id }},
            name: "{{ Auth::user()->name }}",
            username: "{{ Auth::user()->username }}",
            email: "{{ Auth::user()->email }}",
            avatar: "{{ Auth::user()->avatar_url }}",
            bio: "{{ Auth::user()->bio }}",
            website: "{{ Auth::user()->website }}",
          },
          setAuth(user) {
            this.user = user
          }
        })
      })
    </script>
  @endauth
  @vite(['resources/js/main.js'])
  {{ $script }}
</body>

</html>
