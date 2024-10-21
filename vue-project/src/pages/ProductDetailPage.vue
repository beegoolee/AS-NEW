<template lang="pug">
  .product-detail Деталка товара да, код товара - {{productCode}}
</template>

<script>
import {useRoute} from "vue-router";

export default {
  data: function () {
    return {
      productCode: {
        type: String,
        value: ""
      }
    }
  },
  created() {
    const route = useRoute();
    this.productCode = route.params.productCode;
  }
}
</script>
