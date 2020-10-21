<template>
    <v-app>
        <v-divider></v-divider>
        <div class="text-h4 text-center">Latest Events</div>
        <v-divider></v-divider>
        <v-carousel cycle hide-delimiter-background show-arrows-on-hover>
            <v-carousel-item v-for="(slide, i) in slides" :key="i">
                <v-sheet :color="colors[i]" height="100%">
                    <v-row class="fill-height" align="center" justify="center">
                        <div class="display-3">
                            {{ slide }} Slide
                        </div>
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
                slides: [
                'First',
                'Second',
                'Third',
                'Fourth',
                'Fifth',
                ],
            }
        },
        methods: {
            setHedeaderTitle(){
                document.title = 'Home - Event Publication and Poster Management System (EPPMS)';
            },
        },
        created: function() {
            this.setHedeaderTitle()
        },
    }
</script>