<template lang="pug">
  .head-personal
    a(v-if="isAuth" href="/register/") {{username}}
    a(v-else href="/personal/")  Вход
    img(src="@/assets/profile.svg")
</template>

<script>
import "@/style/HeadPersonal.sass"
import axios from "axios";

export default {
  data: function () {
    return {
      username: "",
      isAuth: false,
    }
  },
  created(){
    axios.get(this.$store.getters.getApiHost() + "/api/user/is_authorized/", this.$store.getters.getAxiosUserConfig()).then(res => {
      this.isAuth = res.data.is_authorized;
      this.username = res.data.username;
    });
  }
}
</script>


