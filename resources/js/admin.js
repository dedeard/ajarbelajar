window.CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]')
window.API_TOKEN = document.head.querySelector('meta[name="api-token"]')
window.CSRF_TOKEN = window.CSRF_TOKEN ? window.CSRF_TOKEN.content : ''
window.API_TOKEN = window.API_TOKEN ? window.API_TOKEN.content : ''

window.axios = require('axios').default

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
if (window.CSRF_TOKEN) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.CSRF_TOKEN
if (window.API_TOKEN) window.axios.defaults.headers.common.Authorization = 'Bearer ' + window.API_TOKEN

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