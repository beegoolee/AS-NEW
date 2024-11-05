<template lang="pug">
  .product-detail
    p Деталка товара  {{product.name}} c id {{product.id}}
    p Картинка товара {{product.image}}
    p Код товара {{product.slug}}
</template>

<script>
import "@/style/ProductDetail.sass"
export default {
  props: {
    product: {
      type: Array,
      value: []
    }
  }
}
</script>
