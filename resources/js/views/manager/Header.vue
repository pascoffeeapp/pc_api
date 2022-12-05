<template>

    <div id="header">
        <div id="toggle" @click="toggleSidebar">
            <i class="fa fa-bars"></i>
        </div>
        <div class="logo">
            <b>KOPI PAS</b>
        </div>
        <div class="btn-logout ms-auto">
            <a href="#"><button type="button" class="btn btn-primary m-5">Logout</button></a>
        </div>
    </div>
  
</template>

<script>
export default {
    methods: {
        toggleSidebar() {
            console.log(this.$emit('toggleClicked', true)   )
        }
    }
}
</script>