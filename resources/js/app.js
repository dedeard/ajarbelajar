/**
 * Require library
 */
window.Popper = require('popper.js').default
window.axios = require('axios').default
window.Echo = require('laravel-echo').default
window.Pusher = require('pusher-js')
window.PerfectScrollbar = require('perfect-scrollbar').default
window.Swal = require('sweetalert2')
window.Swiper = require('swiper')
window.tippy = require('tippy.js').default

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
 * Setup library
 */
tippy('[data-tippy-content]')

/**
 * import script
 */
require('./script/layout')
require('./script/avatar-toggle')
require('./script/delete-confirm')
