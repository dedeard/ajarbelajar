<x-app-layout dashboard :title="$lesson->title" header="Edit Pelajaran">
  <x-slot:head>
    @vite(['resources/js/sortable.js'])
  </x-slot:head>

  <x-slot:actions>
    <a href="{{ route('dashboard.lessons.index') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Batal
    </a>
  </x-slot:actions>

  <x-tab route="dashboard.lessons.edit" :tab="$tab" :lists="[
      'details' => ['params' => ['lesson' => $lesson->id], 'text' => 'Detail'],
      'cover' => [
          'params' => ['lesson' => $lesson->id, 'tab' => 'cover'],
          'text' => 'Sampul',
      ],
      'episodes' => [
          'params' => ['lesson' => $lesson->id, 'tab' => 'episodes'],
          'text' => 'Episode',
      ],
  ]">
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
  </x-tab>
</x-app-layout>
