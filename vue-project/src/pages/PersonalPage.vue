<template lang="pug">
  .reg-auth-page
    leaf-title(:title="'Личный кабинет'")
    AuthWindow(v-if="!isAuthorized")
    component(v-else)
      .order-history
        .order-history__title История заказов
        hr
        .order-history__list
          .order-history__item(v-for="(item, index) in arOrders" :key="index")
            p Заказ # {{ item.id }} от {{item.date_create}}. Статус - {{item.status}}
            p Состав заказа:
              p(v-for="product in item.products") Товар # {{product.productId}} в количестве {{product.quantity}} шт. Цена - {{product.total_price}} ₽
              hr
      button(@click="logout()") Выйти из аккаунта
</template>

<script>

import axios from "axios";
import LeafTitle from "@/components/LeafTitle.vue";
import AuthWindow from "@/components/AuthWindow.vue";
import VueCookies from 'vue-cookie';

export default {
  components: {
    LeafTitle,
    AuthWindow
  },
  data: function () {
    return {
      isAuthorized: false,
      arOrders: false
    }
  },
  methods: {
    logout() {
      $cookies.set('token', '', {path: '/', secure: true, expires: '-1d'});
      $cookies.set('refresh_token', '', {path: '/', expires: '-1d'});
      setTimeout(() => {
        location.reload();
      }, 1000);
    }
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/user/is_authorized/", this.$store.getters.getAxiosUserConfig()).then(res => {
      if (res.data.is_authorized === true) {
        this.isAuthorized = res.data.is_authorized;
      }
    });
    axios.get(this.$store.getters.getApiHost() + "/api/user/get_order_history/", this.$store.getters.getAxiosUserConfig()).then(res => {
      this.arOrders = res.data;
    });

  }
}


</script>
