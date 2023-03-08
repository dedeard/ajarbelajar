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
      <div class="mb-3 p-3 w-full bg-gray-100 rounded border">
        <div class="mb-2">
          <figure class="m-auto block w-1/2 rounded-full border border-gray-200 bg-white p-1">
            <img class="block h-full w-full rounded-full" src="{{ Auth::user()->avatar_url }}" />
          </figure>
        </div>
        <div class="overflow-hidden text-center">
          <h3 class="mb-1 truncate font-semibold capitalize leading-none">{{ Auth::user()->name }}</h3>
          <p class="truncate text-sm leading-none opacity-70">{{ Auth::user()->username }}</p>
        </div>
      </div>
      <x-layouts.sidebar-link icon="arrow-left" />
      <x-layouts.sidebar-link route="dashboard.activities" is="dashboard.activities" text="Aktifitas" icon="activity" />
      <x-layouts.sidebar-link route="dashboard.articles.index" is="dashboard.articles*" text="Artikel" icon="book-open" />
      <x-layouts.sidebar-link route="dashboard.lessons.index" is="dashboard.lessons*" text="Pelajaran" icon="video" />
      <br />
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
