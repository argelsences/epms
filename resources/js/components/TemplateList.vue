<template>
    <v-app>
        <div class="text-h4 text-left">Templates</div>
        <div class="text-subtitle-1 text-left">You can manage the templates here</div>
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
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Template</v-btn>
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
                                        <v-window v-model="templateMethod">
                                            <v-window-item value="templateChoice">
                                                <v-card-text>
                                                    <div class="text-h5 text-left">How do you want to create the template?</div>
                                                    <v-radio-group v-model="templateMethod" >
                                                        <v-radio label="Uploading HTML, CSS, and image files" value="upload"></v-radio>
                                                        <v-radio label="By HTML, CSS source code and uploading image files" value="code"></v-radio>
                                                        <v-radio label="By using drawing canvas." value="canvas"></v-radio>
                                                    </v-radio-group>
                                                </v-card-text>
                                            </v-window-item>

                                            <v-window-item value="upload" >
                                                <v-card-text>
                                                    <v-form v-model="isValid" ref="form">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="6">
                                                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                            </v-col>
                                                            <v-col cols="12" sm="12" md="6">
                                                                <v-row>
                                                                    <v-col cols="12" sm="12" md="12">
                                                                        <v-file-input v-model="editedItem.html_code" class="" accept=".html" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                                                            prepend-icon="mdi-camera-iris" label="HTML File" persistentHint chips
                                                                            hint="Uploading a new file will replace the existing template code. Only accept HTML file. File size should not be greater than 2MB"
                                                                            @change="uploadLogo">
                                                                        </v-file-input>
                                                                    </v-col>
                                                                </v-row>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="6">
                                                                <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-map" rows="10"></v-textarea>
                                                            </v-col>
                                                            <v-col cols="12" sm="12" md="6">
                                                                <v-row>
                                                                    <v-col cols="12" sm="12" md="12">
                                                                        <v-file-input v-model="editedItem.css_code" class="mb-8" accept=".css" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                                                            prepend-icon="mdi-camera-iris" label="CSS File" persistentHint chips
                                                                            hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                                                            @change="uploadLogo">
                                                                        </v-file-input>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row>
                                                                    <v-col cols="12" sm="12" md="12">
                                                                        <v-file-input v-model="editedItem.images" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping a file here" 
                                                                            prepend-icon="mdi-camera-iris" label="Images" persistentHint chips
                                                                            hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                                                            @change="uploadLogo">
                                                                        </v-file-input> 
                                                                    </v-col>
                                                                </v-row>
                                                            </v-col>
                                                        </v-row>
                                                    </v-form>
                                                </v-card-text>
                                            </v-window-item>

                                            <v-window-item value="code">
                                                <v-card-text>
                                                    <v-form v-model="isValid" ref="form">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-map" rows="10"></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="HTML Code" v-model="editedItem.html_code" prepend-icon="mdi-map" rows="10" persistentHint hint="Paste your HTML code here"></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="CSS Code" v-model="editedItem.css_code" prepend-icon="mdi-map" rows="10" persistentHint hint="Paste your CSS code here"></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-file-input v-model="editedItem.images" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping file/s here" 
                                                                    prepend-icon="mdi-camera-iris" label="Images" persistentHint chips
                                                                    hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                                                    @change="uploadLogo">
                                                                </v-file-input> 
                                                            </v-col>
                                                        </v-row>
                                                    </v-form>
                                                </v-card-text>
                                            </v-window-item>

                                            <v-window-item value="canvas" eager>
                                                <v-card-text>
                                                    <v-form v-model="isValid" ref="form">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-map" rows="10"></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="HTML Code" v-model="editedItem.html_code" prepend-icon="mdi-map" rows="10" persistentHint hint="Paste your HTML code here"></v-textarea>
                                                                <div id="canvas-editor" ref="canvasEditor" style="position: absolute; left: 100px; top: 200px;">here</div>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-textarea counter label="CSS Code" v-model="editedItem.css_code" prepend-icon="mdi-map" rows="10" persistentHint hint="Paste your CSS code here"></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-file-input v-model="editedItem.images" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Select by clicking or dropping file/s here" 
                                                                    prepend-icon="mdi-camera-iris" label="Images" persistentHint chips
                                                                    hint="Uploading a new file will replace the existing template code. Only accepting CSS file. File size should not be greater than 2MB"
                                                                    @change="uploadLogo">
                                                                </v-file-input> 
                                                            </v-col>
                                                        </v-row>
                                                    </v-form>
                                                </v-card-text>
                                            </v-window-item>
                                        </v-window>
                                    </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <!--
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" :disabled="!isValid" text @click="save">Save</v-btn>
                                </v-card-actions>
                                -->
                                
                                <v-card-actions>
                                    <v-btn
                                        :disabled="templateMethod === 'templateChoice'"
                                        text
                                        @click="templateMethod='templateChoice'"
                                    >
                                        Back
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn
                                        :disabled="templateMethod === 'templateChoice'"
                                        color="blue darken-1"
                                        text
                                        @click="templateMethod"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>


                            </v-card>
                        </v-dialog>
                        <!-- the dialog box -->
                    </v-toolbar>
                <!-- the toolbar -->
                </template>
                <template v-slot:item.screenshot="{ item }">
                    {{item.file_path}}
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
                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                },
                headers: [
                    {text: 'Screenshot', value: 'screenshot'},
                    {text: 'Name', value: 'name'},
                    {text: 'Department', value: 'department_id'},
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
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Template' : 'Edit Template'
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
        
            templateMethod(val) {
                this.templateMethod = val
                console.log(val)
                if ( val == 'canvas')
                    this.setCanvasEditor()
                return val
            }
        },
        methods: {
            initialize: function() {
                axios.get('/api/templates')
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
                    this.$refs.form.reset()
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
            setCanvasEditor(){
                var drawerPlugins = [
                    // Drawing tools
                    'Pencil',
                    'Eraser',
                    'Text',
                    'Line',
                    'ArrowOneSide',
                    'ArrowTwoSide',
                    'Triangle',
                    'Rectangle',
                    'Circle',
                    'Image',
                    'BackgroundImage',
                    'Polygon',

                    // Drawing options
                    //'ColorHtml5',
                    'Color',
                    'ShapeBorder',
                    'BrushSize',
                    'OpacityOption',
                    'LineWidth',
                    'StrokeWidth',

                    'Resize',
                    'ShapeContextMenu',
                    'CloseButton',
                    'OvercanvasPopup',
                    'OpenPopupButton',
                    'MinimizeButton',
                    'ToggleVisibilityButton',
                    'MovableFloatingMode',

                    'TextLineHeight',
                    'TextAlign',

                    'TextFontFamily',
                    'TextFontSize',
                    'TextFontWeight',
                    'TextFontStyle',
                    'TextDecoration',
                    'TextColor',
                    'TextBackgroundColor'
                ];
                var drawer = new DrawerJs.Drawer(null, {
                    /////texts: customLocalization,
                    plugins: drawerPlugins,
                    defaultImageUrl: '/images/drawer.jpg',
                    defaultActivePlugin : { name : 'Pencil', mode : 'lastUsed'},
                }, 600, 600);
                document.getElementById('canvas-editor').innerHTML += drawer.getHtml()
                drawer.onInsert();
            },
        },
        updated: function(){
            console.log(this.templateMethod)
        }, 
        created: function() {
            /////this.setCanvasEditor()
            this.setHedeaderTitle()
            this.initialize()
        },
    }
</script>