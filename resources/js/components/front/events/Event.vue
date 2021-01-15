<template>
    <v-app>
        <v-divider></v-divider>
        <div class="text-h4 text-center">Latest Events</div>
        <v-divider></v-divider>
        <v-carousel cycle hide-delimiter-background show-arrows-on-hover>
            <v-carousel-item v-for="(slide, i) in slides" :key="i">
                <v-sheet :color="colors[i]" height="100%">
                    <v-row class="fill-height" align="center" justify="center">
                        <v-col cols="12" sm="6" md="6" class="no-gutter">
                            <v-layout row wrap align-center fill-height>
                                <v-flex >
                                    <v-img max-width="300" :src="`${base_url}/${theScreenshot(i)}`" class="event-screenshot"></v-img>
                                </v-flex>
                            </v-layout>
                        </v-col>
                        <v-col cols="12" sm="6" md="6" class="fill-height pa-10 text-center">
                            <h3>{{slide.title}}</h3><br />
                            <h5>{{slide.start_date | formatDate}}</h5>
                            <h5 class="pb-5">{{slide.venue.name}}</h5>
                            <h6>{{slide.excerpt}}</h6>
                            <v-btn text class="ma-5 white--text" ripple dark absolute bottom right :href="`${base_url}/d/${slide.department.url}/events/${slide.id}`">
                                View Event
                                <v-icon>mdi-chevron-right-circle-outline</v-icon>
                            </v-btn> 
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>
        <department></department>      
    </v-app>
</template>
<script>
    import Departments from '../departments/Department.vue'
    export default {
        components: {
            'departments': Departments, 
        },
        data () {
            return {
                colors: [
                'indigo',
                'warning',
                'pink darken-2',
                'red lighten-1',
                'deep-purple accent-4',
                ],
                /*
                slides: [
                'First',
                'Second',
                'Third',
                'Fourth',
                'Fifth',
                ],
                */
                base_url: window.location.origin ,
                isLoading: false,
                slides: [],
            }
        },
        methods: {
            initialize: function() {
                axios.get('/api/latest-events')
                .then( response => {
                    this.slides = response.data
                    this.isLoading = false
                });
            },
            setHedeaderTitle(){
                document.title = 'Home - Event Publication and Poster Management System (EPPMS)';
            },
            theScreenshot(i){
                let eventImage = '/images/eppms-default-poster.jpg'
                if (this.slides[i].poster){
                    eventImage = this.slides[i].poster.file_path || eventImage
                }
                return eventImage
            }
        },
        created: function() {
            this.initialize()
            this.setHedeaderTitle()
        },
    }
</script>
<style scoped>
    .event-screenshot{margin:0 auto;}
    .v-btn:hover{
        transform: scale(1.15);
        text-decoration: none;
    }
</style>