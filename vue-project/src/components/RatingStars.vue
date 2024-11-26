<template lang="pug">
  .rating-stars
    .rating-stars__item(v-if="rating > 0" v-for="n in rating") *

</template>

<script>
import "@/style/ProductPreviewCard.sass"

export default {
  props: {
    rating: {
      type: Number,
      default: 0
    },
  },
}

</script>


