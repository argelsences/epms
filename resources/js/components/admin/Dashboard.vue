<template>
    <v-app>
        <div class="text-h4 text-left">Dashboard</div>
        <div class="text-subtitle-1 text-left">In here you see the overview</div>
        <v-divider></v-divider>
            <v-row>
                <v-col>
                    <v-card tile>
                        <v-card-title></v-card-title>
                        <v-card-text>
                            <p class="text-h4">{{numberOfEvents}}</p>
                            <p class="text-uppercase text-subtitle-2">Events</p>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card tile>
                        <v-card-title></v-card-title>
                        <v-card-text>
                            <p class="text-h4">{{numberOfAttendees}}</p>
                            <p class="text-uppercase text-subtitle-2">Tickets Reserved</p>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card tile>
                        <v-card-title></v-card-title>
                        <v-card-text>
                            <p class="text-h4">{{numberOfTemplates}}</p>
                            <p class="text-uppercase text-subtitle-2">Templates Available</p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        <v-card>
            <v-card-title></v-card-title>
            <v-card-text></v-card-text>
        </v-card>
    </v-app>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted');
        },
        data() {
            return {
                rows: [],
                templates: [],
                attendees: [],
            }
        },
        computed: {
            numberOfEvents(){
                return this.rows.length
            },
            numberOfTemplates(){
                return this.templates.length
            },
            numberOfAttendees(){
                return this.attendees.length
            },
        },
        watch: {
            
        },
        methods: {
            initialize: function() {
                axios.get('/api/events')
                .then( response => {
                    this.rows = response.data
                });
            },
            getTemplates: function() {
                axios.get('/api/templates')
                .then( response => {
                    this.templates = response.data
                });
            },
            getAttendees: function() {
                axios.get('/api/attendees')
                .then( response => {
                    this.attendees = response.data
                });
            },
            setHedeaderTitle(){
                document.title = 'Dashboard - Event Publication and Poster Management System (EPPMS)';
            },
        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getTemplates()
            this.getAttendees()
        },
    }
</script>