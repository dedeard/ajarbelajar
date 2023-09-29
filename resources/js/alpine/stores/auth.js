/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine

Alpine.store('authStore', {
  auth: window.AUTH_DATA || null,
  set(val) {
    this.auth = val
  },
})
