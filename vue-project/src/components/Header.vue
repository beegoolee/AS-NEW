<template lang="pug">
  header
    Geolocation
    HeaderFunctionalRow
    CatalogMainMenu
</template>

<script>
import Geolocation from "@/components/Geolocation.vue";
import HeaderFunctionalRow from "@/components/HeaderFunctionalRow.vue";
import CatalogMainMenu from "@/components/CatalogMainMenu.vue";

export default{
  components: {
    Geolocation,
    HeaderFunctionalRow,
    CatalogMainMenu,
  }
};
</script>