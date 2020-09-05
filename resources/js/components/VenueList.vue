<template>
    <v-app>
        <div class="text-h4 text-left">Venues</div>
        <div class="text-subtitle-1 text-left">You can manage the event venues here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog"  width="80%" scrollable>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Venue</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <!-- formTitle is  a computed property based on action edit or new -->
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-container>
                                        <v-form v-model="isValid" ref="form">
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="v-input  theme--light v-text-field ">
                                                        <div class="v-input__prepend-outer">
                                                            <div class="v-input__icon v-input__icon--prepend">
                                                                <i aria-hidden="true" class="v-icon notranslate mdi mdi-home-search theme--light"></i>
                                                            </div>
                                                        </div>
                                                        <div class="v-input__control">
                                                            <div class="v-input__slot">
                                                                <div class="v-text-field__slot">
                                                                    <label for="gplace" class="v-label theme--light" style="left: 0px; right: auto; position: absolute;"></label>
                                                                    <gmap-autocomplete class="w-50" style="width: 100%" id="gplace" 
                                                                        @place_changed="setPlace" :options="{fields: ['geometry', 'address_component']}">
                                                                    </gmap-autocomplete>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<button @click="addMarker">Add</button>
                                                    <gmap-map
                                                        :center="center"
                                                        :zoom="12"
                                                        style="width:100%;  height: 400px;"
                                                        >
                                                        <gmap-marker
                                                            :key="index"
                                                            v-for="(m, index) in markers"
                                                            :position="m.position"
                                                            @click="center=m.position"
                                                        ></gmap-marker>
                                                    </gmap-map>-->
                                                    <v-alert color="#1b1c25"  dark icon="mdi-help" border="left">
                                                        Enter a location, or input the details manually
                                                    </v-alert>

                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea counter label="Address Line 1" v-model="editedItem.address_line_1" prepend-icon="mdi-map"></v-textarea>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea counter label="Address Line 2" v-model="editedItem.address_line_2" prepend-icon="mdi-map"></v-textarea>   
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.state" label="State" prepend-icon="mdi-email" ></v-text-field> 
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-text-field v-model="editedItem.postcode" label="Postcode" prepend-icon="mdi-phone" ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-select :items="countries" label="Country" item-text="name" item-value="name" v-model="editedItem.country"  prepend-icon="mdi-earth"></v-select>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="6">
                                                            <v-text-field v-model="editedItem.lat" label="Latitude" prepend-icon="mdi-map-marker"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="6">
                                                            <v-text-field v-model="editedItem.long" label="Longtitude"  prepend-icon="mdi-map-marker"></v-text-field>
                                                        </v-col>
                                                    </v-row>
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
                <template v-slot:item.addresses="{ item }">
                    {{item.address_line_1}} {{item.address_line_2}}  
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
            /////this.geolocate()
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
                countries: [],
                center: { lat: 45.508, lng: -73.587 },
                markers: [],
                places: [],
                currentPlace: null,

                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                },
                headers: [
                    {text: 'Name', value: 'name'},
                    {text: 'Address', value: 'addresses'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    name: '',
                    address_line_1: '',
                    address_line_2: '',
                    country: '',
                    state: '',
                    postcode: '',
                    lat: '',
                    long: '',
                },
                defaultItem: {
                    id: 0,
                    name: '',
                    address_line_1: '',
                    address_line_2: '',
                    country: '',
                    state: '',
                    postcode: '',
                    lat: null,
                    long: '',
                },
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Venue' : 'Edit Venue'
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
                axios.get('/api/venues')
                .then( response => {
                    this.rows = response.data;
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
                document.title = 'Venues - Event Publication and Poster Management System (EPPMS)';
            },

            // receives a place object via the autocomplete component
            setPlace(place) {
                this.currentPlace = place
                // set the address without country and zip code
                if (this.currentPlace) {
                    let address_components = this.currentPlace.address_components
                    let address_details = {
                        country: '',
                        postal_code: '',
                        formatted_address: '',
                    };
                    address_components.forEach( function(address_component){
                        if ( address_component.types[0] == 'country')
                            address_details.country = address_component.long_name
                        else if ( address_component.types[0] == 'postal_code')
                            address_details.postal_code = address_component.long_name
                        else
                            address_details.formatted_address = address_details.formatted_address + ' ' + address_component.long_name
                    });
                    
                    // set the country, postcode, long, lat and address
                    this.editedItem.address_line_1 = address_details.formatted_address
                    this.editedItem.country = address_details.country
                    this.editedItem.postcode = address_details.postal_code
                    this.editedItem.lat = this.currentPlace.geometry.location.lat()
                    this.editedItem.long = this.currentPlace.geometry.location.lng()
                }
            },
            /*
            addMarker() {
                if (this.currentPlace) {
                    //console.log(this.currentPlace.address_components)
                    let address_components = this.currentPlace.address_components
                    let address_details = {
                        country: '',
                        postal_code: ''
                    };
                    address_components.forEach( function(address_component){
                        if ( address_component.types[0] == 'country')
                            address_details.country = address_component.long_name
                        else if ( address_component.types[0] == 'postal_code')
                            address_details.postal_code = address_component.long_name
                    });
                    // set the country and postcode
                    this.editedItem.country = address_details.country
                    this.editedItem.postcode = address_details.postal_code
                    // set the value for lat long here
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.editedItem.lat = marker.lat
                    this.editedItem.long = marker.lng
                    this.markers.push({ position: marker });
                    this.places.push(this.currentPlace);
                    this.center = marker;
                    this.currentPlace = null;
                }
            },*/
            geolocate: function() {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };
                });
            },

        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getCountries()
        },
    }
</script>