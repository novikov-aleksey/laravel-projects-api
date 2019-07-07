import Vue from 'vue';
import axios from 'axios';
import router from './router';
import VueRouter from 'vue-router';

require('./bootstrap');

window.Vue = Vue;
window.axios = axios;

Vue.use(VueRouter);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});

