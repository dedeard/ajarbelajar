<template>
  <div class="video-uploader">
    <p class="message">{{ message }}</p>
    <input type="file" @change="handleChange" :disabled="disabled">
  </div>
</template>

<script>
import FormData from 'form-data'

export default {
  props: ['upload-url'],
  data() {
    return {
      file: null,
      disabled: false,
      message: 'Jatuhkan Video disini atau Klik disini.'
    }
  },
  methods: {
    onUploadProgress(ev) {
      var percentCompleted = Math.round((ev.loaded * 100) / ev.total)
      if (percentCompleted === 100) {
        this.message = 'Video anda sedang diproses...';
      } else {
        this.message = 'Sedang mengupload ' + this.file.name + ' total ' + percentCompleted + '%'
      }
    },
    handleChange(ev) {
      const files = ev.target.files
      if (!files.length) return false
      this.file = files[0]
      if (!this.file) return false

      this.disabled = true
      const data = new FormData
      data.append('file', this.file)

      window.axios.post(this.uploadUrl, data, {
        onUploadProgress: this.onUploadProgress
      })
      .then((res) => {
        console.log(res.data)
        this.$emit('newvideo', res.data)
        this.message = 'Jatuhkan Video disini atau Klik disini.'
        this.file = null
        this.disabled = false
      }).catch(err => {
        if (err.response && err.response.data && err.response.data.message) {
          this.message = err.response.data.message
        } else {
          this.message = "Gagal mengupload file!"
        }
        this.file = null
        this.disabled = false
      })
    }
  }
}
</script>

<style lang="scss">
  @import "resources/sass/_vars.scss";
  .video-uploader {
    display: block;
    position: relative;
    border: 1px solid $gray-200;
    background-color: rgba($gray-200, .5);
    text-align: center;
    font-size: 16px;
    font-weight: $font-weight-medium;
    padding: $spacer;

    &:hover {
      background-color: $gray-200;
    }
    .message {
      margin: 0;
      padding: $spacer 0;
      text-transform: uppercase;
    }

    input {
      position: absolute;
      display: block;
      background-color: $primary;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      opacity: 0;
      z-index: 3;
    }
  }
</style>
