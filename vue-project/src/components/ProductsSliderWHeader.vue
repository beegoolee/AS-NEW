<template lang="pug">
  div
    LeafTitle(:title="sliderData.title" :tagType="'h1'")
    Swiper.container(v-if="sliderData.slides && sliderData.slides.length > 0" v-bind="sliderOptions")
      SwiperSlide(v-for="item in sliderData.slides")
        ProductPreviewCard(:productData="item")
</template>

<script>
import "@/style/ProductsSliderWHeader.sass"
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
    sliderData: {
      type: Object,
      default: () => ({}),
    },
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


