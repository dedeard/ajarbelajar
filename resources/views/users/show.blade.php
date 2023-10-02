<x-app-layout :title="$user->name" :description="$user->bio">
  <div class="border-b bg-white">
    <div class="p-3">
      <div class="flex flex-col items-center justify-center pb-3 pt-6">
        <div class="m-auto flex h-24 w-24 items-center justify-center rounded-full border bg-gray-100 p-1">
          @if ($user->avatar_url)
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="block h-full w-full rounded-full" />
          @else
            <x-ui.avatar :name="$user->name" class="block h-full w-full rounded-full" />
          @endif
        </div>
      </div>
      <h4 class="truncate text-center text-lg font-bold uppercase tracking-wider">
        {{ $user->name }}</h4>
      <div class="mb-3 truncate text-center text-sm text-gray-500">
        {{ '@' . $user->username }}</div>
      <p class="mx-auto mb-3 max-w-lg text-center text-sm">
        {{ $user->bio }}
      </p>
      @if ($user->website)
        <div class="mb-3 text-center">
          <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer" class="text-sm text-primary-600 hover:text-primary-700">
            {{ $user->website }}
          </a>
        </div>
      @endif
    </div>
    <div class="bg-gray-50 p-2">
      <p class="text-center text-xs">Bergabung
        {{ $user->created_at->diffForHumans() }}</p>
    </div>
  </div>
  <div class="h-16 border-b bg-white">
    <div class="container h-full px-3">
      <div class="flex h-full items-center">
        <h2 class="my-auto flex-1 pr-3 font-semibold uppercase leading-none">
          Pelajaran</h2>
        <div class="dropdown-wrapper relative">
          <x-inputs.button type="button" class="block rounded-full px-4 py-2 text-xs">
            Sortir :
            @if (!$sort)
              Terbaru
            @endif
            @if ($sort == 'oldest')
              Terlama
            @endif
            @if ($sort == 'popularity')
              Popularitas
            @endif
          </x-inputs.button>
          <div class="dropdown-drop absolute right-0 top-full z-10 mt-1 w-48 border bg-white p-3 shadow">
            <a href="{{ route('users.show', $user->username) }}"
              class="@if (!$sort) bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
              Terbaru
            </a>
            <a href="{{ route('users.show', ['user' => $user->username, 'sort' => 'oldest']) }}"
              class="@if ($sort == 'oldest') bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
              Terlama
            </a>
            <a href="{{ route('users.show', ['user' => $user->username, 'sort' => 'popularity']) }}"
              class="@if ($sort == 'popularity') bg-gray-100 @endif flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
              Popularitas
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if (!count($lessons))
    <x-blocks.blank>BELUM ADA PELAJARAN</x-blocks.blank>
  @else
    <div class="container p-3">
      <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($lessons as $lesson)
          <x-cards.lesson-list :$lesson />
        @endforeach
      </div>
      {{ $lessons->links() }}
    </div>
  @endif
</x-app-layout>

