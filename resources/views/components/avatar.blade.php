@props(['name'])

@php
  $parts = preg_split('/[ -]/', $name);
  $initials = '';
  foreach ($parts as $part) {
      $initials .= $part[0];
  }
  
  if (strlen($initials) > 3 && preg_match('/[A-Z]/', $initials)) {
      $initials = preg_replace('/[a-z]+/', '', $initials);
  }
  
  $initials = strtoupper(substr($initials, 0, 2));
  
  $fontsize = 30;
  if (strlen($initials) === 2) {
      $fontsize = 27;
  }
  $translateY = $fontsize / 3;
  
@endphp

<svg
  {{ $attributes->merge(['viewBox' => '0 0 60 60', 'class' => 'h-full w-full block']) }}>
  <title>{{ $name }}</title>
  <rect class="fill-primary-100" x="0" y="0" width="60"
    height="60" />
  <text class="fill-primary-700" x="50%" y="50%"
    transform="translate(0 {{ $translateY }})" text-anchor="middle"
    font-family="Roboto, sans-serif" font-weight="700"
    font-size="{{ $fontsize }}">{{ $initials }}</text>
</svg>
