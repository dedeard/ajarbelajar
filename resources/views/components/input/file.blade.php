@props([
    'name' => '',
    'label' => '',
    'help' => '',
    'placeholder' => '',
    'error' => $errors->first($name),
])

<x-input.wrapper label="{{ $label }}" for="{{ $name }}">
  <div x-data="{ fileName: '', error: '{{ $error }}' }" x-bind:class="error ? 'border-red-600' : 'border-gray-200'" class="relative flex w-full flex-1 border">
    <span class="h-100 flex h-10 items-center bg-gray-300 px-3">PILIH FILE</span>
    <span class="my-auto block flex-1 px-3 leading-6" x-text="fileName || '{{ $placeholder }}'"></span>
    <input x-on:change="fileName = $event.target.files[0]?.name || ''"
      {{ $attributes->merge([
          'type' => 'file',
          'id' => $name,
          'name' => $name,
          'class' => 'absolute top-0 left-0 right-0 bottom-0 opacity-0',
      ]) }} />
  </div>

  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</x-input.wrapper>
