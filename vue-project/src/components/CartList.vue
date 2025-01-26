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
    axios.get("https://127.0.0.1:8000/api/app_get_user_cart/3").then(res => {
      this.cart = res.data;
    })
  }
}

</script>


