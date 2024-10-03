<template lang="pug">
  .rating-stars
    .rating-stars__item(v-for="(star, index) in [1, 2, 3, 4, 5]" :key="index")

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


