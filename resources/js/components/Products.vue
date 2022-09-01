<template>
     <h2>Продукты</h2>
     <div>

     </div>
      <product-list :products="products"
      @addToCart="addToCart"/>
</template>

<script>
import ProductList from './ProductList.vue';
import {useCartStore } from '../cartStore.js';

export default {
    components:{
        ProductList
    },
    setup(){

        const cartStore = useCartStore();

        const addToCart = (product) => {
            let cart =  cartStore.getCart;
            if (cart[product.id] === undefined){
                cart[product.id] = {
                    "count" : 1,
                    'name' : product.name,
                    'price' : product.price
                }
            }else{
                cart[product.id]['count'] ++;
            }
            console.log(cart)
            cartStore.updateCart(cart);
            alert("Товар добавлен в корзину")
        }

        return {
            addToCart
        }
    },
    data(){
        return {
            products: [],
            cart: {}
        }
    },
    methods:{
        async getData(){
            const response = await axios.get('/products')
            console.log(response.data)
            return response.data
        },
    },
    async mounted() {
         this.products = await this.getData()

         this.cart = this.getCart

    },
}
</script>
