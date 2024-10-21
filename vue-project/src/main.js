import 'bootstrap'

import { createApp } from 'vue'
import App from './App.vue'
import Router from './router/router.js'
import axios from 'axios'

createApp(App).use(Router).mount('#app')
