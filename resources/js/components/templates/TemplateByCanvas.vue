<template>
    <v-app id="canvas-template-container">
        <div class="text-h4 text-left">Create template by creating design in canvas</div>
        <div class="text-subtitle-1 text-left">In here you see the overview</div>
        <v-divider></v-divider>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-form v-model="isValid" ref="form">
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row >
                            <v-col cols="12" sm="12" md="12" align-self="center">
                                <v-textarea counter label="Description" v-model="editedItem.description" prepend-icon="mdi-map" rows="10"></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row >
                            <v-col cols="12" sm="12" md="12" align-self="center">
                                <v-chip class="mb-6" large>
                                    <v-icon left>mdi-draw</v-icon>
                                    Canvas
                                </v-chip>
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <div id="canvas-editor" style="" ref="canvasEditor"></div>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
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
    </v-app>
</template>
<script>
    import HTMLCanvas from '../HTMLCanvas.vue'
    export default {
        components: { HTMLCanvas },
        mounted() {
            console.log('Component mounted')
            this.$nextTick(() => {
                this.setCanvasEditor()
            })
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
                drawerPlugins: [
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
                    'Polygon',
                    'Image',
                    'BackgroundImage',
                    'ImageCrop',

                    // Drawing options
                    //'ColorHtml5',
                    'Color',
                    'ShapeBorder',
                    'BrushSize',
                    'Resize',
                    'ShapeContextMenu',
                    'MovableFloatingMode',
                    'CloseButton',
                    'MinimizeButton',
                    'FullscreenModeButton',
                    'ToggleVisibilityButton',
                    'OvercanvasPopup',
                    'OpenPopupButton',
                    'Zoom',
                    'OpacityOption',
                    'LineWidth',
                    'StrokeWidth',

                    'TextLineHeight',
                    'TextAlign',
                    'TextFontFamily',
                    'TextFontSize',
                    'TextFontWeight',
                    'TextFontStyle',
                    'TextDecoration',
                    'TextColor',
                    'TextBackgroundColor'
                ],
                drawerPluginConfig: {
                    ShapeBorder: {
                        color: 'rgba(0, 0, 0, 0)'
                    },
                    Pencil: {
                        cursorUrl: 'pencil',
                        brushSize: 3
                    },
                    Eraser: {
                        brushSize: 5
                    },
                    Circle: {
                        centeringMode: 'normal'
                    },
                    Rectangle: {
                        centeringMode: 'normal'
                    },
                    Triangle: {
                        centeringMode: 'normal'
                    },
                    Text: {
                        fonts: {
                            'Georgia': 'Georgia, serif',
                            'Palatino': "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
                            'Times New Roman': "'Times New Roman', Times, serif",

                            'Arial': 'Arial, Helvetica, sans-serif',
                            'Arial Black': "'Arial Black', Gadget, sans-serif",
                            'Comic Sans MS': "'Comic Sans MS', cursive, sans-serif",
                            'Impact': 'Impact, Charcoal, sans-serif',
                            'Lucida Grande': "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
                            'Tahoma': 'Tahoma, Geneva, sans-serif',
                            'Trebuchet MS': "'Trebuchet MS', Helvetica, sans-serif",
                            'Verdana': 'Verdana, Geneva, sans-serif',

                            'Courier New': "'Courier New', Courier, monospace",
                            'Lucida Console': "'Lucida Console', Monaco, monospace"
                        },
                        defaultFont: 'Palatino',
                        editIconMode: false,
                        defaultValues: {
                            fontSize: 72,
                            lineHeight: 2,
                            textFontWeight: 'bold'
                        },
                        predefined: {
                            fontSize: [8, 12, 14, 16, 32, 40, 72],
                            lineHeight: [1, 2, 3, 4, 6]
                        }
                    },
                    ShapeContextMenu: {
                        position: {
                            touch: 'cursor',
                            mouse: 'cursor'
                        }
                    },
                    Zoom: {
                        enabled: true,
                        showZoomTooltip: true,
                        useWheelEvents: true,
                        zoomStep: 1.05,
                        defaultZoom: 1,
                        maxZoom: 32,
                        minZoom: 1,
                        smoothnessOfWheel: 0,
                        enableMove: true,
                        enableWhenNoActiveTool: true,
                        enableButton: true
                    },
                    Image: {
                        scaleDownLargeImage: true,
                        maxImageSizeKb: 1024,
                        cropIsActive: true
                    },
                    BackgroundImage: {
                        scaleDownLargeImage: true,
                        maxImageSizeKb: 1024, //1MB
                        acceptedMIMETypes: ['image/jpeg', 'image/png', 'image/gif'],
                        dynamicRepositionImage: true,
                        dynamicRepositionImageThrottle: 100,
                        cropIsActive: false
                    }
                },
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
                var canvas = new DrawerJs.Drawer(null, {
                    toolbarSize: 35,
                    toolbarSizeTouch: 43,
                    tooltipCss: {
                        color: 'white',
                        background: 'black'
                    },
                    backgroundCss: 'transparent',
                    activeColor: '#19A6FD',
                    canvasProperties: {
                        selectionColor: 'rgba(255, 255, 255, 0.3)',
                        selectionDashArray: [3, 8],
                        selectionBorderColor: '#5f5f5f'
                    },
                    objectControls: {
                        borderColor: 'rgba(102,153,255,0.75)',
                        borderOpacityWhenMoving: 0.4,
                        cornerColor: 'rgba(102,153,255,0.5)',
                        cornerSize: 12,
                        hasBorders: true
                    },
                    objectControlsTouch: {
                        borderColor: 'rgba(102,153,255,0.75)',
                        borderOpacityWhenMoving: 0.4,
                        cornerColor: 'rgba(102,153,255,0.5)',
                        cornerSize: 20,
                        hasBorders: true
                    },
                    plugins: this.drawerPlugins,
                    pluginsConfig: this.drawerPluginConfig,
                    defaultActivePlugin: { name: 'Pencil', mode: 'onNew' },
                    //defaultImageUrl: '/Client/vendor/DrawerJs/images/drawer.jpg',
                    transparentBackground: false,
                    exitOnOutsideClick: false,
                    toolbars: {
                        drawingTools: {
                            position: 'top',
                            positionType: 'outside',
                            compactType: 'scrollable',
                            hidden: false,
                            toggleVisibilityButton: false,
                            fullscreenMode: {
                                position: 'top',
                                hidden: false,
                                toggleVisibilityButton: false
                            }
                        },
                        toolOptions: {
                            position: 'bottom',
                            positionType: 'outside',
                            compactType: 'scrollable',
                            hidden: false,
                            toggleVisibilityButton: false,
                            fullscreenMode: {
                                position: 'bottom',
                                compactType: 'popup',
                                hidden: false,
                                toggleVisibilityButton: false
                            }
                        },
                        settings: {
                            position: 'right',
                            positionType: 'outside',
                            compactType: 'scrollable',
                            hidden: false,
                            toggleVisibilityButton: false,
                            fullscreenMode: {
                                position: 'bottom',
                                hidden: true,
                                toggleVisibilityButton: true
                            }
                        }
                    },
                    align: 'inline',
                }, this.getCanvasWidth(), this.getCanvasHeight());

                $('#canvas-editor').append(canvas.getHtml());
                canvas.onInsert();
                canvas.api.startEditing();
            },
            getCanvasWidth() {
                //var viewportWidth = $(window).width();
                var canvasWidth = $("#canvas-editor").width();
                /////return canvasWidth *.9;
                return 595
            },
            getCanvasHeight() {
                var viewportHeight = $(window).height();
                var height = viewportHeight / 2;
                /////return height;
                return 842;
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
<style scoped>
    #canvas-template-container {
        overflow:hidden !important;
    }
</style>