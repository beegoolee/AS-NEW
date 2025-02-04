<template lang="pug">
  a.head-personal(href="/login/")
    span(v-if="canAuth") Вход
    span(v-else-if="username") {{username}}
    img(src="@/assets/profile.svg")
</template>

<script>
import "@/style/HeadPersonal.sass"
import axios from "axios";

export default {
  data: function () {
    return {
      'username': ""
    }
  },
  computed: {
    canAuth() {
      let isAuthorized = false;

      axios.get(this.$store.getters.getApiHost() + "/api/user/is_authorized/", this.$store.getters.getAxiosUserConfig()).then(res => {
        isAuthorized = res.data.is_authorized;
        this.username = res.data.username;
      });

      return isAuthorized;
    }
  }
}
</script>


