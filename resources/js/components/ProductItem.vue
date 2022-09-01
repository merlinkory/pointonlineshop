<template>
<div class="product">
    <div>Name:{{product.name}}</div>
    <div>Description:{{product.description}}</div>
    <div><button class="addToCartBtn" @click="$emit('addToCart', product)">add to cart</button></div>
</div>
</template>

<script>

export default {
    components:{
    },
    props:{
        product:{
            type:Object,
            require:true
        }
    }
}
</script>

<style>
.product{
    border: 1px solid #ccc;
    width: 200px;
    margin-top: 5px;
}
.addToCartBtn{
       padding: 10px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
}
</style>
