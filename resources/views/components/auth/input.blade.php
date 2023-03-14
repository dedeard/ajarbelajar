@props(['type' => 'text', 'name' => Str::random(6), 'label' => 'Label', 'placeholder' => null, 'value' => ''])

@php
  $error = $errors->first($name);
  $inputClass = 'block w-full flex-1 border-gray-300 pt-5 pb-1 placeholder:text-gray-400 text-gray-700';
  if ($error) {
      $inputClass = "$inputClass border-red-600";
  }
@endphp

<div class="relative pb-3">
  @if ($label)
    <label for="{{ $name }}" class='absolute block pl-3 pt-1 text-xs font-medium'>
      {{ $label }}
    </label>
  @endif

  <input {{ $slot ? 'error="$slot"' : '' }}
    {{ $attributes->merge([
        'id' => $name,
        'class' => $inputClass,
        'type' => $type ?? 'text',
        'name' => $name,
        'placeholder' => $placeholder ? $placeholder : $label,
        'value' => $type !== 'password' ? old($name) : '',
        'autocomplete' => $name,
        'aria-label' => $type === 'password' ? 'current-password' : $label,
    ]) }} />

  @if ($error)
    <span class="block pt-1 text-xs text-red-600">{{ $error }}</span>
  @endif
</div>
