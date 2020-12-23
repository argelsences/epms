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

        <v-card  flat>
            
            <v-card-title class="title font-weight-regular justify-space-between">
                <!--<span>{{ currentTitle }}</span>
                <v-avatar
                    color="primary lighten-2"
                    class="subheading white--text"
                    size="24"
                    v-text="step"
                ></v-avatar>-->
                <h1 class='section_head text-center'>
                    {{ currentTitle }}
                </h1>
            </v-card-title>
    

            <v-window v-model="step">
                <v-window-item :value="1">
                    <v-card-text>
                        <!--<v-text-field
                            label="Email"
                            value="john@vuetifyjs.com"
                        ></v-text-field>
                        <span class="caption grey--text text--darken-1">
                            This is the email you will use to login to your Vuetify account
                        </span>-->


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
                                            <select :name="`ticket_${ticket.id}`" class="form-control float-right" style="text-align: center" @change="onTicketChange($event, ticket.id)" v-model="numberTickets[ticket.id]">
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

                <v-window-item :value="2">
                    <v-card-text>
                        <!--<v-text-field
                            label="Password"
                            type="password"
                        ></v-text-field>
                        <v-text-field
                            label="Confirm Password"
                            type="password"
                        ></v-text-field>
                        <span class="caption grey--text text--darken-1">
                            Please enter a password for your account
                        </span>-->


                        <v-row>
                            <v-col cols="12" sm="8" md="8">
                                <h3>Your Information</h3>
                                <v-text-field v-model="orders.bookee.first_name" label="First Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                <v-text-field v-model="orders.bookee.last_name" label="Last Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                <v-text-field v-model="orders.bookee.email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-mail" ></v-text-field>
                                <v-btn x-small depressed color="primary">Copy these details to all ticket holders</v-btn>
                            </v-col>
                            <v-col cols="12" sm="4" md="4">
                                <v-card elevation="5">
                                    <v-card-title>
                                        <v-icon>
                                            mdi-cart
                                        </v-icon>
                                        Order Summary
                                    </v-card-title>
                                    <v-card-text>
                                        The order here
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
                                <v-row v-for="n in numberTickets[ticket.id]" :key=n>
                                    <v-card raised class="mb-5 ticket-card" tile>
                                        <v-card-title class="white--text primary">
                                            {{ticket.title}} Ticket Holder {{n}} Details
                                        </v-card-title>
                                        <v-card-text>
                                            <v-text-field v-model="orders.first_name" label="First Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                            <v-text-field v-model="orders.last_name" label="Last Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                                            <v-text-field v-model="orders.email" label="Email" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-mail" ></v-text-field> 
                                        </v-card-text>
                                    </v-card>
                                </v-row>
                            </v-col>
                        </v-row>

                        
                        
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="3">
                    <div class="pa-4 text-center">
                    <v-img
                        class="mb-4"
                        contain
                        height="128"
                        src="https://cdn.vuetifyjs.com/images/logos/v.svg"
                    ></v-img>
                    <h3 class="title font-weight-light mb-2">
                        Welcome to Vuetify
                    </h3>
                    <span class="caption grey--text">Thanks for signing up!</span>
                    </div>
                </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
            <v-btn
                :disabled="step === 1"
                text
                @click="step--"
            >
                Back
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                :disabled="step === 3"
                color="primary"
                depressed
                @click="step++"
            >
                Next
            </v-btn>
            </v-card-actions>
        </v-card>
        
    </v-app>
</template>

<script>
import moment from 'moment'
export default {
    props: ['event'],
    data() {
        return {
            theEvent: _.cloneDeep(this.event),
            errors: [],
            isSubmitting: false,
            submitted: false,
            myForm: null,
            captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
            isValid: false,
            /*
            order: {
                first_name: '',
                last_name: '',
                email: '',
                message: '',
                department_id: 0,
            },
            */
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
                tickets:[],
            },
            numberTickets: [],
        }
    },
    computed: {
        currentTitle () {
            switch (this.step) {
            case 1: return 'Ticket(s)'
            case 2: return 'Order Details'
            default: return 'Payment Information'
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

            axios.post('/api/contact-us', this.contact,)
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
        onTicketChange(event, ticket_id){
            console.log(event.target.value)
            /*this.numberTickets.push({
                ticket_id: ticket_id,
                number: event.target.value
            })*/
            console.log(this.numberTickets)
        },
        onOrderDetails() {
            /*
                this.order.push({
                    id: 0,
                    first_name: '',
                    last_name: '',
                    email: '',
                    ticket_id: '',
                });
            */
        },

        


    },
    render() {}
}
</script>
<style scoped>
    .ticket-card{width:100%;}
</style>