$(function () {
  $(document).on('click', '[delete-confirm]', function () {
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
  })
})
