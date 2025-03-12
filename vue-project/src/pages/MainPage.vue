<template lang="pug">
  component
    FullWidthSlider(:code="'mainpageTop'")
    ProductsSliderWHeader(:code="'hotDiscounts'")
    ProductsSliderWHeader(:code="'populars'")
</template>

<script>
import FullWidthSlider from "@/components/FullWidthSlider.vue";
import ProductsSliderWHeader from "@/components/ProductsSliderWHeader.vue";

export default {
  components: {
    ProductsSliderWHeader,
    FullWidthSlider
  }
}
</script>
