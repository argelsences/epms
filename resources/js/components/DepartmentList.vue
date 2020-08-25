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
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog" max-width="800px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn class="mb-2 btn btn-sm btn-primary" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Department</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <!-- formTitle is  a computed property based on action edit or new -->
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-form v-model="isValid" ref="form">
                                            <v-row>
                                                <v-subheader><h4>Details</h4></v-subheader>
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
                                                    <v-file-input v-model="editedItem.logo_path" :rules="[rules.limitFileSize]" accept="image/png, image/jpeg, image/bmp" show-size clearable placeholder="Select a logo" prepend-icon="mdi-camera-iris" label="Logo"></v-file-input>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-text-field v-model="editedItem.url" label="Department URI" prepend-icon="mdi-link" :prefix="base_url" :rules="[rules.required]"></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-subheader><h4>Social Media</h4></v-subheader>
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
                                                <v-subheader><h4>Typography</h4></v-subheader>
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
                                                <v-subheader><h4 class="mt-6">Statistics code</h4></v-subheader>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea label="Google Analytics code" hint="Paste the code here" v-model="editedItem.google_analytics_code"></v-textarea>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea label="Google Tag Manager code" hint="Paste the code here" v-model="editedItem.google_tag_manager_code"></v-textarea>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </v-container>
                                </v-card-text>
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
                    <v-chip class="ma-2" color="teal" text-color="white" label :href="item.url" target="blank">
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
    export default {
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
                //successAlert: false,
                color: '#1976D2',
                mask: '?#XXXXXX',
                menu_header_bg: false,
                menu_bg: false,
                menu_text_color: false,
                base_url: window.location.origin + '/',
                snackbar: false,
                timeout: 5000,
                error: false,
                logo: [],
                //c_picker: '',
                //c_pickers: ['page_header_bg_color', 'page_bg_color', 'page_text_color'],

                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    phoneValid: (v) => !v || /^(?=.*[0-9])[- +()x0-9]+$/.test(v) || 'Tel. # must be valid',
                    urlValid: (v) => !v || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(v) || 'URL must be valid',
                    limitFileSize: (v) => !v || v.size < 2000000 || 'Logo size should be less than 2 MB!',
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
                    logo_path: '',
                    page_header_bg_color: '',
                    page_bg_color: '',
                    page_text_color: '',
                    google_analytics_code: '',
                    google_tag_manager_code: '',
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    phone: '',
                    email: '',
                    facebook: '',
                    instagram: '',
                    department_name: '',
                    logo_path: '',
                    page_header_bg_color: '',
                    page_bg_color: '',
                    page_text_color: '',
                    google_analytics_code: '',
                    google_tag_manager_code: '',
                },
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
                var background = this.editedItem.page_header_bg_color
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                if (this.editedItem.page_header_bg_color == '' || this.editedItem.page_header_bg_color == null )
                    background = '#1976D2'
                    
                return {
                    backgroundColor: background,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
            swatchStyleBGColor() {
                const { menu } = this
                var background = this.editedItem.page_bg_color
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                if (this.editedItem.page_bg_color == '' || this.editedItem.page_bg_color == null )
                    background = '#1976D2'
                    
                return {
                    backgroundColor: background,
                    cursor: 'pointer',
                    height: '30px',
                    width: '30px',
                    borderRadius: menu ? '50%' : '4px',
                    transition: 'border-radius 200ms ease-in-out'
                }
            },
            swatchStyleTextColor() {
                const { menu } = this
                var background = this.editedItem.page_text_color
                // ['page_header_bg_color', 'page_bg_color', 'page_text_color'],
                if (this.editedItem.page_text_color == '' || this.editedItem.page_text_color == null )
                    background = '#1976D2'
                    
                return {
                    backgroundColor: background,
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
                    this.rows = response.data;
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
                this.$refs.form.validate()
                // check if process is updating or creating
                // if update, then replace the value of the current item with the value in the editedItem
                // if creating, then push the edited item into the object
                
                // assign the edited item to a local var first to be able to be used for filter
                var editedItem = this.editedItem
                var editedIndex = this.editedIndex
                /*var filterDepartment = this.departments.filter(function(department) {
                        return department.id ==  editItem.department_id
                });*/
                // use ES6, filter can only access local variables
                // get department name based on department_id
                /////var filterDepartment = this.departments.filter( department => department.id == editedItem.department_id );
                /////this.editedItem.department_name = filterDepartment[0].name;
                // get role name based on role_id
                /////var filterRole = this.roles.filter( role => role.id == editedItem.role_id );
                /////this.editedItem.role_name = filterRole[0].name;

                /*let files = this.$refs.dropzone.getAcceptedFiles();
                if (files.length > 0 && files[0].filename ){
                    this.item.image = files[0].filename;
                }*/

                console.log(editedItem)
                axios.post('/api/departments/upsert', {
                    payload: editedItem,
                })
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks[0] = 'Changes for ' + editedItem.name + ' is saved.'
                        this.snackbar = true
                        this.error = false
                        if ( editedIndex > -1 )
                            Object.assign(this.rows[editedIndex], editedItem)
                        else
                            this.rows.push(editedItem)
                    }
                })
                .catch( error => {
                    let messages = Object.values(error.response.data.errors); 
                    this.feedbacks = [].concat.apply([], messages)
                    this.snackbar = true
                    this.error = true
                    console.log(this.errors)
                })

                // close the dialog box
                this.close()   
            },
        },
        created: function() {
            this.initialize();
        },
    }
</script>