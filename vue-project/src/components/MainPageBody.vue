<template lang="pug">
  div
    FullWidthSlider(v-if="firstSliderItems.length > 0" :slides="firstSliderItems")
    ProductsSliderWHeader(:sliderData="hotDiscountsSlider")
    ProductsSliderWHeader(:sliderData="popularSlider")
</template>

<script>
import FullWidthSlider from "@/components/FullWidthSlider.vue";
import ProductsSliderWHeader from "@/components/ProductsSliderWHeader.vue";

export default {
  data() {
    return {
      firstSliderItems: [],
      hotDiscountsSlider: {},
      popularSlider: {},
    }
  },
  components: {
    ProductsSliderWHeader,
    FullWidthSlider
  },
  created() {
    this.firstSliderItems = this.getFirstSlider();
    this.hotDiscountsSlider = this.getHotDiscountsSlider();
    this.popularSlider = this.getPopularSlider();
  },
  methods: {
    getFirstSlider() {
      return [
        {
          'img': "https://asevalar.ru/upload/iblock/102/w235dba3t0e1lcleafaa7y55526fs7ly_0_320.jpg",
          'link': '/'
        },
        {
          'img': "https://asevalar.ru/upload/iblock/102/w235dba3t0e1lcleafaa7y55526fs7ly_0_320.jpg",
          'link': '/'
        },
        {
          'img': "https://asevalar.ru/upload/iblock/102/w235dba3t0e1lcleafaa7y55526fs7ly_0_320.jpg",
          'link': '/'
        },
      ];
    },
    getHotDiscountsSlider() {
      return {
        'title': 'Горячие скидки',
        'tag': 'h2',
        'slides': [
          {
            'id': 1,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 1',
            'price': '300',
            'rating': '5'
          },
          {
            'id': 2,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 2',
            'price': '3000',
            'oldPrice': '5000'
          },
          {
            'id': 3,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 3',
            'price': '800'
          },
          {
            'id': 4,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 4',
            'price': '3000',
            'oldPrice': '500',
            'rating': '1'
          },
          {
            'id': 5,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 5',
            'price': '1000',
            'rating': '2'
          },
          {
            'id': 6,
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 6',
            'price': '1500'
          }
        ]
      }
    },
    getPopularSlider() {
      return {
        'title': 'Популярные товары',
        'tag': 'h2',
        'slides': [
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 1',
            'price': '300',
            'rating': '5'
          },
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 2',
            'price': '3000',
            'oldPrice': '5000'
          },
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 3',
            'price': '800'
          },
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 4',
            'price': '3000',
            'oldPrice': '500',
            'rating': '1'
          },
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 5',
            'price': '1000',
            'rating': '2'
          },
          {
            'img': 'https://asevalar.ru/upload/webp-converter.micro/converted_images/as_catalog_list/preview/480/480/100/webp/03b210ab5f5cf6dbd93989a87406ec21.jpg.webp',
            'name': 'Товар 6',
            'price': '1500'
          }
        ]
      }
    },
  }
}
</script>
