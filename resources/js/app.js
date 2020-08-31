/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// commented as it collides with material design
/////require('./bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vuetify from 'vuetify';
import VueMask from 'v-mask'

window.Vue = require('vue');
window.Vue.use(Vuetify);
window.Vue.use(VueMask);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin-template', require('./components/AdminTemplate.vue').default);
Vue.component('user-list', require('./components/UserList.vue').default);
Vue.component('department-list', require('./components/DepartmentList.vue').default);
Vue.component('admin-menu', require('./components/AdminMenu.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify: new Vuetify,
    el: '#app',
});
