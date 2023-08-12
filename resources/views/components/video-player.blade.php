@props([
    'src' => '',
    'containerId' => null,
    'containerClass' => '',
])

@php
  $isM3U8 = pathinfo($src, PATHINFO_EXTENSION) === 'm3u8';
@endphp

<div x-data="{
    video: null,
    player: null,
    init() {
        if (typeof window.videojs === 'function') {
            this.initPlayer()
        }
        document.addEventListener('videojs-loaded', this.initPlayer.bind(this))
    },
    initPlayer() {
        if (!this.player) {
            this.video = this.$refs.videoElement
            this.player = videojs(this.video, {
                controlBar: {
                    pictureInPictureToggle: false,
                },
                disablePictureInPicture: true,
            })

            if (this.video.dataset.quality) {
                this.player?.hlsQualitySelector({
                    displayCurrentQuality: true,
                })
            }
        }
    },
    destroy() {
        document.removeEventListener('videojs-loaded', this.initPlayer.bind(this))
        if (this.player) {
            this.player.dispose()
        }
    }
}"
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
      <source src="{{ $src }}" />
    @endif
  </video>
</div>
