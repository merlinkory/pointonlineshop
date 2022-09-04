<template>
<div class="logout">
    <router-link to="/logout">Выйти из системы</router-link>
</div>
 <cart-widget></cart-widget>
	<router-link class="menu" to="/">Список товаров</router-link> |
    <router-link class="menu" to="/orders">Заказы</router-link>
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

<style>
.logout{
    float: right;

}
</style>
