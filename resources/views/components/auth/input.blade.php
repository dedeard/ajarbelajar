@props(['type' => 'text', 'name' => Str::random(6), 'label' => 'Label', 'placeholder' => null, 'value' => ''])

@php
  $error = $errors->first($name);
  $inputClass = 'block w-full flex-1 border-gray-300 rounded shadow pt-5 pb-1 placeholder:text-gray-400 text-gray-700';
  if ($error) {
      $inputClass = $inputClass . ' border-red-600';
  }
  if ($type === 'password') {
      $inputClass = $inputClass . ' pr-8';
  }

  if (!$value) {
      $value = $type !== 'password' ? old($name) : '';
  }

@endphp

<div class="relative pb-3" x-data="{ showPassword: false }">
  @if ($label)
    <label for="{{ $name }}" class='absolute block pl-3 pt-1 text-xs font-medium'>
      {{ $label }}
    </label>
  @endif

  <input {{ $slot ? 'error="$slot"' : '' }}
    {{ $attributes->merge([
        'id' => $name,
        'class' => $inputClass,
        'x-bind:type' => $type === 'password' ? "showPassword ? 'text' : 'password'" : "'text'",
        'name' => $name,
        'placeholder' => $placeholder ? $placeholder : $label,
        'value' => $value,
        'autocomplete' => $name,
        'aria-label' => $type === 'password' ? 'current-password' : $label,
    ]) }} />

  @if ($type === 'password')
    <button type="button" class="absolute top-0 right-0 flex h-12 w-10 cursor-pointer items-center justify-center"
      @click="showPassword = ! showPassword" aria-hidden="true">
      <i class="ft" x-bind:class="showPassword ? 'ft-eye-off' : 'ft-eye'"></i>
    </button>
  @endif

  @if ($error)
    <span class="block pt-1 text-xs text-red-600">{{ $error }}</span>
  @endif
</div>
