<template lang="pug">
  .product-reviews-list Отзывы покупателей
    .product-reviews-list__item(v-for="review in reviewsList" :key="review.id")
      p {{review.userName}} - оценка {{review.rating}}
      p {{review.text}}
    p(v-if='reviewsList.length === 0') - Список отзывов пуст -
</template>

<script>
import "@/style/ProductReviewsList.sass"
import axios from "axios";

export default {
  name: "ProductReviewsList",
  props: {
    productId: {
      type: Number
    },
  },
  data() {
    return {
      reviewsList: []
    }
  },
  mounted() {
    axios.get(this.$store.getters.getApiHost() + "/api/product_review/get/" + this.productId, this.$store.getters.getAxiosUserConfig()).then((res) => {
      this.reviewsList = res.data;
    });
  }
}
</script>
