<x-app-layout :title="$category->name" :header="$category->name">
  <x-slot:actions>
    <div class="dropdown-wrapper relative">
      <x-button type="button" class="block rounded-full py-2 px-4 text-xs">
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
      </x-button>
      <div class="dropdown-drop absolute top-full right-0 z-10 mt-1 w-48 border bg-white p-3 shadow">
        <a href="{{ route('categories.show', $category->slug) }}"
          class="@if (!$sort) bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Terbaru
        </a>
        <a href="{{ route('categories.show', ['category' => $category->slug, 'sort' => 'oldest']) }}"
          class="@if ($sort == 'oldest') bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Terlama
        </a>
        <a href="{{ route('categories.show', ['category' => $category->slug, 'sort' => 'popularity']) }}"
          class="@if ($sort == 'popularity') bg-gray-100 @endif flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Popularitas
        </a>
      </div>
    </div>
  </x-slot:actions>
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($lessons as $lesson)
        <x-lesson-list :lesson="$lesson" :user="Auth::user()" />
      @endforeach
    </div>
    {{ $lessons->links() }}
  </div>
</x-app-layout>
