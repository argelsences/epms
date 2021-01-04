import Vue from 'vue'
import VueRouter from 'vue-router';

import Dashboard from './components/admin/Dashboard.vue';
import DepartmentList from './components/admin/departments/DepartmentList.vue';
import UserList from './components/admin/users/UserList.vue';
import SpeakerList from './components/admin/speakers/SpeakerList.vue';
import VenueList from './components/admin/venues/VenueList.vue';
import EventList from './components/admin/events/EventList.vue';
import TemplateList from './components/admin/templates/TemplateList.vue';
import TemplateUpload from './components/admin/templates/TemplateByUpload.vue'
import TemplateCode from './components/admin/templates/TemplateByCode.vue'
import TemplateCanvas from './components/admin/templates/TemplateByCanvas.vue'
import TemplateChoice from './components/admin/templates/TemplateChoice.vue'
import Settings from './components/admin/settings/Settings.vue'
import Posters from './components/admin/posters/Posters.vue'

Vue.use(VueRouter)

const router =  new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/web-admin/templates/by-upload',
            name: 'add-by-upload',
            component: TemplateUpload,
            meta: {title: 'Template by upload'}
        },
        {
            path: '/web-admin/templates/by-code',
            name: 'add-by-code',
            component: TemplateCode,
            meta: {title: 'Template by code'}
        },
        {
            path: '/web-admin/templates/by-canvas',
            name: 'add-by-canvas',
            component: TemplateCanvas,
            meta: {title: 'Template by canvas'}
        },
        {
            path: '/web-admin/template/template-choice',
            name: 'template-choice',
            component: TemplateChoice,
            meta: {title: 'Create template'}
        },

        {
            path: '/web-admin/events',
            name: 'events',
            component: EventList,
            meta: {title: 'Events'}
        },
        {
            path: '/web-admin/departments',
            name: 'departments',
            component: DepartmentList,
            meta: {title: 'Departments'}
        },
        {
            path: '/web-admin/',
            name: 'dashboard',
            component: Dashboard,
            meta: {title: 'Dashboard'}
        },
        {
            path: '/web-admin/users',
            name: 'users',
            component: UserList,
            meta: {title: 'Users'}
        },
        {
            path: '/web-admin/speakers',
            name: 'speakers',
            component: SpeakerList,
            meta: {title: 'Speakers'}
        },
        {
            path: '/web-admin/venues',
            name: 'venues',
            component: VenueList,
            meta: {title: 'Venues'}
        },
        {
            path: '/web-admin/templates',
            name: 'templates',
            component: TemplateList,
            meta: {title: 'Templates'}
        },
        {
            path: '/web-admin/settings',
            name: 'settings',
            component: Settings,
            meta: {title: 'Settings'}
        },
        {
            path: '/web-admin/posters',
            name: 'posters',
            component: Posters,
            meta: {title: 'Posters'}
        },
        /* check later {
            path: '*',
            redirect: '/'
        }*/
    ]
})

export default router