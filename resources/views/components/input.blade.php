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
  $inputClass = 'block w-full border flex-1 border-gray-300 placeholder:text-gray-500';
  if ($error) {
      $inputClass = $inputClass . ' border-red-600';
  }
  if ($type === 'password') {
      $inputClass = $inputClass . ' pr-8';
  }
@endphp

<div class="relative" x-data="{ showPassword: false }">
  @if ($type === 'select')
    <select id="{{ $name }}" class="{{ $inputClass }}"
      name="{{ $name }}"
      @if ($model) wire:model="{{ $name }}" @endif
      {{ $attributes }}>
      {{ $slot }}
    </select>
  @elseif($type === 'textarea')
    <textarea id="{{ $name }}" class="{{ $inputClass }}"
      type="{{ $type }}" name="{{ $name }}"
      placeholder="{{ $placeholder }}"
      @if ($model) wire:model="{{ $name }}" @endif
      {{ $attributes }}>{{ $value }}</textarea>
  @elseif($type === 'file')
    <div class="{{ $inputClass }} !flex">
      <span class="h-100 flex h-10 items-center bg-gray-300 px-3">PILIH
        FILE</span>
      <span
        class="my-auto block flex-1 px-3 leading-6">{{ $placeholder }}</span>
    </div>
    <input id="{{ $name }}" class="hidden" type="file"
      name="{{ $name }}"
      @if ($model) wire:model="{{ $name }}" @endif
      {{ $attributes }} />
  @else
    <input id="{{ $name }}" class="{{ $inputClass }}"
      type="{{ $type }}" name="{{ $name }}"
      value="{{ $value }}" placeholder="{{ $placeholder }}"
      x-bind:type="{{ $type === 'password' ? "showPassword ? 'text' : 'password'" : "'text'" }}"
      @if ($model) wire:model="{{ $name }}" @endif
      {{ $attributes }} />

    @if ($type === 'password')
      <button type="button"
        class="absolute right-0 top-0 flex h-10 w-10 cursor-pointer items-center justify-center"
        aria-hidden="true" @click="showPassword = ! showPassword">
        <i class="ft"
          x-bind:class="showPassword ? 'ft-eye-off' : 'ft-eye'"></i>
      </button>
    @endif
  @endif
  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</div>
