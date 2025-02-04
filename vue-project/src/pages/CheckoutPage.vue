<template lang="pug">
  .cart-page Оформление заказа))
    CartList
</template>

<script>

import {defineComponent} from "vue";
import CartList from "@/components/CartList.vue";

export default {
  components: {
    CartList
  }
}
</script>
