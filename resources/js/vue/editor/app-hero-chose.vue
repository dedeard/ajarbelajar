<template>
  <div class="ab-hero-chose">
    <img :src="newUrl || defaultImg" class="img-fluid">
    <button class="btn btn-primary btn-sm btn-block my-10" @click="handleClick">Ubah Gambar</button>
    <input type="file" class="d-none" ref="input" :name="name" @change="handleChange">
  </div>
</template>

<script>
export default {
  props: ['default-img', 'name'],
  data() {
    return {
      file: null,
      newUrl: ''
    }
  },
  methods: {
    handleClick(ev){
      ev.preventDefault()
      this.$refs.input.click()
    },
    handleChange(ev) {
      const files = ev.target.files
      if(!files.length) return false
      this.file = files[0]
      if(!this.file) return false

      const reader = new FileReader()
      const self = this
      reader.onload = function(){
        self.newUrl = reader.result
      }
      reader.readAsDataURL(this.file)
    }
  }
}
</script>