<x-dashboard-layout title="Edit Pelajaran">
  <div class="container p-3">
    <div class="md:flex">
      <div class="md:w-[320px]">
        <x-dashboard.post-edit-cover :post="$lesson" type="lesson" />
        <x-dashboard.post-edit-detail :post="$lesson" type="lesson" />
      </div>
      <div class="md:flex-1 md:pl-3">
        <x-dashboard.post-edit-body :post="$lesson" type="lesson" />
        <x-dashboard.post-upload-episode :lesson="$lesson" />
        <livewire:dashboard.show-episodes :lesson="$lesson" />
      </div>
    </div>
  </div>
</x-dashboard-layout>
