@props([
    'label' => '',
    'for' => '',
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
  <label @if ($for) for="{{ $for }}" @endif class="text-sm">{{ $label }}</label>
  {{ $slot }}
</div>
