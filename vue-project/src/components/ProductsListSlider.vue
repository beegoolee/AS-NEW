<template lang="pug">
  .products-list-slider
    LeafTitle(:title="title" :tagType="'h1'")
    Swiper.container(v-if="arSlides" v-bind="sliderOptions")
      SwiperSlide(v-for="item in arSlides")
        ProductPreviewCard(:productData="item")
    CenterBtn(:label="'Очистить'" @btnClick="clearRecentlyViewed()")
</template>

<script>
import "@/style/ProductsListSlider.sass"
import 'swiper/css';
import LeafTitle from '@/components/LeafTitle.vue';
import CenterBtn from '@/components/CenterBtn.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import ProductPreviewCard from "@/components/ProductPreviewCard.vue";
import axios from "axios";

export default {
  components: {
    ProductPreviewCard,
    LeafTitle,
    Swiper,
    SwiperSlide,
    CenterBtn
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
  },
  methods:{
    clearRecentlyViewed(){
      axios.delete(this.$store.getters.getApiHost() + '/api/delete_user_recent_products/', this.$store.getters.getAxiosUserConfig());
    }
  }
}

</script>


