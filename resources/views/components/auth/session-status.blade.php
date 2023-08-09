@props(['status'])

@if ($status)
  <div
    class="relative mb-5 flex items-center border-l-4 border-primary-500 bg-primary-50 p-4">
    <p class="flex-grow text-sm text-primary-700">{{ $status }}</p>
  </div>
@endif
