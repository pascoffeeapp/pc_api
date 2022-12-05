<template>
        <div id="sidebar">
            <router-link :to="{name:'Dashboard'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-tachometer-alt"></i></div>
                <div class="text">Dashboard</div>
            </router-link>
            <router-link :to="{name:'Role'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-light fa-user"></i></div>
                <div class="text">Role</div>
            </router-link>
            <router-link :to="{name:'User'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-light fa-users"></i></div>
                <div class="text">User</div>
            </router-link>
            <router-link :to="{name:'Table'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-light fa-chair"></i></div>
                <div class="text">Tables</div>
            </router-link>
            <router-link :to="{name:'Menu'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-coffee"></i></div>
                <div class="text">Menu</div>
            </router-link>
            <router-link :to="{name:'Outlet'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-light fa-store"></i></div>
                <div class="text">Outlet</div>
            </router-link>
            <router-link :to="{name:'Stock'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-light fa-box"></i></div>
                <div class="text">Stock</div>
            </router-link>
            <router-link :to="{name:'Wallet'}" class="sidebar-item">
                <div class="icon"><i class="fa fa-wallet"></i></div>
                <div class="text">Wallet</div>
            </router-link>
            <router-link :to="{name:'Takeaway'}" class="sidebar-item">
                <div class="icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="text">Takeaway</div>
            </router-link>
        </div>
</template>