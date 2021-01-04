<template>
    <v-app>
        <div class="text-h4 text-left">Posters</div>
        <div class="text-subtitle-1 text-left">You can manage the event posters here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog"  width="80%" scrollable fullscreen>
                            <template v-slot:activator="{ on, attrs }">
                                <!--<v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Speaker</v-btn>-->
                            </template>
                            

                            <!-- poster modification here -->
                            <v-card flat>
                                <v-card-title>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <div class="text-h5  text-left mb-10">How do you want to {{ formTitle }} your poster?</div>
                                            <v-divider />
                                        </v-col>
                                         <v-spacer />
                                        <v-btn absolute dark fab middle right color="pink" @click="close">
                                            <v-icon x-large>mdi-close</v-icon>
                                        </v-btn>
                                    </v-row>
                                </v-card-title>
                                <v-card-text class="pt-0">
                                    <v-row>
                                        <v-col cols="12" sm="8" md="8">
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-alert icon="mdi-alert-circle-outline" prominent text type="warning">
                                                        Uploading or generating a new file will replace the existing poster.
                                                    </v-alert>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm=12 md="12">
                                                    <div class="text-h6  text-left mb-2">Upload a poster file</div>
                                                    <v-form v-model="isValid5" ref="posterForm">
                                                        <div>
                                                            <v-btn color="primary" class="text-none" rounded  depressed :loading="isSelecting" @click="onButtonClick">
                                                                <v-icon left>cloud_upload</v-icon>
                                                                {{ uploadButtonText }}
                                                            </v-btn>
                                                            <input ref="uploader" class="d-none" type="file" accept="image/png, image/jpeg, image/bmp, image/jpg" @change="onFileChanged">
                                                            <div class="text-caption pl-2">Only accepts JPG/PNG/BMP files. File size should not be greater than 2MB</div>
                                                        </div>
                                                        
                                                        <v-row>
                                                            <v-col>
                                                                <!--<v-chip class="ma-2 white--text poster-file-name" v-if="editedItem.file_path && !editedItem.template_id" color="blue darken-1" @click="deletePoster">
                                                                    <v-icon left>mdi-trash-can</v-icon> 
                                                                    <span>{{posterFilePath()}}</span>
                                                                </v-chip>-->
                                                            </v-col>
                                                            <v-spacer></v-spacer>
                                                            <v-col>
                                                                <v-btn text depressed :loading="isSelecting" class="float-right" :disabled="uploadReady" @click="uploadPoster">Upload Poster</v-btn>
                                                            </v-col>
                                                        </v-row>
                                                        <!--
                                                        <v-spacer></v-spacer>
                                                        <div>
                                                            <v-btn text depressed :loading="isSelecting" class="float-right" :disabled="uploadReady" @click="uploadPoster">Upload Poster</v-btn>
                                                        </div>
                                                        -->
                                                    </v-form>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h6  text-left mb-10 mt-10">
                                                        Or, select from the list of templates to generate a poster
                                                    </div>
                                                    <!-- template lists -->
                                                    <v-row>
                                                        <v-col cols="12" sm="4" md="4" v-for="(template, i) in templateRows" :key="template.id" class="text-center">
                                                            <v-lazy v-model="isActive" :options="{threshold: .8}" min-height="200" transition-group="fade-transition">
                                                                <v-card class="mx-auto" max-width="180" @click="selectTemplate(template.id)">
                                                                    <v-img class="white--text align-end"  :src="`/web-admin/templates/screenshot/${template.id}?rnd=${cacheKey}`">
                                                                        <v-card-title  class="text-left secondary opacity-half" elevation=24>{{template.name}}</v-card-title>
                                                                    </v-img>
                                                                    <v-card-text class="text--primary" >
                                                                        <div class="text-caption">{{template.description}}</div>
                                                                    </v-card-text>
                                                                    <v-card-actions>
                                                                        <div class="d-flex justify-end">
                                                                            <v-icon color="success" v-if="selectedTemplate === template.id">mdi-check-circle</v-icon>
                                                                        </div>
                                                                    </v-card-actions>
                                                                    </v-card>
                                                            </v-lazy>
                                                            <v-btn color="primary" class="ma-2 white--text text-center" @click.stop="imageDialogUrl(template.id)">
                                                                Preview
                                                                <v-icon left dark class="ml-2">
                                                                    mdi-magnify
                                                                </v-icon>
                                                            </v-btn>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="12">
                                                            <span v-if="generatingPoster" class="red--text">Generating posters, please do not refresh the page</span>
                                                            <v-btn text depressed :loading="generatingPoster"  class="float-right" :disabled="!selectedTemplate" @click="generatePoster">Generate Poster</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                    <v-dialog v-model="templatePreview" hide-overlay  scrollable fullscreen>
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
                                                                <v-btn absolute dark fab top right color="pink" class="mt-10" @click="templatePreview=false">
                                                                    <v-icon x-large>mdi-close</v-icon>
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                    <!-- template lists -->
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="12" sm="4" md="4" >
                                            <v-card outlined min-height="500px">
                                                <v-card-title>
                                                    Poster Preview
                                                </v-card-title>
                                                <v-card-text class="align-self-center">
                                                    <v-img v-if="editedItem.file_path" :src="`${base_url}${editedItem.file_path}?rnd=${cacheKey}`" alt="" aspect-ratio=".7" ></v-img>
                                                    <v-icon size=200 v-else class="d-flex justify-center no-poster-icon">mdi-image</v-icon>
                                                </v-card-text>
                                                <v-card-actions v-if="editedItem.file_path">
                                                    <v-spacer></v-spacer>
                                                    <v-select dense :items="posterFormats" v-model="selectedFormat" label="Output Format"></v-select>
                                                    <v-btn color="primary" class="text-none" text depressed  download :href="downloadPoster()">
                                                        <v-icon left>mdi-download</v-icon>
                                                        DOWNLOAD
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <!-- poster modification ends here -->
                        </v-dialog>
                        <!-- the dialog box -->
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <template v-slot:item.photo="{ item }">
                    <v-img v-if="item.file_path" :src="base_url + item.file_path" alt="" aspect-ratio=".7" max-height="100px" max-width="100px"></v-img>
                    <v-icon size="100px" v-else>mdi-account-box</v-icon>
                </template>
                <template v-slot:item.name="{ item }">
                    {{item.event.title}}
                </template>
                <template v-slot:item.author="{ item }">
                    {{item.user.name}}
                </template>
                <template v-slot:item.department="{ item }">
                    {{ getTheDepartment(item.event.department_id) }}
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
    // import the component and the necessary extensions
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
    export default {
        // specify TiptapVuetify component in "components"
        components: { TiptapVuetify },
        mounted() {
            console.log('Component mounted');
        },
        data() {
            return {
                dialog: false,
                isValid: true,
                search : '',
                feedbacks: [],
                rows: [],
                departments: [],
                roles: [],
                editedIndex: -1,
                color: '#1976D2',
                mask: '?#XXXXXX',
                menu_header_bg: false,
                menu_bg: false,
                menu_text_color: false,
                base_url: window.location.origin + '/',
                snackbar: false,
                timeout: 5000,
                error: false,
                photo: null,
                //c_picker: '',
                //c_pickers: ['page_header_bg_color', 'page_bg_color', 'page_text_color'],

                // declare extensions you want to use
                extensions: [
                    History,
                    Blockquote,
                    Link,
                    Underline,
                    Strike,
                    Italic,
                    ListItem,
                    BulletList,
                    OrderedList,
                    [Heading, {
                        options: {
                        levels: [1, 2, 3]
                        }
                    }],
                    Bold,
                    Code,
                    HorizontalRule,
                    Paragraph,
                    HardBreak
                ],

                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    phoneValid: (v) => !v || /^(?=.*[0-9])[- +()x0-9]+$/.test(v) || 'Tel. # must be valid',
                    urlValid: (v) => !v || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(v) || 'URL must be valid',
                    limitFileSize: (v) => !v || v.size < 2000000 || 'Logo size should be less than 2 MB!',
                    limitFileSizeMultiple: files => !files || !files.some(file => file.size > 2e6) || 'Avatar size should be less than 2 MB!'
                },
                headers: [
                    {text: 'Photo', value: 'photo'},
                    {text: 'Name', value: 'name'},
                    {text: 'Author', value: 'author'},
                    {text: 'Department', value: 'department'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    name: '',
                    profile: '',
                    photo: null,
                    department_id: '',
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    profile: '',
                    photo: null,
                    department_id: '',
                },
                isValid5: false,
                defaultUploadButtonText: 'Choose a file',
                posterFile: null,
                isSelecting: false,
                uploadReady: true,
                poster: {
                    file_path: '',
                    poster_code: '',
                    created_by: 0,
                    edited_by: 0,
                    event_id: 0,
                    template_id: 0,
                },
                posterFormats: ['JPG', 'PNG' , 'PDF'],
                selectedFormat: 'JPG',
                selectedTemplate: 0,
                templatePreview: false,
                theImageSrc: '',
                generatingPoster: false,
                templateRows: [],
                cacheKey: +new Date(),
                isActive: false,
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'create' : 'update'
            },
            uploadButtonText() {
                return this.posterFile ? this.posterFile.name : this.defaultUploadButtonText
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
                axios.get('/api/posters')
                .then( response => {
                    this.rows = response.data;
                });
            },
            getDepartments: function() {
                axios.get('/api/departments')
                .then( response => {
                    this.departments = response.data;
                });
            },
            getTemplates(eventId) {
                axios.get('/api/templates')
                .then( response => {
                    this.templateRows = response.data;
                });
            },
            editItem (item) {
                this.editedIndex = this.rows.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                // get all templates
                this.getTemplates(this.editedItem.id)

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
                    /////this.$refs.form.reset();
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

                axios.post('/api/speakers/upsert', {
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
            uploadLogo(){
                if ( this.photo ){
                    let formData = new FormData()
                    formData.append('photo', this.photo)
                    
                    if ( this.editedItem.id )
                        formData.append('id', this.editedItem.id)

                    axios.post('/api/speakers/uploadPhoto', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            // set the path on the global editedItem
                            this.editedItem.photo = response.data.file_path 
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
            setHedeaderTitle(){
                document.title = 'Posters - Event Publication and Poster Management System (EPPMS)';
            },
            addDropFile(e) { 
                this.file = e.dataTransfer.files[0] 
            },
            getTheDepartment(id){
                let filterDepartment = this.departments.filter(function(department){
                    return department.id === id
                })
    
                if (filterDepartment.length)
                    return filterDepartment[0].name
            },
            onButtonClick() {
                this.isSelecting = true
                window.addEventListener('focus', () => {
                    this.isSelecting = false
                }, { once: true })

                this.$refs.uploader.click()
            },
            onFileChanged(e) {
                this.posterFile = e.target.files[0]

                if (this.posterFile)
                    this.uploadReady = false
                else
                    this.uploadReady = true
                
            },
            selectTemplate(templateID){
                this.selectedTemplate = templateID
            },
            downloadPoster(){
                let path = `${this.base_url}files/events/${this.editedItem.id}/poster/${this.editedItem.id}`
                if (this.selectedFormat == 'JPG'){
                    path = `${path}.jpg`
                }
                else if(this.selectedFormat == 'PNG'){
                    path = `${path}.png`
                }
                else if(this.selectedFormat == 'PDF'){
                    path = `${path}.pdf`
                }
                return path
            },
            imageDialogUrl(templateID){
                this.templatePreview = true
                this.theImageSrc = "/web-admin/templates/screenshot/" + templateID
            },
            posterFilePath(){
                return this.editedItem.file_path.split('\\').pop().split('/').pop()
            },
            deletePoster(){
                // delete poster file here
                
                if (confirm("Are you sure you want to this poster image?") ){
                    
                    let id = this.poster.id

                    if (id > 0) {
                        axios.delete('/api/poster/file/delete/' + id)
                        .then(response => {
                            this.poster = response.data.item
                            this.posterFile = ''
                        })
                    }
                }
            },
            generatePoster(){
                this.generatingPoster = true

                var editedItem = this.editedItem
                var editedIndex = this.editedIndex

                axios.post('/api/posters/generate', {
                    event_id : this.editedItem.event_id,
                    template_id: this.selectedTemplate,
                })
                .then(response => {
                    if (response.data.success) {
                        this.editedItem = response.data.item
                        this.feedbacks = []
                        this.feedbacks[0] = 'Posters generated successfully.'
                        this.snackbar = true
                        this.error = false
                        this.generatingPoster = false
                        Object.assign(this.rows[editedIndex], response.data.item)
                        this.$forceUpdate()
                    }
                })
                .catch( error => {
                    
                })
            },
            uploadPoster(){
                if ( this.posterFile ){
                    let formData = new FormData()
                    formData.append('poster', this.posterFile)

                    var editedItem = this.editedItem
                    var editedIndex = this.editedIndex
                    
                    // use event id as id 
                    if ( this.editedItem.event_id )
                        formData.append('id', this.editedItem.event_id)

                    axios.post('/api/posters/upload', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.feedbacks = []
                            this.feedbacks[0] = 'Changes to this poster is applied.'
                            this.snackbar = true
                            this.error = false
                            // set the path on the global editedItem
                            //this.poster_thumb = response.data.poster_thumb 
                            this.editedItem = response.data.item
                            Object.assign(this.rows[editedIndex], response.data.item)
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
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getDepartments()
        },
    }
</script>