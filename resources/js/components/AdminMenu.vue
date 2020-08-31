<template>
    <v-app>
        <div class="sidebar" data-color="green">
            <div class="logo">
                <a href="https://eppms.vicuna.me/" class="simple-text logo-normal">
                    EPPMS
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="vue-sidebar">
                    
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
                            <!--<router-view ></router-view>-->
                        <!--</v-card>-->
                    
                </div>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg bg-dark navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                <a class="navbar-brand" href="#">CONFIGURE THE TITLE OF THE PAGE HERE</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                <!--<form class="navbar-form">
                    <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-white btn-round btn-just-icon">
                    <i class="material-icons">search</i>
                    <div class="ripple-container"></div>
                    </button>
                    </div>
                </form>-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="material-icons">dashboard</i>
                        <p class="d-lg-none d-md-block">
                        Stats
                        </p>
                    </a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">5</span>
                        <p class="d-lg-none d-md-block">
                        Some Actions
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mike John responded to your email</a>
                        <a class="dropdown-item" href="#">You have 5 new tasks</a>
                        <a class="dropdown-item" href="#">You\'re now friend with Andrew</a>
                        <a class="dropdown-item" href="#">Another Notification</a>
                        <a class="dropdown-item" href="#">Another One</a>
                    </div>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                        Account
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log out</a>
                    </div>
                    </li>
                </ul>
                </div>
            </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <div class="row">
                                        <div class="col-6 text-left">
                                            <h4 class="card-title ">Departments</h4>
                                            <p class="card-category"> Here you can manage departments</p>
                                        </div>
                                        <!--<div class="col-6 text-right">
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="material-icons ">add_box</i>User
                                            </a>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <router-view ></router-view>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="float-left">
                    <ul>
                        <li>
                        <a href="https://www.creative-tim.com">
                           Creative Tim
                        </a>
                        </li>
                        <li>
                        <a href="https://creative-tim.com/presentation">
                            About Us
                        </a>
                        </li>
                        <li>
                        <a href="http://blog.creative-tim.com">
                            Blog
                        </a>
                        </li>
                        <li>
                        <a href="https://www.creative-tim.com/license">
                            Licenses
                        </a>
                        </li>
                    </ul>
                    </nav>
                    <div class="copyright float-right">
                    &copy;
                    2020, Event Publication & Poster Management System
                    </div>
                </div>
                </footer>
        </div>
    </v-app>
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