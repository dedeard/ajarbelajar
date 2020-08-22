window.deleteConfirm = (cb = null) => window.Swal.fire({
  title: 'Anda yakin?',
  text: "Kamu akan menghapus ini secara permanen!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Ya, Hapus!',
  cancelButtonText: 'Tidak, Batalkan!',
  reverseButtons: true,
  buttonsStyling: false,
  customClass: {
    confirmButton: 'btn btn-danger ml-1 font-weight-bold w-150',
    cancelButton: 'btn btn-primary mr-1 font-weight-bold w-150',
  }
}).then(function(result){
  if (result.value) {
    if(cb) cb()
    return result
  }
})

export default {
  bind: (el, binding) => {
    el.addEventListener('click', (e) => {
      e.preventDefault()
      const target = document.getElementById(binding.arg)
      if(target) {
        window.Swal.fire({
          title: 'Anda yakin?',
          text: "Kamu akan menghapus ini secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Tidak, Batalkan!',
          reverseButtons: true,
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-danger ml-1 font-weight-bold w-150',
            cancelButton: 'btn btn-primary mr-1 font-weight-bold w-150',
          }
        }).then(function(result){
          if (result.value) {
            target.submit()
          }
        })
      }
    })
  }
}
