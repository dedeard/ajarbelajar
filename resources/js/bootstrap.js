import axios from 'axios'
import Alpine from 'alpinejs'
import * as Turbo from '@hotwired/turbo'
import Swal from 'sweetalert2'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Alpine = Alpine
window.axios = axios
window.Turbo = Turbo
window.Swal = Swal
window.Pusher = Pusher
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: false,
})
