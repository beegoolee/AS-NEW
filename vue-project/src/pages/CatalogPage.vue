<template lang="pug">
  .catalog-page.d-flex.flex-wrap
    h1.w-100 Catalog section
    .catalog-page__left-menu.col-2 левое меню
    .catalog-page__product-list.d-flex.flex-wrap.col-10
      ProductPreviewCard.col-4(v-for="product in products" :key="product.id" :productData="product")
</template>

<script>
import axios from "axios";

import ProductPreviewCard from "@/components/ProductPreviewCard.vue";

export default {
  components: {
    ProductPreviewCard
  },
  data: function () {
    return {
      products: {
        type: Array,
        value: []
      }
    }
  },
  created: function () {
    axios.get("https://127.0.0.1:8001/api/products").then(res => {
      this.products = res.data;
    })
  },
}
</script>
