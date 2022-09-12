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
                <form class="client_data_form" @submit.prevent>
                    <fieldset>
                        <legend>Информация о пользователе</legend>

                        <label for="name">Фамилия:<br/>
                            <input placeholder="Фамилия" type="text" v-model="lastName">
                        </label> <br/>
                        <span>{{formErrors['lastName']}}<br/></span>
                        <label for="name">Имя:<br/>
                            <input placeholder="Имя" type="text" v-model="firstName">
                        </label> <br/>
                        <span>{{formErrors['firstName']}}<br/></span>
                        <label for="name">Отчество:<br/>
                            <input placeholder="Отчество" type="text" v-model="middleName">
                        </label> <br/>
                        <span>{{formErrors['middleName']}}</span>
                    </fieldset>

                    <fieldset>
                        <legend>Информация о адресе</legend>

                        <label for="city">Город:<br/>
                            <input placeholder="Город" type="text" name="city" id="city" v-model="city">
                        </label> <br/>
                        <span>{{formErrors['city']}}<br/></span>
                        <label for="address">Адрес:<br/>
                            <textarea  name="address" id="address" v-model="address"></textarea>
                        </label> <br/>
                        <span>{{formErrors['address']}}<br/></span>
                        <label for="zip">Индекс:<br/>
                            <input placeholder="Индекс" type="text" name="zip" id="zip" v-model="zip">
                        </label> <br/>
                        <span>{{formErrors['zip']}}<br/></span>

                    </fieldset>

                    <button @click="sendCart()">Оформить заказ</button>
                </form>
        </div>
        <div v-else class="empty_cart">
            <h3>Ваша корзина пуста</h3>
        </div>

    </div>
</template>


<script>
import {useCartStore } from '../cartStore.js';

export default{
    data(){
        return{
            firstName: '',
            lastName: '',
            middleName: '',
            city: '',
            address: '',
            zip: '',
            formErrors: [] // Массив с ошибками при заполнение формы
        }
    },
    methods: {
        async sendCart(){

            this.formErrors = [];
            const cartStore = useCartStore();
            let cart = cartStore.getCart;

            const payload = {
                cart: cart,
                firstName: this.firstName,
                lastName: this.lastName,
                middleName: this.middleName,
                city: this.city,
                address: this.address,
                zip: this.zip,
            }

            let response = {};

            try {
                response = await axios.post('/orders', JSON.stringify(payload), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
            }
            catch (exeption){
                response = exeption.response;
            }

            if(response.status === 200) {
               let responseData = response.data;
               if(responseData.status === 'error'){
                   alert(responseData.message);
               }else{
                   alert("Заказ №"+responseData.order['id'] + " был успешно создан");
                   this.firstName = this.lastName = this.middleName = this.city = this. address = this.zip = '';
                   cartStore.updateCart({});
               }
            }else if(response.status === 422) {
                for(let error in response.data.errors){
                    this.formErrors[error] = 'заполните поле'
                }
                console.log(this.formErrors);
            }
            console.log(response);

        },
        deleteCartItem(productId){
            const cartStore = useCartStore();
            let cart =  cartStore.getCart;
            delete cart[productId];
            cartStore.updateCart(cart);
        },
        updateCart(){
            const cartStore = useCartStore();

            let cart = cartStore.getCart;

            for(let k in cart){
                cart[k]['count'] = parseInt(document.getElementById('product_'+k).value);
            }
            cartStore.updateCart(cart);
        }
    },
    mounted(){
        // this._error['general'] = 'general!!!'
    },
    computed:{
        cart: function(){
            const cartStore = useCartStore();
            return cartStore.getCart;
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
