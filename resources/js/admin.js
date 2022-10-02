require('./bootstrap');

import {createApp} from 'vue'
import *  as VueRouter from 'vue-router'
import BootstrapVue3 from 'bootstrap-vue-3'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

import App from './components/admin/Admin.vue'
import Products from './components/admin/Products.vue';
import Orders from './components/admin/Orders.vue';
import Users from './components/admin/Users.vue';

const routes = [
    {path: '/', component: Users },
    {path: '/products', component: Products},
    {path: '/orders', component: Orders},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/admin'),
    routes
})

createApp(App).use(BootstrapVue3).use(router).mount("#app")
