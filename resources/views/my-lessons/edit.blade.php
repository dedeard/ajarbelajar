<x-app-layout dashboard :title="$lesson->title" header="Edit Pelajaran">
  <x-slot:head>
    @if ($tab === 'episodes')
      @vite(['resources/js/sortable.js'])
    @endif
  </x-slot:head>

  <x-slot:actions>
    <a href="{{ route('my-lessons.index') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Batal
    </a>
  </x-slot:actions>

  <x-tab route="my-lessons.edit" :tab="$tab" :lists="[
      'details' => ['params' => ['my_lesson' => $lesson->id], 'text' => 'Detail'],
      'cover' => [
          'params' => ['my_lesson' => $lesson->id, 'tab' => 'cover'],
          'text' => 'Sampul',
      ],
      'episodes' => [
          'params' => ['my_lesson' => $lesson->id, 'tab' => 'episodes'],
          'text' => 'Episode',
      ],
  ]">
    <div class="container p-3">
      @if ($tab === 'details')
        <x-my-lessons.edit-details :lesson="$lesson" />
      @endif
      @if ($tab === 'cover')
        <x-my-lessons.edit-cover :lesson="$lesson" />
      @endif
      @if ($tab === 'episodes')
        <x-my-lessons.edit-episodes :lesson="$lesson" />
      @endif
    </div>
  </x-tab>
</x-app-layout>

