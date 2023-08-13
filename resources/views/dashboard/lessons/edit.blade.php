<x-app-layout dashboard :title="$lesson->title" header="Edit Pelajaran">
  <x-slot:head>
    @vite(['resources/js/videoplayer.js'])
  </x-slot:head>

  <x-slot:actions>
    <a href="{{ route('dashboard.lessons.index') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Batal
    </a>
  </x-slot:actions>
  <div class="bg-gray-300">
    <div class="grid grid-cols-3 gap-px">
      <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id]) }}"
        class="@if ($tab === 'details') bg-gray-50 border-primary-600 @else hover:bg-gray-50 bg-white @endif block border-b pb-3 pt-4 text-center text-sm font-semibold uppercase leading-none tracking-wider">Detail</a>
      <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id, 'tab' => 'cover']) }}"
        class="@if ($tab === 'cover') bg-gray-50 border-primary-600 @else hover:bg-gray-50 bg-white @endif block border-b pb-3 pt-4 text-center text-sm font-semibold uppercase leading-none tracking-wider">Poster</a>
      <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id, 'tab' => 'episodes']) }}"
        class="@if ($tab === 'episodes') bg-gray-50 border-primary-600 @else hover:bg-gray-50 bg-white @endif block border-b pb-3 pt-4 text-center text-sm font-semibold uppercase leading-none tracking-wider">Episode</a>
    </div>
  </div>

  <div class="container p-3">
    @if ($tab === 'details')
      <x-dashboard.lesson-edit-details :lesson="$lesson" />
    @endif
    @if ($tab === 'cover')
      <x-dashboard.lesson-edit-cover :lesson="$lesson" />
    @endif
    @if ($tab === 'episodes')
      <x-dashboard.lesson-upload-episode :lesson="$lesson" />
      <livewire:dashboard.show-episodes :lesson="$lesson" />
    @endif
  </div>
</x-app-layout>
