<x-root-layout>
  <x-slot:head>
    <title>@yield('title')</title>
  </x-slot:head>
  <x-layouts.header :no-sidebar="true" />

  <div class="flex min-h-screen flex-col">
    <main class="flex w-full flex-1 flex-col pt-16">
      <div class="container flex flex-1 flex-col items-center justify-center px-3 py-32 text-center">
        <div class="mb-6 text-[6rem] font-bold leading-none">
          @yield('code')
        </div>
        <div class="text-lg uppercase tracking-widest">
          <div class="mb-3">
            @yield('message')
          </div>
          <a href="{{ route('home') }}"
            class="flex h-10 w-full items-center justify-center rounded-full bg-primary-600 p-0 text-sm font-semibold tracking-widest text-white hover:bg-primary-700">HOME</a>
        </div>
      </div>
    </main>
    <x-layouts.footer />
  </div>

</x-root-layout>

