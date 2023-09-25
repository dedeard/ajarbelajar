@props([
    'containerId' => null,
    'containerClass' => '',
    'poster' => '',
    'episode',
])

@php
  $source = $episode->video_url;
  $isHls = pathinfo($source, PATHINFO_EXTENSION) === 'm3u8';
  $options = [
      'title' => $episode->title,
      'poster' => $poster,
      'controls' => true,
      'autoplay' => true,
  ];
@endphp

<div x-data="{
    video: null,
    player: null,
    hls: null,
    source: '{{ $source }}',
    options: @js($options),
    isHls: {{ $isHls ? 'true' : 'false' }},
    init() {
        if (typeof window.Plyr === 'function') {
            this.initPlayer()
        }
        document.addEventListener('plyr-loaded', this.initPlayer.bind(this))
    },
    initPlayer() {
        if (!this.player) {
            this.video = this.$refs.videoElement
            if (this.isHls && window.Hls.isSupported()) {
                this.hls = new window.Hls()
                this.hls.loadSource(this.source)
                this.hls.attachMedia(this.video)
                this.hls.on(window.Hls.Events.MANIFEST_PARSED, (event, data) => {
                    const availableQualities = this.hls.levels.map((l) => l.height)
                    this.defaultOptions = {
                        ...this.defaultOptions,
                        quality: {
                            default: availableQualities[0],
                            options: availableQualities,
                            forced: true,
                            onChange: (e) => this.updateQuality(e),
                        }
                    }
                    this.player = new window.Plyr(this.video, this.defaultOptions);
                });
            } else {
                this.player = new window.Plyr(this.video, this.defaultOptions);
            }
        }
        window.Self = this
    },
    updateQuality(newQuality) {
        console.log(newQuality)
        this.hls.levels.forEach((level, levelIndex) => {
            if (level.height === newQuality) {
                this.hls.currentLevel = levelIndex;
            }
        });
    },
    destroy() {
        document.removeEventListener('plyr-loaded', this.initPlayer.bind(this))
        if (this.player) {
            this.player.destroy()
        }
    }
}" @if ($containerId)
  id="{{ $containerId }}"
  @endif
  class="{{ $containerClass }} relative block aspect-video w-full">

  <video x-ref="videoElement" controls crossorigin="anonymous" playsinline
    class="h-full w-full">
    @if ($isHls)
      <source src="{{ $source }}" type="application/x-mpegURL" />
    @else
      <source src="{{ $source }}" />
    @endif

    @foreach ($episode->subtitles as $sub)
      <track kind="subtitles" label="{{ $sub->name }}"
        srclang="{{ $sub->code }}" src="{{ $sub->url }}" />
    @endforeach
  </video>
</div>
