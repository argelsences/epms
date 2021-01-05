<template>
    <v-app>
        <v-card flat>
            <v-card-title>
                <div class="text--subtitle-1 subscribe-subtitle mb-5">And get the latest news and events from us.</i></div>
            </v-card-title>
            <v-card-subtitle>
                <v-alert icon="mdi-shield-lock-outline" prominent text type="info">
                    By submitting this form, you expressly consent to our collection, use and storage of your personal data for the purposes of sending you program news, updates and events as per Personal Data Protection Act. If you wish to withdraw from the mailing list, please contact us at <strong><a :href="`mailto:${theEvent.department.email}`">{{theEvent.department.email}}</a></strong>
                </v-alert>
            </v-card-subtitle>
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
                                <v-text-field v-model="subscribe.email" label="Email" :rules="[rules.required,rules.emailValid]" prepend-icon="mdi-email" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
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
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-subheader class="red--text">* All fields are required&nbsp;</v-subheader>
                <v-btn color="blue darken-1" class="white--text" :disabled="!isValid || isSubmitting" @click="FormSubmit">SUBSCRIBE</v-btn>
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
                theMessage: this.message,
                errors: [],
                isSubmitting: false,
                submitted: false,
                myForm: null,
                captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
                isValid: false,
                subscribe: {
                    email: '',
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
                this.subscribe.g_recaptcha_response = token
                this.subscribe.department_id = this.theEvent.department.id

                axios.post('/api/subscribe', this.subscribe,)
                .then(response => {
                    if (response.data.success) {
                        this.errors = []
                    }
                    this.isSubmitting = false
                    this.submitted = true
                    this.message = response.data.message
                    
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
    .subscribe-subtitle {margin:0 auto;}
</style>