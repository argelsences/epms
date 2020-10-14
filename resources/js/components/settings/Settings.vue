<template>
    <v-app>
        <div class="text-h4 text-left">Settings</div>
        <div class="text-subtitle-1 text-left">Configuration parameters that affects the system</div>
        <v-divider></v-divider>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <div class="text-h4  text-left">Poster</div>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.number_of_days_archive" label="Number of days for archiving" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-select :items="format" label="Default image output" v-model="editedItem.default_image_output"  prepend-icon="mdi-earth" hint="Type to select"></v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <div class="text-h4  text-left">Frontend</div>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-text-field v-model="editedItem.header_bg_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page header bg color" outlined readonly :placeholder="color" >
                                    <template v-slot:append>
                                        <v-menu v-model="menu_header_bg" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                            <template v-slot:activator="{ on }">
                                                <div :style="swatchStyleHeaderBGColor" v-on="on" />
                                            </template>
                                            <v-card>
                                                <v-card-text class="pa-0">
                                                    <v-color-picker v-model="editedItem.header_bg_color" mode="hexa" hide-mode-switch flat />
                                                </v-card-text>
                                            </v-card>
                                        </v-menu>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-text-field v-model="editedItem.bg_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page bg color" outlined readonly :placeholder="color">
                                    <template v-slot:append>
                                        <v-menu v-model="menu_bg" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                            <template v-slot:activator="{ on }">
                                                <div :style="swatchStyleBGColor" v-on="on" />
                                            </template>
                                            <v-card>
                                                <v-card-text class="pa-0">
                                                    <v-color-picker v-model="editedItem.bg_color" mode="hexa" hide-mode-switch flat />
                                                </v-card-text>
                                            </v-card>
                                        </v-menu>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-text-field v-model="editedItem.text_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page text color" outlined readonly :placeholder="color">
                                    <template v-slot:append>
                                        <v-menu v-model="menu_text_color" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                            <template v-slot:activator="{ on }">
                                                <div :style="swatchStyleTextColor" v-on="on" />
                                            </template>
                                            <v-card>
                                                <v-card-text class="pa-0">
                                                    <v-color-picker v-model="editedItem.text_color" mode="hexa" hide-mode-switch flat />
                                                </v-card-text>
                                            </v-card>
                                        </v-menu>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <div class="text-h4  text-left">Social Media</div>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-switch label="Linkedin" prepend-icon="mdi-facebook" v-model="this.editedItem.is_facebook"></v-switch>
                                <v-switch label="Linkedin" prepend-icon="mdi-linkedin" v-model="this.editedItem.is_linkedin"></v-switch>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-switch label="Twitter" prepend-icon="mdi-twitter" v-model="this.editedItem.is_twitter"></v-switch>
                                <v-switch label="Whatsapp" prepend-icon="mdi-whatsapp" v-model="this.editedItem.is_whatsapp"></v-switch>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-switch label="Email" prepend-icon="mdi-email" v-model="this.editedItem.is_email"></v-switch>
                            </v-col>
                            
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <div class="text-h4  text-left">System</div>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-autocomplete v-model="editedItem.timezone" :items="timezones" label="Timezone" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                            </v-col>
                        </v-row>

                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :disabled="templateMethod === 'templateChoice'"
                    text
                    :to="{name: `template-choice`}"
                >
                    Back to choices
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn 
                    color="blue darken-1" 
                    text 
                    :to="{name: `templates`}"
                >
                    Go back to Template List
                </v-btn>
                <v-btn
                    :disabled="templateMethod === 'templateChoice'"
                    color="blue darken-1"
                    text
                    v-on:click="save()"
                >
                    Save
                </v-btn>
            </v-card-actions>

            <v-snackbar v-model="snackbar" :timeout="timeout">
                <v-progress-linear indeterminate color="green" :active="loader" ></v-progress-linear>
                <v-list-item v-for="(feedback, index) in feedbacks" :key="index">
                    <v-list-item-icon v-if="error">
                        <v-icon color="red darken-2">mdi-exclamation-thick</v-icon>
                    </v-list-item-icon>
                    <v-list-item-icon v-else>
                        <v-icon color="green darken-2">mdi-check-bold</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="feedback"></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <template v-slot:action="{ attrs }">
                    <v-btn color="teal" text v-bind="attrs" @click="snackbar = false">
                        Close
                    </v-btn>
                </template>
            </v-snackbar>

        </v-card>
    </v-app>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted')
            console.log(this.rows)
        },
        data() {
            return {
                dialog: false,
                isValid: true,
                search : '',
                feedbacks: [],
                rows: [],
                editedIndex: -1,
                snackbar: false,
                loader: false,
                timeout: 5000,
                error: false,
                format: ['JPG','PNG','BMP'],
                mask: '?#XXXXXX',
                color: '#1976D2',
                timezones: ['Asia/Singapore', 'Asia/Taiwan'],
                menu_header_bg: false,
                menu_bg: false,
                menu_text_color: false,
                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                },
                headers: [
                    {text: 'Screenshot', value: 'screenshot'},
                    {text: 'Name', value: 'name'},
                    {text: 'Department', value: 'department_id'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    number_of_days_archive: '',
                    default_image_output: '',
                    header_bg_color: '',
                    bg_color: '',
                    text_color: '',
                    is_facebook: 'false',
                    is_twitter: 'false',
                    is_linkedin: 'false',
                    is_email: 'false',
                    is_whatsapp: 'false',
                    timezone: '',
                },
                defaultItem: {
                    id: 0,
                    number_of_days_archive: '',
                    default_image_output: '',
                    header_bg_color: '',
                    bg_color: '',
                    text_color: '',
                    is_facebook: 'false',
                    is_twitter: 'false',
                    is_linkedin: 'false',
                    is_email: 'false',
                    is_whatsapp: 'false',
                    timezone: '',
                },
                templateMethod: '',
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Template' : 'Edit Template'
            },
            swatchStyleHeaderBGColor() {
                const { menu } = this
                
                //if (this.editedItem.header_bg_color == '' || this.editedItem.header_bg_color == null )
                //    this.editedItem.page_header_bg_color = '#1976D2'
                    
                return {
                    backgroundColor: this.editedItem.header_bg_color,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
            swatchStyleBGColor() {
                const { menu } = this
                console.log(this.editedItem.bg_color)
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                //if (this.editedItem.bg_color == '' || this.editedItem.bg_color == null )
                //    this.editedItem.page_bg_color = '#1976D2'
                    
                return {
                    backgroundColor: this.editedItem.bg_color,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
            swatchStyleTextColor() {
                const { menu } = this
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                //if (this.editedItem.text_color == '' || this.editedItem.text_color == null )
                //    this.editedItem.page_text_color = '#1976D2'
                    
                return {
                    backgroundColor: this.editedItem.text_color,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
        },
        watch: {
            dialog (val) {
                // if val is true, then statement is true, if not the default value is this.close
                // eg. the_title = title || "Error"; if title is true, the the value of the_title is the value of title, else the value of the_title is "Error"
                val || this.close()
            },
        },
        methods: {
            initialize: function() {
                axios.get('/api/settings')
                .then( response => {
                    this.editedItem = response.data
                });
            },
            getTimezones: function() {
                axios.get('/api/timezones')
                .then( response => {
                    ///////this.rows = response.data;
                    console.log(response.data)
                    this.timezones = response.data
                });
            },
            editItem (item) {
                this.editedIndex = this.rows.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.rows.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.rows.splice(index, 1)
            },

            close () {
                // make sure the dialog box is closed
                this.dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the defaultItem object
                    this.editedItem = Object.assign({}, this.defaultItem)
                    // reset the edit flag
                    this.editedIndex = -1
                    // reset the form
                    this.$refs.form.reset()
                    // reset window
                    this.templateMethod = ''
                })

                 setTimeout(() => { this.$router.push({name: 'templates'}) },1500);
            },
            save () {
                /** on change of input, upload the logo, then assign the path to logo path */
                this.$refs.form.validate()
                // check if process is updating or creating
                // if update, then replace the value of the current item with the value in the editedItem
                // if creating, then push the edited item into the object
                
                // assign the edited item to a local var first to be able to be used for filter
                var editedItem = this.editedItem
                var editedIndex = this.editedIndex

                // form data
                let formData = new FormData()
                formData.append('id', this.editedItem.id)
                formData.append('html_code', this.editedItem.html_code)
                formData.append('css_code', this.editedItem.css_code)
                formData.append('name', this.editedItem.name)
                formData.append('description', this.editedItem.description)
                formData.append('department_id', this.editedItem.department_id)
                formData.append('method', 'code')
                
                // add multiple images
                /*
                for (let i = 0 ; i < Object.keys(this.editedItem.images).length; i++){
                    formData.append("images[]", this.editedItem.images[i])
                }
                */
                
                // add multiple images
                if (typeof this.editedItem.images !== 'undefined'){
                    for (let i = 0 ; i < Object.keys(this.editedItem.images).length; i++){
                        formData.append("images[]", this.editedItem.images[i])
                    }
                }
                else { 
                    formData.append("images[]", null)
                }
                
                let formHeader = { headers: { 'Content-Type': 'multipart/form-data' } }

                this.loader = true
                this.snackbar = true
                this.feedbacks[0] = 'Generating template, please wait.'

                axios.post('/api/templates/upsert', formData, formHeader)
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for ' + editedItem.name + ' is saved.'
                        /////this.snackbar = true
                        this.error = false
                        /*
                        if ( editedIndex > -1 )
                            Object.assign(this.rows[editedIndex], editedItem)
                        else
                            this.rows.push(editedItem)
                        */
                        if ( editedIndex > -1 )
                            Object.assign(this.rows[editedIndex], response.data.item)
                        else
                            this.rows.push(response.data.item)

                        // close the dialog box
                        this.close()  
                    }
                })
                .catch( error => {
                    let messages = Object.values(error.response.data.errors); 
                    this.feedbacks = [].concat.apply([], messages)
                    this.snackbar = true
                    this.error = true
                })
              
            },
            setHedeaderTitle(){
                document.title = 'Settings - Event Publication and Poster Management System (EPPMS)';
            },
            setEditItems(item){
                this.editedItem = item
                this.editedItem.html_code = this.htmlEntityDecode(item.file_path.html_code)
                this.editedItem.css_code = item.file_path.css_code
                /*
                this.editedItem.name = item.name
                this.editedItem.description = item.description
                this.editedItem.department_id = item.department_id
                this.editedItem.images = item.file_path.images
                */
            },
            htmlEntityDecode(str) {
                var element = document.createElement('div');

                if(str && typeof str === 'string') {
                    // strip script/html tags
                    str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
                    str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
                    element.innerHTML = str;
                    str = element.textContent;
                    element.textContent = '';
                }

                return str;
            },
        },
        updated: function(){
            console.log(this.templateMethod)
        }, 
        created: function() {
            this.initialize()
            this.getTimezones()
        },
    }
</script>