@props([
    'name' => '',
    'label' => '',
    'help' => '',
    'error' => $errors->first($name),
])

<x-input.wrapper label="{{ $label }}" for="{{ $name }}">
  <select
    {{ $attributes->merge([
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => ($error ? ' border-red-600' : '') . 'block w-full flex-1 border border-gray-300 placeholder:text-gray-500',
    ]) }}>{{ $slot }}</select>

  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</x-input.wrapper>
