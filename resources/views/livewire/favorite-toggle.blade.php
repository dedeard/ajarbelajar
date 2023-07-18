@if ($small)
  <button wire:click="onclick" type="button" aria-label="Toggle Favorite"
    class="@if ($favorited) text-red-600 @else text-gray-500 @endif absolute right-1 top-1 block rounded-full bg-white p-1 shadow">
    <x-svg.heart width="14" height="14" fill="currentColor" />
  </button>
@else
  <button wire:click="onclick" type="button" aria-label="Toggle Favorite"
    class="@if ($favorited) text-red-600 @else text-gray-500 @endif absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white shadow hover:shadow-lg">
    <x-svg.heart width="16" height="16" fill="currentColor" />
  </button>
@endif
