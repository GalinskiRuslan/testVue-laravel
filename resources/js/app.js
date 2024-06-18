import './bootstrap';
import { createApp } from 'vue';

import App from './App.vue';
import router from './router';
import Datepicker from 'vue3-datepicker';


const app = createApp(App);
app.component("Datepicker", Datepicker);
app.use(router).mount('#app');
