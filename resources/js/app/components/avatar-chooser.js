export default {
  data() {
    return {
      url: '',
      file: null,
      name: ''
    }
  },
  methods: {
    handleClick(e){
      e.preventDefault()
      this.$refs.input.click()
    },
    handleChange(ev){
      const files = ev.target.files
      if(!files.length) return false
      this.file = files[0]
      if(!this.file) return false
      this.name = this.file.name
      const reader = new FileReader()
      const self = this
      reader.onload = function(){
        self.url = reader.result
      }
      reader.readAsDataURL(this.file)
    }
  },
}
