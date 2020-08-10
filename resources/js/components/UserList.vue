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
1. Work on pushing the list of departments 
2. For designation, work on pushing the list of designations and allow user to add new input
3. Add Role
4. Fix the password when user is editing
5. Fix the message output after successful create or update
-->
<template>
    <v-app>
        <v-card>
            <v-data-table :headers="columns" :items="rows" :search="search">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog" max-width="600px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn class="mb-2 btn btn-sm btn-primary" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> User</v-btn>
                            </template>
                            <v-form v-model="valid" ref="form" @submit.prevent="">
                                <v-card>
                                    <v-card-title>
                                        <!-- formTitle is a computed property based on action edit or new -->
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="editedItem.email" label="Email" :rules="[rules.required, rules.emailValid]"></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="editedItem.department_id" label="Department" :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field v-model="editedItem.designation" label="Designation" :rules="[rules.required]"></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field label="Password" type="password" v-model="password" :rules="[rules.required, rules.min]"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="12" md="6">
                                                        <v-text-field label="Confirm Password" type="password" v-model="passwordConfirm" :rules="[rules.required,rules.passwordMatch]"></v-text-field>
                                                    </v-col>
                                                </v-row>
                                        </v-container>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                        <v-btn color="blue darken-1" :disabled="!valid" text @click="save">Save</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-form>
                        </v-dialog>
                        <!-- the dialog box -->
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <template v-slot:item.id="{ item }">
                    {{rows.map(function(x) {return x.id; }).indexOf(item.id)+1}}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                    <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn color="primary" @click="initialize">Reset</v-btn>
                </template>
            </v-data-table>
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
                valid: false,
                //showPassword: false,
                search : '',
                password: '',
                passwordConfirm: '',
                rules: {
                    required: (v) => !!v || 'Required.',
                    min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    passwordMatch: (v) => !(v!==this.password) || 'Password do not match.'
                },
                columns: [
                    {text: 'ID', value: 'id'}, 
                    {text: 'Name', value: 'name'},
                    {text: 'Designation', value: 'designation'},
                    {text: 'Email', value: 'email'},
                    {text: 'Department', value: 'department.name'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                rows: [],
                editedIndex: -1,
                editedItem: {
                    name: '',
                    designation: '',
                    email: '',
                    department_id: '',
                },
                defaultItem: {
                    name: '',
                    designation: '',
                    email: '',
                    department_id: '',
                },
                index: 0,
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
                //this.editedIndex > -1 || this.$refs.form.reset();
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
                /////this.$refs.form.reset();
                // make sure the dialog box is closed
                this.dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            save () {
                // check if process is updating or creating
                // if update, then replace the value of the current item with the value in the editedItem
                // if creating, then push the edited item into the object
                axios.post('/api/users/upsert', {
                    user: this.editedItem,
                    password: this.password,
                });

                if (this.editedIndex > -1) {
                    // perform the update action here
                    // action ...
                    Object.assign(this.rows[this.editedIndex], this.editedItem)
                } else {
                    // perform the create action here
                    // action ...
                    console.log(this.editedItem)
                    this.rows.push(this.editedItem)
                }
                // reset the form
                /////this.$refs.form.reset();
                // close the dialog box
                this.close()
            },
        },
        created: function() {
            this.initialize();
        }
    }
</script>