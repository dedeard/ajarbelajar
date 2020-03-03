$(document).ready(function(){
  // Change user avatar
  $("#input_avatar").change(function(){
    $(this).parents('form').submit()
  })

  // Confirm delete user
  $('[data-toggle="delete-confirm"]').click(function(e){
    e.preventDefault();
    var target = $(this).attr('data-target')
    swal.fire({
        title: 'Anda yakin?',
        text: "Kamu akan menghapus ini secara permanen!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak, Batalkan!',
        reverseButtons: true
    }).then(function(result){
        if (result.value) {
            $(target).submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                'Dibatalkan',
                'Data tersebut tidak dihapus :)',
                'error'
            )
        }
    });
  })
})