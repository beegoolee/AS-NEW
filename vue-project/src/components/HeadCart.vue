<template lang="pug">
  a.head-cart(href="/cart/")
    img(src="@/assets/cart.svg")
    span {{cartSize}}
</template>

<script>
import "@/style/HeadCart.sass"
import {mapState} from "vuex";

export default {
  computed: {
    ...mapState(['cart']),

    cartSize() {
      let cart = this.cart,
          cartSize = 0;
      Object.values(cart).forEach((item) => {
        cartSize += item.quantity;
      })

      return cartSize
    }
  },
  created() {
    this.$store.dispatch("triggerUpdateCart");
  }
}
</script>


