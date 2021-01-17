<template>
    <v-app>
        
        <v-card flat >
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12" md="12">
                            <v-alert v-if="submitted" dense outlined type="info">{{message}}</v-alert>
                        </v-col>
                    </v-row>
                    <v-form v-model="isValid" ref="form">
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
                    <div class="text-subtitle-2 text-center ma-5">We love to see you stay</div>
                    <div class="d-flex justify-center">
                        <v-btn color="blue darken-1" class="white--text" :disabled="submitted || isSubmitting" @click="FormSubmit">
                            UNSUBSCRIBE?
                        </v-btn> 
                    </div>
                </v-container>
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha'
    //import * as _ from 'lodash';
    import _ from 'lodash'

    export default {
        components: {VueRecaptcha},
        props: ['subscriber'],
        data() {
            return {
                theSubscriber: _.cloneDeep(this.subscriber),
                theMessage: this.message,
                errors: [],
                submitted: false,
                isSubmitting: false,
                myForm: null,
                captcha_site_key: process.env.MIX_INVISIBLE_RECAPTCHA_SITEKEY,
                isValid: false,
                subscribe: {
                    s_token: '',
                    g_recaptcha_response: '',
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
                this.subscribe.s_token = this.theSubscriber.token

                axios.post('/api/unsubscribed', this.subscribe,)
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
                        
                        var timer = setTimeout(function() {
                            window.location='/'
                        }, 3000);
                        
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
</style>