<script setup>
import { AuthStore } from '../../stores/Auth';

const store = AuthStore();
</script>

<template>
    <div class="login-wrapper">
        <div class="container">
            
            <div class="left">
                <img src="../../assets/img/Logo.svg" alt="Logo">
            </div>
    
            <div class="login">
                <div class="form">
                    <h1>Sign In</h1>
                    <label for="username">Username</label>
                    <input id="username" type="text" @keydown.enter="login" placeholder="Enter Usename"  v-model="username">
                    <label for="password">Password</label>
                    <input id="password" type="password" @keydown.enter="login" placeholder="Enter Password" v-model="password">
                    <button @click="login">Sign In</button>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
// import { AuthStore } from '../../stores/Auth';

export default {
    data(){
        return{
            store: null,
            username: '',
            password: '',
            errors: {
                username: [],
                password: [],
            }
        }
    },
    mounted() {
        if (AuthStore().isAuthenticated()) {
            router.replace({name: 'Dashboard'})
        }
    },
    methods:{
        login(){
            const store = AuthStore();
            store.login({
                username: this.username,
                password: this.password,
            }, (data) => {
                this.$router.push({name: 'Dashboard'})
            }, (data) => {
                console.log(data)
            })
        },
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');
@import '../../assets/css/login.css';
</style>