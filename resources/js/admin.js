require('./bootstrap');

import {createApp} from 'vue'
import *  as VueRouter from 'vue-router'


import App from './components/admin/admin.vue'
import Products from './components/admin/Products.vue';
import Users from './components/admin/Users.vue';

const routes = [
    {path: '/', component: Users },
    {path: '/products', component: Products},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/admin'),
    routes 
})

createApp(App).use(router).mount("#app")