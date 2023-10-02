@props([
    'small' => false,
    'lessonId',
])

@php
  $classes = 'absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white shadow hover:shadow-lg';
  if ($small) {
      $classes = 'absolute right-1 top-1 block rounded-full  bg-white p-1 shadow';
  }
@endphp

<button type="button" aria-label="Toggle Favorite" class="{{ $classes }}"
  x-bind:class="$store.favoriteStore.favorited({{ $lessonId }}) ? 'text-red-600' :
      'text-gray-500'"
  x-on:click="$store.favoriteStore.toggle({{ $lessonId }})">
  <x-svg.heart width="14" height="14" fill="currentColor" />
</button>
