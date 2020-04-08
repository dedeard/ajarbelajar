export default {
  data() {
    return {
      formSearchShow: false
    }
  },
  methods: {
    formSearchToggleClick(ev){
      ev.preventDefault()
      this.formSearchShow = !this.formSearchShow
    }
  }
}