@props([
    'route' => 'home',
    'is' => 'home',
    'icon' => 'home',
    'text' => 'Home',
])

@if ($route !== 'logout')
  <a href="{{ route($route) }}"
    class="@if (Route::is($is)) bg-gray-100 @endif mb-1 flex w-full items-center rounded-full px-4 py-3 text-sm font-semibold leading-none hover:bg-gray-200"
    {{ $attributes }}>
    <span class="@if (Route::is($is)) text-primary-600 @endif mr-3">
      <i class="ft ft-{{ $icon }}"></i>
    </span>
    {{ $text }}
  </a>
@else
  <form class="inline" action="{{ route('logout') }}" method="post">
    @csrf
    <button href="{{ route($route) }}"
      class="@if (Route::is($is)) bg-gray-100 @endif mb-1 flex w-full items-center rounded-full px-4 py-3 text-sm font-semibold leading-none hover:bg-gray-200"
      {{ $attributes }}>
      <span class="mr-3 text-red-600">
        <i class="ft ft-{{ $icon }}"></i>
      </span>
      {{ $text }}
    </button>
  </form>
@endif
