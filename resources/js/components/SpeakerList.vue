<!--<template>              
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col" v-for="(column, index) in columns" :key="index">{{column.label}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in rows" :key="row.id">
                <td>{{row.id}}</td>
                <td>{{row.name}}</td>
                <td>{{row.designation}}</td>
                <td>{{row.email}}</td>
                <td><a :href="`/web-admin/users/${row.id}/edit`">Edit</a></td>
            </tr>
        </tbody>
    </table>      
</template>
** search what is map function {{desserts.map(function(x) {return x.id; }).indexOf(item.id)}}
1. API for department list, and selected department DONE
2. Work on pushing the list of departments DONE
3. Fix issue with department when editing entry DONE
4. Disable editing email on update DONE
5. For designation, work on pushing the list of unique designations and allow user to add new input (use combobox) DONE
6. Add Role
7. Fix the password when user is editing DONE, confirm password is not shown
8. Changed password field with input to show the password DONE
9. BUG: when edit then add new, the password is prefilled and you can save without setting the password. Designation is affected. DONE
10. Fix the message output after successful create or update
11. Push changes to API backend
12. Force form reset
-->
<template>
    <v-app>
        <div class="text-h4 text-left">Speakers</div>
        <div class="text-subtitle-1 text-left">You can manage the event speakers here</div>
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
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Speaker</v-btn>
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
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6" v-cloak @drop.prevent="addDropFile" @dragover.prevent>
                                                    <v-file-input v-model="photo" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping an image here" 
                                                    prepend-icon="mdi-camera-iris" label="Photo" persistentHint chips
                                                    hint="Selecting an image will replace the existing photo. Valid image formats are JPG, JPEG, PNG & BMP. Image size should not be greater than 2MB"
                                                    @change="uploadLogo">
                                                    </v-file-input>        
                                                    
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-card v-if="editedItem.photo != null" class="my-2">
                                                        <v-card-text>
                                                            <v-img :lazy-src="base_url + editedItem.photo" max-height="150" max-width="250" :src="base_url + editedItem.photo"></v-img>
                                                            <v-divider class="my-2"></v-divider>
                                                            <p>{{editedItem.photo}}</p>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <!--<v-textarea counter label="Profile" v-model="editedItem.profile" prepend-icon="mdi-face-profile"></v-textarea>-->
                                                    <v-chip class="mb-6">
                                                        <v-icon left>mdi-face-profile</v-icon>
                                                        Profile
                                                    </v-chip>
                                                    <tiptap-vuetify
                                                        v-model="editedItem.profile"
                                                        :extensions="extensions"
                                                        id="profile"
                                                        min-height="400"
                                                    ></tiptap-vuetify>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    
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
                <template v-slot:item.photo="{ item }">
                    <v-img v-if="item.photo" :src="base_url + item.photo" alt="" aspect-ratio=".7" max-height="100px" max-width="100px"></v-img>
                    <v-icon size="100px" v-else>mdi-account-box</v-icon>
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
                content: `
                    <h1>Yay Headlines!</h1>
                    <p>All these <strong>cool tags</strong> are working now.</p>
                `,

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
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Speaker' : 'Edit Speaker'
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
                axios.get('/api/speakers')
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
                document.title = 'Speakers - Event Publication and Poster Management System (EPPMS)';
            },
            addDropFile(e) { 
                this.file = e.dataTransfer.files[0]
                console.log(this.file) 
            }
        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getDepartments()
        },
    }
</script>