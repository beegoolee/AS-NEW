<template lang="pug">
  .product-review-add-form
    hr
    p Добавить отзыв
    form(@submit.prevent="onSubmit()")
      textarea(v-model="reviewText" placeholder="Напишите своё мнение о товаре")
      .product-review-add-form__rating-stars.d-flex
        .product-review-add-form__rating-stars__item(v-if="rating > 0" v-for="n in 5" :class="{'active': rating >= n}" @click="rating = n")
      input(type="submit" value="Отправить")
</template>

<script>
import "@/style/ProductReviewAddForm.sass"
import axios from "axios";

export default {
  name: "ProductReviewAddForm",
  data() {
    return {
      reviewText: "",
      rating: 5,
    }
  },
  props: {
    productId: {
      type: Number
    }
  },
  methods: {
    onSubmit() {
      let obSend = {
        'product_id': this.productId,
        'rating': this.rating,
        'text': this.reviewText,
      }

      axios.post(this.$store.getters.getApiHost() + "/api/product_review/add/", obSend, this.$store.getters.getAxiosUserConfig()).then((res) => {

      });
    }
  }
}
</script>
