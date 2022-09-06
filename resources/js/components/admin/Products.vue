<template>
        <div class="form-group">
            <form @submit.prevent="sendProductForm">
                <label>Название продукта:<br/><input type="text" v-model="productTitle" id="title" name="title" placeholder="Название продукта"/></label>
                <label>Описание продукта<br/><textarea id="description" v-model="productDescription" name="description" placeholder="Описание продукта"></textarea></label>
                <label>Цена:<br/><input type="text" v-model="productPrice" id="price" name="price" placeholder="Цена продукта"/></label>
                <label>Кол-во:<br/><input type="text" v-model="productQuantity" id="quantity" name="quantity" placeholder="Кол-во"/></label>
                <label>Изображение:<br/><input ref="image" type="file" @change="processFile"></label>
                <button>Сохранить продукт</button>
            </form>
       </div>
       <div class="product-list">
        <h1>Products:</h1>
            <div class="product-item" v-for="product in products" :key="product.id">
                <form @submit.prevent="editProduct(product.id)">
                    <label>Название: <input v-bind:id="'product_name_' + product.id" type="text" v-bind:value="product.name" /></label><br/>
                    <label>Описание: <input v-bind:id="'product_description_' + product.id" type="text" v-bind:value="product.description" /></label><br/>
                    <label>Цена: <input v-bind:id="'product_price_' + product.id" type="text" v-bind:value="product.price" /></label><br/>
                    <label>Кол-во: <input v-bind:id="'product_quantity_' + product.id" type="text" v-bind:value="product.quantity" /></label><br/>                                      
                    <img class="product_image" v-for="image in product.images" :key="image.id" v-bind:src="'/storage/images/' + image.image_path" /> <br/> 
                    <button>Изменить продукт</button>              
                </form>                                                                           
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
            productPrice:0,
            productQuantity:0,
            productImage: null,
        }
    },
    methods:{
        async editProduct(product_id){
            
            let payload = {
                id: product_id,
                name: document.getElementById('product_name_'+product_id).value,
                description: document.getElementById('product_description_'+product_id).value,
                price: document.getElementById('product_price_'+product_id).value,
                quantity: document.getElementById('product_quantity_'+product_id).value
            };
            

            const response = await axios.put('/admin/api/product', JSON.stringify(payload),{
                headers: {
                     'Content-Type': 'application/json'
                }
            });

            if(response.data.status === 'ok'){
                alert('Успешно отредактировано!')
            }else{
                alert('Ошибка во время редактирования!')
            }
        
        },
        processFile(event) {
            this.productImage = event.target.files[0];
            console.log(this.productImage); // В консоли картинка распознаётся со всеми параметрами как надо
        },
        async sendProductForm(){
            let form = new FormData();
            form.append('name', this.productTitle);
            form.append('description', this.productDescription);
            form.append('price', this.productPrice);
            form.append('quantity', this.productQuantity);
            form.append('image', this.productImage);

            console.log(form);

            const response = await axios.post('/admin/api/product', form);

            this.productTitle = ''
            this.productDescription = '';
            this.productPrice = null;
            this.productQuantity = null;

            console.log(response);

            this.getProducts();
        },
        async getProducts(){
             const response = await axios.get('/products');
             this.products = response.data;
             console.log(response.data);
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
   background: #7ba4e5;
   width:250px;
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
   background: #72c5d3;
   border-width: 0;
}
.product-list{
    float: right;
    width: 50%;
    background-color: #ccc;
    vertical-align: text-top;
    padding: 20px;
}
.product-item{
    border: 1px solid;
    padding-left: 10px;
}
.product_image{
    width: 200px;
}
</style>
