<template lang="pug">
  .header-functional-row
    .header-functional-row__green-bg
    .header-functional-row__content.container.d-flex.align-items-center
      SiteLogo.col-4
      Searchbar.col-4
      .col-4.h-100.d-flex.align-items-center.justify-content-between
        HeadCart
        HeadFav
        HeadPersonal
        HeadAnnualLogo
</template>

<script>
import "@/style/HeaderFunctionalRow.sass"
import SiteLogo from "@/components/SiteLogo.vue";
import Searchbar from "@/components/Searchbar.vue";
import HeadCart from "@/components/HeadCart.vue";
import HeadFav from "@/components/HeadFav.vue";
import HeadPersonal from "@/components/HeadPersonal.vue";
import HeadAnnualLogo from "@/components/HeadAnnualLogo.vue";

export default{
  components: {
    Searchbar,
    SiteLogo,
    HeadCart,
    HeadFav,
    HeadPersonal,
    HeadAnnualLogo
  }
};
</script>


