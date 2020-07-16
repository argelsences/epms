<template>              
    <table class="table table-striped table-dark">
        <thead>
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
            </tr>
        </tbody>
    </table>      
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted');
        },
        data() {
            return {
                columns: [
                    {label: 'id', field: 'id'}, 
                    {label: 'Name', field: 'name'},
                    {label: 'Designation', field: 'designation'},
                    {label: 'Email', field: 'email'},
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
            }
            
        },
        created: function() {
            this.getUsers();
        }
    }
</script>