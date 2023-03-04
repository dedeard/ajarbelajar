import axios from 'axios'
import Alpine from 'alpinejs'
import * as Turbo from '@hotwired/turbo'
import Swal from 'sweetalert2'
// import Echo from 'laravel-echo'
// import Pusher from 'pusher-js'

window.Alpine = Alpine
window.axios = axios
window.Turbo = Turbo
window.Swal = Swal
// window.Pusher = Pusher
// window.Echo = Echo

// window.echoConfig = {
//   broadcaster: 'pusher',
//   key: import.meta.env.VITE_PUSHER_APP_KEY,
//   wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//   wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//   wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//   forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//   enabledTransports: ['ws', 'wss'],
// }
