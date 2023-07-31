import jQuery from 'jquery'
import Swal from 'sweetalert2/dist/sweetalert2'
window.jQuery = window.$ = jQuery

import 'bootstrap'
import 'admin-lte'

window.Swal = Swal

window.fire = {
  success(text, options = {}) {
    Swal.fire({
      icon: 'success',
      title: 'Sukses',
      text,
      ...options,
    })
  },
  error(text, options = {}) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text,
      ...options,
    })
  },
}
