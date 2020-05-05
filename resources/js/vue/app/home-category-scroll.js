export default {
  data() {
    return {
      elScroll: null,
      elScrollStyle: null,
      ps: null,
      open: false
    }
  },
  methods: {
    scroll(){
      if (this.elScrollStyle.getPropertyValue('overflow-y') != 'auto') {
        if(!this.ps) {
          this.ps = new PerfectScrollbar(this.elScroll)
        }
      } else {
        if(this.ps) {
          this.ps.destroy()
          this.ps = null
        }
      }
    }
  },
  mounted() {
    this.elScroll = this.$refs.elScroll
    this.elScrollStyle = window.getComputedStyle(this.elScroll)
    this.scroll()
    window.onresize = this.scroll
  }
}