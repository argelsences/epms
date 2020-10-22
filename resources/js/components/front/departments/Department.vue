<template>
    <v-app>
        <v-divider></v-divider>
        <div class="text-h4 text-center">Departments</div>
        <v-divider></v-divider>
        <!-- no container as the component is already enclosed with default -->
        <v-row>
            <v-col cols="4" v-for="row in rows" :key="row.id">
                <v-lazy v-model="isActive" :options="{threshold: .8}" min-height="200" transition="fade-transition">
                    <v-card class="mx-auto" max-width="400">
                        <!--<v-img class="white--text align-end" height="200px" src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">-->
                        <v-img class="white--text align-end" height="200px" :src="row.department.logo_path">
                            <v-card-title  class="text-left secondary opacity-half" elevation=24>{{row.department.name}}</v-card-title>
                        </v-img>

                        <v-card-subtitle class="pb-0">
                        </v-card-subtitle>

                        <!--<v-card-text class="text--primary" v-for="event in row.events" :key="event.id">
                            <div class="text-caption">{{event.start_date}} - {{event.title}}</div>
                        </v-card-text>-->

                        <v-card-actions>
                            <v-badge bordered color="error" :content="row.events.count"  v-if="row.events.count">
                                Upcoming Events
                            </v-badge>
                            <v-spacer />
                            <v-btn :style="style_color(row.department.page_header_bg_color)" :href="'/d/' + row.department.url" target="_blank" class="white--text text-right">
                                URL
                                <v-icon right dark>
                                    mdi-arrow-top-right
                                </v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-lazy>
            </v-col>
        </v-row>
    </v-app>
</template>
<script>
export default {
        mounted() {
            console.log('Component mounted')
        },
        data() {
            return {
                rows: [],
                isActive: false,
            }
        },
        computed: {},
        watch: {},
        methods: {
            initialize: function() {
                axios.get('/api/departments-front-list')
                .then( response => {
                    this.rows = response.data;
                });
            },
            style_color: function (hex) {
                return "background-color:" + hex
            },
        },
        created: function() {
            this.initialize()
        },
    }
</script>
<style scoped>
    .opacity-half{opacity:0.8;}
</style>