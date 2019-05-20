
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Swiper from 'vue-awesome-swiper';
window.Swiper = require('vue-awesome-swiper');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Swiper.component('slider-component', require('./components/FreemodeSliderComponent.vue'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('movie-component', require('./components/MovieComponent.vue'));
Vue.component('video-component', require('./components/VideoComponent.vue'));

const app = new Vue({
    el: '#app'
});
