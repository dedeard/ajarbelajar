@props(['status'])

@if ($status)
  <div class="relative mb-5 flex items-center rounded border-l-4 border-primary-500 bg-primary-50 p-4 shadow-sm">
    <p class="flex-grow text-primary-700 text-sm">{{ $status }}</p>
  </div>
@endif
