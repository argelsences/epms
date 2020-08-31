<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list dense>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-home</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-email</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Contact</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-navigation-drawer
                            v-model="drawer"
                            app
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

    <v-app-bar
      app
      color="indigo"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>EPPMS</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col class="text-center">
            <router-view ></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <v-footer
      color="indigo"
      app
    >
      <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
  import VueRouter from 'vue-router';
  import DepartmentList from './DepartmentList.vue';
  import UserList from './UserList.vue';
  export default {
    props: {
      source: String,
    },

    data: () => ({
      drawer: null,
    }),
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