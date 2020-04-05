<template>
  <div class="upload-video-wrapper">
    <div class="upload-video-content">
      <p class="message">{{ message }}</p>
    </div>
    <input type="file" @change="handleChange" :disabled="disabled">
  </div>
</template>

<script>
import axios from 'axios'
import FormData from 'form-data'

export default {
  props: ['upload-url'],
  data() {
    return {
      file: null,
      disabled: false,
      message: 'Jatuhkan Video anda disini atau Klik disini.'
    }
  },
  methods: {
    onUploadProgress(ev) {
      var percentCompleted = Math.round((ev.loaded * 100) / ev.total)
      if(percentCompleted === 100){
        this.message = 'Video anda sedang diproses...';
      } else {
        this.message = 'Sedang mengupload ' + this.file.name + ' total ' + percentCompleted + '%'
      }
    },
    handleChange(ev) {
      const files = ev.target.files
      if(!files.length) return false
      this.file = files[0]
      if(!this.file) return false

      this.disabled = true
      const data = new FormData
      data.append('file', this.file)

      axios.post(this.uploadUrl, data, { onUploadProgress: this.onUploadProgress })
      .then(function(res) {
        window.location.reload(true)
      }).catch(err => {
        this.disabled = false
        if(err.response && err.response.data && err.response.data.message) {
          this.message = err.response.data.message
        }else {
          this.message = "Gagal mengupload file!"
        }
      })
    }
  }
}
</script>