import 'bootstrap'

import {createApp} from 'vue'
import {createStore} from 'vuex'
import App from './App.vue'
import Router from './router/router.js'
import VueCookies from 'vue-cookies'
import $cookies from "vue-cookie";
import axios from "axios";

const store = createStore({
    state: {
        apiHost() {
            return "http://localhost:8080";
        },
        axiosUserConfig() {
            return {
                headers: {
                    'Authorization': 'Bearer ' + $cookies.get('token'),
                    'X-Refresh-Token': $cookies.get('refresh_token')
                }
            }
        },
        cart() {
            return false;
        }
    },
    getters: {
        getCart: state => state.cart,
        getApiHost: state => state.apiHost,
        getAxiosUserConfig: state => state.axiosUserConfig,
    },
    mutations: {
        updateCart(state, payload) {
            axios.get(this.getters.getApiHost() + "/api/user/get_cart/", this.getters.getAxiosUserConfig()).then(res => {
                state.cart = res.data;
            });
        }
    },
    actions: {
        triggerUpdateCart({commit}, payload) {
            commit('updateCart', payload);
        }
    }
})

const app = createApp(App).use(Router).use(VueCookies).use(store).mount('#app')