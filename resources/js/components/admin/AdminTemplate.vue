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
        <v-list-item link :to="{name: `events`}">
          <v-list-item-action>
            <v-icon>mdi-calendar</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Events</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link :to="{name: `posters`}">
          <v-list-item-action>
            <v-icon>mdi-file-image-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Posters</v-list-item-title>
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
        <v-list-item link :to="{name: `venues`}">
          <v-list-item-action>
            <v-icon>mdi-map-marker</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Venues</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link :to="{name: `templates`}">
          <v-list-item-action>
            <v-icon>mdi-panorama</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Templates</v-list-item-title>
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
      <v-toolbar-title>
        
        
        <v-btn v-if="isSuperAdmin" class="ma-2 text-h5" text dark :href="`${base_url}`" target="_blank">
            EPPMS
          <v-icon dark right>
            mdi-home
          </v-icon>
        </v-btn>

         <v-btn v-else class="ma-2 text-h5" text dark :href="`${base_url}d/${profile.department.url}`" target="_blank">
            {{profile.department.name}}
          <v-icon dark right>
            mdi-home
          </v-icon>
        </v-btn>

      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn :to="{name: `settings`}" icon>
        <v-icon>mdi-cogs</v-icon>
      </v-btn>
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

  export default {
    props: {
      source: String,
    },

    data() {
      return {
        drawer: null,
        expandOnHover: true,
        profile: {
          department: {
            url: '',
            name: '',
          },
        },
        base_url: window.location.origin + '/',
        isSuperAdmin: false
      }  
    },
    watch: {
      '$route' (to, from) {
        document.title = to.meta.title + ' - Event Publication and Poster Management System (EPPMS)' || 'Event Publication and Poster Management System (EPPMS)'
      }
    },
    methods: {
      getProfile: function() {
        axios.get('/api/profile')
          .then( response => {
              //this.profile = response.data
              this.setUserProfile(response.data)
              if ( this.profile.roles[0].name === 'Super Administrator' )
                this.isSuperAdmin = true
              
              console.log(this.profile)
          });
      },
      setUserProfile(userProfile){
        this.profile = userProfile
      },
    },
    created: function() {
      this.getProfile()
    },
  }
</script>