<template lang="pug">
  Swiper.full-width-slider(v-if="slides.length > 0" v-bind="sliderOptions")
    SwiperSlide.full-width-slider__item(v-for="item in slides")
      a.d-flex.w-100.justify-content-center(:href="item.link")
        img(:src="item.img")
</template>

<script>
import "@/style/FullWidthSlider.sass"
import 'swiper/css';
import { Swiper, SwiperSlide } from 'swiper/vue';

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  props: {
    slides: [],
  },
  setup() {
    const sliderOptions = {
      slidesPerView: 1,
      loop: true,
      navigation: true,
    };

    return {
      sliderOptions,
    };
  }
}

</script>


