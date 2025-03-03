<template lang="pug">
  .product-detail.w-100
    .product-detail__top-row.d-flex.justify-content-between.w-100
      .product-detail__picture.col-4
        img(:src="product.image")
      .product-detail__props.col-4
        RatingStars(:rating="product.rating")
        p Код товара {{product.slug}}
        p ID товара {{product.id}}
      .product-detail__buy-block.col-4
        p.product-detail__price {{product.price}} ₽
        AddToCartBtn(:productId="product.id")
</template>

<script>
import "@/style/ProductDetail.sass"
import AddToCartBtn from "@/components/AddToCartBtn.vue";
import RatingStars from "@/components/RatingStars.vue";

export default {
  components: {
    RatingStars,
    AddToCartBtn
  },
  props: {
    product: {
      type: Array,
      value: []
    }
  }
}
</script>
