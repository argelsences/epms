<template>
    <div class="vue-sidebar">
        <v-app>
            <!--<ul class="nav">
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="material-icons">business</i>
                        <p>Departments</p>
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">library_books</i>
                    <p>Typography</p>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">bubble_chart</i>
                    <p>Icons</p>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">location_ons</i>
                    <p>Maps</p>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">notifications</i>
                    <p>Notifications</p>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">language</i>
                    <p>RTL Support</p>
                </a>
                </li>
            </ul>-->
            <!--<v-card
                class="mx-auto nav-card"
            >-->
                <v-navigation-drawer
                class="navigation"
                dark
                permanent
                >
                <v-list>
                    <v-list-item link>
                        <v-list-item-icon>
                            <v-icon>mdi-office-building-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                <router-link :to="{name: `departments`}">Departments</router-link>
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-content>
                            <v-list-item-title>
                                <router-link :to="{name: `users`}">Users</router-link>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <!--<template v-slot:append>
                    <div class="pa-2">
                    <v-btn block>Logout</v-btn>
                    </div>
                </template>-->
                </v-navigation-drawer>
                <router-view ></router-view>
            <!--</v-card>-->
        </v-app>
    </div>
</template>
<!-- 
1. Make the main template to contain this component
2. In this main content is the call to router-view
-->
<script>
    import VueRouter from 'vue-router';
    import DepartmentList from './DepartmentList.vue';
    import UserList from './UserList.vue';
    
    export default {
        data () {
            return {
                items: [
                { title: 'Dashboard', icon: 'mdi-view-dashboard' },
                { title: 'Departments', icon: 'mdi-image' },
                { title: 'Users', icon: 'mdi-help-box' },
                ],
                right: null,
            }
        },
        router: new VueRouter({
            mode: 'history',
            base: 'web-admin',
            routes: [
                {
                    path: '/departments',
                    name: 'departments',
                    component: DepartmentList
                },
                {
                    path: '/',
                    redirect: {name: ''}
                },
                {
                    path: '/users',
                    name: 'users',
                    component: UserList
                },
                {
                    path: '*',
                    redirect: '/'
                }
            ]
        })
    }
</script>