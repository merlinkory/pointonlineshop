<template>
    <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" />
    <b-table
        striped
        hover
        :fields="fields"
        :items="orders"
        :current-page="currentPage"
    >
        <template #cell(id)="row">
            {{ row.value }}
        </template>

        <template #cell(last_name)="row">
            {{ row.value }}
        </template>

        <template #cell(order_total)="row">
            {{ row.value }}
        </template>

        <template #cell(edit)="row">
            <b-link href="#" @click="showOrder(row.item)">
                show
            </b-link>
        </template>
    </b-table>

    <b-modal size="lg" v-model="orderDetailShow" hide-footer id="order_info" title="заказ">
        <div class="my-4">
           <p>Заказ № {{ orderId }} На суммму {{ orderTotal }}</p>
            <p>Статус заказа:</p>
            <p><b-form-select v-model="orderStatus" :options="orderOptions"></b-form-select></p>
            <p>Продукты в заказе:</p>
            <b-table
                striped
                hover
                :items="orderItems">
            </b-table>
        </div>
        <b-button id="saveOrderBtn" class="mt-3" block @click="saveOrder()">Сохранить изменения</b-button>
    </b-modal>
</template>

<script>
export default {
    name: "Orders",
    data(){
        return{
            orders:[],
            fields: [
                {key: 'id'},
                {key: 'last_name', label: 'Фамилия'},
                {key: 'order_total', label: 'Сумма заказа (points)'},
                {key: 'edit', label: ''}
            ],

            currentPage: 1,
            perPage: 1,
            totalRows: 1,

            orderDetailShow: false,

            orderOptions:[
                {value: 'new', text:'new'},
                {value: 'pending', text:'pending'},
                {value: 'canceled', text:'canceled'},
                {value: 'completed', text:'completed'},
            ],

            //order detail data
            orderId: 0,
            orderTotal: 0,
            orderStatus: '',
            orderItems: [],
        }
    },
    methods: {
       async saveOrder(){

           document.getElementById('saveOrderBtn').setAttribute('disabled','disabled');

           const payload = {
               status: this.orderStatus
           }
           const response = await axios.put('/admin/api/orders/'+this.orderId+'/update',payload);
           if(response.data.status === 'ok'){
               //измениене статуса заказа в локально массиве заказов
               for(let order of this.orders){
                   if(order.id === this.orderId){
                       order.status = this.orderStatus;
                   }
               }
               alert('Заказ успешно изменен');
           }else{
               alert('Ошибка при изменение заказа');
           }
           this.orderDetailShow = false;
        },
        showOrder(item){
            this.orderDetailShow = true;
            // document.getElementById('saveOrderBtn').setAttribute('visible','true');
            // console.log(this.orderDetailShow);
            this.orderId = item.id;
            this.orderTotal = item.order_total;
            this.orderStatus = item.status;
            this.orderItems = item.order_items;
            console.log(item);
        },
        async getOrders(){
            const response = await axios.post('/admin/api/orders/list',{
                page: this.currentPage,

            });
            this.orders = response.data.data;
            this.totalRows = Math.ceil(parseInt(response.data.total) / parseInt(response.data.per_page));
            console.log(this.totalRows);
            console.log(response.data)
        },
    },
    mounted() {
        this.getOrders();
    },
    watch:{
        currentPage(){
            this.getOrders();
            console.log('current page was changed');
        }
    }
}
</script>

<style scoped>

</style>
