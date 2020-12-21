<template>
    <!--<form action="{{ route('events.contact_us') }}" @submit.prevent="FormSubmit($event)">-->
    <v-app>
        <v-card elevation="2">
            <v-card-title>
                <h3>Contact <i>{{theEvent.department.name}}</i></h3>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="10" md="10">
                            <v-alert dense outlined type="info">All fields are required</v-alert>
                        </v-col>
                    </v-row>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="10" md="10">
                                <v-text-field v-model="contact.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-account" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="10" md="10">
                                <v-text-field v-model="contact.email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-email" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="10" md="10">
                                <v-textarea counter label="Message" required v-model="contact.message" prepend-icon="mdi-message"></v-textarea>
                            </v-col>
                            <vue-recaptcha
                                ref="recaptcha"
                                @verify="onCaptchaVerified"
                                @expired="resetCaptcha"
                                size="invisible"
                                :sitekey="captcha_site_key"
                                :loadRecaptchaScript="true"
                                >
                            </vue-recaptcha>
                        </v-row>

                        <!--<button type="submit" class="button" :disabled="isSubmitting">Sign Up</button>-->
                        
                    <!--</form>-->
                    </v-form>
                </v-container>
            </v-card-text>
        </v-card>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-subheader class="red--text">* All fields are required&nbsp;</v-subheader>
            <v-btn color="blue darken-1" class="white--text" :disabled="!isValid || isSubmitting" @click="FormSubmit">SEND MESSAGE</v-btn>
        </v-card-actions>
    </v-app>
</template>

<script>
import VueRecaptcha from 'vue-recaptcha'
import * as _ from 'lodash';

export default {
    components: {VueRecaptcha},
    props: ['event'],
    data() {
        return {
            theEvent: _.cloneDeep(this.event),
            errors: [],
            isSubmitting: false,
            myForm: null,
            captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
            isValid: false,
            contact: {
                name: '',
                email: '',
                message: '',
                g_recaptcha_response: '',
            },
            rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    phoneValid: (v) => !v || /^(?=.*[0-9])[- +()x0-9]+$/.test(v) || 'Tel. # must be valid',
                    urlValid: (v) => !v || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(v) || 'URL must be valid',
                    limitFileSize: (v) => !v || v.size < 2000000 || 'Logo size should be less than 2 MB!',
                    limitFileSizeMultiple: files => !files || !files.some(file => file.size > 2e6) || 'Avatar size should be less than 2 MB!'
                },
        }
    },
    methods: {
        FormSubmit() {
            //this.myForm = event
            /////console.log(this.contact)
            this.isSubmitting = true
            this.$refs.recaptcha.execute()
        },
        onCaptchaVerified(token) {
            console.log(this.$refs.form)
            this.resetCaptcha()

            // append recaptcha token
            this.contact.g_recaptcha_response = token

            axios.post('/api/contact-us', this.contact,)
            .then(response => {
                this.errors = []
                this.isSubmitting = false

                // all good
                /////window.location.replace('/')

            })
            .catch(err => {
                this.isSubmitting = false
                this.errors = err.response.data.errors
            })
        },
        resetCaptcha() {
            this.$refs.recaptcha.reset()
        }
    },
    render() {}
}
</script>

<style scoped>
    .grecaptcha-badge {
        visibility: hidden !important;
    }
</style>