<template>
    <product-item
    v-for="product in products"
    :product = "product"
    :key = "product.id"
    @addToCart="$emit('addToCart', product)"
    />
</template>

<script>
import ProductItem from './ProductItem.vue' 
export default{
    components:{
        ProductItem
    },
    props: {
        products:{
            type:Array,
            require: true
        }
    }
}
</script>