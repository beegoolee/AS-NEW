<template lang="pug">
  .catalog-page__left-menu.col-2(v-if="pageType!=='product'")
    .catalog-page__left-menu-item
      a(href="/catalog/") Весь каталог
    .catalog-page__left-menu-item(v-for="item in menuItems" :class="[{'active': item.url === currentUrl}]")
      a(:href="item.url") {{item.name}}
</template>

<script>
import "@/style/CatalogLeftMenu.sass"

import axios from "axios";
import {useRoute} from "vue-router";

export default {
  data: function () {
    return {
      currentUrl: {
        type: String,
        value: ''
      },
      menuItems: {
        type: Array,
        value: []
      }
    }
  },
  created() {
    const route = useRoute();
    this.currentUrl = route.path;

    axios.get('https://127.0.0.1:8000/api/catalog_menu/').then(res => {
      this.menuItems = res.data;
    });
  }
}
</script>
