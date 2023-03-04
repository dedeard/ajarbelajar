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
  </x-slot:head>
  <x-slot:script>
    {!! $script !!}
  </x-slot:script>

  <header class="flex bg-white py-5 shadow">
    <a href="#" class="m-auto block">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 164.67 164.67" class="h-10 w-10">
        <path class="fill-primary-600"
          d="M164.67,82.34A82.32,82.32,0,0,0,40.8,11.26,21.75,21.75,0,0,0,0,21.76V82.34H0a82.32,82.32,0,0,0,123.87,71.08,21.74,21.74,0,0,0,19,11.25h0a21.75,21.75,0,0,0,21.75-21.75V82.34ZM82.33,121.18a38.83,38.83,0,1,1,38.83-38.83h0A38.83,38.83,0,0,1,82.33,121.18Z">
        </path>
      </svg>
    </a>
  </header>
  <main class="py-10 px-3 md:px-0">
    <div class="mx-auto max-w-xl border bg-white">
      @if (Route::is('login') || Route::is('register'))
        <div class="flex">
          <a href="{{ route('login') }}"
            class="{{ Route::is('login') ? 'border-b-0 bg-transparent text-gray-600 ' : 'bg-gray-100 ' }}flex h-14 flex-1 items-center justify-center border-b text-sm font-bold uppercase tracking-widest text-gray-500">
            Masuk
          </a>
          <div class="h-14 w-px bg-gray-200"></div>
          <a href="{{ route('register') }}"
            class="{{ Route::is('register') ? 'border-b-0 bg-transparent text-gray-600 ' : 'bg-gray-100 ' }}flex h-14 flex-1 items-center justify-center border-b text-sm font-bold uppercase tracking-widest text-gray-500">
            Daftar
          </a>
        </div>
      @endif
      <div class="px-10 pb-10">
        <h1 class="mt-14 mb-8 text-center text-4xl font-light text-gray-700">
          {{ $title }}
        </h1>
        {{ $slot }}
      </div>
    </div>
  </main>
  <footer class="pb-10 text-center text-gray-400">
    © {{ config('app.name') }} {{ now()->year }}
  </footer>
</x-root-layout>
