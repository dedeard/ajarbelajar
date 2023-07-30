@props([
    'label' => '',
    'grid' => true,
    'useDiv' => false,
])

{{-- @if ($grid)
  <label class="block py-3 md:grid md:grid-cols-3 md:gap-3">
    <div class="text-sm md:text-base">{{ $label }}</div>
    <div class="md:col-span-2">
      {{ $slot }}
    </div>
  </label>
@else --}}
{{-- @endif --}}

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
