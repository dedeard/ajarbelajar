<x-app-layout dashboard title="Edit Pelajaran">
  <div class="container p-3">
    <div class="md:flex">
      <div class="md:w-[320px]">
        <x-dashboard.lesson-edit-cover :lesson="$lesson" />
        <x-dashboard.lesson-edit-detail :lesson="$lesson" />
      </div>
      <div class="md:flex-1 md:pl-3">
        <x-dashboard.lesson-edit-description :lesson="$lesson" />
        <x-dashboard.lesson-upload-episode :lesson="$lesson" />
        <livewire:dashboard.show-episodes :lesson="$lesson" />
      </div>
    </div>
  </div>
</x-app-layout>
