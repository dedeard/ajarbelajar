@props([
    'src' => '',
    'containerId' => null,
    'containerClass' => '',
])

@php
  $isM3U8 = pathinfo($src, PATHINFO_EXTENSION) === 'm3u8';
@endphp

<div x-data="videoplayer"
  @if ($containerId) id="{{ $containerId }}" @endif
  class="{{ $containerClass }} relative block aspect-video w-full">
  <video x-ref="videoElement"
    {{ $attributes->merge([
        'controls' => true,
        'autoplay' => true,
        'data-quality' => $isM3U8,
        'class' => 'video-js vjs-theme-ab absolute left-0 top-0 h-full w-full',
    ]) }}>
    @if ($isM3U8)
      <source src="{{ $src }}" type="application/x-mpegURL" />
    @else
      <source src="{{ $src }}"
        type="video/{{ pathinfo($src, PATHINFO_EXTENSION) }}" />
    @endif
  </video>
</div>
