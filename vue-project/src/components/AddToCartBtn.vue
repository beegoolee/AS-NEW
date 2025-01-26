<template lang="pug">
  .add-to-cart-btn(@click="addToCart()") {{label}}
</template>

<script>
import "@/style/AddToCartBtn.sass"
import axios from "axios";

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
    addToCart() {
      let obSend = {
        'userId': 3,
        'action': 'add',
        'product': this.productId,
        'quantity': 1
      }

      axios.post("https://127.0.0.1:8000/api/app_edit_user_cart/", obSend, {}).then((res) => {

      });
    }
  }
}

</script>


