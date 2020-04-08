export default {
  bind: el => {
    el.addEventListener('click', (ev) => {
      ev.preventDefault()
      document.querySelector('body').classList.add('ab-sidebar--close')
    })
  }
}