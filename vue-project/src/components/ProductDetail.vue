<template lang="pug">
  .product-detail.w-100
    .product-detail__top-row.d-flex.justify-content-between.w-100
      .product-detail__picture.col-4
        img(:src="product.image")
      .product-detail__props.col-4
        RatingStars(:rating="product.rating")
        //p Код товара {{product.slug}}
        //p ID товара {{product.id}}
        p Штрихкод: {{product.barcode}}
        p Цвет товара: {{product.color}}
        p Вес товара: {{product.weight}} г.
        p Объем товара: {{product.volume}} мл.
        p Описание товара: {{product.description}}
      .product-detail__buy-block.col-4
        p.product-detail__price {{product.price}} ₽
        AddToCartBtn(:productId="product.id")
    .product-detail__bottom-row
      ProductReviewAddForm(:productId="product.id")
      hr
      ProductReviewsList(:productId="product.id")
      ProductsListSlider(:title="'Ранее вы смотрели'" :arSlides="recentlyViewedProducts")
</template>

<script>
import "@/style/ProductDetail.sass"
import AddToCartBtn from "@/components/AddToCartBtn.vue";
import RatingStars from "@/components/RatingStars.vue";
import ProductReviewAddForm from "@/components/ProductReviewAddForm.vue";
import ProductReviewsList from "@/components/ProductReviewsList.vue";
import ProductsListSlider from "@/components/ProductsListSlider.vue";
import axios from 'axios';
import LeafTitle from "@/components/LeafTitle.vue";

export default {
  components: {
    LeafTitle,
    ProductReviewsList,
    ProductReviewAddForm,
    RatingStars,
    AddToCartBtn,
    ProductsListSlider
  },
  props: {
    product: {
      type: Array,
      value: []
    },
  },
  data() {
    return {
      recentlyViewedProducts: []
    }
  },
  created() {
    let self = this;

    axios.get(this.$store.getters.getApiHost() + '/api/get_user_recent_products/', this.$store.getters.getAxiosUserConfig()).then(res => {
      let allViewedProducts = res.data;

      self.recentlyViewedProducts = allViewedProducts.filter((item) => {
        return item.id !== self.product.id; // в блоке "ранее вы смотрели" мы не выводим текущий товар (открытую карточку)
      });
    });
  }
}
</script>
