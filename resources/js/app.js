require('./bootstrap');

import {createApp} from 'vue'
import *  as VueRouter from 'vue-router'
// import Vuex from 'vuex';
import { createPinia } from 'pinia'
import App from './components/App.vue'


import About from './components/About.vue'
import Products from './components/Products.vue'
import Cart from './components/Cart.vue';

const routes = [
    {path: '/', component: Products},
    {path: '/about', component: About},
    {path: '/cart', component: Cart},
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



