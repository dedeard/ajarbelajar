/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine
/** @type {import('laravel-echo').default} */
const Echo = window.Echo

Alpine.store('notificationStore', {
  count: window.NOTIFICATION_COUNT || 0,
  init() {
    if (window.AUTH_DATA) {
      Echo.private(`App.Models.User.${window.AUTH_DATA.id}`).notification(() => {
        this.count++
      })
    }
  },
  set(val) {
    this.count = val
  },
})
