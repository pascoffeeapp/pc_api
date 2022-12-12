<script setup>
import Header from './Header.vue'
import Sidebar from './Sidebar.vue'
import Content from './Content.vue'
</script>

<template>
    <Header @toggle-clicked="toggleSidebar" />
    <div id="wrapper" class="hide">
        <Sidebar/>
        <Content/>
    </div>
</template>

<script>
import { AuthStore } from '../../stores/Auth';
export default {
    data() {
        return {
            showSidebar: false
        }
    },
    mounted() {
        console.log(AuthStore().isAuthenticated())
        if (!AuthStore().isAuthenticated()) {
            router.replace({name: 'Login'})
        }
    },
    methods: {
        toggleSidebar() {
            if (this.showSidebar) {
                document.querySelector('#wrapper').classList.add('hide')
                this.showSidebar = false;
            }else {
                document.querySelector('#wrapper').classList.remove('hide')
                this.showSidebar = true;
            }
        }
    }
}
</script>

<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');
@import '../../assets/css/style.css';
</style>