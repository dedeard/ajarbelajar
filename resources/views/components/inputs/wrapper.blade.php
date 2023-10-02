@props([
    'label' => '',
    'for' => '',
])

@if ($label === '')
  {{ $slot }}
@else
  <div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label @if ($for) for="{{ $for }}" @endif class="text-sm">{{ $label }}</label>
    {{ $slot }}
  </div>
@endif
