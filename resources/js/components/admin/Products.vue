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
                    <div id="image_container">
                        <div v-for="image in product.images" :key="image.id" v-bind:id="'image_' + image.id">
                            <img class="product_image"  v-bind:src="'/storage/images/' + image.image_path" />
                            <a href="#"  @click.prevent="deleteImage(product.id, image.id)">X</a> <br/>
                        </div>
                    </div>
                    <button>Изменить продукт</button>
                </form>
                    <br/>
                <form @submit.prevent="addNewImage(product.id)">
                    <label>Изображение:<br/><input ref="image" v-bind:id="'image_product_id_'+ product.id" type="file" @change="processFile"></label>
                    <button>Добавить изображение</button>
                </form> <br/>
                <button @click="deleteProduct(product.id)">Удалить</button>
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
        async deleteProduct(product_id){

            if(!confirm('вуверены в удаление ?')) return true;

            const response = await axios.delete('/admin/api/products/'+ product_id);

            if(response.data.status === 'ok'){
                for(let key in this.products){
                    if(this.products[key].id === product_id){
                        this.products.splice(key,1);
                    }
                }
            }else{
                alert('Проблема с удалением');
            }
        },
        async addNewImage(product_id){
            let form = new FormData();

            form.append('product_id', product_id);
            form.append('image',this.productImage);

            const response = await axios.post('/admin/api/products/image', form);

            if(response.data.status === 'ok'){

                let product  = this.getProductById(product_id);
                console.log(product);
                product.images.push(response.data.image);

                this.productImage = null;
            }else{
                alert('Проблема с добавлением картинки');
            }
        },
        getProductById(product_id){
            for(let product of this.products){
                    if(product.id === product_id){
                        return product;
                    }
                }
        },
        async deleteImage(product_id, image_id){

            if(!confirm('вуверены в удаление ?')) return true;
            const response = await axios.delete('/admin/api/products/image/'+image_id);

            if(response.data.status === 'ok'){

                let product = this.getProductById(product_id);
                for(let key in product.images){
                    console.log(product.images[key].id, image_id);
                    if(product.images[key].id === image_id){
                        product.images.splice(key,1);
                    }
                }
                //document.getElementById('image_' + id).remove(); //TODO: подумать может оставить это решение, оно быстрее...
            }
        },
        async editProduct(product_id){

            let payload = {
                id: product_id,
                name: document.getElementById('product_name_'+product_id).value,
                description: document.getElementById('product_description_'+product_id).value,
                price: document.getElementById('product_price_'+product_id).value,
                quantity: document.getElementById('product_quantity_'+product_id).value
            };


            const response = await axios.put('/admin/api/products', JSON.stringify(payload),{
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
        },
        async sendProductForm(){
            let form = new FormData();
            form.append('name', this.productTitle);
            form.append('description', this.productDescription);
            form.append('price', this.productPrice);
            form.append('quantity', this.productQuantity);
            form.append('image', this.productImage);

            console.log(form);

            const response = await axios.post('/admin/api/products', form);

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
   width:350px;
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
    float: left;
    width: 50%;
    background-color: #ccc;
    vertical-align: text-top;
    padding: 20px;
    margin-left: 10px;
}
.product-item{
    border: 1px solid;
    padding-left: 10px;
}
.product_image{
    width: 200px;
}
</style>
