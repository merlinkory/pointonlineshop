<template>
<div class="product">
    <div><strong>Name: </strong>{{product.name}}</div>
    <div><strong>Price: </strong>{{product.price}}</div>
    <div><strong>Description: </strong>{{product.description}}</div>
    <div><img class="product_image" v-for="image in product.images" :key="image.id" v-bind:src="'/storage/images/' + image.image_path"></div>
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
    width: 250px;
    margin-top: 10px;
    padding-left: 10px;
}
.addToCartBtn{
    padding: 10px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
}
.product_image{
     width: 200px;
}
</style>
