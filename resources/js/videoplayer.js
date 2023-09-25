import Plyr from 'plyr'
import Hls from 'hls.js'
import 'plyr/dist/plyr.css'

window.Plyr = Plyr
window.Hls = Hls

document.dispatchEvent(new Event('plyr-loaded'))
