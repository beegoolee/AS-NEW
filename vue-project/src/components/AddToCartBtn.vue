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
        'action': 'add',
        'product': this.productId,
        'quantity': 1
      }

      axios.post(this.$store.getters.getApiHost() + "/api/user/edit_cart/", obSend, this.$store.getters.getAxiosUserConfig()).then((res) => {
        this.$store.dispatch("triggerUpdateCart");
      });
    }
  }
}

</script>


