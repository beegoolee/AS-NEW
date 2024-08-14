<template lang="pug">
  .geolocation.d-flex.container
    .geolocation__current-city(@click='toggleCitySelector()')
      span {{currentCity.cityName}}
      span(v-if="currentCity.pharmaciesCount > 0") &nbsp;&mdash; {{currentCity.pharmaciesCount}} аптек
    .geolocation__select-city
      a.geolocation__select-city-item(v-for="city in citySelectList" :href="city.link") {{city.cityName}}
    .geolocation__delivery-link
      a(href='') Доставка и возврат
</template>

<script>
import "@/style/Geolocation.sass"
export default{
  methods: {
    toggleCitySelector(){
      var citySelectPopup = document.querySelector('.geolocation__select-city');
      citySelectPopup.classList.toggle("active");
    }
  },
  computed: {
    currentCity(){
      return {
       cityName: "Москва",
       pharmaciesCount: 11,
      };
    },
    citySelectList(){
      return [
        {
          'link': 'https://asevalar.ru',
          'cityName' : 'Москва'
        },
        {
          'link': 'https://spb.asevalar.ru',
          'cityName' : 'Санкт-Петербург'
        },
        {
          'link': 'https://volgograd.asevalar.ru',
          'cityName' : 'Волгоград'
        },
        {
          'link': 'https://byisk.asevalar.ru',
          'cityName' : 'Бийск'
        }
      ]
    }
  }
}
</script>


