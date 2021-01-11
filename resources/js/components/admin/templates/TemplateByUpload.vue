<template>
    <v-app>
        <div class="text-h4 text-left">{{formTitle}} by uploading files</div>
        <div class="text-subtitle-1 text-left">In here you see the overview</div>
        <v-divider></v-divider>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-row v-if="editedItem.id">
                            <v-col cols="12" sm="12" md="6">
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-switch v-model="switchFile" label="Switch on to update template files"></v-switch>
                            </v-col>
                    </v-row>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="12" md="6">
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-typewriter" rows="5" hint="Input description of the template eg. How many speakers it can accommodate, the limit of description, etc" persistent-hint></v-textarea>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.html_code" class="mb-8" accept=".html" :rule="[rules.limitFileSize]" clearable placeholder="Click to upload an HTML file" 
                                            prepend-icon="mdi-language-html5" label="HTML File" persistentHint chips
                                            hint="Uploading a new file will replace the existing template code. Only accept HTML file. File size should not be greater than 2MB"
                                            :disabled="!switchFile"
                                            :required="switchFile"
                                            @click.stop="onButtonClick($event)"
                                        >
                                        </v-file-input>
                                        <v-chip class="ma-2 white--text" v-if="editedItem.file_path.html_code" color="blue darken-1" >
                                            <v-icon left>mdi-file</v-icon> {{editedItem.file_path.html_code}}
                                        </v-chip>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.css_code" class="mb-8" accept=".css" :rule="[rules.limitFileSize]" clearable placeholder="Click to upload a CSS file" 
                                            prepend-icon="mdi-language-css3" label="CSS File" persistentHint chips
                                            hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                            :disabled="!switchFile"
                                            :required="switchFile"
                                            @click.stop="onButtonClick($event)"
                                            >
                                        </v-file-input>
                                        <v-chip class="ma-2 white--text" v-if="editedItem.file_path.css_code" color="blue darken-1">
                                            <v-icon left>mdi-file</v-icon> {{editedItem.file_path.css_code}}
                                        </v-chip>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-file-input v-model="editedItem.images" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Click to upload an image" 
                                            prepend-icon="mdi-camera-iris" label="Images" persistentHint chips
                                            hint="Uploading a new file will replace the existing images. Only accepting JPG/PNG/BMP files. File size should not be greater than 2MB"
                                            multiple
                                            :disabled="!switchFile"
                                            :required="switchFile" 
                                            @click.stop="onButtonClick($event)"
                                            >
                                        </v-file-input>
                                        <v-chip class="ma-2 white--text" v-for="image in editedItem.file_path.images" :key="image" v-if="editedItem.file_path.images" color="blue darken-1">
                                            <v-icon left>mdi-file</v-icon> {{image}}
                                        </v-chip>
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
                    :disabled="!isValid"
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
                departments: [],
                switchFile: false,
                rules: {
                    required: (v) => !!v || 'Required.',
                    limitFileSize: (v) => !v || v.size < 1000000 || 'Logo size should be less than 2 MB!',
                    limitFileSizeMultiple: files => !files || !files.some(file => file.size > 2e6) || 'Avatar size should be less than 2 MB!',
                    fileRequired: (v) => [
                        v => !!v || 'File is required',
                        v => (v && v.length > 0) || 'File is required',
                    ],
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
                    images: [],
                    department_id: '',
                    department_name: '',
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
                    images: [],
                    department_id: '',
                    department_name: '',
                },
                templateMethod: '',
            }
        },
        computed: {
            formTitle () {
                return this.editedItem.id ? 'Edit Template' : 'New Template'
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
            /*initialize: function() {
                axios.get('/api/templates')
                .then( response => {
                    this.rows = response.data;
                });
            },*/
            getDepartments: function() {
                axios.get('/api/departments')
                .then( response => {
                    this.departments = response.data;
                });
            },
            editItem (item) {
                this.editedIndex = this.rows.indexOf(item)
                this.editedItem = Object.assign({}, item)
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

                // method
                var method = 'upload'

                // form data
                let formData = new FormData()
                formData.append('id', this.editedItem.id)
                formData.append('name', this.editedItem.name)
                formData.append('description', this.editedItem.description)
                formData.append('department_id', this.editedItem.department_id)
                formData.append('method', method)                

                if (typeof this.editedItem.html_code !== 'undefined'){
                    formData.append('html_code', this.editedItem.html_code)
                }

                if (typeof this.editedItem.css_code !== 'undefined'){
                    formData.append('css_code', this.editedItem.css_code)
                }

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
                        ///////this.snackbar = true
                        this.loader = true
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
            setEditItems(item){
                this.editedItem = item
            },
            onButtonClick(e){
                e.stopPropagation()
            }
        },
        updated: function(){
            console.log(this.templateMethod)
        }, 
        created: function() {
            this.setHedeaderTitle()
            this.getDepartments()
            //this.initialize()
            //this.editedItem = this.$route.params
            console.log(this.$route.params)
            if (this.$route.params.id)
                this.setEditItems(this.$route.params)
            else
                this.switchFile = true
        },
    }
</script>