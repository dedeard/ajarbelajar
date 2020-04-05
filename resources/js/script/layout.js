const sidebarToggles = document.querySelectorAll('[data-toggle="sidebar"]')
const elBody = document.querySelector('body')
const sidebarBackdrop = document.querySelector('#ab-sidebar-backdrop')
const elSidebarScroll = document.querySelector('#ab-sidebar-scroll')
const elNotificationCounts = document.querySelectorAll('[notification-count]')


sidebarToggles.forEach(sidebarToggle => {
  sidebarToggle.addEventListener('click', (ev) => {
    ev.preventDefault()
    elBody.classList.toggle('ab-sidebar--close')
  })
})

sidebarBackdrop.addEventListener('click', (ev) => {
  ev.preventDefault()
  elBody.classList.add('ab-sidebar--close')
})


let sidebarPs = null
const sidebarScroll = () => {
  const elSidebarScrollStyle = window.getComputedStyle(elSidebarScroll)

  if (elSidebarScrollStyle.getPropertyValue('overflow-y') != 'auto') {
    if(!sidebarPs) {
      sidebarPs = new PerfectScrollbar(elSidebarScroll)
    }
  } else {
    if(sidebarPs) {
      sidebarPs.destroy()
      sidebarPs = null
    }
  }
}
sidebarScroll()
window.onresize = function(){
  sidebarScroll()
}


if(AUTH_ID) {
  if(NOTIFICATION_COUNT > 0) {
    elNotificationCounts.forEach(elNotificationCount => {
      elNotificationCount.innerHTML = NOTIFICATION_COUNT
    })
  }
  window.Echo.private('App.User.' + AUTH_ID)
  .notification(() => {
    NOTIFICATION_COUNT++
    elNotificationCounts.forEach(elNotificationCount => {
      elNotificationCount.innerHTML = NOTIFICATION_COUNT
    })
  })
}