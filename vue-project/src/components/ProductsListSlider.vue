<template lang="pug">
  .products-list-slider
    LeafTitle(:title="title" :tagType="'h1'")
    Swiper.container(v-if="arSlides" v-bind="sliderOptions")
      SwiperSlide(v-for="item in arSlides")
        ProductPreviewCard(:productData="item")
</template>

<script>
import "@/style/ProductsListSlider.sass"
import 'swiper/css';
import LeafTitle from '@/components/LeafTitle.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import ProductPreviewCard from "@/components/ProductPreviewCard.vue";

export default {
  components: {
    ProductPreviewCard,
    LeafTitle,
    Swiper,
    SwiperSlide,
  },
  props: {
    arSlides: [],
    title: ''
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


