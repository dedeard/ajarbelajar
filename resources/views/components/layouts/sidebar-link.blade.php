@props([
    'route' => 'home',
    'is' => 'home',
    'icon' => 'home',
    'text' => 'Home',
])

<a href="{{ route($route) }}"
  class="@if (Route::is($is)) bg-gray-100 @endif mb-1 flex w-full items-center rounded px-3 py-3 text-sm font-semibold leading-none hover:bg-gray-200"
  {{ $attributes }}>
  <span class="mr-3 opacity-60">
    <i class="ft ft-{{ $icon }}"></i>
  </span>
  <span>
    {{ $text }}
  </span>
</a>
