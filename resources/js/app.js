
require('./bootstrap');

window.Vue = require('vue').default;
import router from './router'
import store from './store'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import Vue from 'vue';
Vue.use(ViewUI);
import common from './common'
Vue.mixin(common)

Vue.component('mainapp', require('./components/mainapp.vue').default);


const app = new Vue({
    el: '#app',
    router, 
    store
});
