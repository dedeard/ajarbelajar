@props([
    'name' => '',
    'label' => '',
    'checked' => false,
])

<div class="flex items-center py-3">
  <input @if ($checked) checked @endif
    {{ $attributes->merge([
        'name' => $name,
        'id' => $name,
        'type' => 'checkbox',
        'class' => 'border-gray-300 bg-gray-100 !ring-0 hover:border-primary-600',
    ]) }} />
  <label for="{{ $name }}" class="ml-2 text-sm font-medium text-gray-900">{{ $label }}</label>
</div>
