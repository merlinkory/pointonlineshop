import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useCartStore = defineStore('cartStore', {
    state: () => ({
         cart: useStorage('cart', {})
    }),
    getters: {
      getCart: (state) => state.cart,
    },
    actions: {
      addToCart(_cart) {
        this.cart = _cart;
      },
    },
})