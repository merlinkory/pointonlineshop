<template>
    <div class="cart_wiget">
        <router-link to="/cart">
        В корзине : {{getCartLength()}} продуктов |
        На сумму: {{getCartTotalPrice()}} point
        </router-link>
    </div>
</template>

<script>
import {useCartStore } from '../cartStore.js'

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

<style>
.cart_wiget{
    float: right;
    background-color: #dbe0e5;
    padding: 10px;
}

.cart_wiget a{
    text-decoration: none;
    color: #2d3748;
}

.cart_wiget a:hover{
    text-decoration: underline;
}
</style>
