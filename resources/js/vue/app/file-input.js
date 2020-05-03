export default {
  data() {
    return {
      url: '',
      file: null,
      name: ''
    }
  },
  methods: {
    handleChange(ev){
      const files = ev.target.files
      if(!files.length) return false
      this.file = files[0]
      if(!this.file) return false
      this.name = this.file.name
    }
  }
}
