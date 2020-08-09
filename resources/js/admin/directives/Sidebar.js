export const toggleSidebar = {
  bind: (el) => {
    el.addEventListener('click', (ev) => {
      ev.preventDefault()
      document.querySelector('body').classList.toggle('sidebar-open')
    })
  }
}

export const openSidebar = {
  bind: (el) => {
    el.addEventListener('click', (ev) => {
      ev.preventDefault()
      document.querySelector('body').classList.add('sidebar-open')
    })
  }
}

export const closeSidebar = {
  bind: (el) => {
    el.addEventListener('click', (ev) => {
      ev.preventDefault()
      document.querySelector('body').classList.remove('sidebar-open')
    })
  }
}
