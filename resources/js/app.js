window.CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]')
window.API_TOKEN = document.head.querySelector('meta[name="api-token"]')
window.CSRF_TOKEN = window.CSRF_TOKEN ? window.CSRF_TOKEN.content : ''
window.API_TOKEN = window.API_TOKEN ? window.API_TOKEN.content : ''

/**
 * Init bootstrap and jquery
 */
window.Popper = require('popper.js').default
window.$ = window.jQuery = require('jquery')
window.axios = require('axios').default

require('bootstrap')
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


/**
 * Require library
 */
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');
window.PerfectScrollbar = require('perfect-scrollbar').default
window.Swal = require('sweetalert2')
window.Ladda = require('ladda')
require('owl.carousel2')
require('dropify')
require('./vendors/tagsinput')

 // Setup axios
 window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
 if (window.CSRF_TOKEN) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.CSRF_TOKEN
 if (window.API_TOKEN) window.axios.defaults.headers.common.Authorization = 'Bearer ' + window.API_TOKEN



window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  forceTLS: true
});

if(AUTH_ID) {
  if(NOTIFICATION_COUNT > 0) $('[notification-count]').text(NOTIFICATION_COUNT);
  window.Echo.private('App.User.' + AUTH_ID)
  .notification((notification) => {
    NOTIFICATION_COUNT++;
    $('[notification-count]').text(NOTIFICATION_COUNT);
  });
}


;(function(){

  // preloader
  $(document).ready(() => {
    setTimeout(() => {
      $('body').removeClass('preload')
    }, 500)
  })


  // form search toggle
  $(document).ready(function(){
    let open = false
    $(document).click(function (e) {
      var t = $(e.target)
      var hitBtn = t.closest('[data-toggle="header-form-search"]').length

      if(hitBtn) e.preventDefault()
      if (!open && hitBtn) {
        $('#header-form-search').show()
        open = true
        return 0
      }
      if(!t.closest("#header-form-search").length) {
        $('#header-form-search').hide()
        open = false
      }
    })
  })



  // sidebar
  if($('#ab-sidebar--toggle-size').css('opacity') === "1") {
    $('body').addClass('ab-sidebar--close')
  } else {
    if(window.SIDEBAR_CLOSE) {
      $('body').addClass('ab-sidebar--close')
    } else {
      $('body').removeClass('ab-sidebar--close')
    }
  }
  $(document).ready(function(){
    $('[data-toggle="sidebar"]').click(function (e) {
      e.preventDefault()
      $('body').toggleClass('ab-sidebar--close')
    })
    $("#ab-sidebar-backdrop").click(function (e) {
      $('body').addClass('ab-sidebar--close')
      e.preventDefault()
    })

    let sidebarPs = null
    const sidebarScroll = () => {
      if ($('#ab-sidebar-scroll').css('overflow-y') != 'auto') {
        if(!sidebarPs) {
          sidebarPs = new PerfectScrollbar('#ab-sidebar-scroll')
        }
      } else {
        if(sidebarPs) {
          sidebarPs.destroy()
          sidebarPs = null
        }
      }
    }
    sidebarScroll()
    $(window).resize(() => {
      if($('#ab-sidebar--toggle-size').css('opacity') !== "1") {
        if(!window.SIDEBAR_CLOSE) {
          $('body').removeClass('ab-sidebar--close')
        }
      }
      sidebarScroll()
    })
  })



  // Custom avatar toggler
  $(document).ready(function(){
    $('[data-toggle="avatar-uploader"]').click(function(e) {
      e.preventDefault()
      const target = $(this).attr('data-target')
      $(target).click()
    })

    $('[data-toggle="avatar-uploader"]').each(function(){
      const target = $(this).attr('data-target')
      $(target).change(function() {
        var fn = $(this).val()
        var filename = fn.match(/[^\\/]*$/)[0];
        $(this).parent().children('p').html(filename)
      })
    })
  })



  // delete confirm
  $('[delete-confirm]').click(function(e){
    e.preventDefault();
    var target = $(this).attr('data-target')
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
        $(target).submit();
      }
    });
  })


  // home owl.carousel
  $(document).ready(function(){
    $(".owl-carousel.owl-carousel-landing").owlCarousel({
      loop: true,
      nav: true,
      responsive: {
        0: {
          items: 1
        },
        992: {
          items: 2
        }
      },
      dots: false
    })
  })

  // library
  $(document).ready(function(){
    $('.tags-input').tagsinput()
    $('.dropify').dropify();
    Ladda.bind('button.ladda-button')
  })
}());
