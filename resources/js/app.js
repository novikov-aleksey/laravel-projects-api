import router from './router';
import VueRouter from 'vue-router';

require('./bootstrap');

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router
});

