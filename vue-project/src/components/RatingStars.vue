<template lang="pug">
  .rating-stars.d-flex.justify-content-center
    .rating-stars__item(v-if="rating > 0" v-for="n in 5" :class="{'active': rating >= n}")
</template>

<script>
import "@/style/RatingStars.sass"

export default {
  props: {
    rating: {
      type: Number,
      default: 0
    },
  },
}

</script>


