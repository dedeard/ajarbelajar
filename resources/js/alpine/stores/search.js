/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine

/** @type {import('axios')} */
const axios = window.axios

Alpine.store('searchStore', {
  open: false,
  loading: false,
  results: [],
  queryResult: '',

  toggleOpen(open) {
    if (typeof open === 'boolean') {
      this.open = open
    } else {
      this.open = !this.open
    }
  },

  reset() {
    this.results = []
    this.queryResult = ''
  },

  async search(search) {
    this.loading = true
    try {
      const { data } = await axios.post('/search', { search })
      this.results = data.results
      this.queryResult = data.input
    } catch (e) {
      console.log(e)
    }
    this.loading = false
  },
})
