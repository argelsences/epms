<template>
    <v-app>
        <div class="text-h4 text-left">Events</div>
        <div class="text-subtitle-1 text-left">You can manage your events here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog"  width="80%" scrollable fullscreen hide-overlay>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Event</v-btn>
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
                                                    <div class="text-h4  text-left mt-10">Department</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h4 text-left mt-10">Details</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-text-field v-model="editedItem.title" label="Title" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-chip class="mb-6">
                                                        <v-icon left>mdi-face-profile</v-icon>
                                                        Synopsis
                                                    </v-chip>
                                                    <tiptap-vuetify
                                                        v-model="editedItem.synopsis"
                                                        :extensions="extensions"
                                                        id="synopsis"
                                                        min-height="400"
                                                    ></tiptap-vuetify>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <v-textarea counter label="Excerpt" v-model="editedItem.excerpt" :rules=[rules.limitCharacters] prepend-icon="mdi-face-profile" hint="Limit to 150 characters only" persisten-hint></v-textarea>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h4  text-left mt-10">Dates</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-menu ref="st_menu" v-model="st_menu" :close-on-content-click="false" :return-value.sync="start_date" transition="scale-transition" offset-y min-width="290px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field v-model="start_date" label="Start Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="start_date" no-title scrollable>
                                                            <v-spacer></v-spacer>
                                                            <v-btn text color="primary" @click="st_menu = false">
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn text color="primary" @click="$refs.st_menu.save(start_date)" >
                                                                OK
                                                            </v-btn>
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-dialog ref="stt_dialog" v-model="stt_dialog" :return-value.sync="start_time" persistent width="290px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field v-model="start_time" label="Start Time" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-time-picker v-if="stt_dialog" v-model="start_time" full-width>
                                                            <v-spacer></v-spacer>
                                                            <v-btn text color="primary" @click="stt_dialog = false">
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn text color="primary" @click="$refs.stt_dialog.save(start_time)">
                                                                OK
                                                            </v-btn>
                                                        </v-time-picker>
                                                    </v-dialog>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-menu ref="se_menu" v-model="se_menu" :close-on-content-click="false" :return-value.sync="end_date" transition="scale-transition" offset-y min-width="290px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field v-model="end_date" label="End Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="end_date" no-title scrollable :min="start_date">
                                                        <v-spacer></v-spacer>
                                                            <v-btn text color="primary" @click="se_menu = false" > Cancel</v-btn>
                                                            <v-btn text color="primary" @click="$refs.se_menu.save(end_date)" >
                                                                OK
                                                            </v-btn>
                                                        </v-date-picker>
                                                    </v-menu>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="6">
                                                    <v-dialog ref="ste_dialog" v-model="ste_dialog" :return-value.sync="end_time" persistent width="290px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field v-model="end_time" label="End Time" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-time-picker v-if="ste_dialog" v-model="end_time" full-width>
                                                            <v-spacer></v-spacer>
                                                            <v-btn text color="primary" @click="ste_dialog = false">
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn text color="primary" @click="$refs.ste_dialog.save(end_time)">
                                                                OK
                                                            </v-btn>
                                                        </v-time-picker>
                                                    </v-dialog>
                                                </v-col>
                                            </v-row>
                                            <!--
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h4  text-left mt-10">Page</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea counter label="Pre booking display message" v-model="editedItem.pre_booking_display_message" prepend-icon="mdi-face-profile"></v-textarea>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-textarea counter label="Post booking display message" v-model="editedItem.post_booking_display_message" prepend-icon="mdi-face-profile"></v-textarea>
                                                </v-col>
                                            </v-row>
                                            -->
                                            <!--
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h4  text-left mt-10">Social Media</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-switch label="Facebook" prepend-icon="mdi-facebook" v-model="editedItem.social_show_facebook"></v-switch>
                                                    <v-switch label="Linkedin" prepend-icon="mdi-linkedin" v-model="editedItem.social_show_linkedin"></v-switch>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-switch label="Twitter" prepend-icon="mdi-twitter" v-model="editedItem.social_show_twitter"></v-switch>
                                                    <v-switch label="Whatsapp" prepend-icon="mdi-whatsapp" v-model="editedItem.social_show_whatsapp"></v-switch>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="4">
                                                    <v-switch label="Email" prepend-icon="mdi-email" v-model="editedItem.social_show_email"></v-switch>
                                                </v-col>
                                            </v-row>
                                            -->
                                            <v-row>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="12">
                                                            <div class="text-h4 text-left mt-10">Venue</div>
                                                            <v-divider />
                                                        </v-col>
                                                  
                                                        <v-col cols="12" sm="12" md="12">
                                                            <v-row>
                                                                <v-col cols="8" sm="8" md="8">
                                                                    <v-autocomplete v-model="editedItem.venue_id" :items="venues" item-text="name" item-value="id"  label="Venue" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                                </v-col>
                                                                <v-col cols="4" sm="4" md="4">
                                                                    <v-dialog v-model="dialog2" persistent max-width="600px">
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Venue</v-btn>
                                                                        </template>
                                                                        <v-card>
                                                                            <v-card-title>
                                                                            <span class="headline">New Venue</span>
                                                                            </v-card-title>
                                                                            <v-card-text>
                                                                                <v-container>
                                                                                    <v-row>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-text-field label="Name" required v-model="venue.name" hint="*Required" persistent-hint></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-text-field label="Address line 1" hint="*Required" required persistent-hint v-model="venue.address_line_1"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-text-field label="Address line 2" v-model="venue.address_line_2"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="4" md="4">
                                                                                            <v-text-field label="Postcode" required v-model="venue.postcode"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="4" md="4">
                                                                                            <v-text-field label="State" v-model="venue.state"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="4" md="4">
                                                                                            <v-select :items="countries" label="Country" item-text="name" item-value="name" v-model="venue.country"  prepend-icon="mdi-earth"></v-select>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" text @click="dialog2 = false">
                                                                                    Close
                                                                                </v-btn>
                                                                                <v-btn color="blue darken-1" text @click="dialog2 = false">
                                                                                    Save
                                                                                </v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>
                                                                </v-col>
                                                            </v-row>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="12">
                                                            <div class="text-h4  text-left mt-10">Speaker</div>
                                                            <v-divider />
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="12">
                                                            <v-row>
                                                                <v-col cols="8" sm="8" md="8">
                                                                    <v-autocomplete v-model="editedItem.speakers" :items="speakers" prepend-icon="mdi-office-building" filled chips color="blue-grey lighten-2" label="Select" item-text="name" item-value="id" multiple>
                                                                        <template v-slot:selection="data">
                                                                            <v-chip v-bind="data.attrs" :input-value="data.selected">
                                                                                <v-avatar left>
                                                                                    <v-img :src="base_url + data.item.photo"></v-img>
                                                                                </v-avatar>
                                                                                {{ data.item.name }}
                                                                            </v-chip>
                                                                        </template>
                                                                        <template v-slot:item="data">
                                                                            <template v-if="typeof data.item !== 'object'">
                                                                                <v-list-item-content v-text="data.item"></v-list-item-content>
                                                                            </template>
                                                                            <template v-else>
                                                                                <v-list-item-avatar>
                                                                                    <img :src="base_url + data.item.photo">
                                                                                </v-list-item-avatar>
                                                                                <v-list-item-content>
                                                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                                    <!--<v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle>-->
                                                                                </v-list-item-content>
                                                                            </template>
                                                                        </template>
                                                                    </v-autocomplete>
                                                                </v-col>
                                                                <v-col cols="4" sm="4" md="4">
                                                                    <v-dialog v-model="dialog3" persistent max-width="600px">
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Speaker</v-btn>
                                                                        </template>
                                                                        <v-card>
                                                                            <v-card-title>
                                                                            <span class="headline">New Speaker</span>
                                                                            </v-card-title>
                                                                            <v-card-text>
                                                                                <v-container>
                                                                                    <v-row>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-text-field label="Name" hint="*Required" persistent-hint required v-model="speaker.name"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-textarea counter label="Profile" required v-model="speaker.profile"></v-textarea>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-text-field label="Photo" hint="example of helper text only on focus" v-model="speaker.photo"></v-text-field>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12">
                                                                                            <v-autocomplete v-model="speaker.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" text @click="dialog3 = false">
                                                                                    Close
                                                                                </v-btn>
                                                                                <v-btn color="blue darken-1" text @click="dialog2 = false">
                                                                                    Save
                                                                                </v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>
                                                                </v-col>
                                                            </v-row>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                            <!-- This should be on another tab
                                            <v-row>
                                                <v-col cols="12" sm="12" md="12">
                                                    <div class="text-h4  text-left mt-10">Poster</div>
                                                    <v-divider />
                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    <v-dialog
                                                    v-model="dialog2"
                                                    fullscreen
                                                    hide-overlay
                                                    transition="dialog-bottom-transition"
                                                    >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn
                                                        color="#1f4068"
                                                        dark
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        >
                                                        Select Template
                                                        </v-btn>
                                                    </template>
                                                    <v-card>
                                                        <v-toolbar
                                                        dark
                                                        color="primary"
                                                        >
                                                        <v-btn
                                                            icon
                                                            dark
                                                            @click="dialog2 = false"
                                                        >
                                                            <v-icon>mdi-close</v-icon>
                                                        </v-btn>
                                                        <v-toolbar-title>Templates</v-toolbar-title>
                                                        <v-spacer></v-spacer>
                                                        <v-toolbar-items>
                                                            <v-btn
                                                            dark
                                                            text
                                                            @click="setTemplateChoice"
                                                            >
                                                            Save your choice
                                                            </v-btn>
                                                        </v-toolbar-items>
                                                        </v-toolbar>
                                                        <v-list
                                                        three-line
                                                        subheader
                                                        >
                                                            <v-list-item-group
                                                                v-model="selectedItem"
                                                                color="primary"
                                                            >
                                                                <v-row>
                                                                <v-col cols="4" sm="12" md="4" v-for="(item, i) in templates"
                                                                :key="i">
                                                                <v-list-item>
                                                                
                                                                <v-list-item-icon>
                                                                    <v-icon v-text="item.icon"></v-icon>
                                                                </v-list-item-icon>
                                                                <v-list-item-content>
                                                                    <v-list-item-title v-text="item.name"></v-list-item-title>
                                                                </v-list-item-content>
                                                                
                                                                </v-list-item>
                                                                </v-col>
                                                                </v-row>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-card>
                                                    </v-dialog>


                                                </v-col>
                                                <v-col cols="12" sm="12" md="6">
                                                    upload poster
                                                </v-col>
                                            </v-row>
                                            -->
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
                <template v-slot:item.title="{ item }">
                    <p class="text-subtitle-1">
                        <strong>{{item.title}}</strong>
                    </p>
                </template>
                <template v-slot:item.start_date="{ item }">
                    <p>{{item.start_date | formatDate}}</p>
                </template>
                <template v-slot:item.venue="{ item }">
                    <p class="pt-5">
                        <strong>{{item.venue.name}}</strong><br />
                        {{item.venue.address_line_1}}<br />
                        {{item.venue.address_line_2}}<br />
                        {{item.venue.state}} {{item.venue.country}} {{item.venue.postcode}}
                    </p>
                </template>
                <template v-slot:item.is_public="{ item }">
                    <p class="pt-5">
                        {{isPublic(item.is_public)}}
                    </p>
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
    import moment from 'moment'
    export default {
        // specify TiptapVuetify component in "components"
        components: { TiptapVuetify },
        mounted() {
            console.log('Component mounted');
        },
        data() {
            return {
                dialog: false,
                dialog2: false,
                dialog3: false,
                st_menu: false,
                se_menu: false,
                stt_dialog:false,
                ste_dialog: false,
                isValid: true,
                search : '',
                feedbacks: [],
                rows: [],
                departments: [],
                venues: [],
                speakers: [],
                editedIndex: -1,
                snackbar: false,
                timeout: 5000,
                error: false,
                photo: null,
                base_url: window.location.origin + '/',
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
                start_time: '00:00',
                end_time: '00:00',
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
                settings: [],
                rules: {
                    required: (v) => !!v || 'Required.',
                    /////min: (v) => v && v.length >= 8 || 'Minimum of 8 characters.',
                    emailValid: (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
                    phoneValid: (v) => !v || /^(?=.*[0-9])[- +()x0-9]+$/.test(v) || 'Tel. # must be valid',
                    urlValid: (v) => !v || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(v) || 'URL must be valid',
                    limitFileSize: (v) => !v || v.size < 2000000 || 'Logo size should be less than 2 MB!',
                    limitFileSizeMultiple: files => !files || !files.some(file => file.size > 2e6) || 'Avatar size should be less than 2 MB!',
                    limitCharacters: (v) => (v || '' ).length <= 150 || 'Excerpt must be 150 characters or less',
                },
                headers: [
                    {text: 'Title', value: 'title'},
                    {text: 'Date', value: 'start_date'},
                    {text: 'Venue', value: 'venue'},
                    {text: 'Status', value: 'is_public'},
                    {text: 'Actions', value: 'actions', sortable: false },
                ],
                editedItem: {
                    id: 0,
                    title: '',
                    synopsis: '',
                    excerpt: '',
                    start_date: '',
                    end_date: '',
                    //pre_booking_display_message: '',
                    //post_booking_display_message: '',
                    social_show_facebook: 0,
                    social_show_twitter: 0,
                    social_show_whatsapp: 0,
                    social_show_email: 0,
                    social_show_linkedin: 0,
                    is_public: 0,
                    is_approved: 0,
                    for_approval: 0,
                    barcode_type: 'QRCODE',
                    checkout_timeout: 0,
                    department_id: 0,
                    created_by: 0,
                    edited_by: 0,
                    venue: [],
                    speakers: [],
                },
                defaultItem: {
                    id: 0,
                    title: '',
                    synopsis: '',
                    excerpt: '',
                    start_date: '',
                    end_date: '',
                    //pre_booking_display_message: '',
                    //post_booking_display_message: '',
                    social_show_facebook: 0,
                    social_show_twitter: 0,
                    social_show_whatsapp: 0,
                    social_show_email: 0,
                    social_show_linkedin: 0,
                    is_public: 0,
                    is_approved: 0,
                    for_approval: 0,
                    barcode_type: 'QRCODE',
                    checkout_timeout: 0,
                    department_id: 0,
                    created_by: 0,
                    edited_by: 0,
                    venue: [],
                    speakers: [],
                },
                textFieldProps: {
                    appendIcon: 'event',
                    label: 'sdfsdfsdfsdf'
                },
                dateProps: {
                    headerColor: 'cyan darken-2'
                },
                venue: {
                    name: '',
                    address_line_1: '',
                    address_line_2: '',
                    postcode: '',
                    country: '',
                    state: '',
                },
                speaker: {
                    name: '',
                    profile: '',
                    photo: null,
                    department_id: 0,
                },
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Event' : 'Edit Event'
            },
        },
        watch: {
            dialog (val) {
                // if val is true, then statement is true, if not the default value is this.close
                // eg. the_title = title || "Error"; if title is true, the the value of the_title is the value of title, else the value of the_title is "Error"

                // set default values from settings
                if (val && this.editedIndex === -1){
                    this.editedItem.social_show_linkedin = this.settings.is_linkedin
                    this.editedItem.social_show_twitter = this.settings.is_twitter
                    this.editedItem.social_show_whatsapp = this.settings.is_whatsapp
                    this.editedItem.social_show_email = this.settings.is_email
                    this.editedItem.social_show_facebook = this.settings.is_facebook
                }
                val || this.close()
            },
        },
        methods: {
            initialize: function() {
                axios.get('/api/events')
                .then( response => {
                    this.rows = response.data;
                    console.log(this.rows)
                });
            },
            getDepartments: function() {
                axios.get('/api/departments')
                .then( response => {
                    this.departments = response.data;
                });
            },
            getSettings: function() {
                axios.get('/api/settings')
                .then( response => {
                    this.settings = response.data
                });
            },
            getVenues: function() {
                axios.get('/api/venues')
                .then( response => {
                    this.venues = response.data;
                });
            },
            getSpeakers: function() {
                axios.get('/api/speakers')
                .then( response => {
                    this.speakers = response.data;
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
                let eventStartDate = new Date(this.editedItem.start_date)
                let eventEndDate = new Date(this.editedItem.end_date)
                this.start_date = eventStartDate.toISOString().substr(0, 10)
                this.start_time = String(eventStartDate.getHours()).padStart(2, '0') + ":" + String(eventStartDate.getMinutes()).padStart(2, '0')
                this.end_date = eventEndDate.toISOString().substr(0, 10)
                this.end_time = String(eventEndDate.getHours()).padStart(2, '0') + ":" + String(eventEndDate.getMinutes()).padStart(2, '0')
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
                this.editedItem.start_date = this.start_date + ' ' + this.start_time
                this.editedItem.end_date = this.end_date + ' ' + this.end_time

                //console.log(this.editedItem )

                axios.post('/api/events/upsert', {
                    payload: this.editedItem,
                })
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for ' + editedItem.title + ' is saved.'
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

                        console.log(this.rows)

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
                document.title = 'Events - Event Publication and Poster Management System (EPPMS)';
            },
            addDropFile(e) { 
                this.file = e.dataTransfer.files[0]
                //console.log(this.file) 
            },
            isPublic(value){
                return (value) ? 'Public' : 'Private'
            },
        },
        created: function() {
            this.setHedeaderTitle()
            this.initialize()
            this.getSettings()
            this.getDepartments()
            this.getVenues()
            this.getSpeakers()
            this.getCountries()
        },
    }
</script>