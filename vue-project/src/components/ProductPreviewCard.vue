<template lang="pug">
  div
    .product-preview-card.h-100.d-flex.flex-column
      img(:src="productData.image" :alt="productData.name")
      a.product-preview-card__title(:href="productData.url") {{productData.name}}
      RatingStars(:rating="+productData.rating")
      .product-preview-card__buy-block.d-flex.justify-content-between.align-items-center
        .product-preview-card__prices
          .product-preview-card__old-price(v-if="productData.oldPrice && productData.oldPrice > productData.price") {{productData.oldPrice}}
          .product-preview-card__price(v-if="productData.price > 0") {{productData.price}} ₽
        AddToCartBtn(:productId="productData.id")
</template>

<script>
import "@/style/ProductPreviewCard.sass"
import RatingStars from "@/components/RatingStars.vue";
import AddToCartBtn from "@/components/AddToCartBtn.vue";

export default {
  components: {
    RatingStars,
    AddToCartBtn
  },
  props: {
    productData: {},
  },
}

</script>


