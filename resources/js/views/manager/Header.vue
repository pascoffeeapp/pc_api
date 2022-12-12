<template>

    <div id="header">
        <div id="toggle" @click="toggleSidebar">
            <i class="fa fa-bars"></i>
        </div>
        <div class="logo">
            <b>KOPI PAS</b>
        </div>
        <div class="btn-logout ms-auto" @click="logout">
            <a href="#"><button type="button" class="btn btn-primary m-5">Logout</button></a>
        </div>
    </div>
  
</template>

<script>
import { AuthStore } from '../../stores/Auth';
export default {
    methods: {
        toggleSidebar() {
            this.$emit('toggleClicked', true)
        },
        logout() {
            const store = AuthStore();
            store.logout(() => {
                this.$router.replace({name: 'Login'})
            }, (err) => {
                console.log(err)
            })

        }
    }
}
</script>