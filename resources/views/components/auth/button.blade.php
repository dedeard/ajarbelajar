@props(['value', 'variant' => 'primary'])

@php
  $btnClass = 'group relative inline-block w-1/2 cursor-pointer select-none items-center justify-center p-4 text-center text-sm font-semibold uppercase leading-none tracking-wider text-white disabled:text-transparent disabled:opacity-70 hover:disabled:cursor-wait';
  if ($variant === 'primary') {
      $btnClass = $btnClass . ' bg-primary-600 hover:bg-primary-700 hover:disabled:bg-primary-600';
  } elseif ($variant === 'red') {
      $btnClass = $btnClass . ' bg-red-600 hover:bg-red-700 hover:disabled:bg-red-600';
  }
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $btnClass]) }}>
  {{ $value ?? $slot }}
  <span aria-hidden="true" class="absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 transform group-disabled:block">
    <svg viewBox="0 0 50 50" class="h-9 w-9 text-white">
      <circle fill="currentColor" stroke="none" cx="5" cy="25" r="5">
        <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1" />
      </circle>
      <circle fill="currentColor" stroke="none" cx="25" cy="25" r="5">
        <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2" />
      </circle>
      <circle fill="currentColor" stroke="none" cx="45" cy="25" r="5">
        <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3" />
      </circle>
    </svg>
  </span>
</button>
