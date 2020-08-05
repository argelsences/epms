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
</template>-->
<template>
  <v-card>
    <v-card-title>
      <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="columns" :items="rows" :search="search">
        <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
            <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
        </template>
        <!--<template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>-->
    </v-data-table>
  </v-card>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted');
        },
        data() {
            return {
                search : '',
                columns: [
                    {text: 'ID', value: 'id'}, 
                    {text: 'Name', value: 'name'},
                    {text: 'Designation', value: 'designation'},
                    {text: 'Email', value: 'email'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                rows: [],
                page: 1,
                per_page: 10,
            }
        },
        methods: {
            getUsers: function() {
                axios.get('/api/users')
                .then( response => {
                    this.rows = response.data;
                });
            },
            editItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.desserts.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
            },
 
        },
        created: function() {
            this.getUsers();
        }
    }
</script>