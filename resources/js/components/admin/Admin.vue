<template>
   <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="#">Панель администрирования</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item><router-link to="/users">Пользователи</router-link></b-nav-item>
                <b-nav-item><router-link to="/products">Продукты</router-link></b-nav-item>
                <b-nav-item><router-link to="/orders">Заказы</router-link></b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="float-right" >
                <b-nav-item href="/logout" >logout</b-nav-item>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
   </div>
    <div class="wrapper">
        <router-view></router-view>
    </div>

</template>


<style>
.wrapper{
    margin: 20px;
}
</style>
