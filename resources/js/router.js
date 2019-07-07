import VueRouter from 'vue-router';

/**
 * Main front-end routes
 */
const routes = [
    {
        path: '/',
        component: require('./pages/Projects').default
    },
    {
        path: '/users',
        component: require('./pages/Users').default
    }
];

export default new VueRouter({
    routes,
    linkActiveClass: 'active'
});
