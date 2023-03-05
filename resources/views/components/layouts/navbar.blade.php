@props(['container' => false, 'sidebar' => true])

<nav x-data="{ openSearchModal: false }" class="fixed top-0 right-0 left-0 z-40 flex h-16 w-full items-center border-b border-gray-200 bg-white">
  <div class="{{ $container ? 'container' : '' }} flex-1">
    <div class="flex">
      <div class="hidden lg:flex lg:w-60">
        <a href="{{ route('home') }}" class="flex items-center p-3">
          <x-svg.brand class="block h-7" />
        </a>
      </div>
      <div class="container flex flex-1">
        <a href="{{ route('home') }}" class="flex items-center p-3 lg:hidden">
          <x-svg.brand no-text class="block h-7" />
        </a>
        <div class="flex flex-1 justify-end md:justify-start">
          <div class="flex py-3 lg:pl-3">
            <button
              class="toggle-color flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm font-semibold md:w-40 md:justify-between md:px-4 lg:ml-0"
              @click="openSearchModal = true">
              <div class="hidden md:block">Cari</div>
              <i class="ft ft-search md:text-lg"></i>
            </button>
            @if ($sidebar)
              <button class="toggle-color ml-3 flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm lg:hidden"
                @click="sidebarOpen = ! sidebarOpen">
                <i x-bind:class="sidebarOpen ? 'ft ft-x' : 'ft ft-menu'"></i>
              </button>
            @endif
          </div>
        </div>

        @auth
          <div class="flex p-3 md:ml-auto">
            <a href="#" class="toggle-color relative flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm">
              <i class="ft ft-bell"></i>
              <span class="min-w-4 absolute -top-1 -right-1 block h-4 rounded-full bg-red-600 px-1 text-center text-xs leading-4 text-white">
                30</span>
            </a>
            <x-layouts.navbar-profile-dropdown />
          </div>
        @else
          <div class="ml-auto flex p-3">
            <a href="{{ route('login') }}"
              class="toggle-color flex h-9 items-center justify-center rounded-full px-4 text-sm font-semibold">Masuk</a>
            <a href="{{ route('register') }}"
              class="ml-3 flex h-9 items-center justify-center rounded-full bg-primary-600 px-4 text-sm font-semibold text-white hover:bg-primary-600">Buat
              Akun</a>
          </div>
        @endauth
      </div>
    </div>
  </div>
</nav>
