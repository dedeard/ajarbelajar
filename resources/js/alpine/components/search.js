/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine

/** @type {import('axios')} */
const axios = window.axios

Alpine.data('search', () => ({
  focus: true,
  input: '',
  typing: false,
  typingTimeout: null,

  init() {
    this.input = this.$store.searchStore.queryResult
    this.$refs.input?.focus()

    this.$watch('input', (val) => {
      if (val.length > 1) {
        this.typing = true
        if (this.typingTimeout) {
          clearTimeout(this.typingTimeout)
        }
        this.typingTimeout = setTimeout(() => {
          this.typing = false
        }, 1000)
      }
    })

    this.$watch('typing', (val) => {
      if (!val && this.input.length > 1) {
        this.$store.searchStore.search(this.input)
      }
    })
  },

  reset() {
    this.input = ''
    this.$store.searchStore.reset()
  },

  get empty() {
    return !this.input
  },

  get logging() {
    if (this.input.length > 1) {
      if (this.typing) {
        return 'Sedang mengetik...'
      }
      if (this.$store.searchStore.loading) {
        return 'Sedang mencari...'
      }
    }
    return ''
  },

  get searchResults() {
    if (this.input.length > 1) {
      return this.$store.searchStore.results
    }
    return []
  },

  get queryResult() {
    return this.$store.searchStore.queryResult
  },
}))
