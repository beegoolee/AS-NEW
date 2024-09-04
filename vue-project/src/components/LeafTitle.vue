<template lang="pug">
  .leaf-title-container
    component.leaf-title-container__title.d-flex.justify-content-center.align-items-center(:is="tagType")
      span {{title}}
</template>

<script>
import "@/style/LeafTitle.sass"
export default {
  props:{
    'tagType': {
      type: String,
      default: "h2"
    },
    'title': {
      type: String
    }
  }
}
</script>