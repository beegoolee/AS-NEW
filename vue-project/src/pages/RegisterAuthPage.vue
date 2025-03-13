<template lang="pug">
  .reg-auth-page
    leaf-title(:title="'Регистрация'")
    RegisterWindow
</template>

<script>
import RegisterWindow from "@/components/RegisterWindow.vue";
import axios from "axios";
import LeafTitle from "@/components/LeafTitle.vue";

export default {
  components: {
    LeafTitle,
    RegisterWindow,
  },
  created() {
    axios.get(this.$store.getters.getApiHost() + "/api/user/is_authorized/", this.$store.getters.getAxiosUserConfig()).then(res => {
      if (res.data.is_authorized === true) {
        this.$router.push({name: 'personal'});
      }
    });
  }
}


</script>
