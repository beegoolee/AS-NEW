<template lang="pug">
  .searchbar
    .searchbar__container
      input(type="text" placeholder="Поиск..." v-model="query")
    .searchbar__suggestions-list(v-if="arSearchResult")
      .searchbar__suggestions-item(v-for="item in arSearchResult" :key="item.id")
        a(:href="item.url") {{item.name}}
</template>

<script>
import "@/style/Searchbar.sass"
import axios from "axios";

export default {
  data(){
    return {
      query: "",
      arSearchResult: false
    }
  },
  watch: {
    query: function(searchQ){
      this.arSearchResult = false;
      axios.get(this.$store.getters.getApiHost()+'/api/product_search/'+searchQ, this.$store.getters.getAxiosUserConfig()).then((res)=>{
        this.arSearchResult = res.data;
      });
    }
  }
}
</script>


