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
        <v-container fluid>
            <v-row class="fill-height">
                <v-col cols="12" md="8" sm="8">
                    <v-sheet height="64">
                        <v-toolbar flat>
                        <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
                            Today
                        </v-btn>
                        <v-btn fab text small color="grey darken-2" @click="prev">
                            <v-icon small>
                                mdi-chevron-left
                            </v-icon>
                        </v-btn>
                        <v-btn fab text small color="grey darken-2" @click="next">
                            <v-icon small>
                                mdi-chevron-right
                            </v-icon>
                        </v-btn>
                        <v-toolbar-title v-if="$refs.calendar">
                            {{ $refs.calendar.title }}
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-menu bottom right>
                            <template v-slot:activator="{ on, attrs }">
                            <v-btn outlined color="grey darken-2" v-bind="attrs" v-on="on">
                                <span>{{ typeToLabel[type] }}</span>
                                <v-icon right>
                                    mdi-menu-down
                                </v-icon>
                            </v-btn>
                            </template>
                            <v-list>
                            <v-list-item @click="type = 'day'">
                                <v-list-item-title>Day</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'week'">
                                <v-list-item-title>Week</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'month'">
                                <v-list-item-title>Month</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = '4day'">
                                <v-list-item-title>4 days</v-list-item-title>
                            </v-list-item>
                            </v-list>
                        </v-menu>
                        </v-toolbar>
                    </v-sheet>
                    <v-sheet height="600">
                        <v-calendar ref="calendar" v-model="focus" color="primary" :events="events" :event-color="getEventColor"
                        :type="type" @click:event="showEvent" @click:more="viewDay" @click:date="viewDay" @change="updateRange"
                        ></v-calendar>
                        <v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
                            <v-card color="grey lighten-4" min-width="350px" flat>
                                <v-toolbar :color="selectedEvent.color" dark>
                                    <!--<v-btn icon>
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>-->
                                    <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <!--<v-btn icon>
                                        <v-icon>mdi-heart</v-icon>
                                    </v-btn>-->
                                    <!--
                                    <v-btn icon>
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                    -->
                                </v-toolbar>
                                <v-card-text>
                                    <v-list-item>
                                        <v-list-item-avatar>
                                            <v-icon class="grey lighten-1" dark>mdi-calendar</v-icon>
                                        </v-list-item-avatar>
                                        <v-list-item-content class="text-left">
                                            <v-list-item-subtitle v-text="formatDate(selectedEvent.start)"></v-list-item-subtitle>
                                            <v-list-item-subtitle v-text="selectedEvent.venue"></v-list-item-subtitle>
                                            <v-list-item-subtitle v-text="selectedEvent.department_name"></v-list-item-subtitle>
                                            <v-divider class="pt-5 pb-2"></v-divider>
                                            <v-list-item-subtitle v-text="selectedEvent.excerpt"></v-list-item-subtitle>
                                        </v-list-item-content>
                                        <v-list-item-action>
                                        </v-list-item-action>
                                    </v-list-item>
                                </v-card-text>
                                <v-card-actions>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn icon>
                                                <v-icon color="pink" @click="eventURL(selectedEvent)">mdi-eye</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>View the event</span>
                                    </v-tooltip>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="secondary" @click="selectedOpen = false">
                                        Cancel
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-menu>
                    </v-sheet>
                </v-col>
                <v-col cols="12" md="4" sm="4">
                    <v-card tile>
                        <v-card-title>
                            <p class="text-uppercase text-h6">Latest Events</p>
                        </v-card-title>
                        <v-card-text>
                            <v-list-item v-for="(event, index) in rows.slice(0,5)" :key="event.id">
                                <v-list-item-avatar>
                                    <v-icon class="grey lighten-1" dark>mdi-calendar</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content class="text-left">
                                    <v-list-item-title v-text="event.title"></v-list-item-title>
                                    <v-list-item-subtitle v-text="formatDate(event.start_date)"></v-list-item-subtitle>
                                    <v-list-item-subtitle v-text="event.venue.name"></v-list-item-subtitle>
                                    <v-list-item-subtitle v-text="event.department.name"></v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                           <v-btn icon>
                                                <v-icon color="pink" @click="eventURL(event)">mdi-eye</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>View the event</span>
                                    </v-tooltip>
                                </v-list-item-action>
                            </v-list-item>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
    import moment from 'moment'
    export default {
        mounted() {
            console.log('Component mounted')
            this.$refs.calendar.checkChange()
        },
        data() {
            return {
                rows: [],
                templates: [],
                attendees: [],

                focus: '',
                type: 'month',
                typeToLabel: {
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    '4day': '4 Days',
                },
                selectedEvent: {},
                selectedElement: null,
                selectedOpen: false,
                events: [],
                colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
                names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
                theEvent : [],

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
                axios.get('/api/dashboard/events')
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
            viewDay ({ date }) {
                this.focus = date
                this.type = 'day'
            },
            getEventColor (event) {
                return event.color
            },
            setToday () {
                this.focus = ''
            },
            prev () {
                this.$refs.calendar.prev()
            },
            next () {
                this.$refs.calendar.next()
            },
            showEvent ({ nativeEvent, event }) {
                const open = () => {
                    this.selectedEvent = event
                    this.selectedElement = nativeEvent.target
                    setTimeout(() => {
                        this.selectedOpen = true
                    }, 10)
                }

                if (this.selectedOpen) {
                    this.selectedOpen = false
                    setTimeout(open, 10)
                } 
                else {
                    open()
                }

                nativeEvent.stopPropagation()
            },
            updateRange ({ start, end }) {
                
                const min = new Date(`${start.date}T00:00:00`)
                const max = new Date(`${end.date}T23:59:59`)
                
                let theMin = moment(min).format('YYYY-MM-DD HH:mm:ss')
                let theMax = moment(max).format('YYYY-MM-DD HH:mm:ss')

                axios.get(`/api/events-by-range/${theMin}/${theMax}`)
                .then( response => {
                    this.theEvent = response.data
                    this.setEventsByRange()
                })
                
            
            },
            rnd (a, b) {
                return Math.floor((b - a + 1) * Math.random()) + a
            },

            formatDate(date){
                return moment(date).format('dddd, MMMM Do YYYY hh:mm A')
            },
            eventURL(item) {
                console.log(item)
                let vID = item.id
                let theDepartmentURL = item.department.url
                
                window.open('/d/'+theDepartmentURL+'/events/'+ vID, '_blank');
            },
            setEventsByRange(){

                const events = []
                let theEvent = this.theEvent

                for (let i = 0; i < theEvent.length; i++) {
                    const allDay = 1

                    events.push({
                            name: theEvent[i].title,
                            start: theEvent[i].start_date,
                            end: theEvent[i].end_date,
                            color: this.colors[this.rnd(0, this.colors.length - 1)],
                            timed: allDay,
                            excerpt: theEvent[i].excerpt,
                            venue: theEvent[i].venue.name,
                            department: {
                                name: theEvent[i].department.name,
                                url: theEvent[i].department.url,
                            },
                            department_name: theEvent[i].department.name,
                            id: theEvent[i].id,
                            
                        })
                }
                this.events = events
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