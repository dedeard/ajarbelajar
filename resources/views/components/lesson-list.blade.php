@if ($lesson)
  <div class="flex flex-col border bg-white">
    <div class="block w-full flex-1 p-2">
      <div class="relative mb-2">
        @if ($lesson->category)
          <a href="{{ route('categories.show', $lesson->category->slug) }}"
            class="absolute left-1 top-1 block bg-primary-600 px-2 py-1 text-2xs font-semibold leading-none text-white shadow hover:shadow-lg">
            {{ $lesson->category->name }}
          </a>
        @endif

        @auth
          <livewire:favorite-toggle :lesson="$lesson" :user="Auth::user()" small />
        @endauth

        <img src="{{ $lesson->cover_urls['thumb'] }}" alt="{{ $lesson->title }}"
          class="block h-full w-full" />
        <div
          class="absolute -bottom-4 right-1 h-9 w-9 rounded-full bg-white p-px shadow-lg">
          @if ($lesson->user->avatar_url)
            <img src="{{ $lesson->user->avatar_url }}"
              alt="{{ $lesson->user->name }}"
              class="block h-full w-full rounded-full border border-white" />
          @else
            <x-avatar :name="$lesson->user->name"
              class="block h-full w-full rounded-full border border-white" />
          @endif
        </div>
      </div>

      <div class="flex flex-1 flex-col">
        <div class="mb-3 w-full flex-1">
          <div class="text-2xs font-semibold text-gray-600">
            {{ $lesson->posted_at->diffForHumans() }}
          </div>
          <h4 class="mb-1 font-bold leading-5">{{ $lesson->title }}</h4>
          <div class="text-xs font-semibold text-gray-600">
            Dari <span class="text-gray-900">{{ $lesson->user->name }}</span>
          </div>
        </div>
        <div class="flex w-full">
          @if ($lesson->episodes_count)
            <span
              class="mr-1 block border bg-gray-100 px-1 text-2xs font-bold text-gray-700">
              <i class="ft ft-film"></i> {{ $lesson->episodes_count }} EPISODE
            </span>
          @endif
          @if ($lesson->seconds)
            <span
              class="mr-1 block border bg-gray-100 px-1 text-2xs font-bold text-gray-700">
              <i class="ft ft-clock"></i> {{ $lesson->readable_second }}
            </span>
          @endif
        </div>
      </div>
    </div>
    <div class="border-t">
      <a href="{{ route('lessons.show', $lesson->slug) }}"
        class="block bg-gray-50 py-2 text-center text-sm font-semibold uppercase tracking-wider hover:text-primary-600">
        Tonton
      </a>
    </div>
  </div>
@endif
