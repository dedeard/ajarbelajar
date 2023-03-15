@if ($small)
  <button wire:click="onclick" type="button"
    class="@if ($favorited) text-red-600 @else text-gray-500 @endif absolute top-1 right-1 block rounded-full bg-white p-1 shadow">
    <x-svg.heart width="14" height="14" fill="currentColor" />
  </button>
@else
  <button wire:click="onclick" type="button"
    class="@if ($favorited) text-red-600 @else text-gray-500 @endif absolute top-3 right-3 flex h-9 w-9 items-center justify-center rounded-full bg-white shadow hover:shadow-lg">
    <x-svg.heart width="16" height="16" fill="currentColor" />
  </button>
@endif
