<x-app-layout title="Kategori" header="Kategori">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($categories as $category)
        <x-cards.category-list :category="$category" />
      @endforeach
    </div>
    {{ $categories->links() }}
  </div>
</x-app-layout>
