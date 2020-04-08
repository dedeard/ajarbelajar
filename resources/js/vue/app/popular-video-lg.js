import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
export default {
  data() {
    return {
      swiperOptions: {
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
      }
    }
  },
  components: {
    Swiper,
    SwiperSlide
  }
}
