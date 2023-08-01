// Import required libraries
import jQuery from 'jquery'
import Swal from 'sweetalert2/dist/sweetalert2'
window.jQuery = window.$ = jQuery

import 'bootstrap'
import 'admin-lte'

// Assign SweetAlert2 to the global variable
window.Swal = Swal

// Custom wrapper for Swal.fire
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

// Document ready event
$(function () {
  // Function to handle delete confirmation
  function handleDeleteConfirmation() {
    const target = $(this).attr('delete-confirm')
    Swal.fire({
      title: 'Anda yakin?',
      text: 'Kamu akan menghapus ini secara permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Tidak, Batalkan!',
      reverseButtons: true,
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-primary',
      },
    }).then(function (result) {
      if (result.value) {
        $(target).submit()
      }
    })
  }

  // Attach click event handler for delete confirmation
  $(document).on('click', '[delete-confirm]', handleDeleteConfirmation)
})
