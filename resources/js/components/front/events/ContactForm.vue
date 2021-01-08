<template>
    <v-app>
        <v-card flat>
            <v-card-title >
                <!--<h3>Contact <i>{{theEvent.department.name}}</i></h3>-->
                <h3 class="contact-header">Contact Us</h3>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12" md="12">
                            <v-alert v-if="submitted" dense outlined type="info">{{message}}</v-alert>
                        </v-col>
                    </v-row>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="contact.name" label="Name" :rules="[rules.required,rules.maxName]" prepend-icon="mdi-account" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="contact.email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-email" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-textarea counter label="Message" :rules="[rules.required,rules.maxMessage]" required v-model="contact.message" prepend-icon="mdi-message"></v-textarea>
                            </v-col>
                            <vue-recaptcha
                                ref="recaptcha"
                                @verify="onCaptchaVerified"
                                @expired="resetCaptcha"
                                size="invisible"
                                :sitekey="captcha_site_key"
                                
                                >
                            </vue-recaptcha>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-subheader class="red--text">* All fields are required&nbsp;</v-subheader>
                <v-btn color="blue darken-1" class="white--text" :disabled="!isValid || isSubmitting" @click="FormSubmit">SEND MESSAGE</v-btn>
            </v-card-actions>
        </v-card>
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
                submitted: false,
                myForm: null,
                captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
                isValid: false,
                contact: {
                    name: '',
                    email: '',
                    message: '',
                    g_recaptcha_response: '',
                    department_id: 0,
                },
                message: '',
                rules: {
                        required: (v) => !!v || 'Required.',
                        maxMessage: (v) => (v || '').length <= 255 || 'Text must be 255 characters or less',
                        maxName: (v) => (v || '').length <= 80 || 'Text must be 80 characters or less',
                        emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    },
            }
        },
        methods: {
            FormSubmit() {
                this.isSubmitting = true
                this.$refs.recaptcha.execute()
            },
            onCaptchaVerified(token) {
                this.resetCaptcha()

                // append recaptcha token
                this.contact.g_recaptcha_response = token
                this.contact.department_id = this.theEvent.department.id

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
            }
        },
        render() {}
    }
</script>

<style scoped>
    .grecaptcha-badge {
        visibility: hidden !important;
    }
    h3.contact-header{margin: 0 auto;}
</style>