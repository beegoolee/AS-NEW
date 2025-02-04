<template lang="pug">
  a.head-cart(href="/cart/")
    img(src="@/assets/cart.svg")
    span {{cartSize}}
</template>

<script>
import "@/style/HeadCart.sass"
import axios from "axios";

export default {
  data: function () {
    return {
      cartSize: 0
    }
  },
  created: function () {
    axios.get(this.$store.getters.getApiHost() + "/api/user/get_cart/", this.$store.getters.getAxiosUserConfig()).then(res => {
      let cart = res.data,
          self = this;
      Object.values(cart).forEach((item) => {
        self.cartSize += item.quantity;
      })
    });
  }
}
</script>


