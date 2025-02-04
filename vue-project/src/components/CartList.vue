<template lang="pug">
  .cart-list
    .cart-list__item.d-flex.align-items-center(v-for="(productData, productId) in cart") Продукт с id {{productId}} в количестве {{productData.quantity}}
      AddToCartBtn(:product-id="productId")
</template>

<script>
import "@/style/CartList.sass"
import axios from "axios";
import AddToCartBtn from "@/components/AddToCartBtn.vue";

export default {
  components: {AddToCartBtn},
  data: function () {
    return {
      cart: {
        type: Array,
        value: []
      }
    }
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/user/get_cart/", this.$store.getters.getAxiosUserConfig()).then(res => {
      this.cart = res.data;
    })
  }
}

</script>


