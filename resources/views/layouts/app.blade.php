@props([
    'head' => '',
    'script' => '',
    'title' => config('app.name', 'Laravel'),
    'description' => config('app.description', 'The Laravel Framework.'),
])

<x-root-layout>
  <x-slot:head>
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}" />
    {!! $head !!}
    @livewireStyles
  </x-slot:head>
  <x-slot:script>
    @livewireScripts
    {!! $script !!}
  </x-slot:script>

  <x-layouts.navbar />

  <div class="flex">
    <x-layouts.sidebar-wrap>
      <x-layouts.sidebar-link />
      <x-layouts.sidebar-link text="Artikel" icon="book-open" />
      <x-layouts.sidebar-link text="Pelajaran" icon="film" />
      <x-layouts.sidebar-link text="Kategori" icon="list" />
      <x-layouts.sidebar-link text="Pengguna" icon="users" />
      <br />
      @auth
        <x-layouts.sidebar-link text="Dasbor Saya" route="dashboard.activities" is="dashboard*" icon="clipboard" />
      @else
        <x-layouts.sidebar-link text="Masuk" route="login" is="login" icon="user" />
        <x-layouts.sidebar-link text="Buat Akun" route="register" is="register" icon="user" />
      @endauth
    </x-layouts.sidebar-wrap>
    <div class="relative flex min-h-screen max-w-full flex-1 flex-col pl-0 lg:pl-60">
      <div class="w-full flex-1 pt-16">
        {{ $slot }}
      </div>
      <x-layouts.footer />
    </div>
  </div>
</x-root-layout>
