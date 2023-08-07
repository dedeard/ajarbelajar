import videojs from 'video.js'
import hlsQualitySelector from './hlsQualitySelector'
import 'video.js/dist/video-js.css'

hlsQualitySelector(videojs)

document.addEventListener('alpine:init', () => {
  Alpine.data('videoplayer', () => ({
    video: null,
    player: null,
    init() {
      this.video = this.$refs.videoElement
      this.player = videojs(this.video, {
        controlBar: {
          pictureInPictureToggle: false,
        },
        disablePictureInPicture: true,
      })

      if (this.video.dataset.quality) {
        this.player.hlsQualitySelector({
          displayCurrentQuality: true,
        })
      }
    },
  }))
})
