<template lang="pug">
  .page-nav.d-flex(v-if="navItems.length > 1")
    .page-nav__link(v-for="(navItem, pageNum) in navItems" :class="[{active:navItem.label === this.activePage}]")
      span(v-if="navItem.label === this.activePage") {{navItem.label}}
      a(:href="navItem.link" v-else) {{navItem.label}}
</template>

<script>
import "@/style/PageNavigation.sass"

export default {
  props: {
    pagenInfo: {
      type: Array,
      value: []
    },
    pagePath: {
      type: String,
      value: ""
    }
  },
  computed: {
    activePage() {
      return Number(this.pagenInfo.currentPage);
    },
    navItems() {
      let navItems = [];
      let pagesCount = Number(this.pagenInfo?.pagesCount);
      let activePage = this.activePage;

      // Кнопка Назад
      if (activePage > 1 && pagesCount > 1) {
        navItems.push(
            this.getNavItem('<', activePage - 1)
        );
      }

      // первые три страницы
      for (let i = 1; i < 4; i++) {
        if (pagesCount > i) {
          navItems.push(
              this.getNavItem(i, i)
          );
        } else {
          break;
        }
      }

      // левая четверть пагинации
      if (activePage > 4) {
        let label = (activePage === 5) ? '4' : '...';
        navItems.push(
            this.getNavItem(
                label,
                Math.ceil((activePage + 3) / 2)
            )
        );
      }

      // активная страница пагинации
      if (activePage > 3 && (activePage !== 1 || activePage !== pagesCount)) {
        navItems.push(
            this.getNavItem(activePage, activePage)
        );
      }

      // правая четверть пагинации
      if (activePage < pagesCount - 1) {
        let label = (activePage === pagesCount - 2) ? pagesCount - 1 : '...';
        navItems.push(
            this.getNavItem(
                label,
                Math.ceil(activePage + (pagesCount - activePage) / 2)
            )
        );
      }

      // последняя страница
      if (activePage !== pagesCount && pagesCount > 1) {
        navItems.push(
            this.getNavItem(pagesCount, pagesCount)
        );
      }

      // Кнопка Вперед
      if ((activePage => 1) && (pagesCount > 1) && (activePage < pagesCount)) {
        navItems.push(
            this.getNavItem('>', activePage + 1)
        );
      }

      return navItems;
    }
  },
  methods: {
    getNavItem(label, pageNum) {
      return {
        'label': label,
        'link': this.pagePath + '?pagen=' + pageNum,
      }
    }
  }
}
</script>
