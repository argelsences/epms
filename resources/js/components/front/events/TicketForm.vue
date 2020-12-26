<template>
    <v-app>
        <!--
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="10" md="10">
                            <v-alert v-if="submitted" dense outlined type="info">{{message}}</v-alert>
                        </v-col>
                    </v-row>
                    <v-form v-model="isValid" ref="form">
                        <v-row v-for="ticket in theEvent.tickets" :key="ticket.id" class="ticket" property="offers" typeof="Offer">
                            <v-col cols="12" sm="8" md="8">
                                <span class="ticket-title semibold" property="name">
                                    {{ticket.title}}
                                </span>
                                <p class="ticket-descripton mb0 text-muted" property="description">
                                    {{ticket.description}}
                                </p>
                            </v-col>
                            <v-col cols="12" sm="2" md="2">
                                <div class="ticket-pricing float-right" style="margin-right: 20px;">
                                    FREE
                                </div>
                            </v-col>
                            <v-col cols="12" sm="2" md="2">
                                <div v-if="ticket.is_paused" >
                                    <span class="text-danger float-right">
                                        Ticket currently not on sale
                                    </span>
                                </div>
                                <div v-else>
                                    <div v-if="ticket.quantity_available - ticket.quantity_booked == 0">
                                        <span class="text-danger float-right" property="availability"
                                                content="http://schema.org/SoldOut">
                                                Sold out
                                        </span>
                                    </div>
                                    <div v-else-if="ticket.start_book_date > currentTimestamp">
                                        <span class="text-danger float-right" >
                                            Sale not started yet
                                        </span>
                                    </div>
                                    <div v-else-if="ticket.end_book_date > currentTimestamp">
                                        <span class="text-danger float-right">
                                            Sale has ended
                                        </span>
                                    </div>
                                    <div v-else>
                                        <input name="tickets[]" type="hidden" :value="ticket.id">
                                        <meta property="availability" content="http://schema.org/InStock">
                                        <select :name="`ticket_${ticket.id}`" class="form-control float-right" style="text-align: center">
                                            <option v-if="ticketCount > 1" value="0">0</option>
                                            <option v-for="i in (ticket.min_per_person, ticket.max_per_person)" :value="i" :key=i>{{i}}</option>
                                        </select>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-divider></v-divider>
                                <p class="text-center">Choose the number of tickets and click "REGISTER". On the next step you will be asked for your information.</p>
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" class="white--text" @click="checkout">REGISTER</v-btn>
            </v-card-actions>
        </v-card>
        -->

        <v-card flat class="ticket-form">
            <v-card-title class="title font-weight-regular justify-space-between">
                <h1 class='section_head text-center'>
                    {{ currentTitle }}
                </h1>
            </v-card-title>
            <v-window v-model="step">
                <v-window-item :value="1" ref="ticketWindow">
                    <v-card-text>
                        <v-form v-model="isValid" ref="form">
                            <v-row v-for="ticket in theEvent.tickets" :key="ticket.id" class="ticket" property="offers" typeof="Offer">
                                <v-col cols="12" sm="8" md="8">
                                    <span class="ticket-title semibold" property="name">
                                        {{ticket.title}}
                                    </span>
                                    <p class="ticket-descripton mb0 text-muted" property="description">
                                        {{ticket.description}}
                                    </p>
                                </v-col>
                                <v-col cols="12" sm="2" md="2">
                                    <div class="ticket-pricing float-right" style="margin-right: 20px;">
                                        FREE
                                    </div>
                                </v-col>
                                <v-col cols="12" sm="2" md="2">
                                    <div v-if="ticket.is_paused" >
                                        <span class="text-danger float-right">
                                            Ticket currently not on sale
                                        </span>
                                    </div>
                                    <div v-else>
                                        <div v-if="ticket.quantity_available - ticket.quantity_booked == 0">
                                            <span class="text-danger float-right" property="availability"
                                                    content="http://schema.org/SoldOut">
                                                    Sold out
                                            </span>
                                        </div>
                                        <div v-else-if="ticket.start_book_date > currentTimestamp">
                                            <span class="text-danger float-right" >
                                                Sale not started yet
                                            </span>
                                        </div>
                                        <div v-else-if="ticket.end_book_date > currentTimestamp">
                                            <span class="text-danger float-right">
                                                Sale has ended
                                            </span>
                                        </div>
                                        <div v-else>
                                            <input name="tickets[]" type="hidden" :value="ticket.id">
                                            <meta property="availability" content="http://schema.org/InStock">
                                            <select :name="`ticket_${ticket.id}`" class="form-control float-right" style="text-align: center" v-model="numberTickets[ticket.id]" @change="createEmptyAttendee($event,ticket.id)">
                                                <option v-if="ticketCount > 1" value="0">0</option>
                                                <option v-for="i in (ticket.min_per_person, ticket.max_per_person)" :value="i" :key=i>{{i}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="12" md="12">
                                    <v-divider></v-divider>
                                    <p class="text-center">Choose the number of tickets and click "REGISTER". On the next step you will be asked for your information.</p>
                                    <v-divider></v-divider>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-window-item>
                <v-window-item :value="2" ref="orderWindow">
                    <v-card-text>
                        <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="8" md="8">
                                <h3>Your Information</h3>
                                <v-text-field v-model="orders.bookee.first_name" label="First Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                <v-text-field v-model="orders.bookee.last_name" label="Last Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                <v-text-field v-model="orders.bookee.email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-mail" ></v-text-field>
                                <input type="hidden" 
                                <v-btn x-small depressed color="primary" @click="copyToHolder">Copy these details to all ticket holders</v-btn>
                            </v-col>
                            <v-col cols="12" sm="4" md="4">
                                <v-card elevation="5">
                                    <v-card-title>
                                        <v-icon>
                                            mdi-cart
                                        </v-icon>
                                        Order Summary
                                    </v-card-title>
                                    <v-card-text v-for="(t,i) in theEvent.tickets" :key="t.id" class="order">    
                                        <div>{{t.title}} x <strong>{{numberTickets[t.id]}}</strong></div>
                                        <div >FREE</div>
                                        <v-divider></v-divider>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="8" md="8">
                                <h3>Ticket Holder Information</h3>
                            </v-col>
                        </v-row>

                        <v-row v-for="(ticket,index) in theEvent.tickets" :key="ticket.id" class="ticket">
                            <v-col cols="12" sm="8" md="8">
                                <v-row v-for="(n,i) in numberTickets[ticket.id]" :key=i>
                                    <v-card raised class="mb-5 ticket-card" tile>
                                        <v-card-title class="white--text primary">
                                            {{ticket.title}} Ticket Holder {{n}} Details
                                        </v-card-title>
                                        <v-card-text id="ticket-holder-details">
                                            <v-text-field v-model="orders.attendee[ticket.id][i].first_name" label="First Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ref="ticket-holder-detail-first-name"></v-text-field>
                                            <v-text-field v-model="orders.attendee[ticket.id][i].last_name" label="Last Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" id="ticket-holder-detail-last-name"></v-text-field>
                                            <v-text-field v-model="orders.attendee[ticket.id][i].email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-mail" id="ticket-holder-detail-email"></v-text-field>
                                        </v-card-text>
                                    </v-card>
                                </v-row>
                            </v-col>
                        </v-row>
                        </v-form>
                    </v-card-text>
                </v-window-item>
                <v-window-item :value="3" ref="confirmationWindow">
                    <v-row>
                        <v-col cols="12" sm="8" md="8">
                            <v-alert icon="mdi-shield-lock-outline" prominent text type="info">
                                We are ready to book your reservation, please review your order and click the <strong>RESERVE</strong> button to proceed.
                            </v-alert>
                            <v-card flat class="mb-5 ticket-card" tile>
                                <v-card-title>
                                    Bookee Details
                                </v-card-title>
                                <v-card-text id="ticket-holder-details">
                                    <p label="First Name"><strong>First Name:</strong> {{orders.bookee.first_name}}</p>
                                    <p label="Last Name"><strong>Last Name:</strong>{{orders.bookee.last_name}}</p>
                                    <p label="Email"><strong>Email:</strong>{{orders.bookee.email}}</p>
                                </v-card-text>
                            </v-card>
                            <v-row v-for="(ticket,index) in theEvent.tickets" :key="ticket.id" class="ticket">
                                <v-col cols="12" sm="12" md="12">
                                    <v-row v-for="(n,i) in numberTickets[ticket.id]" :key=i>
                                        <v-card flat class="mb-5 ticket-card" tile>
                                            <v-card-title>
                                                {{ticket.title}} Ticket Holder {{n}} Details
                                            </v-card-title>
                                            <v-card-text id="ticket-holder-details">
                                                <p label="First Name"><strong>First Name:</strong> {{orders.attendee[ticket.id][i].first_name}}</p>
                                                <p label="Last Name"><strong>Last Name:</strong>{{orders.attendee[ticket.id][i].last_name}}</p>
                                                <p label="Email"><strong>Email:</strong>{{orders.attendee[ticket.id][i].email}}</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" sm="4" md="4">
                            <v-card elevation="5">
                                <v-card-title>
                                    <v-icon>
                                        mdi-cart
                                    </v-icon>
                                    Order Summary
                                </v-card-title>
                                <v-card-text v-for="(t,i) in theEvent.tickets" :key="t.id" class="order">    
                                    <div>{{t.title}} x <strong>{{numberTickets[t.id]}}</strong></div>
                                    <div >FREE</div>
                                    <v-divider></v-divider>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-window-item>
            </v-window>
            <v-divider></v-divider>
            <v-card-actions>
            <v-btn :disabled="step === 1" text @click="ticketBackButtonClicked">
                Back
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" :disabled="!isValid || isSubmitting" depressed @click="ticketForwardButtonClicked">
                {{buttonTitle}}
            </v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
</template>

<script>
import moment from 'moment'
export default {
    props: ['event'],
    mounted() {
        let numberTickets = this.numberTickets
        this.theEvent.tickets.forEach(function(ticket){
            console.log(numberTickets.length)
            for (let i=0;i<numberTickets;i++) {
                console.log(ticket)
            }
            
        })
    },
    data() {
        return {
            theEvent: _.cloneDeep(this.event),
            errors: [],
            isSubmitting: false,
            submitted: false,
            myForm: null,
            captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
            isValid: false,
            message: '',
            rules: {
                    required: (v) => !!v || 'Required.',
                    maxMessage: (v) => (v || '').length <= 255 || 'Text must be 255 characters or less',
                    maxName: (v) => (v || '').length <= 80 || 'Text must be 80 characters or less',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                },

            step: 1,
            orders: {
                bookee: {
                    first_name: '',
                    last_name: '',
                    email: '',
                },
                attendee:[],
                event:{
                    event_id: 0,
                    department_id: 0,
                }
            },
            numberTickets: [],
        }
    },
    computed: {
        currentTitle () {
            switch (this.step) {
            case 1: return 'Ticket(s)'
            case 2: return 'Order Details'
            default: return 'Summary and Reservation'
            }
        },
        buttonTitle () {
            switch (this.step) {
            case 1: return 'Register'
            case 2: return 'Confirm Booking'
            default: return 'Reserve'
            }
        },
    },
    methods: {
        /*FormSubmit() {
            this.isSubmitting = true
            this.$refs.recaptcha.execute()
        },*/
        checkout() {
            //console.log(this.$refs.form)
            //this.resetCaptcha()

            // append recaptcha token
            //this.contact.g_recaptcha_response = token
            //this.contact.department_id = this.theEvent.department.id
            // assign event and department id
            this.orders.event.event_id = this.theEvent.id 
            this.orders.event.department_id = this.theEvent.department_id
            console.log(this.orders)

            let filteredAttendees = this.orders.attendee.filter(function (el) {
                return el != null;
            });
            this.orders.attendee = filteredAttendees
            console.log(this.orders)
            
            axios.post('/api/ticket/checkout', this.orders,)
            .then(response => {
                if (response.data.success) {
                    this.errors = []
                    this.isSubmitting = false
                    this.message = response.data.message
                    this.submitted = true
                }
                
                this.$nextTick(() => {
                    // reset the form
                    this.$refs.form.reset();
                })

            })
            .catch(err => {
                this.isSubmitting = false
                this.errors = err.response.data.errors
            })
            
        },
        resetCaptcha() {
            this.$refs.recaptcha.reset()
        },
        tickets(){
            console.log(this.theEvent.tickets)
        },
        currentTimestamp(){
            return moment().toISOString()
        },
        ticketCount(){
            return this.theEvent.tickets.length
        },
        copyToHolder(){
            let orders = this.orders
            orders.attendee.forEach(function(value, i){
                orders.attendee[i].forEach(function(val,k){
                    orders.attendee[i][k].first_name = orders.bookee.first_name
                    orders.attendee[i][k].last_name = orders.bookee.last_name
                    orders.attendee[i][k].email = orders.bookee.email
                    
                })
            })
            this.orders.attendee = orders.attendee
            this.$forceUpdate(); 
            console.log(this.orders)
        },
        createEmptyAttendee(event, ticket_id){
            let attendeeCount = event.target.value
            this.orders.attendee[ticket_id] = []
            for(let i=0;i<attendeeCount;i++){
                let arr = []
                arr = {
                    first_name: '',
                    last_name: '',
                    email: '',
                    ticket_id: ticket_id,
                } 
                this.orders.attendee[ticket_id].push(arr)
            }
            console.log(this.orders.attendee[ticket_id])
        },
        // remove later
        theLength(ticketID){
            return this.orders.attendee[ticketID].length
        },
        ticketBackButtonClicked(){
            this.step--
            this.scrollToElement()
        },
        ticketForwardButtonClicked(){
            console.log(this.step)
            if (this.step < 3)
                this.step++
            else
                this.checkout()

            this.scrollToElement()
        },
        scrollToElement() {
            const el = this.$el.getElementsByClassName('ticket-form')[0];

            if (el) {
                el.scrollIntoView();
            }
        }
    },
    render() {}
}
</script>
<style scoped>
    .ticket-card{width:100%;}
</style>