<template lang="pug">
  .leaf-title-container.w-100
    h1.leaf-title-container__title.d-flex.justify-content-center.align-items-center
      span {{title}}
</template>

<script>
import "@/style/LeafTitle.sass"
export default {
  props:{
    'title': {
      type: String
    }
  }
}
</script>