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
import { TiptapVuetifyPlugin } from 'tiptap-vuetify';
/////import DrawerJs from '@vadjs/drawerjs/src/Drawer';
// tiptap CSSs
import 'tiptap-vuetify/dist/main.css'
// drawerjs css
/////import '@vadjs/drawerjs/dist/drawerJs.min.css' 
/////import '@vadjs/drawerjs/dist/drawerJs.standalone.js'

import Route from './routes.js'

const vuetify = new Vuetify()

window.Vue = require('vue');
window.Vue.use(Vuetify);
window.Vue.use(VueMask);


/// drawerJS
/////window.Vue.use(DrawerJs);


// initialize vue2-google-maps
window.Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyC85SAldoyqwtIvtD04Xz18TgYD-ud_bIU',
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

// use this package's plugin
Vue.use(TiptapVuetifyPlugin, {
    // the next line is important! You need to provide the Vuetify Object to this place.
    vuetify, // same as "vuetify: vuetify"
    // optional, default to 'md' (default vuetify icons before v2.0.0)
    iconsGroup: 'md'
  })

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
Vue.component('user-list', require('./components/users/UserList.vue').default);
Vue.component('department-list', require('./components/departments/DepartmentList.vue').default);
Vue.component('speaker-list', require('./components/speakers/SpeakerList.vue').default);
Vue.component('venue-list', require('./components/venues/VenueList.vue').default);
Vue.component('event-list', require('./components/events/EventList.vue').default);
Vue.component('template-list', require('./components/templates/TemplateList.vue').default);
Vue.component('template-choice', require('./components/templates/TemplateChoice.vue').default);
Vue.component('by-upload', require('./components/templates/TemplateByUpload.vue').default);
Vue.component('by-code', require('./components/templates/TemplateByCode.vue').default);
Vue.component('by-canvas', require('./components/templates/TemplateByCanvas.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    //vuetify: new Vuetify,
    vuetify: vuetify,
    router: Route,
    el: '#app',
});
