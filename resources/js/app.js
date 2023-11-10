import './bootstrap'

import.meta.glob(['../img/**',]);

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import moment from 'moment'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

axios.defaults.headers.common['Content-Type'] = 'application/json'

//axios.defaults.withCredentials = true;
if (window.localStorage.getItem('auth_token')) {
    axios.defaults.headers.common['TokenAdmAuth'] = window.localStorage.getItem('auth_token')
}
axios.defaults.baseURL = '/api'

moment.locale('ru')

const vuetify = createVuetify({
    components,
    directives,
});

const app = createApp(App)
app.config.globalProperties.$moment = moment
app.use(store)
    .use(router)
    .use(vuetify)
    .use(VueAxios, axios)
    .use(Toast)
    .component('Datepicker', Datepicker)
    .mount('#app')
