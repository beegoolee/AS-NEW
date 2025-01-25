<template lang="pug">
  .add-to-cart-btn {{label}}
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
  }
}

</script>


