<script setup>
// This starter template is using Vue 3 <script setup> SFCs
// Check out https://vuejs.org/api/sfc-script-setup.html#script-setup
import Header from './Header.vue'
import Sidebar from './Sidebar.vue'
import Content from './Content.vue'
</script>

<template>
    
        <Header/>
    
    <div id="wrapper" class="hide">
        <Sidebar/>
        <Content/>
    </div>
</template>