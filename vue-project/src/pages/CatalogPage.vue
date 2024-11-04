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
import {useRoute} from "vue-router";

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
    const route = useRoute();
    this.url = route.params.slug;

    //TODO через аксиос по урлу проверяем, раздел это, каталог, или деталка товара.
    // В зависимости от ответа - получаем либо весь каталог, либо один раздел, либо один товар

    // axios.get("https://127.0.0.1:8000/api/sections").then(res => {
    //   this.products = res.data;
    // })
  },
}
</script>
