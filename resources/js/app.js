import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router.js';

const pinia = createPinia();
const app = createApp({});

import AppComponent from './App.vue';
app.component('app', AppComponent).use(router).use(pinia).mount('#app');
