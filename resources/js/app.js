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
import VueMask from 'v-mask';
import * as VueGoogleMaps from 'vue2-google-maps';

window.Vue = require('vue');
window.Vue.use(Vuetify);
window.Vue.use(VueMask);

// initialize vue2-google-maps
window.Vue.use(VueGoogleMaps, {
    load: {
      key: 'YOUR_API_TOKEN',
      libraries: 'places', // This is required if you use the Autocomplete plugin
      // OR: libraries: 'places,drawing'
      // OR: libraries: 'places,drawing,visualization'
      // (as you require)
  
      //// If you want to set the version, you can do so:
      // v: '3.26',
    },
  
    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,
  
    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then set installComponents to 'false'.
    //// If you want to automatically install all the components this property must be set to 'true':
    installComponents: true
  })
  // initialize vue2-google-maps
  
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
Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('user-list', require('./components/UserList.vue').default);
Vue.component('department-list', require('./components/DepartmentList.vue').default);
Vue.component('speaker-list', require('./components/SpeakerList.vue').default);
Vue.component('venue-list', require('./components/VenueList.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify: new Vuetify,
    el: '#app',
});
