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
import AddToCartBtn from "@/components/AddToCartBtn.vue";
import {mapState} from "vuex";

export default {
  components: {AddToCartBtn},
  computed: {
    ...mapState(['cart'])
  }
}

</script>


