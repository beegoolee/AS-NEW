<template lang="pug">
  .searchbar
    .searchbar__container
      input(type="text" placeholder="Поиск..." v-model="query")
</template>

<script>
import "@/style/Searchbar.sass"

export default {
  data(){
    return {
      query: ""
    }
  }
}
</script>


