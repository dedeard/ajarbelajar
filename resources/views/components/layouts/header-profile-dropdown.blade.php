<div class="dropdown-wrapper relative ml-3 h-9 w-9">
  <button class="block h-9 w-9 rounded-full p-0">
    @if (Auth::user()->avatar_url)
      <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="block h-full w-full rounded-full" />
    @else
      <x-avatar :name="Auth::user()->name" class="block h-full w-full rounded-full" />
    @endif
  </button>
  <div class="dropdown-drop absolute right-0 top-full mt-3 w-60">
    <span class="absolute -top-1 right-1 h-6 w-6 rotate-45 transform rounded bg-primary-600"></span>
    <div class="relative z-10 border border-gray-100 bg-white p-3 shadow-lg">
      <div class="flex p-3">
        <figure class="m-auto block h-24 w-24 rounded-full">
          @if (Auth::user()->avatar_url)
            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="block h-full w-full rounded-full" />
          @else
            <x-avatar :name="Auth::user()->name" class="block h-full w-full rounded-full" />
          @endif
        </figure>
      </div>
      <h3 class="text-md capitalized w-full truncate text-center font-semibold">
        {{ Auth::user()->name }}
      </h3>
      <p class="w-full truncate text-center text-sm">
        {{ '@' }}{{ Auth::user()->username }}
      </p>
      <div class="pt-3">
        <a href="{{ route('histories') }}"
          class="mb-3 flex h-9 w-full items-center justify-center rounded-full border bg-gray-100 p-0 text-sm font-semibold uppercase tracking-wider hover:bg-gray-200">
          Riwayat</a>
        <a href="{{ route('dashboard.edit-profile') }}"
          class="mb-3 flex h-9 w-full items-center justify-center rounded-full border bg-gray-100 p-0 text-sm font-semibold uppercase tracking-wider hover:bg-gray-200">
          Edit Profil</a>
        <x-auth.logout-button
          class="inline-block rounded-full bg-red-600 px-4 py-3 text-sm font-semibold uppercase leading-none tracking-wider text-white hover:bg-red-700">
          Keluar
        </x-auth.logout-button>
      </div>
    </div>
  </div>
</div>
