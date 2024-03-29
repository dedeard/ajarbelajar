<aside
  class="fixed left-0 z-30 flex h-screen w-60 transform bg-white pt-16 shadow-xl transition-transform md:border-r md:shadow-none lg:left-auto lg:-translate-x-0 lg:transition-none"
  x-bind:class="sidebarOpen ? '-translate-x-0' : '-translate-x-full'">
  <div class="flex flex-1 overflow-y-auto">
    <nav class="w-full flex-1">
      @auth
        <div class="flex h-16 w-full items-center border-b px-3">
          <div class="pr-2">
            <figure class="m-auto block h-12 w-12 rounded-full border border-gray-200 bg-white p-1">
              <template x-if="$store.authStore.auth.avatar_url">
                <img :src="$store.authStore.auth.avatar_url" :alt="$store.authStore.auth.name" class="block h-full w-full rounded-full" />
              </template>
              <x-ui.avatar :name="Auth::user()->name" x-bind:name="$store.authStore.auth.name"
                x-bind:class="$store.authStore.auth.avatar_url ? '!hidden' : ''" class="block h-full w-full rounded-full" />
            </figure>
          </div>
          <div class="flex-1 overflow-hidden">
            <h3 class="mb-1 truncate font-semibold capitalize leading-none" x-text="$store.authStore.auth.name">{{ Auth::user()->name }}</h3>
            <p class="truncate text-sm leading-none" x-text="'@' + $store.authStore.auth.username">{{ '@' . Auth::user()->username }}</p>
          </div>
        </div>
      @endauth
      <div class="p-3">{{ $slot }}</div>
    </nav>
  </div>
</aside>
