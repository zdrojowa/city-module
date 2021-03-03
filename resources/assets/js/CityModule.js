import Vue from 'vue';
import {BootstrapVue, BootstrapVueIcons, IconsPlugin} from 'bootstrap-vue';
import VueRouter from 'vue-router'
import Index from './components/Index'
import CityTab from './components/CityTab'
import Sort from './components/Sort'

window.axios = require('axios');

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueRouter)

const app = document.getElementById('app');

new Vue({
    components: {Index, CityTab, Sort}
}).$mount(app);
