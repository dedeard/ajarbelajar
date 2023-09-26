import axios from "axios"

Alpine.store('favoriteStore', {
  favorites: FAVORITE_DATA || [],

  set(val) {
    this.favorites = val
  },

  favorited(lessonId) {
    return !!this.favorites.find(el => el === lessonId)
  },

  async toggle(lessonId) {
    try {
      const { favorited } = (await axios.put(`/dashboard/favorites/${lessonId}/toggle`)).data
      if(favorited) {
        this.favorites = [...[...this.favorites, lessonId].filter((x, i, a) => a.indexOf(x) == i)]
        window.fire.success('Pelajaran telah di tambahkan ke daftar favorit.')
      } else {
        this.favorites = [...this.favorites.filter((el) => el !== lessonId)]
        window.fire.success('Pelajaran telah di hapus dari daftar favorit.')
      }
    } catch(e) {
      window.fire.error(e.message)
    }
  }
})
