@props([
    'type' => 'text',
    'model' => null,
    'name' => Str::random(6),
    'value' => '',
    'placeholder' => '',
    'help' => '',
])

@php
  $name = $model ?? $name;
  $error = $errors->first($name);
  if (!$value) {
      $value = $type !== 'password' ? old($name) : '';
  }
  $inputClass = 'block w-full flex-1 border-gray-300 rounded shadow placeholder:text-gray-500';
  if ($error) {
      $inputClass = $inputClass . ' border-red-600';
  }
@endphp

<div class="relative">
  @if ($type === 'select')
    <select id="{{ $name }}" class="{{ $inputClass }}" name="{{ $name }}"
      @if ($model) wire:model="{{ $name }}" @endif {{ $attributes }}>
      {{ $slot }}
    </select>
  @elseif($type === 'textarea')
    <textarea id="{{ $name }}" class="{{ $inputClass }}" type="{{ $type }}" name="{{ $name }}"
      placeholder="{{ $placeholder }}" @if ($model) wire:model="{{ $name }}" @endif {{ $attributes }}>{{ $value }}</textarea>
  @else
    <input id="{{ $name }}" class="{{ $inputClass }}" type="{{ $type }}" name="{{ $name }}"
      value="{{ $value }}" placeholder="{{ $placeholder }}"
      @if ($model) wire:model="{{ $name }}" @endif {{ $attributes }} />
  @endif
  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</div>
