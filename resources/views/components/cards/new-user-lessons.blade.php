@props(['user', 'ignore-id'])

@php
  $lessons = $user
      ->lessons()
      ->listQuery()
      ->where('id', '!=', $ignoreId)
      ->orderBy('posted_at', 'desc')
      ->take(6)
      ->get();
@endphp

@if (count($lessons))
  <div class="mb-3 overflow-hidden border bg-white">
    <div class="px-3 py-4">
      <h4 class="text-sm font-semibold leading-none">Lainnya dari
        {{ $user->name }}</h4>
    </div>
    @foreach ($lessons as $lesson)
      <a href="{{ route('lessons.show', $lesson->slug) }}" class="block border-t px-3 py-2 text-sm first:border-t-0 hover:bg-gray-100">
        @if ($lesson->category)
          <span class="block text-xs font-semibold leading-none">{{ $lesson->category->name }}</span>
        @endif
        {{ $lesson->title }}
      </a>
    @endforeach
  </div>
@endif
