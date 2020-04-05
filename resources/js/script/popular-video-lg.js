var mySwiper = new window.Swiper('#ab-popular-video-lg', {
  loop: true,
  cubeEffect: {
    slideShadows: false,
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