<template lang="pug">
  a.head-personal(href="/personal/")
    span(v-if="canAuth") Вход
    img(src="@/assets/profile.svg")
</template>

<script>
import "@/style/HeadPersonal.sass"

export default {
  computed: {
    canAuth(){
      return true;
    }
  }
}
</script>


