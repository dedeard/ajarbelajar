export default {
  data() {
    return {
      notificationCount: 0
    }
  },
  created(){
    if(AUTH_ID) {
      this.notificationCount = NOTIFICATION_COUNT
      window.Echo.private('App.User.' + AUTH_ID).notification(() => {
        this.notificationCount++
      })
    }
  }
}