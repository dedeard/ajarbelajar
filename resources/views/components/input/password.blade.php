@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'help' => '',
    'error' => $errors->first($name),
])

<x-input.wrapper label="{{ $label }}" for="{{ $name }}">
  <div class="relative" x-data="{ showPassword: false }">
    <input x-bind:type="showPassword ? 'text' : 'password'"
      {{ $attributes->merge([
          'type' => 'password',
          'id' => $name,
          'name' => $name,
          'value' => old($name, $value),
          'class' => ($error ? ' border-red-600' : '') . 'block pr-8 w-full flex-1 border border-gray-200 placeholder:text-gray-500',
      ]) }} />

    <button type="button" class="absolute right-0 top-0 flex h-10 w-10 cursor-pointer items-center justify-center" aria-hidden="true"
      x-on:click="showPassword = ! showPassword">
      <i class="ft" x-bind:class="showPassword ? 'ft-eye-off' : 'ft-eye'"></i>
    </button>
  </div>

  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</x-input.wrapper>
