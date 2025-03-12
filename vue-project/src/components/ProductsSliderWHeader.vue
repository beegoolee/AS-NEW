<template lang="pug">
  div
    LeafTitle(:title="title" :tagType="'h1'")
    Swiper.container(v-if="arSlides" v-bind="sliderOptions")
      SwiperSlide(v-for="item in arSlides")
        ProductPreviewCard(:productData="item")
</template>

<script>
import "@/style/ProductsSliderWHeader.sass"
import 'swiper/css';
import LeafTitle from '@/components/LeafTitle.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import ProductPreviewCard from "@/components/ProductPreviewCard.vue";
import axios from "axios";

export default {
  components: {
    ProductPreviewCard,
    LeafTitle,
    Swiper,
    SwiperSlide,
  },
  props: {
    code: ''
  },
  data() {
    return {
      title: '',
      arSlides: false
    }
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/get_product_slider/" + this.code, this.$store.getters.getAxiosUserConfig()).then((res) => {
      this.title = res.data.slider_title;
      this.arSlides = res.data.slides;
    });
  },
  setup() {
    const sliderOptions = {
      slidesPerView: 5,
      loop: true,
      navigation: true,
    };

    return {
      sliderOptions,
    };
  }
}

</script>


