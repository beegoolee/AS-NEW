<template lang="pug">
  .searchbar
    form.searchbar__container(@submit.prevent="onSearchSubmit()")
      input(type="text" placeholder="Поиск..." v-model="query")
      input(type="submit")
    .searchbar__suggestions-list(v-if="arSearchResult")
      .searchbar__suggestions-item(v-for="item in arSearchResult" :key="item.id")
        a(:href="item.url") {{item.name}}
</template>

<script>
import "@/style/Searchbar.sass"
import axios from "axios";

export default {
  data() {
    return {
      query: "",
      arSearchResult: false
    }
  },
  methods: {
    onSearchSubmit() {
      if (this.query.length > 0) {
        const params = {
          search: this.query,
        }
        this.$router.push({path: "/catalog/", query: params}).then(() => {
          this.$router.go(0);
        });
      }
    },
  },
  watch: {
    query: function (searchQ) {
      this.arSearchResult = false;
      if(searchQ){
        axios.get(this.$store.getters.getApiHost() + '/api/product_search/' + searchQ, this.$store.getters.getAxiosUserConfig()).then((res) => {
          this.arSearchResult = res.data;
        });
      }
    }
  }
}
</script>


