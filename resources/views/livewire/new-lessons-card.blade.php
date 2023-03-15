@if (count($lessons))
  <div class="mb-3 overflow-hidden border bg-white">
    <div class="py-4 px-3">
      <h4 class="text-sm font-semibold leading-none">Baru di Ajarbelajar</h4>
    </div>
    @foreach ($lessons as $lesson)
      <a href="{{ route('lessons.show', $lesson->slug) }}" class="block border-t py-2 px-3 text-sm first:border-t-0 hover:bg-gray-100">
        @if ($lesson->category)
          <span class="block text-xs font-semibold leading-none">{{ $lesson->category->name }}</span>
        @endif
        {{ $lesson->title }}
      </a>
    @endforeach
  </div>
@endif
