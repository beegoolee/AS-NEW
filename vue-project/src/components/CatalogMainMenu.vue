<template lang="pug">
  .catalog-main-menu.container.d-flex.justify-content-center(v-if="menuItems && menuItems.length > 0")
    .catalog-main-menu__lvl1-item.d-flex.align-items-center.text-center(v-for="menuItemLvl1 in menuItems")
      a.w-100(:href="menuItemLvl1.link") {{ menuItemLvl1.label }}
      .catalog-main-menu__lvl1-item-dropdown(v-if="menuItemLvl1.children && menuItemLvl1.children.length > 0")
        .catalog-main-manu__lvl2-item(v-for="menuItemLvl2 in menuItemLvl1.children")
          a(:href="menuItemLvl2.link") {{ menuItemLvl2.label }}
</template>

<script>
import "@/style/CatalogMainMenu.sass"

export default {
  data(){
    return {
      menuItems: []
    }
  },
  created() {
    this.menuItems = this.getMenuItems();
  },
  methods:{
    getMenuItems(){
      return [
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        },
        {
          'label': 'First lvl item',
          'link' : '/',
          'children' : [
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            },
            {
              'label': 'Second lvl item',
              'link' : '/',
            }
          ]
        }
      ]
    }
  }
}
</script>


