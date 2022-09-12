<template>
    <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" />
    <b-table
        striped
        hover
        :fields="fields"
        :items="orders"
        :current-page="currentPage"

    >
    </b-table>
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
                {key: 'first_name', label: 'Имя'},
                {key: 'middle_name', label: 'Отчество'},
                {key: 'order_total', label: 'Сумма заказа (points)'}
            ],
            currentPage: 1,
            perPage: 1,
            totalRows: 1,

        }
    },
    methods: {
        async getOrders(){
            let response = await axios.post('/admin/api/orders/list',{
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
