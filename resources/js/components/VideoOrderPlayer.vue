<template>
  <div class="player" v-if="video">
    <div class="thumb">
      <img src="https://storage.googleapis.com/ajarbelajarid.appspot.com/public/hero/04391120082020KMQCW2DRxKk8C2ix8P58zhm4L2YmcyvGKtHWYEYFjMz1CzGp1xvTX00glIJX-thumb.jpeg" alt="">
      <div class="video-player" :class="{ play }">
        <button class="btn btn-danger close-toggle" @click.prevent="stopVideo">STOP</button>
        <div class="video-wrapper">
          <video ref="video" class="video-js vjs-theme-forest">
            <source :src="video.url">
          </video>
        </div>
      </div>
    </div>
    <div class="video-info">
      ID <span>{{ video.id }}</span>
    </div>
    <div class="my-auto ml-auto px-2">
      <button type="button" class="btn btn-default btn-outline btn-sm" @click.prevent="playVideo">PLAY</button>
      <button type="button" class="btn btn-danger btn-sm" @click.prevent="handleDelete" :disabled="deleteLoading">HAPUS</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['video'],
  data() {
    return {
      player: null,
      play: false,
      deleteLoading: false,
    }
  },
  methods: {
    playVideo() {
      this.play = true
      if(!this.player) {
        this.player = window.videojs(this.$refs.video, {
          controls: true,
          controlBar: {
            children: [
              'playToggle',
              'progressControl',
              'volumePanel',
              'fullscreenToggle',
            ],
          },
          autoplay: true,
          aspectRatio: '16:9',
          fluid: true,
          preload: 'auto'
        });
      } else {
        this.$refs.video.play()
      }
    },
    stopVideo(){
      if (this.player) {
        this.$refs.video.pause()
      }
      this.play = false
    },
    handleDelete(){
      this.deleteLoading = true
      window.deleteConfirm(async () => {
        try {
          await window.axios.delete('/api/admin/videos/' + this.video.id)
          this.$emit('videodeleted', this.video)
        } catch (e) {
          console.log(e)
        }
        this.deleteLoading = false
      })
    }
  },
  beforeDestroy() {
    if (this.player) {
      this.player.dispose()
    }
  }
}
</script>

<style lang="scss">
  @import "resources/sass/_vars.scss";

  .player {
    display: flex;
    width: 100%;
    .thumb {
      padding: 10px;
      img {
        display: block;
        height: 40px;
        border-radius: 3px;
      }
    }

    .video-info {
      margin: auto 0;
      line-height: 1;
      font-size: 20px;
      font-weight: $font-weight-bold;
      color: $gray-500;
      span {
        color: $gray-800;
      }
    }
  }

  .video-player {
    width: 100px;
    min-height: 56.25px;
    display: none;

    .close-toggle {
      position: absolute;
      right: $spacer;
      top: $spacer;
      z-index: 5;
    }

    &.play {
      display: flex;
      position: fixed;
      width: 100vw;
      height: 100vh;
      z-index: 999999;
      top: 0;
      left: 0;
      background-color: rgba($black, .35);

      .video-wrapper {
        width: 100%;
        max-width: 800px;
        margin: auto;
        display: block;
        box-shadow: $box-shadow-lg;
        background-color: $white;
        margin: auto;
      }

    }
  }
</style>
