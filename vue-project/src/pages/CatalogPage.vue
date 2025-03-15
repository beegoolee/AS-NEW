<template lang="pug">
  .catalog-page.d-flex.flex-wrap
    leaf-title(:title="pageTitle")
    catalog-left-menu(v-if="pageType !== 'product'")
    product-detail(v-if="pageType === 'product'" :product="products[0]")
    products-list(v-else :products="products")
    page-navigation.w-100.justify-content-center(:pagenInfo="pagenInfo" :pagePath="this.url")
</template>

<script>
import axios from "axios";

import {useRoute} from "vue-router";
import ProductsList from "@/components/ProductsList.vue";
import ProductDetail from "@/components/ProductDetail.vue";
import CatalogLeftMenu from "@/components/CatalogLeftMenu.vue";
import PageNavigation from "@/components/PageNavigation.vue";
import LeafTitle from "@/components/LeafTitle.vue";

export default {
  components: {
    LeafTitle,
    ProductsList,
    ProductDetail,
    CatalogLeftMenu,
    PageNavigation
  },
  data: function () {
    return {
      products: [],
      sections: [],
      pageType: 'catalog', //или product или section
      pagenInfo: [],
      pageTitle: ''
    }
  },
  created: function () {
    const route = useRoute();
    this.url = route.path;
    const params = {
      pagen: route.query.pagen,
      pagesize: route.query.pagesize,
      search: route.query.search,
      requestedUrl: encodeURIComponent(this.url),
    };

    // В зависимости от урла - получаем от бека либо весь каталог, либо один раздел, либо один товар
    axios.get(this.$store.getters.getApiHost()+'/api/catalog/', {params}).then(res => {
      this.products = res.data.products;
      this.sections = res.data.sections;
      this.pageType = res.data.pageType;
      this.pageTitle = res.data.pageTitle;
      this.pagenInfo = res.data.pagenInfo;
    });

  },
}
</script>
