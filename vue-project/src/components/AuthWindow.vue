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
          "https://127.0.0.1:8000/api/auth_user/",
          obSend
      ).then(res => {
        this.serviceMsg = res.data.message;

        if (res.data.success === true) {
          setTimeout(() => {
            location.reload();
          }, 2000);
        }
      });
    }
  }
}
</script>
