Alpine.store('searchModal', {
  show: false,
  toggle() {
    this.show = !this.show
  },
  open() {
    this.show = true
  },
  close() {
    this.show = false
  },
})
