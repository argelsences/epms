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
import 'tiptap-vuetify/dist/main.css';
//import moment from 'moment';
import moment from 'moment-timezone';
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
moment.tz.setDefault('Asia/Singapore')


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
 * Filters
 */
Vue.use(moment)
/////Vue.config.productionTip = false
Vue.filter('formatDate', function(value) {
  if (value) {
    //return moment( new Date(value)).add(8, 'hours').format('DD MMMM YYYY @ hh:mm A')
    return moment( new Date(value)).format('DD MMMM YYYY @ hh:mm A')
  }
});
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
// Admin components
//////Vue.component('admin-template', require('./components/admin/AdminTemplate.vue').default);
//////Vue.component('dashboard', require('./components/admin/Dashboard.vue').default);
//////Vue.component('user-list', require('./components/admin/users/UserList.vue').default);
//////Vue.component('department-list', require('./components/admin/departments/DepartmentList.vue').default);
//////Vue.component('speaker-list', require('./components/admin/speakers/SpeakerList.vue').default);
//////Vue.component('venue-list', require('./components/admin/venues/VenueList.vue').default);
/////Vue.component('event-list', require('./components/admin/events/EventList.vue').default);
/////Vue.component('template-list', require('./components/admin/templates/TemplateList.vue').default);
//////Vue.component('template-choice', require('./components/admin/templates/TemplateChoice.vue').default);
//////Vue.component('by-upload', require('./components/admin/templates/TemplateByUpload.vue').default);
//////Vue.component('by-code', require('./components/admin/templates/TemplateByCode.vue').default);
/////Vue.component('by-canvas', require('./components/admin/templates/TemplateByCanvas.vue').default);
/////Vue.component('settings', require('./components/admin/settings/Settings.vue').default);
//////Vue.component('poster-list', require('./components/admin/posters/Posters.vue').default);
// Frontend components
///////Vue.component('department', require('./components/front/departments/Department.vue').default);
///////Vue.component('event', require('./components/front/events/Event.vue').default);
//////Vue.component('contact-form', require('./components/front/events/ContactForm.vue').default);
//////Vue.component('ticket-form', require('./components/front/events/TicketForm.vue').default);
//////Vue.component('subscribe-form', require('./components/front/events/SubscribeForm.vue').default);
//////Vue.component('unsubscribe-form', require('./components/front/subscriber/UnsubscribeForm.vue').default);
//////Vue.component('subscribe-department-form', require('./components/front/departments/SubscribeDepartmentForm.vue').default);
//////Vue.component('contact-department-form', require('./components/front/departments/ContactDepartmentForm.vue').default);

//Vue.component('AsyncComponent', () => import('./components/AsyncComponent') )
// BACKEND
Vue.component('admin-template', () => import('./components/admin/AdminTemplate.vue'));
Vue.component('dashboard', () => import('./components/admin/Dashboard.vue'));
Vue.component('user-list', () => import('./components/admin/users/UserList.vue'));
Vue.component('department-list', () => import('./components/admin/departments/DepartmentList.vue'));
Vue.component('speaker-list', () => import('./components/admin/speakers/SpeakerList.vue'));
Vue.component('venue-list', () => import('./components/admin/venues/VenueList.vue'));
Vue.component('event-list', () => import('./components/admin/events/EventList.vue'));
Vue.component('template-list', () => import('./components/admin/templates/TemplateList.vue'));
Vue.component('template-choice', () => import('./components/admin/templates/TemplateChoice.vue'));
Vue.component('by-upload', () => import('./components/admin/templates/TemplateByUpload.vue'));
Vue.component('by-code', () => import('./components/admin/templates/TemplateByCode.vue'));
Vue.component('settings', () => import('./components/admin/settings/Settings.vue'));
Vue.component('poster-list', () => import('./components/admin/posters/Posters.vue'));
// FRONTEND
Vue.component('department', () => import('./components/front/departments/Department.vue'));
Vue.component('event', () => import('./components/front/events/Event.vue'));
Vue.component('contact-form', () => import('./components/front/events/ContactForm.vue'));
Vue.component('ticket-form', () => import('./components/front/events/TicketForm.vue'));
Vue.component('subscribe-form', () => import('./components/front/events/SubscribeForm.vue'));
Vue.component('unsubscribe-form', () => import('./components/front/subscriber/UnsubscribeForm.vue' ));
Vue.component('subscribe-department-form', () => import('./components/front/departments/SubscribeDepartmentForm.vue'));
Vue.component('contact-department-form', () => import('./components/front/departments/ContactDepartmentForm.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    /////vuetify: new Vuetify,
    vuetify: vuetify,
    router: Route,
    el: '#app',
});
