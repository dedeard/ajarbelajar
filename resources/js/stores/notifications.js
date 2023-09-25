/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine
/** @type {import('laravel-echo').default} */
const Echo = window.Echo

Alpine.store('notificationStore', {
  count: NOTIFICATION_COUNT || 0,
  init() {
    Echo.private(`App.Models.User.${AUTH_DATA?.id}`).notification(() => {
      this.count++
    })
  },
  set(val) {
    this.count = val
  },
})
