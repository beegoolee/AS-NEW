<template lang="pug">
  a.site-logo(:href="siteMainpageLink")
    img.site-logo__img(src="@/assets/logo.svg")
</template>

<script>
import "@/style/SiteLogo.sass"

export default {
  computed: {
    siteMainpageLink(){
      return 'https://asevalar.ru';
    }
  }
}
</script>


