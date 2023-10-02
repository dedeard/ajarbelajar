<x-app-layout title="Pelajaran" header="Pelajaran">
  <x-slot:actions>
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
        <a href="{{ route('lessons.index') }}"
          class="@if (!$sort) bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Terbaru
        </a>
        <a href="{{ route('lessons.index', ['sort' => 'oldest']) }}"
          class="@if ($sort == 'oldest') bg-gray-100 @endif mb-3 flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Terlama
        </a>
        <a href="{{ route('lessons.index', ['sort' => 'popularity']) }}"
          class="@if ($sort == 'popularity') bg-gray-100 @endif flex h-9 w-full items-center justify-center rounded-full border px-4 text-sm uppercase hover:bg-gray-200">
          Popularitas
        </a>
      </div>
    </div>
  </x-slot:actions>
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($lessons as $lesson)
        <x-cards.lesson-list :$lesson />
      @endforeach
    </div>
    {{ $lessons->links() }}
  </div>
</x-app-layout>

