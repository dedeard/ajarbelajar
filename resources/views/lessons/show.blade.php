<x-app-layout :title="$lesson->title" :description="$lesson->seo_description">
  <div class="container p-3">
    <div class="relative grid grid-cols-1 md:grid-cols-3 md:gap-3">
      <div class="md:col-span-2">
        <article class="mb-3 border bg-white">
          <div class="relative">
            <img src="{{ $lesson->cover_urls['large'] }}"
              alt="{{ $lesson->title }}" class="block w-full" />

            @auth
              <x-favorite-toggle lessonId="{{ $lesson->id }}" />
            @endauth

            <a href="{{ route('lessons.watch', $lesson->slug) }}"
              class="absolute bottom-3 right-3 z-10 flex h-9 items-center justify-center rounded-full bg-white p-0 px-4 text-sm uppercase shadow">
              Mulai Menonton
            </a>
          </div>

          <div class="flex p-3 pb-0">
            @if ($lesson->category)
              <a href="{{ route('categories.show', $lesson->category->slug) }}"
                class="leading-0 block border bg-gray-100 px-2 py-1 text-2xs font-semibold uppercase hover:bg-gray-200">
                {{ $lesson->category->name }}
              </a>
            @endif
          </div>
          <h1 class="my-auto flex-1 p-3 font-semibold uppercase leading-none">
            {{ $lesson->title }}
          </h1>
          <p
            class="flex items-center border-b p-3 pt-0 text-xs uppercase text-gray-600">
            <span
              class="block">{{ $lesson->posted_at->diffForHumans() }}</span>
            <span class="mx-2 block h-2 w-px bg-gray-600"></span>
            <span class="block">
              <i class="ft ft-film"></i> {{ $lesson->episodes_count }} Episode
            </span>
            <span class="mx-2 block h-2 w-px bg-gray-600"></span>
            <span class="block">
              <i class="ft ft-clock"></i> {{ $lesson->readable_second }}
            </span>
          </p>
          <div class="prose max-w-none p-3 pb-6 text-sm">
            {!! $lesson->html_description !!}
          </div>
          <a href="{{ route('lessons.watch', $lesson->slug) }}"
            class="block bg-primary-600 py-3 text-center text-sm font-semibold uppercase tracking-widest text-white hover:bg-primary-700">
            Mulai Menonton
          </a>
        </article>
      </div>
      <div>
        <div class="mb-3 overflow-hidden border bg-white">
          <div class="p-3">
            <div class="flex flex-col items-center justify-center pb-3 pt-6">
              <a href="{{ route('users.show', $lesson->user->username) }}"
                class="m-auto flex h-24 w-24 items-center justify-center rounded-full border bg-gray-100 p-1">
                @if ($lesson->user->avatar_url)
                  <img src="{{ $lesson->user->avatar_url }}"
                    alt="{{ $lesson->user->name }}"
                    class="block h-full w-full rounded-full" />
                @else
                  <x-avatar :name="$lesson->user->name"
                    class="block h-full w-full rounded-full" />
                @endif
              </a>
            </div>
            <h4
              class="truncate text-center text-lg font-bold uppercase tracking-wider">
              <a
                href="{{ route('users.show', $lesson->user->username) }}">{{ $lesson->user->name }}</a>
            </h4>
            <div class="mb-3 truncate text-center text-sm text-gray-500">
              <a
                href="{{ route('users.show', $lesson->user->username) }}">{{ '@' . $lesson->user->username }}</a>
            </div>
          </div>
          <div class="bg-gray-100 p-2">
            <p class="text-center text-xs">Pelajaran ini diibuat oleh
              {{ $lesson->user->name }}</p>
          </div>
        </div>

        <x-new-user-lessons-card :user="$lesson->user" :ignore-id="$lesson->id" />

        <x-new-lessons-card :ignore-id="$lesson->id" />
      </div>
    </div>
  </div>
</x-app-layout>
