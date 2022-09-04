require('./bootstrap');

import {createApp} from 'vue'
import *  as VueRouter from 'vue-router'
// import Vuex from 'vuex';
import { createPinia } from 'pinia'
import App from './components/App.vue'


import Products from './components/Products.vue'
import Cart from './components/Cart.vue';
import Orders from './components/Orders.vue';

const routes = [
    {path: '/', component: Products},
    {path: '/cart', component: Cart},
    {path: '/orders', component: Orders},
]

const pinia = createPinia()

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/lk'),
    routes
})

// export const store = new Vuex.Store({
//     state: {
//         cart: []
//     },
//     getters: {},
//     mutations: {
//         SET_CART: (state, payload)=>{
//             state.cart = payload
//         },
//     },
//     getters: {
//         CART: state => {
//           return state.cart;
//         },
//       },
//     actions: {},
//   });

createApp(App).use(pinia).use(router).mount("#app")



