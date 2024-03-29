import './stores/notifications'
import './stores/auth'
import './stores/comment'
import './stores/delete-confirm'
import './stores/fire'
import './stores/toast'
import './stores/favorite'
import './stores/search'

import './components/markdown'
import './components/search'

Alpine.start()

function initAlpineTurboPermanentFix() {
  document.addEventListener('turbo:before-render', () => {
    let permanents = document.querySelectorAll('[data-turbo-permanent]')
    let undos = Array.from(permanents).map((el) => {
      el._x_ignore = true
      return () => {
        delete el._x_ignore
      }
    })

    Alpine.store('searchStore')?.toggleOpen?.(false)

    document.addEventListener('turbo:render', function handler() {
      while (undos.length) undos.shift()()
      document.removeEventListener('turbo:render', handler)
    })
  })
}

initAlpineTurboPermanentFix()
