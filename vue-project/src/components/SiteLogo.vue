<template lang="pug">
  RouterLink.site-logo(to="/")
    img.site-logo__img(src="@/assets/logo.svg")
</template>

<script>
import "@/style/SiteLogo.sass"
import {RouterLink} from "vue-router";

export default {
  components: [
      RouterLink
  ]
}
</script>


