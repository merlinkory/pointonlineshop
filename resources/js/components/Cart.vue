<template>
    <h1>Содержимое корзины:</h1>
    <div>
        <div class="cart" v-if="Object.keys(cart).length !== 0">
            <div class="cart_item" v-for="(value, key) in cart" :key="key">
                {{value.name}} кол-во <input type="text" v-bind:id="'product_' + key" v-bind:value="value.count" /> цена {{ value.price }} | <button @click="deleteCartItem(key)">X</button>
            </div>
            <div v-if="Object.keys(cart).length !== 0">
                <button @click="updateCart()">Обновить корзину</button>
            </div>
        </div>
        <div class="client_data" v-if="Object.keys(cart).length !== 0">
                <form class="client_data_form">
                    <label for="name">ФИО:<br/>
                    <input placeholder="ФИО" type="text" name="name" id="name">
                    </label> <br/>

                    <label for="city">Город:<br/>
                    <input placeholder="Город" type="text" name="city" id="city">
                    </label> <br/>

                    <label for="address">Адрес:<br/>
                    <textarea  name="address" id="address"></textarea>
                    </label> <br/>

                    <label for="zip">Индекс:<br/>
                    <input placeholder="Индекс" type="text" name="zip" id="zip">
                    </label> <br/>

                    <button>Оформить заказ</button>
                </form>
        </div>
        <div v-else class="empty_cart">
            <h3>Ваша корзина пуста</h3>
        </div>

    </div>
</template>


<script>
import {useCartStore } from '../cartStore.js';
import {computed} from 'vue';
export default{
  setup(){
    const cartStore = useCartStore();

    const deleteCartItem = (productId) => {
        let cart =  cartStore.getCart;
        delete cart[productId];
        cartStore.updateCart(cart);
    }

    const updateCart = ()=> {
        let cart = cartStore.getCart;

        for(let k in cart){
            cart[k]['count'] = parseInt(document.getElementById('product_'+k).value);
        }
        cartStore.updateCart(cart);
    }
    return {
        cart: computed(()=>cartStore.getCart),
        deleteCartItem,
        updateCart,
    }
  }
}
</script>

<style>
.cart{
    background-color: #c9defb;
    float: left;
    margin: 15px;
    padding: 15px;
}

.client_data{
    float: left;
    background-color: #e1e1e1;
    margin: 15px;
    padding: 15px;
}
.cart_item{
    padding: 10px;
}
.cart_item input{
    width:40px;
}
.client_data_form input{
    margin-bottom: 10px;
}
</style>
