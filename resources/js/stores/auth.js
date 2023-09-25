Alpine.store('authStore', {
  auth: AUTH_DATA || null,
  set(val) {
    this.auth = val
  },
})
