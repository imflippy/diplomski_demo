require('./bootstrap');

import Vue from 'vue'
import App from '@/js/App.vue'
import router from '@/js/Router/index.js'
import axios from 'axios'

Vue.config.productionTip = false;

const rootUrl = document.location.protocol +"//" + document.location.hostname + ":" +document.location.port;
axios.defaults.baseURL = rootUrl + '/api/';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
};

const app =  new Vue({
    el: '#app',
    router,
    render: h => h(App)
});

export default app;
