<template lang="pug">
  .product-detail
    p Деталка товара  {{product.name}} c id {{product.id}}
    p Картинка товара {{product.image}}
    p Код товара {{product.slug}}
    AddToCartBtn(:productId="product.id")
</template>

<script>
import "@/style/ProductDetail.sass"
import AddToCartBtn from "@/components/AddToCartBtn.vue";

export default {
  components: {
    AddToCartBtn
  },
  props: {
    product: {
      type: Array,
      value: []
    }
  }
}
</script>
