<template>
<div class="orders">
    <h3>Заказы:</h3>
    <table>
        <tr>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Отчество</td>
            <td>Сумма заказа</td>
        </tr>
        <tr v-for="order in orders">
            <td>{{order['last_name']}}</td>
            <td>{{order['first_name']}}</td>
            <td>{{order['middle_name']}}</td>
            <td>{{getOrderTotal(order['order_items'])}}</td>
        </tr>
    </table>
</div>
</template>

<script>
export default {
    name: "Orders",
    data(){
        return{
            orders: [],
        }
    },
    methods:{
      async getOrders(){
          const response = await axios.get('/order');
          console.log(response.data);
          this.orders = response.data;
      },
        getOrderTotal(orderItems){
          let total = 0;
          for(let item of orderItems){
              total += parseInt(item.price) * parseInt(item.quantity);
          }
          return total;
        }
    },
    mounted() {
        this.getOrders();
    }
}
</script>

<style scoped>

</style>
