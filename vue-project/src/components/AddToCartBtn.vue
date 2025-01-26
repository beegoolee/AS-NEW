<template lang="pug">
  .add-to-cart-btn(@click="afterAddToCart()") {{label}}
</template>

<script>
import "@/style/AddToCartBtn.sass"

export default {
  props: {
    productId: {
      type: Number
    },
    label: {
      type: String,
      value: ""
    }
  },
  methods: {
    afterAddToCart() {
      alert("Продукт с ID " + this.productId + " добавлен в корзину");
    }
  }
}

</script>


