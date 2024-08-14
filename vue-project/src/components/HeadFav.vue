<template lang="pug">
  .head-fav
    img(src="@/assets/heart.svg")
    span {{favItemsCount}}
</template>

<script>
import "@/style/HeadFav.sass"

export default {
  computed: {
    favItemsCount(){
      return 0;
    }
  }
}
</script>


