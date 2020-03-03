$(document).ready(function(){
  // delete confirm
  $('[delete-confirm]').click(function(e){
    e.preventDefault();
    var target = $(this).attr('data-target')
    swal({
        title: 'Anda yakin?',
        text: "Kamu akan menghapus ini secara permanen!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak, Batalkan!',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
          confirmButton: 'btn btn-danger ml-1 font-weight-bold w-150',
          cancelButton: 'btn btn-primary mr-1 font-weight-bold w-150',
        }
    }, function(isConfirm) {
        if (isConfirm) $(target).submit()
      }
    )
  })
  
})