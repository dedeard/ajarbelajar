/**
 * Require library
 */
window.Vue = require('vue')
window.axios = require('axios').default
window.Echo = require('laravel-echo').default
window.Pusher = require('pusher-js')
window.PerfectScrollbar = require('perfect-scrollbar').default
window.Swal = require('sweetalert2/dist/sweetalert2')

/**
 * Setup laravel echo
 */
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  forceTLS: true
});


/**
 * Setup axios
 */
window.CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]')
window.API_TOKEN = document.head.querySelector('meta[name="api-token"]')
window.CSRF_TOKEN = window.CSRF_TOKEN ? window.CSRF_TOKEN.content : ''
window.API_TOKEN = window.API_TOKEN ? window.API_TOKEN.content : ''

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
if (window.CSRF_TOKEN) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.CSRF_TOKEN
if (window.API_TOKEN) window.axios.defaults.headers.common.Authorization = 'Bearer ' + window.API_TOKEN


/**
 * vue app
 */
import { VLazyImagePlugin } from 'v-lazy-image/dist/v-lazy-image.es'

//components
import StarRating from 'vue-star-rating'
import AvatarUploader from './vue/app/avatar-uploader'
import PopularVideoLg from './vue/app/popular-video-lg'
import SidebarScroll from './vue/app/sidebar-scroll'
import FeedbackList from './vue/app/feedback-list'

//directives
import Sticky from 'vue-sticky-directive'
import SidebarToggle from './vue/directives/sidabar-toggle'
import SidebarBackdrop from './vue/directives/sidebar-backdrop'
import DeleteConfirm from './vue/directives/delete-confirm'

//mixins
import FormsearchToggle from './vue/mixins/formsearch-toggle'
import NotificationCount from './vue/mixins/notification-count'

Vue.use(VLazyImagePlugin)

new Vue({
  el: "#app",
  mixins: [NotificationCount, FormsearchToggle],
  components: {
    AvatarUploader,
    PopularVideoLg,
    SidebarScroll,
    StarRating,
    FeedbackList
  },
  directives: {
    Sticky,
    SidebarToggle,
    SidebarBackdrop,
    DeleteConfirm
  }
})
