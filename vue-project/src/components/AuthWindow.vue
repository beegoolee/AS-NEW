<template lang="pug">
  form.auth-window.d-flex.flex-column.m-auto(@submit.prevent="tryToAuth()")
    span {{serviceMsg}}
    input(type="login" v-model="login" placeholder="логин")
    input(type="password" v-model="password"  placeholder="пароль")
    input(type="submit")
</template>

<script>
import "@/style/AuthWindow.sass"
import axios from "axios";
import VueCookies from 'vue-cookie';

export default {
  name: "RegisterWindow",
  data() {
    return {
      password: "",
      login: "",
      serviceMsg: "Авторизация",
    }
  },
  methods: {
    tryToAuth() {
      let obSend = {
        'password': this.password,
        'username': this.login,
      };

      this.serviceMsg = "";

      axios.post(
          this.$store.getters.getApiHost() + "/api/auth_user/",
          obSend
      ).then(res => {
        if (res.data.token) {
          $cookies.set('token', res.data.token, 1);
          $cookies.set('refresh_token', res.data.refresh_token, 30);
          setTimeout(() => {
            location.reload();
          }, 2000);
        }
      });
    }
  }
}
</script>
