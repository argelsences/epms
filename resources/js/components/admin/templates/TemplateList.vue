<template>
    <v-app>
        <div class="text-h4 text-left">Templates</div>
        <div class="text-subtitle-1 text-left">You can manage the templates here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name" :loading="isLoading" :loading-text="loadingText">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-btn color="#1f4068" v-on:click="redirectToChoice" class="white--text" ><i class="material-icons ">add_box</i> Template</v-btn>
                        <v-dialog v-model="dialog" hide-overlay  scrollable fullscreen>
                            <v-card tile>
                                <v-card-text>
                                    <v-container fill-height>
                                        <v-row justify="center" align="center">
                                            <v-col cols="12" sm="4">
                                                <v-img :src="theImageSrc" @error="imageUrl='alt-image.jpg'" height="auto" ></v-img>
                                            </v-col>
                                        </v-row>
                                    </v-container> 
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn absolute dark fab top right right color="pink" class="mt-10" @click="close">
                                        <v-icon x-large>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <template v-slot:item.screenshot="{ item }">
                   <v-img :src="`/web-admin/templates/screenshot/${item.id}?rnd=${cacheKey}`" @error="imageUrl='alt-image.jpg'" max-height="133px" max-width="100px" @click.stop="imageDialogUrl(item)" ></v-img>
                </template>
                <template v-slot:item.department="{ item }">
                   <span>{{ getDepartment(item.department_id) }}</span>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                    <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn class="btn btn-sm btn-primary" @click="initialize">Reset</v-btn>
                </template>
            </v-data-table>
            <v-snackbar v-model="snackbar" :timeout="timeout">
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
                timeout: 5000,
                error: false,
                theImageSrc: '',
                cacheKey: +new Date(),
                departments: [],
                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                },
                headers: [
                    {text: 'Screenshot', value: 'screenshot'},
                    {text: 'Name', value: 'name'},
                    {text: 'Department', value: 'department'},
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
                isLoading: true,
                loadingText: "Loading items, please wait."
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
                    this.isLoading = false
                });
            },
            getDepartments: function() {
                axios.get('/api/departments')
                .then( response => {
                    this.departments = response.data;
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
                console.log(this.editedItem.method)
                if ( this.editedItem.method == 'upload' )
                    this.$router.push({name: 'add-by-upload', params: this.editedItem})
                else if( this.editedItem.method == 'code' )
                    this.$router.push({name: 'add-by-code', params: this.editedItem})
                else if( this.editedItem.method == 'canvas' )
                    this.$router.push({name: 'add-by-canvas', params: this.editedItem})
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
                    /////this.$refs.form.reset()
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
            redirectToChoice() {
                //this.$router.push('/template/create-choice')
                this.$router.push({name: 'template-choice'})
            },
            imageDialogUrl(item){
                this.dialog = true
                this.theImageSrc = "/web-admin/templates/screenshot/" + item.id
            },
            getDepartment(id) {
                return this.departments.find(department => department.id == id).name
            }
        },
        updated: function(){
            console.log(this.templateMethod)
        }, 
        created: function() {
            /////this.setCanvasEditor()
            this.setHedeaderTitle()
            this.initialize()
            this.getDepartments()
            /////window.addEventListener("resize", this.canvasResize);
        },
    }
</script>