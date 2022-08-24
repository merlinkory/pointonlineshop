<template>
USERS:
    <div>
        <div v-for="user in users" :key="user.id">
            {{user.email}} <strong>({{user.balance}})</strong>
            <input type="text" :id="'user_' + user.id" />
            <button @click="addUserPoint(user.id)">добавить баллы</button>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
          users:[]  
        }
    },
    methods:{
        async addUserPoint(user_id){
            let value = document.getElementById('user_' + user_id).value;
            if (value === '') {
                alert('Введите балы')
                return
            }
            let payload = {
                "user_point" : value,
                "user_id" : user_id
            }
            const response = await axios.post('/admin/api/users/create_user_point_transaction', JSON.stringify(payload), {
                headers: {
                     'Content-Type': 'application/json'
                }
            });

            document.getElementById('user_' + user_id).value  = '';
            this.changeUserBalanceOnFrontEnd(user_id, value);
            console.log(response.data);
        },
        changeUserBalanceOnFrontEnd(user_id, user_points){
            this.users.forEach((element) => {
                if(element.id === user_id){
                    element.balance += parseInt(user_points);
                    console.log(element.balance,user_points)
                }
            });
        }
    },
    async mounted() {
        const response = await await axios.get('/admin/api/users');
        this.users = response.data;
        console.log(this.users);
    }
}

</script>