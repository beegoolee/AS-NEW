<template lang="pug">
  .catalog-main-menu.container.d-flex.justify-content-center(v-if="menuItems && menuItems.length > 0")
    .catalog-main-menu__lvl1-item.d-flex.align-items-center.text-center(v-for="menuItemLvl1 in menuItems")
      a.w-100(:href="menuItemLvl1.url") {{ menuItemLvl1.name }}
      .catalog-main-menu__lvl1-item-dropdown(v-if="menuItemLvl1.children && menuItemLvl1.children.length > 0")
        .catalog-main-manu__lvl2-item(v-for="menuItemLvl2 in menuItemLvl1.children")
          a(:href="menuItemLvl2.url") {{ menuItemLvl2.name }}
</template>

<script>
import "@/style/CatalogMainMenu.sass"
import axios from "axios";

export default {
  data(){
    return {
      menuItems: []
    }
  },
  created() {
    axios.get("https://127.0.0.1:8000/api/catalog_menu/").then(res => {
      this.menuItems = res.data;
    });
  }
}
</script>


