<template>
  <video ref="videoPlayer" class="video-js"></video>
</template>

<script>
export default {
  props: ['src', 'autoplay', 'poster'],
  data() {
    return {
      player: null,
    }
  },
  mounted() {
    const options = {
      controls: true,
      autoplay: this.autoplay,
      aspectRatio: '16:9',
      fluid: true,
      preload: 'auto',
      poster: this.poster,
      sources: [{src: this.src}],
      plugins: {
        vjsdownload:{
        textControl: 'Download video',
        name: 'downloadButton'
      }
    }
    }
    this.player = window.videojs(this.$refs.videoPlayer, options)
  },
  beforeDestroy() {
    this.$refs.videoPlayer.pause()
    if (this.player) {
      this.player.dispose()
    }
  },
}
</script>
