/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import { ModelSelect } from 'vue-search-select';
import 'vue-search-select/dist/VueSearchSelect.css';
window._ = require('lodash');
// import Swal from 'sweetalert2';
window.Swal = require('sweetalert2');
import Notifications from 'vue-notification';
Vue.use(Notifications);
import VueHtmlToPaper from 'vue-html-to-paper';
import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import VModal from 'vue-js-modal';
// window._ = require('vue-notification');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('router-component', require('./components/RouterComponent.vue').default);
Vue.component('invoicer', require('./components/Invoicer.vue').default);
Vue.component('v-select', vSelect);
Vue.component('model-select', ModelSelect);
Vue.component('sweet-alert', Swal);
Vue.use(VueHtmlToPaper);
Vue.use(ClientTable);
Vue.use(VModal);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
