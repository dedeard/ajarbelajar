import Vue from 'vue'
import Editor from './vue/vendors/markadown/index'

Vue.use(Editor)

new Vue({
  el: '#markdown-editor',
  data() {
    return {
      marked: ''
    }
  },
})