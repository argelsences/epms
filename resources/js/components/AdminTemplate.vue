<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app :expand-on-hover="expandOnHover" mobile-breakpoint="800">
      <v-list dense>
        <v-list-item link :to="{name: `dashboard`}">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link :to="{name: `departments`}">
          <v-list-item-action>
            <v-icon>mdi-office-building</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Departments</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link :to="{name: `speakers`}">
          <v-list-item-action>
            <v-icon>mdi-bullhorn</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Speakers</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link :to="{name: `users`}">
          <v-list-item-action>
            <v-icon>mdi-account-multiple</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Users</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <template v-slot:prepend>
        <v-list dense>
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-account-circle-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <div class="text-subtitle-2 text-left">
                  {{profile.name}}
                </div>
                <div class="text-caption text-left">
                  {{profile.designation}}
                </div>
                <v-btn x-small color="cyan darken-2" tile outlined>
                  Profile
                </v-btn>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
      </template>
      <!--<template v-slot:append>
        <div class="pa-2">
          <v-btn block>Logout</v-btn>
        </div>
      </template>-->
    </v-navigation-drawer>

    <v-app-bar app class="cyan darken-4" dark>
      <!--<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>-->
      <v-toolbar-title>EPPMS</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn onclick="event.preventDefault();document.getElementById('logout-form').submit();" icon>
        <v-icon>mdi-exit-run</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main>
      <v-container class="fill-height" fluid >
        <v-row align="center" justify="center">
          <v-col class="text-center">
            <router-view ></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer app class="cyan darken-4" dark >
      <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
  import VueRouter from 'vue-router';
  import Dashboard from './Dashboard.vue';
  import DepartmentList from './DepartmentList.vue';
  import UserList from './UserList.vue';
  import SpeakerList from './SpeakerList.vue';

  export default {
    props: {
      source: String,
    },

    data() {
      return {
        drawer: null,
        expandOnHover: true,
        profile: [],
      }  
    },
    router: new VueRouter({
      mode: 'history',
      base: 'web-admin',
      routes: [
          {
              path: '/departments',
              name: 'departments',
              component: DepartmentList,
              meta: {title: 'Departments'}
          },
          {
              path: '/',
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
              path: '*',
              redirect: '/'
          }
      ]
    }),
    watch: {
      '$route' (to, from) {
        document.title = to.meta.title + ' - Event Publication and Poster Management System (EPPMS)' || 'Event Publication and Poster Management System (EPPMS)'
      }
    },
    methods: {
      getProfile: function() {
        axios.get('/api/profile')
          .then( response => {
              this.profile = response.data;
          });
      },
    },
    created: function() {
      this.getProfile()
    },
  }
</script>