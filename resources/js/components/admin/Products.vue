<template>          
        <div class="form-group">
            <input type="text" v-model="productTitle" id="title" name="title" placeholder="Название продукта"/>
            <textarea id="description" v-model="productDescription" name="description" placeholder="Описание продукта"></textarea>
            <input type="text" v-model="productPrice" id="price" name="price" placeholder="Цена продукта"/>
            <button @click="sendProductForm">Сохранить продукт</button>
       </div>
       <div class="product-list">
        <h1>Products:</h1>
            <div class="product-item" v-for="product in products" :key="product.id">
                <div class="product-name">Title:{{product.name}}</div>
                <div class="product-description">Description: {{product.description}}</div>
                <div class="product-price">Price: {{product.price}}</div>
            </div>
       </div>
</template>

<script>
export default {
    data(){
        return{
            products: [],
            productTitle:'',
            productDescription:'',
            productPrice:0
        }
    },
    methods:{
        async sendProductForm(){

            if(this.productTitle === '' || this.productDescription === ''|| this.productPrice === ''){
                alert('Заполните все поля продукта');
                return;
            }
            const payload = {
                "name" : this.productTitle,
                "description" : this.productDescription,
                "price" : this.productPrice
            };
            
            const response = await axios.post('/admin/api/products', JSON.stringify(payload), {
                headers: {
                     'Content-Type': 'application/json'
                }
            });

            this.productTitle = ''
            this.productDescription = '';
            this.productPrice = null;
            console.log(response);

            this.getProducts();
        },
        async getProducts(){
             const response = await axios.get('/products');
             this.products = response.data;
        }
    },
    mounted(){
        this.getProducts()     
    }
}
</script>

<style scoped>
.form-group {
   margin-bottom: 20px;
   padding: 10px;
   background: #291810;
   width:200px;
      float: left;
}
.form{
    max-width: 350px;
   margin: 50px auto 0;
   padding: 20px;
   background: #FAAB1B;
   font-family: 'Oswald', sans-serif  
}
.form-group input, .form-group label, .form-group textarea {
   display: block;
}
.form-group input textarea {
   padding: 0;
   line-height: 30px;
   background: #FAAB1B;
   border-width: 0;
}
.product-list{
    float: right;
    width: 50%;
    background-color: #ccc;
    vertical-align: text-top;
}
.product-item{
    border: 1px solid;
    padding-left: 10px;
    width: 200px;
}
</style>