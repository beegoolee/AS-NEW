<template lang="pug">
  .cart-list
    .cart-list__item.d-flex.align-items-center.justify-content-between(v-for="(productData, productId) in cart")
      img(:src="productData.img" :alt="productData.name")
      a(:href="productData.url") {{productData.name}}
      span Количество: {{productData.quantity}}
      span Цена: {{productData.price}} ₽
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
      cart: []
    }
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/user/get_cart/", this.$store.getters.getAxiosUserConfig()).then(res => {
      this.cart = res.data;
    })
  }
}

</script>


