@props([
    'head' => '',
    'script' => '',
    'noSidebar' => false,
    'dashboard' => false,
    'header' => false,
    'actions' => null,
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

  <x-layouts.header :no-container="!$noSidebar" :no-sidebar="$noSidebar" />

  @if ($noSidebar)
    <div class="flex min-h-screen flex-col">
      <main class="w-full flex-1 pt-16">{{ $slot }}</main>
      <x-layouts.footer />
    </div>
  @else
    <div class="flex">
      <x-layouts.sidebar-wrap>
        @if ($dashboard)
          <x-layouts.sidebar-link route="dashboard.activities" is="dashboard.activities" text="Aktifitas" icon="activity" />
          <x-layouts.sidebar-link route="dashboard.lessons.index" is="dashboard.lessons*" text="Pelajaran" icon="video" />
          <x-layouts.sidebar-link text="Favorit" route="dashboard.favorites" is="dashboard.favorites" icon="heart" />
          <x-layouts.sidebar-link route="dashboard.edit-profile" is="dashboard.edit-profile" text="Edit Profil" icon="settings" />
          <x-layouts.sidebar-link route="dashboard.edit-password" is="dashboard.edit-password" text="Edit Password" icon="lock" />
          <x-layouts.sidebar-link route="logout" is="logout" text="Keluar" icon="arrow-left-circle" />
        @else
          <x-layouts.sidebar-link text="Home" route="home" is="home" icon="home" />
          <x-layouts.sidebar-link text="Pelajaran" route="lessons.index" is="lessons*" icon="film" />
          <x-layouts.sidebar-link text="Kategori" route="categories.index" is="categories*" icon="grid" />
          <x-layouts.sidebar-link text="Pengguna" route="users.index" is="users*" icon="users" />
          @auth
            <x-layouts.sidebar-link text="Dasbor Saya" route="dashboard.activities" is="dashboard*" icon="clipboard" />
            <x-layouts.sidebar-link route="logout" is="logout" text="Keluar" icon="arrow-left-circle" />
          @else
            <x-layouts.sidebar-link text="Masuk" route="login" is="login" icon="user" />
            <x-layouts.sidebar-link text="Buat Akun" route="register" is="register" icon="user" />
          @endauth
        @endif
      </x-layouts.sidebar-wrap>
      <div class="relative flex min-h-screen max-w-full flex-1 flex-col pl-0 lg:pl-60">
        <main class="w-full flex-1 pt-16">
          @if ($header)
            <div class="h-16 border-b bg-white">
              <div class="container h-full px-3">
                <div class="flex h-full items-center">
                  <h2 class="my-auto flex-1 pr-3 font-semibold uppercase leading-none">
                    {{ $header }}
                  </h2>
                  {{ $actions }}
                </div>
              </div>
            </div>
          @endif
          {{ $slot }}
        </main>
        <x-layouts.footer />
      </div>
    </div>
  @endif
</x-root-layout>
