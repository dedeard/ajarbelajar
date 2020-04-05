import Vue from 'vue'
window.Swal = require('sweetalert2')

import AppEditorjs from './vue/editor/app-editorjs.vue'
import AppTagsInput from './vue/editor/app-tags-input.vue'
import AppHeroChose from './vue/editor/app-hero-chose.vue'
import AppVideoUploader from './vue/editor/app-video-uploader.vue'

import DeleteConfirm from './vue/directives/delete-confirm'

new Vue({
  el: '#app-editor-layout',
  components: {
    AppEditorjs,
    AppTagsInput,
    AppHeroChose,
    AppVideoUploader,
  },
  directives: {
    DeleteConfirm
  }
})
