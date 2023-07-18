<x-app-layout :title="$episode->title" :description="$lesson->seo_description" noSidebar>
  <x-slot:script>
    <script>
      (() => {
        if (!window.resizeVideoplayer) {
          window.resizeVideoplayer = () => {
            const videoEl = document.getElementById('video-player')
            const targetEl = document.getElementById('video-player-autoheight')

            if (videoEl && targetEl) {
              targetEl.style.height = videoEl.clientHeight + 'px'
            }
          }
        }

        if (!window.videoplayerInitialized) {
          window.addEventListener('resize', window.resizeVideoplayer)
          window.videoplayerInitialized = true
        }

        window.resizeVideoplayer()
      })()
    </script>
  </x-slot:script>

  <div class="border-b bg-white">
    <div class="container px-3 py-5">
      <a href="{{ route('lessons.show', $lesson->slug) }}" class="inline-flex text-lg leading-none hover:text-primary-600">
        <span class="my-auto mr-3 block">
          <i class="ft ft-arrow-left-circle"></i>
        </span>
        <span class="my-auto block text-gray-900">{{ $lesson->title }}</span>
      </a>
    </div>
  </div>

  <div class="container p-3">
    <div class="mb-10 grid grid-cols-1 lg:grid-cols-3 lg:gap-3">
      <div class="mb-3 lg:col-span-2">
        <video id="video-player" src="{{ $episode->video_url }}" controls class="block aspect-video w-full bg-black" />
      </div>
      <div id="video-player-autoheight" class="flex flex-col">
        <div class="mb-1 flex w-full items-center justify-between border bg-white px-5 py-4">
          <div class="min-w-0 flex-grow">
            <div class="text-xs uppercase tracking-wide opacity-75">Now playing</div>
            <h2 class="truncate text-ellipsis text-sm">{{ sprintf('%02d', $episode->index + 1) }}. {{ $episode->title }}</h2>
          </div>
          <div class="ml-4 flex items-center text-xs opacity-75">
            <div class="my-auto mr-1">
              <i class="ft ft-clock"></i>
            </div>
            <div class="my-auto whitespace-nowrap">{{ $episode->readable_second }}</div>
          </div>
        </div>

        <div class="grid flex-1 grid-cols-1 gap-1 overflow-y-auto">
          @foreach ($lesson->episodes as $e)
            <a href="{{ route('lessons.watch', ['lesson' => $lesson->slug, 'index' => $e->index]) }}"
              class="flex items-center justify-between border bg-white px-5 py-4 hover:bg-gray-50">
              <div class="min-w-0 flex-grow">
                <h2 class="truncate text-ellipsis text-sm">{{ sprintf('%02d', $e->index + 1) }}. {{ $e->title }}</h2>
              </div>
              <div class="ml-4 flex items-center text-xs opacity-75">
                <div class="my-auto mr-1">
                  <i class="ft ft-clock"></i>
                </div>
                <div class="my-auto whitespace-nowrap">{{ $e->readable_second }}</div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="mx-auto max-w-3xl">
      <h3 class="mb-3 text-xl font-semibold uppercase tracking-wider">Komentar</h3>
      <div class="mb-3 block border bg-white">
        @auth
          <x-comment-form :episode="$episode" />
        @endauth
        <livewire:comments :episode="$episode" :user="Auth::user()" />
      </div>
    </div>
  </div>
</x-app-layout>
