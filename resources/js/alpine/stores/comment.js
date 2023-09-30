/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine

Alpine.store('commentStore', {
  comments: [],
  loadLoading: false,
  loadErrorMessage: '',
  createLoading: false,
  destroyLoading: false,
  likeLoading: false,
  async load(route) {
    this.loadErrorMessage = ''
    this.loadLoading = true
    try {
      this.comments = (await window.axios.get(route)).data
    } catch (e) {
      this.loadErrorMessage = e.response?.data.message || e.message
      window.fire.error(this.error)
    }
    this.loadLoading = false
  },
  async create(route, body) {
    this.createLoading = true
    try {
      const { data } = await axios.post(route, { body })
      window.fire.success('Berhasil membuat komentar')
      this.comments = [data, ...this.comments]
      this.createLoading = false
      return true
    } catch (e) {
      window.fire.error(e.response?.data.message || e.message)
      this.createLoading = false
      return false
    }
  },
  async destroy(route, id) {
    this.destroyLoading = true
    try {
      await axios.delete(route)
      window.fire.success('Berhasil menghapus komentar')
      this.comments = [...this.comments.filter((el) => el.id !== id)]
    } catch (e) {
      window.fire.error(e.response?.data.message || e.message)
    }
    this.destroyLoading = false
  },
  async likeToggle(route, id) {
    this.likeLoading = true
    try {
      const { data } = await axios.get(route)
      this.comments = [
        ...this.comments.map((el) => {
          if (el.id == id) {
            return {
              ...el,
              liked: data.liked,
              like_count: data.liked ? el.like_count++ : el.like_count--,
            }
          }
          return el
        }),
      ]
    } catch {}
    this.likeLoading = false
  },
})
