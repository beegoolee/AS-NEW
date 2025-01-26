<template lang="pug">
  .reg-auth-page Reg\Auth
    RegisterWindow
    AuthWindow
</template>

<script>
import RegisterWindow from "@/components/RegisterWindow.vue";
import AuthWindow from "@/components/AuthWindow.vue";

export default {
  components: {
    RegisterWindow,
    AuthWindow
  }
}


</script>
