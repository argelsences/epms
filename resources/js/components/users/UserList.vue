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
        <div class="text-h4 text-left">Users</div>
        <div class="text-subtitle-1 text-left">You can manage your users here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" :single-expand="singleExpand" :expanded.sync="expanded" show-expand sort-by="name">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog" width="80%" scrollable fullscreen>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> User</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <!-- formTitle is a computed property based on action edit or new -->
                                    <span class="headline">{{ formTitle }}</span>
                                    <v-spacer></v-spacer>
                                    <v-btn absolute dark fab middle right color="pink" @click="close">
                                        <v-icon x-large>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-container>
                                        <v-form v-model="valid" ref="form" @submit.prevent="" lazy-validation>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-if="editedIndex > -1" v-model="editedItem.email" label="Email" :rules="[rules.required, rules.emailValid]" prepend-icon="mdi-email" readonly disabled></v-text-field>
                                                    <v-text-field v-else v-model="editedItem.email" label="Email" :rules="[rules.required, rules.emailValid]" prepend-icon="mdi-email"></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <!--<v-text-field v-model="editedItem.department_id" label="Department" :rules="[rules.required]"></v-text-field>-->
                                                    <!--<v-select :items="departments" label="Department" item-text="name" item-value="id" v-model="editedItem.department_id" :rules="[rules.required]"></v-select>-->
                                                    <v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <!--<v-text-field v-model="editedItem.designation" label="Designation" :rules="[rules.required]"></v-text-field>-->
                                                    <v-combobox v-model="editedItem.designation" :items="rows" item-text="designation" item-value="designation"  label="Designation" :rules="[rules.required]" :return-object="false" prepend-icon="mdi-tooltip-account" hint="Type to select or add new item"></v-combobox>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <!--<v-text-field label="Password" type="password" v-model="password" :rules="[rules.required, rules.min]"></v-text-field>-->
                                                    <v-autocomplete v-model="editedItem.role_id" :items="roles" item-text="name" item-value="id"  label="Role" :rules="[rules.required]" prepend-icon="mdi-shield-account" hint="Type to select"></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <!--<v-text-field v-if="editedIndex == -1" label="Confirm Password" type="password" v-model="passwordConfirm" :rules="[rules.required,rules.passwordMatch]"></v-text-field>-->
                                                    <v-text-field v-if="editedIndex > -1" v-model="editedItem.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.min]" :type="showPassword ? 'text' : 'password'" label="Password" hint="At least 8 characters" counter @click:append="showPassword = !showPassword" prepend-icon="mdi-shield-key"></v-text-field>
                                                    <v-text-field v-else v-model="editedItem.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="showPassword ? 'text' : 'password'" label="Password" hint="At least 8 characters" counter @click:append="showPassword = !showPassword" prepend-icon="mdi-shield-key"></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" :disabled="!valid" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <!-- the dialog box -->
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <!--<template v-slot:item.id="{ item }">
                    {{rows.map(function(x) {return x.id; }).indexOf(item.id)+1}}
                </template>-->
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                    <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn class="btn btn-sm btn-primary" @click="initialize">Reset</v-btn>
                </template>
                <template v-slot:expanded-item="{ headers, item }" flat>
                    <td :colspan="headers.length/2">
                        <v-chip class="ma-2" color="grey darken-3" label text-color="white"> 
                            <v-icon left>mdi-email</v-icon>Email
                        </v-chip>
                        {{ item.email }}
                    </td>
                    <td :colspan="headers.length/2" flat>
                        <v-chip class="ma-2" color="grey darken-3" label text-color="white"> 
                            <v-icon left>mdi-face</v-icon>Designation
                        </v-chip>
                        {{ item.designation }}
                    </td>
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
                valid: true,
                showPassword: false,
                expanded: [],
                singleExpand: true,
                search : '',
                feedbacks: [],
                rows: [],
                departments: [],
                roles: [],
                editedIndex: -1,
                snackbar: false,
                timeout: 5000,
                error: false,
                rules: {
                    required: (v) => !!v || 'Required.',
                    min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    //passwordMatch: (v) => !(v!==this.password) || 'Password do not match.'
                },
                headers: [
                    {text: 'Name', value: 'name'},
                    {text: 'Department', value: 'department_name'},
                    {text: 'Role', value: 'role_name'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    name: '',
                    designation: '',
                    email: '',
                    department_id: '',
                    department_name: '',
                    role_id: '',
                    role_name: '',
                    department: {
                        id: 0,
                        name: '',
                    },
                    roles : [
                        { 
                            id: 0,
                            name: '',
                        },
                    ],
                    password: '',
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    designation: '',
                    email: '',
                    department_id: '',
                    department_name: '',
                    role_id: '',
                    role_name: '',
                    department: {
                        id: 0,
                        name: '',
                    },
                    roles : [
                        { 
                            id: 0,
                            name: '',
                        },
                    ],
                    password: '',
                },
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New User' : 'Edit User'
            },
            /*departmentName () {
                return this.editedIndex === -1 ? '' : this.rows[this.editedIndex].department.name
            },*/ 
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
                axios.get('/api/users')
                .then( response => {
                    this.rows = response.data;
                });
                //console.log("the rows" + this.rows)
            },
            getDepartments: function() {
                axios.get('/api/departments')
                .then( response => {
                    this.departments = response.data;
                });
            },
            getRoles: function() {
                axios.get('/api/roles')
                .then( response => {
                    this.roles = response.data;
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
                var filterDepartment = this.departments.filter( department => department.id == editedItem.department_id );
                this.editedItem.department_name = filterDepartment[0].name;
                // get role name based on role_id
                var filterRole = this.roles.filter( role => role.id == editedItem.role_id );
                this.editedItem.role_name = filterRole[0].name;

                axios.post('/api/users/upsert', {
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

                /////if (this.editedIndex > -1) {
                    // push changes to server
                    /////axios.post('/api/users/update', {
                        /////user: editedItem,
                    /////})
                    /////.then(response => {
                        /////if (response.data.success) {
                            /////this.feedback = 'Changes for ' + editedItem.name + ' is saved.'
                            /////this.successAlert = true
                            /////Object.assign(this.rows[editedIndex], editedItem)
                        /////}
                    /////})
                    //Object.assign(this.rows[this.editedIndex], this.editedItem)
                /////} else {
                    // perform the create action here
                    // action ...
                    /////this.rows.push(this.editedItem)
                    /////console.log(this.rows)
                /////}

                // close the dialog box
                this.close()
                
            },
            setHedeaderTitle(){
                document.title = 'Users - Event Publication and Poster Management System (EPPMS)';
            }
        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getDepartments()
            this.getRoles()
        },
    }
</script>