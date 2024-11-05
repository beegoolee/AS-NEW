<template lang="pug">
  .catalog-page__product-list.d-flex.flex-wrap.col-10
    ProductPreviewCard.col-4(v-for="product in products" :key="product.id" :productData="product")
</template>

<script>
import ProductPreviewCard from "@/components/ProductPreviewCard.vue";

export default {
  components: {
    ProductPreviewCard
  },
  props: {
    products: {
      type: Array,
      value: []
    }
  }
}
</script>
