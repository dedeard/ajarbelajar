<x-app-layout title="Kategori" header="Kategori">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($categories as $category)
        <a href="{{ route('categories.show', $category->slug) }}"
          class="flex items-center justify-center border bg-white px-3 py-4 hover:bg-gray-50">
          <span class="block text-center text-sm font-bold tracking-wide">{{ $category->name }}</span>
        </a>
      @endforeach
    </div>
    {{ $categories->links() }}
  </div>
</x-app-layout>
