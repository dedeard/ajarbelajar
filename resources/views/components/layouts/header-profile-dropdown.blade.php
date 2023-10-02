<div class="dropdown-wrapper relative ml-3 h-9 w-9">
  <button class="block h-9 w-9 rounded-full p-0">
    <template x-if="$store.authStore.auth.avatar_url">
      <img :src="$store.authStore.auth.avatar_url" :alt="$store.authStore.auth.name" class="block h-full w-full rounded-full" />
    </template>
    <x-ui.avatar :name="Auth::user()->name" x-bind:name="$store.authStore.auth.name" x-bind:class="$store.authStore.auth.avatar_url ? '!hidden' : ''"
      class="block h-full w-full rounded-full" />
  </button>
  <div class="dropdown-drop absolute right-0 top-full mt-3 w-60">
    <span class="absolute -top-1 right-1 h-6 w-6 rotate-45 transform rounded bg-primary-600"></span>
    <div class="relative z-10 border border-gray-100 bg-white p-3 shadow-lg">
      <div class="flex p-3">
        <figure class="m-auto block h-24 w-24 rounded-full">
          <template x-if="$store.authStore.auth.avatar_url">
            <img :src="$store.authStore.auth.avatar_url" :alt="$store.authStore.auth.name" class="block h-full w-full rounded-full" />
          </template>
          <x-ui.avatar :name="Auth::user()->name" x-bind:name="$store.authStore.auth.name"
            x-bind:class="$store.authStore.auth.avatar_url ? '!hidden' : ''" class="block h-full w-full rounded-full" />
        </figure>
      </div>
      <h3 class="text-md capitalized w-full truncate text-center font-semibold" x-text="$store.authStore.auth.name"></h3>
      <p class="w-full truncate text-center text-sm" x-text="'@' + $store.authStore.auth.username"></p>
      <div class="pt-3">
        <a href="{{ route('histories') }}"
          class="mb-3 flex h-9 w-full items-center justify-center rounded-full border bg-gray-100 p-0 text-sm font-semibold uppercase tracking-wider hover:bg-gray-200">
          Riwayat</a>
        <a href="{{ route('settings') }}"
          class="mb-3 flex h-9 w-full items-center justify-center rounded-full border bg-gray-100 p-0 text-sm font-semibold uppercase tracking-wider hover:bg-gray-200">
          Pengaturan</a>
        <x-auth.logout-button
          class="inline-block rounded-full bg-red-600 px-4 py-3 text-sm font-semibold uppercase leading-none tracking-wider text-white hover:bg-red-700">
          Keluar
        </x-auth.logout-button>
      </div>
    </div>
  </div>
</div>
