@props(['category'])

<a href="{{ route('categories.show', $category->slug) }}" class="flex items-center justify-center border bg-white px-3 py-4 hover:bg-gray-50">
  <span class="block text-center text-sm font-bold tracking-wide">{{ $category->name }}</span>
</a>
