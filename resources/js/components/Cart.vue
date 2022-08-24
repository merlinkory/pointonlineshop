<template>
    <h1>Содержимое корзины:</h1>
    <div>
        <div v-for="(value, key) in cart" :key="key">
            {{key}} :  {{value.name}} кол-во {{ value.count }} ценва {{ value.price }} <br/>
        </div>    
    </div>
</template>


<script>
import {useCartStore } from '../cartStore.js';
import {computed} from 'vue';
export default{
  setup(){
    const cartStore = useCartStore();

    return {
        cart: computed(()=>cartStore.getCart),
    }
  }
}
</script>