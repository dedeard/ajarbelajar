<script>
  window.isActive = function(url) {
    let location = document.location
    location = new URL(location).pathname.replaceAll('/', '')
    url = new URL(url).pathname.replaceAll('/', '')
    return url === location
  }
</script>

<div
  class="fixed left-0 z-30 flex h-screen w-60 transform border-r bg-white pt-16 transition-transform lg:left-auto lg:-translate-x-0 lg:transition-none"
  x-bind:class="sidebarOpen ? '-translate-x-0' : '-translate-x-full'">
  <div class="flex flex-1 overflow-y-auto p-3">
    <div class="w-full flex-1">
      @auth
        <livewire:layouts.sidebar-profile-card />
      @endauth
      {{ $slot }}
    </div>
  </div>
</div>
