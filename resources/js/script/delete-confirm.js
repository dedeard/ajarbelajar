const elToggles = document.querySelectorAll('[delete-confirm]')

elToggles.forEach(elToggle => {
  const elTarget = document.querySelector(elToggle.getAttribute('data-target'))
  elToggle.addEventListener('click', function(e){
    e.preventDefault()
    Swal.fire({
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
        elTarget.submit()
      }
    });
  })
})
