<template lang="pug">
  component
    FullWidthSlider(:code="'mainpageTop'")
    ProductsCollection(:code="'hotDiscounts'")
    ProductsCollection(:code="'populars'")
</template>

<script>
import FullWidthSlider from "@/components/FullWidthSlider.vue";
import ProductsCollection from "@/components/ProductsCollection.vue";

export default {
  components: {
    ProductsCollection,
    FullWidthSlider
  }
}
</script>
