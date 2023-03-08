<x-dashboard-layout title="Edit Artikel">
  <div class="container p-3">
    <div class="md:flex">
      <div class="md:w-[320px]">
        <x-dashboard.post-edit-cover :post="$article" type="article" />
        <x-dashboard.post-edit-detail :post="$article" type="article" />
      </div>
      <div class="md:flex-1 md:pl-3">
        <x-dashboard.post-edit-body :post="$article" type="article" name="content" label="kontent artikel" />
      </div>
    </div>
  </div>
</x-dashboard-layout>
