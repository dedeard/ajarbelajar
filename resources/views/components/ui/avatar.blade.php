@props(['name' => null, 'alpine' => false])

@php
  if (!$alpine) {
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
  }
@endphp

@if ($alpine)
  <svg x-data="{
      initial: '',
      fontSize: 30,
      translateY: 0,
      parse() {
          let parts = name.split(/[ -]/);
          this.initials = '';
          for (let part of parts) {
              this.initials += part[0];
          }
  
          if (this.initials.length > 3 && /[A-Z]/.test(this.initials)) {
              this.initials = this.initials.replace(/[a-z]+/g, '');
          }
  
          this.initials = this.initials.substr(0, 2).toUpperCase();
  
          if (this.initials.length === 2) {
              this.fontSize = 27;
          }
          this.translateY = this.fontSize / 3;
      }
  }" x-init="parse" {{ $attributes->merge(['viewBox' => '0 0 60 60', 'class' => 'h-full w-full block']) }}>
    <title x-text="name"></title>
    <rect class="fill-primary-100" x="0" y="0" width="60" height="60" />
    <text class="fill-primary-700" x="50%" y="50%" x-bind:transform="`translate(0 ${translateY})`" text-anchor="middle"
      font-family="Roboto, sans-serif" font-weight="700" x-bind:font-size="fontSize" x-text="initials"></text>
  </svg>
@else
  <svg {{ $attributes->merge(['viewBox' => '0 0 60 60', 'class' => 'h-full w-full block']) }}>
    <title>{{ $name }}</title>
    <rect class="fill-primary-100" x="0" y="0" width="60" height="60" />
    <text class="fill-primary-700" x="50%" y="50%" transform="translate(0 {{ $translateY }})" text-anchor="middle"
      font-family="Roboto, sans-serif" font-weight="700" font-size="{{ $fontsize }}">{{ $initials }}</text>
  </svg>
@endif
