<template lang="pug">
    .page
      Header
      MainPageBody
</template>

<script>
import Header from "@/components/Header.vue";
import MainPageBody from "@/components/MainPageBody.vue";

export default{
  components: {
    Header,
    MainPageBody
  }
};
</script>

