var mySwiper = new window.Swiper('#ab-popular-video-lg', {
  loop: true,
  effect: 'coverflow',
  speed: 600,
  autoplay: {
    delay: 5000,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
})