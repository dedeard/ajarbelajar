@props([
    'label' => '',
    'grid' => true,
    'useDiv' => false,
])

@if ($useDiv)
  <div class="mb-3 block" {{ $attributes->merge(['class' => 'mb-3 block']) }}>
    <div class="text-sm">{{ $label }}</div>
    {{ $slot }}
  </div>
@else
  <label class="mb-3 block" {{ $attributes->merge(['class' => 'mb-3 block']) }}>
    <div class="text-sm">{{ $label }}</div>
    {{ $slot }}
  </label>
@endif
