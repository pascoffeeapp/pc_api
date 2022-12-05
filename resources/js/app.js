import './bootstrap';
import { createApp } from 'vue';
import router from './router.js';
import './assets/js/script.js';

const app = createApp({});

import AppComponent from './App.vue';
app.component('app', AppComponent).use(router).mount('#app');
