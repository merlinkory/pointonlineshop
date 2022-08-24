<template>
<router-link to="/cart">
В корзине : {{getCartLength()}} продуктов | 
На сумму: {{getCartTotalPrice()}} point
</router-link>
</template>

<script>
import {useCartStore } from '../cartStore.js'
import {computed} from 'vue'

export default{
    setup() {
        const cartStore = useCartStore()

        //Получить длинну корзины
        const getCartLength = () => {
            const cart =  cartStore.getCart;
            let count = 0;
            for(let product_id in cart){
                count += cart[product_id].count;
            }
            return count;
        }

        //Получить общую сумму корзины в points
        const getCartTotalPrice = () => {
            const cart =  cartStore.getCart;            
            let total = 0;
            for(let product_id in cart){
                total += cart[product_id].price * cart[product_id].count;
            }
            return total;
        }

        return{            
            getCartLength,
            getCartTotalPrice
        }    
    }
}
</script>