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
  info(text, options = {}) {
    Swal.fire({
      icon: 'info',
      title: 'Info',
      text,
      ...options,
    })
  },
  warning(text, options = {}) {
    Swal.fire({
      icon: 'warning',
      title: 'Warning',
      text,
      ...options,
    })
  },
}

Alpine.store('fire', window.fire)
