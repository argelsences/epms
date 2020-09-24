<template>
    <v-app>
        <div class="text-h4 text-left">Create template by uploading files</div>
        <div class="text-subtitle-1 text-left">In here you see the overview</div>
        <v-divider></v-divider>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="12" md="6">
                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.html_code" class="" accept=".html" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                            prepend-icon="mdi-camera-iris" label="HTML File" persistentHint chips
                                            hint="Uploading a new file will replace the existing template code. Only accept HTML file. File size should not be greater than 2MB"
                                            @change="uploadLogo">
                                        </v-file-input>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="6">
                                <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-map" rows="10"></v-textarea>
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.css_code" class="mb-8" accept=".css" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                            prepend-icon="mdi-camera-iris" label="CSS File" persistentHint chips
                                            hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                            @change="uploadLogo">
                                        </v-file-input>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.images" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                            prepend-icon="mdi-camera-iris" label="Images" persistentHint chips
                                            hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                            @change="uploadLogo">
                                        </v-file-input> 
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    :disabled="templateMethod === 'templateChoice'"
                    text
                    @click="templateMethod='templateChoice'"
                >
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn
                    :disabled="templateMethod === 'templateChoice'"
                    color="blue darken-1"
                    text
                    @click="templateMethod"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted')
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
                timeout: 5000,
                error: false,
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
                    name: '',
                    description: '',
                    file_path: '',
                    template_code: '',
                    department_id: '',
                    html_code: null,
                    css_code: null,
                    images: null,
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    description: '',
                    file_path: '',
                    template_code: '',
                    department_id: '',
                    html_code: null,
                    css_code: null,
                    images: null,
                },
                templateMethod: '',
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Template' : 'Edit Template'
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
                axios.get('/api/templates')
                .then( response => {
                    this.rows = response.data;
                });
            },
            getCountries() {
                axios.get('/api/countries')
                .then( response => {
                    this.countries = response.data;
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

                axios.post('/api/venues/upsert', {
                    payload: this.editedItem,
                })
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for ' + editedItem.name + ' is saved.'
                        this.snackbar = true
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
                document.title = 'Templates - Event Publication and Poster Management System (EPPMS)';
            },
            uploadLogo(){
                if ( this.logo ){
                    let formData = new FormData()
                    formData.append('logo', this.logo)
                    
                    if ( this.editedItem.id )
                        formData.append('id', this.editedItem.id)

                    axios.post('/api/departments/uploadLogo', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            // set the path on the global editedItem
                            this.editedItem.logo_path = response.data.file_path 
                        }
                    })
                    .catch( error => {
                        let messages = Object.values(error.response.data.errors); 
                        this.feedbacks = [].concat.apply([], messages)
                        this.snackbar = true
                        this.error = true
                        this.logo = null
                    })
                }
            },
        },
        updated: function(){
            console.log(this.templateMethod)
        }, 
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
        },
    }
</script>