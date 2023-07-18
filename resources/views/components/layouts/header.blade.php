@props([
    'noContainer' => false,
    'noSidebar' => false,
])

<header x-data="{ openSearchModal: false }" class="fixed left-0 right-0 top-0 z-40 flex h-16 w-full items-center border-b border-gray-200 bg-white">

  <div class="@if (!$noContainer) container @endif flex-1">
    <div class="flex">
      <div class="hidden lg:flex lg:w-60">
        <a href="{{ route('home') }}" class="flex items-center p-3" aria-label="Ajarbelajar.com">
          <x-svg.brand class="block h-7" />
        </a>
      </div>
      <div class="container flex flex-1">
        <a href="{{ route('home') }}" class="flex items-center p-3 lg:hidden" aria-label="Ajarbelajar.com">
          <x-svg.brand class="block h-7" />
        </a>
        <div class="flex flex-1 justify-end md:justify-start">
          <div class="flex py-3 lg:pl-3">
            <button aria-label="Search"
              class="flex h-9 w-9 items-center justify-center rounded-full border bg-gray-100 p-0 text-sm hover:bg-gray-200 md:w-40 md:justify-between md:px-4 lg:ml-0"
              @click="openSearchModal = true">
              <div class="hidden font-semibold uppercase tracking-wider md:block">Cari</div>
              <i class="ft ft-search md:text-lg"></i>
            </button>
            @if (!$noSidebar)
              <button aria-label="Menu"
                class="toggle-color ml-3 flex h-9 w-9 items-center justify-center rounded-full border p-0 text-sm lg:hidden"
                @click="sidebarOpen = ! sidebarOpen">
                <i x-bind:class="sidebarOpen ? 'ft ft-x' : 'ft ft-menu'"></i>
              </button>
            @endif
          </div>
        </div>
        @auth
          <div class="flex p-3 md:ml-auto">
            <a aria-label="Notifications" href="{{ route('dashboard.notifications.index') }}"
              class="toggle-color relative flex h-9 w-9 items-center justify-center rounded-full border p-0 text-sm">
              <i class="ft ft-bell"></i>
              <livewire:notification-counter :user="Auth::user()" />
            </a>
            <x-layouts.header-profile-dropdown />
          </div>
        @else
          <div class="ml-auto flex p-3">
            <a href="{{ route('login') }}"
              class="flex h-9 items-center justify-center rounded-full bg-gray-100 px-4 text-sm hover:bg-gray-200">Masuk</a>
            <a href="{{ route('register') }}"
              class="ml-3 flex h-9 items-center justify-center rounded-full bg-primary-600 px-4 text-sm text-white hover:bg-primary-600">Buat
              Akun</a>
          </div>
        @endauth
      </div>
    </div>
  </div>
</header>
