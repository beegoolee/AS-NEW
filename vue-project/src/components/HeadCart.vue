<template lang="pug">
  .head-cart
    img(src="@/assets/cart.svg")
    span {{cartItemsCount}}
</template>

<script>
import "@/style/HeadCart.sass"

export default {
  computed: {
    cartItemsCount(){
      return 0;
    }
  }
}
</script>


