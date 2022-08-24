<template>
<!-- Хочу тут вывести виджет корзины -->
 <cart-widget></cart-widget>
 <br/>
	<router-link to="/">Home</router-link> | 
	<router-link to="/about">About</router-link>
	<hr>	
	<hr>
	
	<router-view></router-view>	
</template>

<script>
import CartWidget from './CartWidget.vue';
export default{
name : 'App',
components :{
	CartWidget
},
data(){
	return{
		cart:[]
	}
}
}
</script>
