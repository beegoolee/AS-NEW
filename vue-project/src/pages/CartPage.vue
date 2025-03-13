<template lang="pug">
  .cart-page
    leaf-title(:title="'Корзина'")
    CartList
    button(@click="makeOrder()") Оформить заказ
</template>

<script>
import CartList from "@/components/CartList.vue";
import LeafTitle from "@/components/LeafTitle.vue";
import axios from "axios";

export default {
  components: {
    CartList,
    LeafTitle
  },
  methods: {
    makeOrder(){
      axios.post(this.$store.getters.getApiHost() + "/api/order/make/", false, this.$store.getters.getAxiosUserConfig()).then((res) => {
        alert("Заказ успешно оформлен, ID заказа - "+res.data.orderId);
        this.$store.dispatch("triggerUpdateCart");
        this.$router.push({name: 'main'});
      });
    }
  }
}
</script>
