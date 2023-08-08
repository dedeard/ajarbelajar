import videojs from 'video.js'
import hlsQualitySelector from './hlsQualitySelector'
import 'video.js/dist/video-js.css'

hlsQualitySelector(videojs)

window.videojs = videojs

document.dispatchEvent(new Event('videojs-loaded'))
