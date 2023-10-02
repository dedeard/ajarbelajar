@props(['route', 'tab', 'lists', 'default' => '', 'class' => 'grid-cols-3'])

<div class="bg-gray-300">
  <div class="{{ $class }} grid gap-px">
    @foreach ($lists as $key => $value)
      <a href="{{ route($route, $value['params']) }}"
        class="@if ($tab === $key) bg-gray-50 border-primary-600 @else hover:bg-gray-50 bg-white @endif block border-b pb-3 pt-4 text-center text-sm font-semibold uppercase leading-none tracking-wider">{{ $value['text'] }}</a>
    @endforeach
  </div>
</div>

{{ $slot }}
