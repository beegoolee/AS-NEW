<template lang="pug">
  component
    leaf-title(:title="title")
    Swiper.full-width-slider(v-if="arSlides" v-bind="sliderOptions")
      SwiperSlide.full-width-slider__item(v-for="(item, index) in arSlides" :key="index")
        a.d-flex.w-100.justify-content-center(:href="item.link")
          img(:src="item.image")
</template>

<script>
import "@/style/FullWidthSlider.sass"
import 'swiper/css';

import { Swiper, SwiperSlide } from 'swiper/vue';
import LeafTitle from "@/components/LeafTitle.vue";
import axios from "axios";

export default {
  components: {
    LeafTitle,
    Swiper,
    SwiperSlide,
  },
  props: ['code'],
  data() {
    return {
      title: '',
      arSlides: false
    }
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
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/get_slider/" + this.code, this.$store.getters.getAxiosUserConfig()).then((res) => {
      this.title = res.data.slider_title;
      this.arSlides = res.data.slides;
    });
  }
}

</script>


