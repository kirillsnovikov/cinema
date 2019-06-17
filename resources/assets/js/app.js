
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');
window.VueAwesomeSwiper = require('vue-awesome-swiper');
window.axios = require('axios');
//import VueAwesomeSwiper from 'vue-awesome-swiper';

Vue.use(VueAwesomeSwiper);
// Vue.use(axios);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('swiper-component', require('./components/FreemodeSliderComponent.vue'));
Vue.component('big-swiper-component', require('./components/BigSliderComponent.vue'));
Vue.component('search-component', require('./components/SearchComponent.vue'));

const app = new Vue({
    el: '#app'
});
