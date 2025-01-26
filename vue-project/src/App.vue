<template lang="pug">
    .page
      Header
      RouterView.container
      Footer
</template>

<script>
import {RouterView} from "vue-router";
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";

export default{
  components: {
    Header,
    RouterView,
    Footer
  }
};
</script>

