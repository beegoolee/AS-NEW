<template lang="pug">
  div
    .product-preview-card
      img(:src="productData.image.file.url" :alt="productData.title")
      p {{productData.title}}
      //RatingStars(:rating="+productData.rating")
      .product-preview-card__buy-block
        .product-preview-card__prices
          .product-preview-card__old-price(v-if="productData.oldPrice && productData.oldPrice > productData.price") {{productData.oldPrice}}
          .product-preview-card__price(v-if="productData.price > 0") {{productData.price}}
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


