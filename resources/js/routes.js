import Vue from 'vue'
import VueRouter from 'vue-router';

import Dashboard from './components/Dashboard.vue';
import DepartmentList from './components/departments/DepartmentList.vue';
import UserList from './components/users/UserList.vue';
import SpeakerList from './components/speakers/SpeakerList.vue';
import VenueList from './components/venues/VenueList.vue';
import EventList from './components/events/EventList.vue';
import TemplateList from './components/templates/TemplateList.vue';
import TemplateUpload from './components/templates/TemplateByUpload.vue'
import TemplateCode from './components/templates/TemplateByCode.vue'
import TemplateCanvas from './components/templates/TemplateByCanvas.vue'
import TemplateChoice from './components/templates/TemplateChoice.vue'
import Settings from './components/settings/Settings.vue'

Vue.use(VueRouter)

const router =  new VueRouter({
    mode: 'history',
    base: 'web-admin',
    routes: [
        {
            path: '/templates/by-upload',
            name: 'add-by-upload',
            component: TemplateUpload,
            meta: {title: 'Template by upload'}
        },
        {
            path: '/templates/by-code',
            name: 'add-by-code',
            component: TemplateCode,
            meta: {title: 'Template by code'}
        },
        {
            path: '/templates/by-canvas',
            name: 'add-by-canvas',
            component: TemplateCanvas,
            meta: {title: 'Template by canvas'}
        },
        {
            path: '/template/template-choice',
            name: 'template-choice',
            component: TemplateChoice,
            meta: {title: 'Create template'}
        },

        {
            path: '/events',
            name: 'events',
            component: EventList,
            meta: {title: 'Events'}
        },
        {
            path: '/departments',
            name: 'departments',
            component: DepartmentList,
            meta: {title: 'Departments'}
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {title: 'Dashboard'}
        },
        {
            path: '/users',
            name: 'users',
            component: UserList,
            meta: {title: 'Users'}
        },
        {
            path: '/speakers',
            name: 'speakers',
            component: SpeakerList,
            meta: {title: 'Speakers'}
        },
        {
            path: '/venues',
            name: 'venues',
            component: VenueList,
            meta: {title: 'Venues'}
        },
        {
            path: '/templates',
            name: 'templates',
            component: TemplateList,
            meta: {title: 'Templates'}
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings,
            meta: {title: 'Settings'}
        },
        {
            path: '*',
            redirect: '/dashboard'
        }
    ]
})

export default router