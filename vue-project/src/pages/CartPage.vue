<template lang="pug">
  .cart-page Корзина
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
