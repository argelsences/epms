<template>
    <v-app>
        <div class="text-h4 text-left">Departments</div>
        <div class="text-subtitle-1 text-left">You can manage the departments here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name" :loading="isLoading" :loading-text="loadingText">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog"  width="80%" scrollable fullscreen>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Department</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <!-- formTitle is  a computed property based on action edit or new -->
                                    <span class="headline">{{ formTitle }}</span>
                                    <v-spacer></v-spacer>
                                    <v-btn absolute dark fab middle right color="pink" @click="close">
                                        <v-icon x-large>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-container>
                                        <v-form v-model="isValid" ref="form">
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-subheader><h4>Details</h4></v-subheader>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.email" label="Email" :rules="[rules.required, rules.emailValid]" prepend-icon="mdi-email" ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.phone" label="Tel. #" :rules="[rules.phoneValid]" prepend-icon="mdi-phone" ></v-text-field>
                                                    <!--<v-select :items="departments" label="Department" item-text="name" item-value="id" v-model="editedItem.department_id" :rules="[rules.required]"></v-select>-->
                                                    <!--<v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select"></v-autocomplete>-->
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">    
                                                    <v-file-input v-model="logo" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Click to upload an image" 
                                                    prepend-icon="mdi-camera-iris" label="Logo" persistentHint chips
                                                    hint="Selecting an image will replace the existing logo. Valid image formats are JPG, JPEG, PNG & BMP. Image size should not be greater than 2MB"
                                                    @change="uploadLogo" @click.stop="{event => {event.stopPropagation()}}" ref="uploader">

                                                    </v-file-input>        
                                                    <v-card v-if="editedItem.logo_path != null" class="my-2">
                                                        <v-card-text>
                                                            <v-img :lazy-src="base_url + editedItem.logo_path" max-height="150" max-width="250" :src="base_url + editedItem.logo_path"></v-img>
                                                            <v-divider class="my-2"></v-divider>
                                                            <p>{{editedItem.logo_path}}</p>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-chip class="mb-6">
                                                        <v-icon left>mdi-face-profile</v-icon>
                                                        About
                                                    </v-chip>
                                                    <tiptap-vuetify
                                                        v-model="editedItem.about"
                                                        :extensions="extensions"
                                                        id="about"
                                                        min-height="400"
                                                    ></tiptap-vuetify>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-text-field v-model="editedItem.url" label="Department URI" prepend-icon="mdi-link" :prefix="base_url" :rules="[rules.required]"></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-subheader><h4>Social Media</h4></v-subheader>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.facebook" label="Facebook URL" :rules="[rules.urlValid]" prepend-icon="mdi-facebook"></v-text-field>
                                                    <!--<v-combobox v-model="editedItem.designation" :items="rows" item-text="designation" item-value="designation"  label="Designation" :rules="[rules.required]" :return-object="false" hint="Type to select or add new item"></v-combobox>-->
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.instagram" label="Instagram URL" :rules="[rules.urlValid]" prepend-icon="mdi-instagram"></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-subheader><h4>Backgrounds & Colors</h4></v-subheader>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-text-field v-model="editedItem.page_header_bg_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page header bg color" outlined readonly :placeholder="color" >
                                                        <template v-slot:append>
                                                            <v-menu v-model="menu_header_bg" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                                                <template v-slot:activator="{ on }">
                                                                    <div :style="swatchStyleHeaderBGColor" v-on="on" />
                                                                </template>
                                                                <v-card>
                                                                <v-card-text class="pa-0">
                                                                    <v-color-picker v-model="editedItem.page_header_bg_color" mode="hexa" hide-mode-switch flat />
                                                                </v-card-text>
                                                                </v-card>
                                                            </v-menu>
                                                        </template>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-text-field v-model="editedItem.page_bg_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page bg color" outlined readonly :placeholder="color">
                                                        <template v-slot:append>
                                                            <v-menu v-model="menu_bg" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                                                <template v-slot:activator="{ on }">
                                                                    <div :style="swatchStyleBGColor" v-on="on" />
                                                                </template>
                                                                <v-card>
                                                                    <v-card-text class="pa-0">
                                                                        <v-color-picker v-model="editedItem.page_bg_color" mode="hexa" hide-mode-switch flat />
                                                                    </v-card-text>
                                                                </v-card>
                                                            </v-menu>
                                                        </template>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-text-field v-model="editedItem.page_text_color" v-mask="mask" hide-details class="ma-0 pa-0"  label="Page text color" outlined readonly :placeholder="color">
                                                        <template v-slot:append>
                                                            <v-menu v-model="menu_text_color" top nudge-bottom="105" nudge-left="16" :close-on-content-click="false">
                                                                <template v-slot:activator="{ on }">
                                                                    <div :style="swatchStyleTextColor" v-on="on" />
                                                                </template>
                                                                <v-card>
                                                                    <v-card-text class="pa-0">
                                                                        <v-color-picker v-model="editedItem.page_text_color" mode="hexa" hide-mode-switch flat />
                                                                    </v-card-text>
                                                                </v-card>
                                                            </v-menu>
                                                        </template>
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-subheader><h4 class="mt-6">Statistics code</h4></v-subheader>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field label="Google Analytics ID" hint="Input the ID here" v-model="editedItem.google_analytics_code"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field label="Google Tag Manager ID" hint="Input the ID here" v-model="editedItem.google_tag_manager_code"></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" :disabled="!isValid" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <!-- the dialog box -->
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <template v-slot:item.url="{ item }">
                    <v-chip class="ma-2" color="cyan darken-2" tile outlined label :href="base_url + 'd/' + item.url" target="blank">
                        <v-avatar left>
                            <v-icon>mdi-link</v-icon>
                        </v-avatar>
                        URL
                     </v-chip>
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
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
    export default {
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
                logo: null,
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
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    phoneValid: (v) => !v || /^(?=.*[0-9])[- +()x0-9]+$/.test(v) || 'Tel. # must be valid',
                    urlValid: (v) => !v || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(v) || 'URL must be valid',
                    limitFileSize: (v) => !v || v.size < 2000000 || 'Logo size should be less than 2 MB!',
                    limitFileSizeMultiple: files => !files || !files.some(file => file.size > 2e6) || 'Avatar size should be less than 2 MB!'
                },
                headers: [
                    {text: 'Name', value: 'name'},
                    {text: 'URL', value: 'url'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    name: '',
                    phone: '',
                    email: '',
                    facebook: '',
                    instagram: '',
                    logo_path: null,
                    page_header_bg_color: '',
                    page_bg_color: '',
                    page_text_color: '',
                    google_analytics_code: '',
                    google_tag_manager_code: '',
                    url: '',
                    about: '',
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    phone: '',
                    email: '',
                    facebook: '',
                    instagram: '',
                    department_name: '',
                    logo_path: null,
                    page_header_bg_color: '',
                    page_bg_color: '',
                    page_text_color: '',
                    google_analytics_code: '',
                    google_tag_manager_code: '',
                    url: '',
                    about: '',
                },
                isLoading: true,
                loadingText: "Loading items, please wait."
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Department' : 'Edit Department'
            },
            /*departmentName () {
                return this.editedIndex === -1 ? '' : this.rows[this.editedIndex].department.name
            },*/ 
            swatchStyleHeaderBGColor() {
                const { menu } = this
                //var background = this.editedItem.page_header_bg_color
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                if (this.editedItem.page_header_bg_color == '' || this.editedItem.page_header_bg_color == null )
                    this.editedItem.page_header_bg_color = '#0D7377'
                    
                return {
                    backgroundColor: this.editedItem.page_header_bg_color,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
            swatchStyleBGColor() {
                const { menu } = this
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                if (this.editedItem.page_bg_color == '' || this.editedItem.page_bg_color == null )
                    this.editedItem.page_bg_color = '#EEEEEE'
                    
                return {
                    backgroundColor: this.editedItem.page_bg_color,
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
                if (this.editedItem.page_text_color == '' || this.editedItem.page_text_color == null )
                    this.editedItem.page_text_color = '#FFFFFF'
                    
                return {
                    backgroundColor: this.editedItem.page_text_color,
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
                axios.get('/api/departments')
                .then( response => {
                    this.rows = response.data
                    this.isLoading = false
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
                    this.$refs.form.reset();
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

                axios.post('/api/departments/upsert', {
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
            setHedeaderTitle(){
                document.title = 'Departments - Event Publication and Poster Management System (EPPMS)';
            },
            addDropFile(e) { 
                this.file = e.dataTransfer.files[0]
                console.log(this.file) 
            },
        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
        },
    }
</script>