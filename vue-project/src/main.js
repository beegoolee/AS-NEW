import 'bootstrap'

import { createApp } from 'vue'
import {createStore} from 'vuex'
import App from './App.vue'
import Router from './router/router.js'
import VueCookies from 'vue-cookies'
import $cookies from "vue-cookie";

const store = createStore({
    state: {
        apiHost(){
            return "https://127.0.0.1:8000";
        },
        axiosUserConfig(){
            return {
                headers: {
                    'Authorization': 'Bearer ' + $cookies.get('token'),
                    'X-Refresh-Token': $cookies.get('refresh_token')
                }
            }
        },
    },
    getters: {
        getApiHost: state => state.apiHost,
        getAxiosUserConfig: state => state.axiosUserConfig,
    }
})

const app = createApp(App).use(Router).use(VueCookies).use(store).mount('#app')