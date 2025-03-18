<template lang="pug">
  .leaf-title-container.w-100
    button.center-btn(@click.prevent="this.$emit('btnClick')") {{label}}
</template>

<script>
import "@/style/CenterBtn.sass"
export default {
  props:{
    'label': ''
  }
}
</script>