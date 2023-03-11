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
    @vite(['resources/js/editor.js'])
    {!! $script !!}
  </x-slot:script>

  <x-layouts.navbar />

  <div class="flex">
    <x-layouts.sidebar-wrap>
      <div class="mb-3 flex w-full flex-col rounded bg-gray-100">
        <div class="flex w-full items-center p-3">
          <div class="pr-2">
            <figure class="m-auto block h-12 w-12 rounded-full border border-gray-200 bg-white p-1">
              <img class="block h-full w-full rounded-full" src="{{ Auth::user()->avatar_url }}" />
            </figure>
          </div>
          <div class="flex-1 overflow-hidden">
            <h3 class="mb-1 truncate font-semibold capitalize leading-none">{{ Auth::user()->name }}</h3>
            <p class="truncate text-sm leading-none opacity-70">{{ '@' . Auth::user()->username }}</p>
          </div>
        </div>
      </div>
      <x-layouts.sidebar-link icon="arrow-left" />
      <span class="block py-1"></span>
      <x-layouts.sidebar-link route="dashboard.activities" is="dashboard.activities" text="Aktifitas" icon="activity" />
      <span class="block py-1"></span>
      <x-layouts.sidebar-link route="dashboard.articles.index" is="dashboard.articles*" text="Artikel" icon="book-open" />
      <x-layouts.sidebar-link route="dashboard.lessons.index" is="dashboard.lessons*" text="Pelajaran" icon="video" />
      <span class="block py-1"></span>
      <x-layouts.sidebar-link route="dashboard.edit-profile" is="dashboard.edit-profile" text="Edit Profil" icon="settings" />
      <x-layouts.sidebar-link route="dashboard.edit-password" is="dashboard.edit-password" text="Edit Password" icon="lock" />
    </x-layouts.sidebar-wrap>
    <div class="relative flex min-h-screen max-w-full flex-1 flex-col pl-0 lg:pl-60">
      <div class="w-full flex-1 pt-16">
        {{ $slot }}
      </div>
      <x-layouts.footer />
    </div>
  </div>
</x-root-layout>
