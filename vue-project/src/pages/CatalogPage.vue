<template lang="pug">
  .catalog-page.d-flex.flex-wrap
    h1.w-100 {{pageType}}
    catalog-left-menu(v-if="pageType !== 'product'")
    product-detail(v-if="pageType === 'product'" :product="products[0]")
    products-list(v-else :products="products")
    page-navigation(:pagenInfo="pagenInfo" :pagePath="this.url")
</template>

<script>
import axios from "axios";

import {useRoute} from "vue-router";
import ProductsList from "@/components/ProductsList.vue";
import ProductDetail from "@/components/ProductDetail.vue";
import CatalogLeftMenu from "@/components/CatalogLeftMenu.vue";
import PageNavigation from "@/components/PageNavigation.vue";

export default {
  components: {
    ProductsList,
    ProductDetail,
    CatalogLeftMenu,
    PageNavigation
  },
  data: function () {
    return {
      products: {
        type: Array,
        value: []
      },
      sections: {
        type: Array,
        value: []
      },
      pageType: {
        type: String,
        value: 'catalog' //или product или section
      },
      pagenInfo: {
        type: Array,
        value: []
      },
    }
  },
  created: function () {
    const route = useRoute();
    this.url = route.path;
    // В зависимости от урла - получаем от бека либо весь каталог, либо один раздел, либо один товар
    axios.get('https://127.0.0.1:8000/api/catalog/' + this.url + '?pagen=' + route.query.pagen + '&pagesize=' + route.query.pagesize).then(res => {
      this.products = res.data.products;
      this.sections = res.data.sections;
      this.pageType = res.data.pageType;
      this.pagenInfo = res.data.pagenInfo;
    });

  },
}
</script>
