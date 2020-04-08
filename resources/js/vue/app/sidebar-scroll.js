export default {
  data() {
    return {
      elSidebarScroll: null,
      elSidebarScrollStyle: null,
      sidebarPs: null
    }
  },
  methods: {
    sidebarScroll(){
      if (this.elSidebarScrollStyle.getPropertyValue('overflow-y') != 'auto') {
        if(!this.sidebarPs) {
          this.sidebarPs = new PerfectScrollbar(this.elSidebarScroll)
        }
      } else {
        if(this.sidebarPs) {
          this.sidebarPs.destroy()
          this.sidebarPs = null
        }
      }
    }
  },
  mounted() {
    this.elSidebarScroll = this.$refs.elSidebarScroll
    this.elSidebarScrollStyle = window.getComputedStyle(this.elSidebarScroll)
    this.sidebarScroll()
    window.onresize = this.sidebarScroll
  }
}