<template>
    <v-app>
        <div class="text-h5 text-left">Events</div>
        <div class="text-subtitle-1 text-left">You can manage your events here</div>
        <v-divider></v-divider>
        <v-card>
            <v-data-table :headers="headers" :items="rows" :search="search" :items-per-page="20" sort-by="name" :loading="isLoading" :loading-text="loadingText">
                <template v-slot:top>
                    <!-- the toolbar -->
                    <v-toolbar flat color="white">
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                        <v-spacer></v-spacer>
                        <!-- the dialog box -->        
                        <v-dialog v-model="dialog" persistent scrollable fullscreen hide-overlay>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Event</v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <!-- formTitle is  a computed property based on action edit or new -->
                                    <v-list-item two-line>
                                        <v-list-item-content>
                                            <v-list-item-title class="headline">
                                                {{ formTitle }}
                                                <v-tooltip right>
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn icon color="pink" @click="eventURL(false)">
                                                            <v-icon>
                                                                mdi-eye
                                                            </v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Event Page</span>
                                                </v-tooltip>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ eventTitle }}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-spacer />
                                    <v-btn absolute dark fab middle right color="pink" @click="close">
                                        <v-icon x-large>mdi-close</v-icon>
                                    </v-btn>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text class="pt-0">
                                    <v-container>
                                        <v-tabs vertical v-model="active_tab" color="cyan darken-4">
                                            <v-tab class="pa-8" >
                                                <v-icon left>mdi-cog</v-icon>
                                                Details
                                            </v-tab>
                                            <v-tab class="pa-8" :disabled="tabDisable">
                                                <v-icon left>mdi-image</v-icon>
                                                Poster
                                            </v-tab>
                                            <v-tab class="pa-8" :disabled="tabDisable">
                                                <v-icon left>mdi-ticket-confirmation-outline</v-icon>
                                                Ticket
                                            </v-tab>
                                            <v-tab class="pa-8" :disabled="tabDisable">
                                                <v-icon left>mdi-ticket-confirmation</v-icon>
                                                Booking
                                            </v-tab>
                                            <v-tab class="pa-8" :disabled="tabDisable">
                                                <v-icon left>mdi-ticket-account</v-icon>
                                                Attendee
                                            </v-tab>
                                            <!-- -->
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text class="pt-0">
                                                        <v-form v-model="isValid" ref="form">
                                                            <v-row>
                                                                <v-col cols="12" sm="12" md="12" class="d-flex justify-end">
                                                                    <div class="d-inline-block">
                                                                        <v-switch dense :label="isPublic(editedItem.is_public)" :prepend-icon="eventPublic" v-model="editedItem.is_public" class="mr-5"></v-switch>
                                                                    </div>
                                                                    <div class="d-inline-block">
                                                                        <v-switch dense :label="isApproved(editedItem.is_approved)" :prepend-icon="eventApprove" v-model="editedItem.is_approved" ></v-switch>
                                                                    </div>
                                                                    
                                                                </v-col>
                                                            </v-row>
                                                            <!--1 -->
                                                            <v-row v-if="isSuperAdmin">
                                                                <v-col cols="12" sm="12" md="12">
                                                                    <div class="text-h5  text-left">Department</div>
                                                                    <v-divider />
                                                                </v-col>
                                                                <v-col cols="12" sm="12" md="6">
                                                                    <v-autocomplete v-model="editedItem.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                                </v-col>
                                                                <v-col cols="12" sm="12" md="6">
                                                                </v-col>
                                                            </v-row>
                                                            <!--1 -->
                                                            <v-row>
                                                                <v-col cols="12" sm="12" md="12">
                                                                    <div class="text-h5 text-left mt-10">Details</div>
                                                                    <v-divider />
                                                                </v-col>
                                                                <v-col cols="12" sm="12" md="12">
                                                                    <v-text-field v-model="editedItem.title" label="Title" :rules="[rules.required]" prepend-icon="mdi-information" ></v-text-field>
                                                                </v-col>
                                                            </v-row>
                                                            <!-- -->
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
                                                            <!-- -->
                                                            <v-row>
                                                                <v-col cols="12" sm="12" md="12">
                                                                    <v-textarea counter label="Excerpt" v-model="editedItem.excerpt" :rules=[rules.limitCharacters] prepend-icon="mdi-face-profile" hint="Limit to 150 characters only" persisten-hint></v-textarea>
                                                                </v-col>
                                                            </v-row>
                                                            <!-- -->
                                                            <v-row>
                                                                <v-col cols="12" sm="12" md="12">
                                                                    <div class="text-h5  text-left mt-10">Dates</div>
                                                                    <v-divider />
                                                                </v-col>
                                                                <v-col cols="12" sm="12" md="6">
                                                                    <v-menu ref="st_menu" v-model="st_menu" :close-on-content-click="false" :return-value.sync="start_date" transition="scale-transition" offset-y min-width="290px">
                                                                        <template v-slot:activator="{ on, attrs }">
                                                                            <v-text-field  :label="computedStartDateFormatted" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" hint="Start Date" persistent-hint></v-text-field>
                                                                        </template>
                                                                        <v-date-picker v-model="start_date" @change="updateEndDate($event)">
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
                                                                            <v-text-field :label="computedStartTimeFormatted" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" hint="Start Time" persistent-hint></v-text-field>
                                                                        </template>
                                                                        <v-time-picker v-if="stt_dialog" v-model="start_time" full-width @input="updateEndTime($event)">
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
                                                                            <v-text-field :label="computedEndDateFormatted"  prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" hint="End Date" persistent-hint></v-text-field>
                                                                        </template>
                                                                        <v-date-picker v-model="end_date" :min="start_date">
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
                                                                            <v-text-field :label="computedEndTimeFormatted" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" hint="End Time" persistent-hint></v-text-field>
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
                                                            <v-row>
                                                                <!-- 2 -->
                                                                <v-col cols="12" sm="12" md="6">
                                                                    <v-row>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <div class="text-h5 text-left mt-10">Venue</div>
                                                                            <v-divider />
                                                                        </v-col>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <v-row>
                                                                                <v-col cols="8" sm="8" md="8">
                                                                                    <v-autocomplete v-model="editedItem.venue_id" :items="venues" item-text="name" item-value="id"  label="Venue" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                                                                                </v-col>
                                                                                <v-col cols="4" sm="4" md="4">
                                                                                    <v-btn color="#1f4068" class="white--text" @click="dialog2 = true"><i class="material-icons ">add_box</i> Venue</v-btn>
                                                                                </v-col>
                                                                            </v-row>
                                                                        </v-col>
                                                                    </v-row>
                                                                </v-col>
                                                                <!-- -->
                                                                <v-col cols="12" sm="12" md="6">
                                                                    <v-row>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <div class="text-h5  text-left mt-10">Speakers</div>
                                                                            <v-divider />
                                                                        </v-col>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <v-row>
                                                                                <v-col cols="8" sm="8" md="8">
                                                                                    <v-autocomplete v-model="editedItem.speakers" :items="speakers" prepend-icon="mdi-office-building"  chips color="blue-grey lighten-2" label="Select" item-text="name" item-value="id" multiple>
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
                                                                                    <v-btn color="#1f4068" class="white--text" @click="openSpeakerDialog"><i class="material-icons ">add_box</i> Speaker</v-btn>
                                                                                </v-col>
                                                                            </v-row>
                                                                        </v-col>
                                                                    </v-row>
                                                                </v-col>
                                                            </v-row>
                                                        </v-form>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>
                                            <!-- -->
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text class="pt-0">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <div class="text-h5  text-left">How do you want to create your poster?</div>
                                                                <v-divider />
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12" sm="8" md="8">
                                                                <v-row>
                                                                    <v-col cols="12" sm="12" md="12">
                                                                        <v-alert icon="mdi-alert-circle-outline" prominent text type="warning">
                                                                            Uploading or generating a new file will replace the existing poster.
                                                                        </v-alert>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row>
                                                                    <v-col cols="12" sm=12 md="12">
                                                                        <div class="text-h6  text-left mb-2">Upload a poster file</div>
                                                                        <v-form v-model="isValid5" ref="posterForm">
                                                                            <!--<v-file-input v-model="poster" class="mb-8" accept="image/png, image/jpeg, image/bmp, image/jpg" :rule="[rules.limitFileSize]" clearable placeholder="Click to upload" 
                                                                                prepend-icon="mdi-camera-iris" label="Poster File" persistentHint chips
                                                                                hint="Uploading a new file will replace the existing poster. Only accepting JPG/PNG/BMP files. File size should not be greater than 2MB"
                                                                                ref="posterUpload"
                                                                                
                                                                            >
                                                                            </v-file-input>-->
                                                                            <div>
                                                                                <v-btn color="primary" class="text-none" rounded  depressed :loading="isSelecting" @click="onButtonClick">
                                                                                    <v-icon left>cloud_upload</v-icon>
                                                                                    {{ uploadButtonText }}
                                                                                </v-btn>
                                                                                <input ref="uploader" class="d-none" type="file" accept="image/png, image/jpeg, image/bmp, image/jpg" @change="onFileChanged">
                                                                                <div class="text-caption pl-2">Only accepts JPG/PNG/BMP files. File size should not be greater than 2MB</div>
                                                                            </div>
                                                                            
                                                                            <v-row>
                                                                                <v-col>
                                                                                    <!--<v-chip class="ma-2 white--text poster-file-name" v-if="poster.file_path && !poster.template_id" color="blue darken-1" @click="deletePoster">
                                                                                        <v-icon left>mdi-trash-can</v-icon> 
                                                                                        <span>{{posterFilePath()}}</span>
                                                                                    </v-chip>-->
                                                                                </v-col>
                                                                                <v-spacer></v-spacer>
                                                                                <v-col>
                                                                                    <v-btn text depressed :loading="isSelecting" class="float-right" :disabled="uploadReady" @click="uploadPoster">Upload Poster</v-btn>
                                                                                </v-col>
                                                                            </v-row>
                                                                            <!--
                                                                            <v-spacer></v-spacer>
                                                                            <div>
                                                                                <v-btn text depressed :loading="isSelecting" class="float-right" :disabled="uploadReady" @click="uploadPoster">Upload Poster</v-btn>
                                                                            </div>
                                                                            -->
                                                                        </v-form>
                                                                    </v-col>
                                                                    <v-col cols="12" sm="12" md="12">
                                                                        <div class="text-h6  text-left mb-10 mt-10">
                                                                            Or, select from the list of templates to generate a poster
                                                                        </div>
                                                                        <!-- template lists -->
                                                                        <v-row>
                                                                            <v-col cols="12" sm="4" md="4" v-for="(template, i) in templateRows" :key="template.id" class="text-center">
                                                                                <v-lazy v-model="isActive" :options="{threshold: .8}" min-height="200" transition-group="fade-transition">
                                                                                    <v-card class="mx-auto" max-width="180" @click="selectTemplate(template.id)">
                                                                                        <v-img class="white--text align-end"  :src="`/web-admin/templates/screenshot/${template.id}?rnd=${cacheKey}`" :lazy-src="`${base_url}images/eppms.png?rnd=${cacheKey}`">
                                                                                            <v-card-title  class="text-left secondary opacity-half" elevation=24>{{template.name}}</v-card-title>
                                                                                        </v-img>
                                                                                        <v-card-text class="text--primary" >
                                                                                            <div class="text-caption">{{template.description}}</div>
                                                                                        </v-card-text>
                                                                                        <v-card-actions>
                                                                                            <div class="d-flex justify-end">
                                                                                                <v-icon color="success" v-if="selectedTemplate === template.id">mdi-check-circle</v-icon>
                                                                                            </div>
                                                                                        </v-card-actions>
                                                                                     </v-card>
                                                                                </v-lazy>
                                                                                <v-btn color="primary" class="ma-2 white--text" @click.stop="imageDialogUrl(template.id)">
                                                                                    Preview
                                                                                    <v-icon left dark class="ml-2">
                                                                                        mdi-magnify
                                                                                    </v-icon>
                                                                                </v-btn>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <span v-if="generatingPoster" class="red--text">Generating posters, please do not refresh the page</span>
                                                                                <v-btn text depressed :loading="generatingPoster"  class="float-right" :disabled="!selectedTemplate" @click="generatePoster">Generate Poster</v-btn>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-dialog v-model="templatePreview" hide-overlay  scrollable fullscreen>
                                                                            <v-card tile>
                                                                                <v-card-text>
                                                                                    <v-container fill-height>
                                                                                        <v-row justify="center" align="center">
                                                                                            <v-col cols="12" sm="4">
                                                                                                <v-img :src="theImageSrc" @error="imageUrl='alt-image.jpg'" height="auto" ></v-img>
                                                                                            </v-col>
                                                                                        </v-row>
                                                                                    </v-container> 
                                                                                </v-card-text>
                                                                                <v-card-actions>
                                                                                    <v-spacer></v-spacer>
                                                                                    <v-btn absolute dark fab top right color="pink" class="mt-10" @click="templatePreview=false">
                                                                                        <v-icon x-large>mdi-close</v-icon>
                                                                                    </v-btn>
                                                                                </v-card-actions>
                                                                            </v-card>
                                                                        </v-dialog>
                                                                        <!-- template lists -->
                                                                    </v-col>
                                                                </v-row>
                                                            </v-col>
                                                            <v-col cols="12" sm="4" md="4" >
                                                                <v-card outlined min-height="500px">
                                                                    <v-card-title>
                                                                        Poster Preview
                                                                    </v-card-title>
                                                                    <v-card-text class="align-self-center">
                                                                        <v-img v-if="poster.file_path" :src="`${base_url}${poster.file_path}?rnd=${cacheKey}`" alt="" aspect-ratio=".7" ></v-img>
                                                                        <v-icon size=200 v-else class="d-flex justify-center no-poster-icon">mdi-image</v-icon>
                                                                    </v-card-text>
                                                                    <v-card-actions v-if="poster.file_path">
                                                                        <v-spacer></v-spacer>
                                                                        <v-select dense :items="posterFormats" v-model="selectedFormat" label="Output Format"></v-select>
                                                                        <v-btn color="primary" class="text-none" text depressed  download :href="downloadPoster()">
                                                                            <v-icon left>mdi-download</v-icon>
                                                                            DOWNLOAD
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                </v-card>
                                                            </v-col>
                                                        </v-row>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text class="pt-0">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-btn color="#1f4068" class="white--text float-right" @click="openTicketDialog"><i class="material-icons ">add_box</i> Ticket</v-btn>
                                                            </v-col>
                                                        </v-row>
                                                        <v-divider />
                                                        <v-row dense>
                                                            <v-col cols="12" sm="6" md="4" v-for="ticket in tickets" :key="ticket.id">
                                                                <v-card class="mb-5">    
                                                                    <div class="ticket-header cyan darken-4 text-white" @click="editTicket(ticket)">
                                                                        <v-card-subtitle class="pb-0 text-white" >FREE</v-card-subtitle>
                                                                        <v-card-title class="headline pt-0">{{ticket.title}}</v-card-title>
                                                                    </div>
                                                                    <v-card-text>
                                                                        <div class="d-flex flex-no-wrap justify-space-between pa-5 pb-0">
                                                                            <div class="text-center">
                                                                                <p class="text-lg-h4">{{ticket.quantity_booked}}</p>
                                                                                <p class="text-caption text--secondary">BOOKED</p>
                                                                            </div>
                                                                            <v-divider vertical />
                                                                            <div class="text-center">
                                                                                <p class="text-lg-h4">{{ticket.quantity_available - ticket.quantity_booked}}</p>
                                                                                <p class="text-caption text--secondary">REMAINING</p>
                                                                            </div>
                                                                        </div>
                                                                    </v-card-text>
                                                                    <v-card-actions>
                                                                        <v-spacer></v-spacer>
                                                                        <v-btn class="ml-2 mt-3" fab icon height="40px" right width="40px" @click="ticketPause(ticket.id)">
                                                                            <!--<v-icon>{{`mdi-${ticket_icon}`}}</v-icon>-->
                                                                            <v-icon v-if="ticket.is_paused">mdi-pause</v-icon>
                                                                            <v-icon v-else>mdi-play</v-icon>
                                                                        </v-btn>
                                                                        <v-btn class="ml-2 mt-5" outlined rounded small>
                                                                            <div v-if="ticket.is_paused" class="pink--text">Paused</div>
                                                                            <div v-else class="cyan--text darken-4">Online</div>
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                </v-card>
                                                            </v-col>
                                                        </v-row>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text class="pt-0">
                                                        <!-- theBooking -->
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-btn small color="#1f4068" class="white--text" :href="`/web-admin/bookings/export-to-csv/${editedItem.id}`"><v-icon class="mr-2">mdi-export</v-icon>Export bookings to CSV</v-btn>
                                                            </v-col>
                                                        </v-row>
                                                        <v-data-table :headers="bookingHeaders" :items="bookingRows" :search="search" :items-per-page="20" sort-by="name" class="booking-data-table">
                                                            <template v-slot:top>
                                                                <!-- the toolbar -->
                                                                <v-toolbar flat color="white">
                                                                    <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                                                                    <v-spacer></v-spacer>
                                                                    <!-- the dialog box -->
                                                                    <v-dialog v-model="booking_cancel_dialog"  max-width="600px" scrollable>
                                                                        <v-card>
                                                                            <v-card-title color="primary">
                                                                                
                                                                                <span class="headline"><v-icon>mdi-cart</v-icon> Cancel Booking Attendee: {{editedBookingItem.booking_reference}}</span>
                                                                                <v-spacer></v-spacer>
                                                                                <!--<v-btn absolute dark fab middle right color="pink" @click="closeCancelBooking">
                                                                                    <v-icon>mdi-close</v-icon>
                                                                                </v-btn>-->
                                                                            </v-card-title>
                                                                            <v-divider></v-divider>
                                                                            <v-card-text>
                                                                                <v-container>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-simple-table v-if="Array.isArray(editedBookingItem.attendees) && editedBookingItem.attendees.length > 0 ">
                                                                                                <template v-slot:default>
                                                                                                    <tbody>
                                                                                                        <tr v-for="(attendee, i) in editedBookingItem.attendees" :key="attendee.id">
                                                                                                            <td>{{attendee.first_name + " " + attendee.last_name}}</td>
                                                                                                            <td>{{attendee.email}}</td>
                                                                                                            <td>{{getTicketName(attendee.ticket_id) + " " + attendee.private_reference_number}}</td>
                                                                                                            <td><v-icon color="pink" small @click="cancelAttendee(i)">mdi-delete</v-icon></td>                                                                                                            
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </template>
                                                                                            </v-simple-table>
                                                                                            <v-alert icon="mdi-delete-empty-outline" prominent text type="info" v-else>
                                                                                                All attendees in this booking is cancelled.
                                                                                            </v-alert>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-divider></v-divider>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" text @click="closeCancelBooking">Close</v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>

                                                                    <!-- booking details dialog -->
                                                                    <v-dialog v-model="booking_details_dialog"  max-width="600px" scrollable>
                                                                        <v-card>
                                                                            <v-card-title color="primary">
                                                                                
                                                                                <span class="headline"><v-icon>mdi-cart</v-icon> Booking: {{editedBookingItem.booking_reference}}</span>
                                                                                <v-spacer></v-spacer>
                                                                                <!--<v-btn absolute dark fab middle right color="pink" @click="closeCancelBooking">
                                                                                    <v-icon>mdi-close</v-icon>
                                                                                </v-btn>-->
                                                                            </v-card-title>
                                                                            <v-divider></v-divider>
                                                                            <v-card-text>
                                                                                <v-container>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <span class="text-h6">Booking Details</span>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-simple-table>
                                                                                                <template v-slot:default>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="width:50%">
                                                                                                                <p class="text-subtitle-2">First Name</p>
                                                                                                                <p>{{editedBookingItem.first_name}}</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%">
                                                                                                                <p class="text-subtitle-2">Last Name</p>
                                                                                                                <p>{{editedBookingItem.last_name}}</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <p class="text-subtitle-2">Amount</p>
                                                                                                                <p>FREE</p>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <p class="text-subtitle-2">Reference</p>
                                                                                                                <p>{{editedBookingItem.booking_reference}}</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <p class="text-subtitle-2">Date</p>
                                                                                                                <p>{{editedBookingItem.created_at | formatDate}}</p>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <p class="text-subtitle-2">Email</p>
                                                                                                                <p>{{editedBookingItem.email}}</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </template>
                                                                                            </v-simple-table>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <span class="text-h6">Booking Items</span>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-simple-table>
                                                                                                <template v-slot:default>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th class="text-left" style="width:50%;">
                                                                                                                Ticket
                                                                                                            </th>
                                                                                                            <th class="text-left">
                                                                                                                Quantity
                                                                                                            </th>
                                                                                                            <th class="text-left">
                                                                                                                Price
                                                                                                            </th>
                                                                                                            <th class="text-left">
                                                                                                                Booking Fee
                                                                                                            </th>
                                                                                                            <th class="text-left">
                                                                                                                Total
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr v-for="(book_item,i) in editedBookingItem.book_items" :key="book_item.id">
                                                                                                            <td style="width:50%">
                                                                                                                <p>{{book_item.title}}</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%">
                                                                                                                <p>{{book_item.quantity}}</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%">
                                                                                                                <p>FREE</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%">
                                                                                                                <p>-</p>
                                                                                                            </td>
                                                                                                            <td style="width:50%">
                                                                                                                <p>FREE</p>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <b>Subtotal</b>
                                                                                                            </td>
                                                                                                            <td colspan="2">
                                                                                                                0.00
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <b>Total</b>
                                                                                                            </td>
                                                                                                            <td colspan="2">
                                                                                                                0.00
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </template>
                                                                                            </v-simple-table>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <span class="text-h6">Booking Attendees</span>
                                                                                        </v-col>
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-simple-table v-if="Array.isArray(editedBookingItem.attendees) && editedBookingItem.attendees.length > 0 ">
                                                                                                <template v-slot:default>
                                                                                                    <tbody>
                                                                                                        <tr v-for="(attendee, i) in editedBookingItem.attendees" :key="attendee.id">
                                                                                                            <td>{{attendee.first_name + " " + attendee.last_name}}</td>
                                                                                                            <td>{{attendee.email}}</td>
                                                                                                            <td>{{getTicketName(attendee.ticket_id) + " " + attendee.private_reference_number}}</td>                                                                                                           
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </template>
                                                                                            </v-simple-table>
                                                                                            <v-alert icon="mdi-delete-empty-outline" prominent text type="info" v-else>
                                                                                                All attendees in this booking is cancelled.
                                                                                            </v-alert>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-divider></v-divider>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" text @click="editBooking">Edit</v-btn>
                                                                                <v-btn color="blue darken-1" text :href="`/booking/${editedBookingItem.booking_reference}/tickets?download=1`" target="blank">Print Tickets</v-btn>
                                                                                <v-btn color="blue darken-1" text @click="resendBooking()">Resend Tickets</v-btn>
                                                                                <v-btn color="blue darken-1" text @click="closeDetailsBooking">Close</v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>
                                                                    <!-- booking details dialog -->

                                                                    <!-- booking edit dialog -->
                                                                    <v-dialog v-model="booking_edit_dialog"  max-width="600px" scrollable>
                                                                        <v-card>
                                                                            <v-card-title color="primary">
                                                                                <span class="headline"><v-icon>mdi-cart</v-icon> Edit Booking: {{editedBookingItem.booking_reference}}</span>
                                                                                <v-spacer></v-spacer>
                                                                                <!--<v-btn absolute dark fab middle right color="pink" @click="closeCancelBooking">
                                                                                    <v-icon>mdi-close</v-icon>
                                                                                </v-btn>-->
                                                                            </v-card-title>
                                                                            <v-divider></v-divider>
                                                                            <v-card-text>
                                                                                <v-container>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-form v-model="isValid6" ref="bookingForm">
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedBookingItem.first_name" label="First Name" :rules="[rules.required]" prepend-icon="mdi-account" ></v-text-field>
                                                                                                </v-col> 
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedBookingItem.last_name" label="Last Name" :rules="[rules.required]" prepend-icon="mdi-account" ></v-text-field>
                                                                                                </v-col>
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedBookingItem.email" label="Email" :rules="[rules.required]" prepend-icon="mdi-email" ></v-text-field>
                                                                                                </v-col>
                                                                                            </v-form>
                                                                                         </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-divider></v-divider>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" :disabled="!isValid6" text @click="updateBooking">Save</v-btn>
                                                                                <v-btn color="blue darken-1" text @click="closeEditBooking">Close</v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>
                                                                    <!-- the dialog box -->
                                                                </v-toolbar>
                                                            <!-- the toolbar -->
                                                            </template>
                                                            <template v-slot:item.booking_date="{ item }">
                                                                {{item.created_at | formatDate}}
                                                            </template>
                                                            <template v-slot:item.name="{ item }">
                                                                <!--<v-img v-if="item.photo" :src="base_url + item.photo" alt="" aspect-ratio=".7" max-height="100px" max-width="100px"></v-img>
                                                                <v-icon size="100px" v-else>mdi-account-box</v-icon>-->
                                                                {{item.first_name + ' ' + item.last_name}}
                                                            </template>
                                                            <template v-slot:item.amount="{ item }">
                                                                <!-- Event is always free at the moment -->
                                                                FREE
                                                            </template>
                                                            <template v-slot:item.reserve_status="{ item }">
                                                                {{item.reserve_status.name}}
                                                            </template>
                                                            <template v-slot:item.actions="{ item }">
                                                                <!--<v-icon color="error" small class="mr-2" @click="cancelBooking(item)">mdi-account-cancel</v-icon>
                                                                <v-icon color="pink" small class="mr-2" @click="cancelBooking(item)">mdi-cancel</v-icon>-->

                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-icon color="error" dark v-bind="attrs" v-on="on" small @click="removeBooking(item)">mdi-delete</v-icon>
                                                                    </template>
                                                                    <span>Cancel Booking</span>
                                                                </v-tooltip>

                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-icon color="pink" dark v-bind="attrs" v-on="on" small @click="cancelBooking(item)">mdi-account-cancel</v-icon>
                                                                    </template>
                                                                    <span>Cancel Attendees</span>
                                                                </v-tooltip>
                                                                
                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-icon color="primary" dark v-bind="attrs" v-on="on" small @click="detailsBooking(item)">mdi-information</v-icon>
                                                                    </template>
                                                                    <span>Booking Details</span>
                                                                </v-tooltip>
                                                            </template>
                                                            <template v-slot:no-data>
                                                                <v-btn class="btn btn-sm btn-primary" @click="initialize">Reset</v-btn>
                                                            </template>
                                                        </v-data-table>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>
                                            <!-- -->
                                            <!-- the attendee -->
                                            <v-tab-item>
                                                <v-card flat>
                                                    <v-card-text class="pt-0">
                                                        <v-row>
                                                            <v-col cols="12" sm="12" md="12">
                                                                <v-btn small color="#1f4068" class="white--text" :href="`/web-admin/attendees/export-to-csv/${editedItem.id}`"><v-icon class="mr-2">mdi-export</v-icon>Export Attendees to CSV</v-btn>
                                                                <v-btn small color="#1f4068" class="white--text" :href="`/web-admin/attendees/print/${editedItem.id}`" target="blank" ><v-icon class="mr-2">mdi-printer</v-icon>Print Attendees List</v-btn>                                                       
                                                            </v-col>
                                                        </v-row>
                                                        <v-data-table :headers="attendeeHeaders" :items="attendeeRows" :search="search" :items-per-page="20" sort-by="name" class="attendee-data-table">
                                                            <template v-slot:top>
                                                                <!-- the toolbar -->
                                                                <v-toolbar flat color="white">
                                                                    <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details ></v-text-field>
                                                                    <v-spacer></v-spacer>
                                                                    <!-- the dialog box -->
    
                                                                    <!-- attendee edit dialog -->
                                                                    <v-dialog v-model="attendee_edit_dialog"  max-width="600px" scrollable>
                                                                        <v-card>
                                                                            <v-card-title color="primary">
                                                                                
                                                                                <span class="headline"><v-icon>mdi-cart</v-icon> Edit Booking Attendee: {{editedBookingItem.booking_reference}}</span>
                                                                                <v-spacer></v-spacer>
                                                                                <!--<v-btn absolute dark fab middle right color="pink" @click="closeCancelBooking">
                                                                                    <v-icon>mdi-close</v-icon>
                                                                                </v-btn>-->
                                                                            </v-card-title>
                                                                            <v-divider></v-divider>
                                                                            <v-card-text>
                                                                                <v-container fluid>
                                                                                    <v-row >
                                                                                        <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                            <v-form v-model="isValid7" ref="attendeeForm" >
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedAttendeeItem.first_name" label="First Name" :rules="[rules.required]" prepend-icon="mdi-account" ></v-text-field>
                                                                                                </v-col> 
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedAttendeeItem.last_name" label="Last Name" :rules="[rules.required]" prepend-icon="mdi-account" ></v-text-field>
                                                                                                </v-col>
                                                                                                <v-col cols="12" sm="12" md="12" class="ma-2">
                                                                                                    <v-text-field v-model="editedAttendeeItem.email" label="Email" :rules="[rules.required]" prepend-icon="mdi-email" ></v-text-field>
                                                                                                </v-col>
                                                                                            </v-form>
                                                                                        </v-col>
                                                                                    </v-row>
                                                                                </v-container>
                                                                            </v-card-text>
                                                                            <v-divider></v-divider>
                                                                            <v-card-actions>
                                                                                <v-spacer></v-spacer>
                                                                                <v-btn color="blue darken-1" :disabled="!isValid7" text @click="updateAttendee">Save</v-btn>
                                                                                <v-btn color="blue darken-1" text @click="closeEditAttendee">Close</v-btn>
                                                                            </v-card-actions>
                                                                        </v-card>
                                                                    </v-dialog>
                                                                    <!-- the dialog box -->
                                                                </v-toolbar>
                                                            <!-- the toolbar -->
                                                            </template>
                                                            <template v-slot:item.name="{ item }">
                                                                {{item.first_name + ' ' + item.last_name}}
                                                            </template>
                                                            <template v-slot:item.ticket="{ item }">
                                                                {{item.ticket.title}}
                                                            </template>
                                                            <template v-slot:item.reference="{ item }">
                                                                {{item.book.booking_reference}}
                                                            </template>
                                                           
                                                            <template v-slot:item.actions="{ item }">
                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-icon color="primary" dark v-bind="attrs" v-on="on" small @click="editAttendee(item)">mdi-pencil</v-icon>
                                                                    </template>
                                                                    <span>Edit Attendee</span>
                                                                </v-tooltip>
                                                                <v-tooltip bottom>
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-icon color="error" dark v-bind="attrs" v-on="on" small @click="removeAttendee(item)">mdi-delete</v-icon>
                                                                    </template>
                                                                    <span>Cancel Attendee</span>
                                                                </v-tooltip> 
                                                            </template>
                                                            <template v-slot:no-data>
                                                                <v-btn class="btn btn-sm btn-primary" @click="initialize">Reset</v-btn>
                                                            </template>
                                                        </v-data-table>
                                                    </v-card-text>
                                                </v-card>
                                            </v-tab-item>
                                            <!-- -->
                                            <!-- the attendees -->
                                        </v-tabs>  
                                    </v-container>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions v-if="!active_tab">
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
                    <v-icon small @click="eventURL(item)">mdi-eye</v-icon>
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
        <!-- for speaker -->
        <v-dialog v-model="dialog3" persistent max-width="600px">
            <!--<template v-slot:activator="{ on, attrs }">
                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Speaker</v-btn>
            </template>-->
            <v-card>
                <v-card-title>
                    <span class="headline">New Speaker</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form v-model="isValid3" ref="formSpeaker">
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field label="Name" hint="*Required" persistent-hint required v-model="speaker.name"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-textarea counter label="Profile" required v-model="speaker.profile"></v-textarea>
                            </v-col>
                            <!--
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field label="Photo" hint="example of helper text only on focus" v-model="speaker.photo"></v-text-field>
                            </v-col>
                            -->
                            <!--
                            <v-col cols="12" sm="12" md="12" v-if="isSuperAdmin">
                                <v-autocomplete v-model="speaker.department_id" :items="departments" item-text="name" item-value="id"  label="Department" :rules="[rules.required]" hint="Type to select" prepend-icon="mdi-office-building"></v-autocomplete>
                            </v-col>
                            -->
                        </v-row>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeSpeaker">
                        Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="saveSpeaker()">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- for venue -->
        <v-dialog v-model="dialog2" persistent max-width="600px">
            <!--<template v-slot:activator="{ on, attrs }">
                <v-btn color="#1f4068" class="white--text" v-bind="attrs" v-on="on"><i class="material-icons ">add_box</i> Venue</v-btn>
            </template>-->
            <v-card>
                <v-card-title>
                    <span class="headline">New Venue</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form v-model="isValid2" ref="formVenue">
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
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog2 = false">
                        Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="saveVenue">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- for tickets -->
        <v-dialog v-model="dialog1" persistent max-width="600px" >
            <v-card>
                <v-card-title>
                    <span class="headline">{{ticketFormTitle}}</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-form v-model="isValid1" ref="formTicket">
                            <v-row>
                                <v-col cols="12" sm="12" md="12">
                                    <v-text-field label="Ticket Title" required v-model="ticket.title" hint="*Required" persistent-hint></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <v-text-field label="Ticket Description"  v-model="ticket.description"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <v-text-field label="Quantity Available" v-model="ticket.quantity_available"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <v-expansion-panels flat v-model="ticketExpansionPanel">
                                        <v-expansion-panel>
                                            <v-expansion-panel-header color="#1f4068" class="white--text">
                                                More Options
                                                <template v-slot:actions>
                                                    <v-icon color="white">
                                                    mdi-more
                                                    </v-icon>
                                                </template>
                                            </v-expansion-panel-header>
                                            <v-expansion-panel-content>
                                                <v-row>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-menu ref="start_book_menu" v-model="start_book_menu" :close-on-content-click="false" :return-value.sync="ticket.start_book_date" transition="scale-transition" offset-y min-width="290px">
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field  :label="computedStartTicketBook" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" hint="Start booking on" persistent-hint></v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="ticket.start_book_date" no-title scrollable>
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="start_book_menu = false">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn text color="primary" @click="$refs.start_book_menu.save(ticket.start_book_date)" >
                                                                    OK
                                                                </v-btn>
                                                            </v-date-picker>
                                                        </v-menu>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-dialog ref="start_time_dialog" v-model="start_time_dialog" :return-value.sync="ticket.start_book_time" persistent width="290px">
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field :label="computedStartTicketBookTime" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" hint="Start booking time" persistent-hint></v-text-field>
                                                            </template>
                                                            <v-time-picker v-if="start_time_dialog" v-model="ticket.start_book_time" full-width>
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="start_time_dialog = false">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn text color="primary" @click="$refs.start_time_dialog.save(ticket.start_book_time)">
                                                                    OK
                                                                </v-btn>
                                                            </v-time-picker>
                                                        </v-dialog>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-menu ref="end_book_menu" v-model="end_book_menu" :close-on-content-click="false" :return-value.sync="ticket.end_book_date" transition="scale-transition" offset-y min-width="290px">
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field  :label="computedEndTicketBook" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" hint="End booking on" persistent-hint></v-text-field>
                                                            </template>
                                                            <v-date-picker v-model="ticket.end_book_date" no-title scrollable>
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="end_book_menu = false">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn text color="primary" @click="$refs.end_book_menu.save(ticket.end_book_date)" >
                                                                    OK
                                                                </v-btn>
                                                            </v-date-picker>
                                                        </v-menu>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-dialog ref="end_time_dialog" v-model="end_time_dialog" :return-value.sync="ticket.end_book_time" persistent width="290px">
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-text-field :label="computedEndTicketBookTime" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" hint="End booking time" persistent-hint></v-text-field>
                                                            </template>
                                                            <v-time-picker v-if="end_time_dialog" v-model="ticket.end_book_time" full-width>
                                                                <v-spacer></v-spacer>
                                                                <v-btn text color="primary" @click="end_time_dialog = false">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn text color="primary" @click="$refs.end_time_dialog.save(ticket.end_book_time)">
                                                                    OK
                                                                </v-btn>
                                                            </v-time-picker>
                                                        </v-dialog>
                                                    </v-col>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <!--<v-select :items="countries" label="Minimum ticket per booking" item-text="name" item-value="name" v-model="ticket.min_per_person"  prepend-icon="mdi-earth"></v-select>-->
                                                        <v-select :items="[1,2,3,4,5,6,7,8,9,10]" label="Minimum ticket per booking"  v-model="ticket.min_per_person"  prepend-icon="mdi-earth"></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="6">
                                                        <v-select :items="[1,2,3,4,5,6,7,8,9,10]" label="Maximum ticket per booking" v-model="ticket.max_per_person"  prepend-icon="mdi-earth"></v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeTicket">
                        Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="saveTicket">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- for tickets -->
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
            console.log('Component mounted')
        },
        data() {
            return {
                dialog: false,
                dialog1: false,
                dialog2: false,
                dialog3: false,
                dialog5: false,
                st_menu: false,
                se_menu: false,
                start_book_menu: false,
                end_book_menu: false,
                stt_dialog:false,
                ste_dialog: false,
                start_time_dialog: false,
                end_time_dialog: false,
                booking_cancel_dialog: false,
                booking_details_dialog: false,
                booking_edit_dialog: false,
                attendee_edit_dialog: false,
                isValid: true,
                isValid1: true,
                isValid2: true,
                isValid3: true,
                isValid5: true,
                isValid6: true,
                isValid7: true,
                search : '',
                feedbacks: [],
                rows: [],
                bookingRows: [],
                attendeeRows: [],
                templateRows: [],
                departments: [],
                venues: [],
                speakers: [],
                editedIndex: -1,
                editedBookingIndex: -1,
                snackbar: false,
                timeout: 5000,
                error: false,
                isActive: false,
                base_url: window.location.origin + '/',
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10),
                start_time: moment().startOf('hour').format('HH:mm'),
                end_time: moment().startOf('hour').format('HH:mm'),
                cacheKey: +new Date(),
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
                    {text: 'Title', value: 'title', class: 'data-title',},
                    {text: 'Date', value: 'start_date'},
                    {text: 'Venue', value: 'venue'},
                    {text: 'Status', value: 'is_public'},
                    {text: 'Actions', value: 'actions', sortable: false, class: 'data-actions', },
                ],
                bookingHeaders: [
                    {text: 'Reference', value: 'booking_reference', class: 'data-title',},
                    {text: 'Booking Date', value: 'booking_date'},
                    {text: 'Name', value: 'name'},
                    {text: 'Email', value: 'email'},
                    {text: 'Amount', value: 'amount'},
                    {text: 'Status', value: 'reserve_status'},
                    {text: 'Actions', value: 'actions', sortable: false, class: 'data-actions', },
                ],
                attendeeHeaders: [
                    {text: 'Name', value: 'name', class: 'data-title',},
                    {text: 'Email', value: 'email'},
                    {text: 'Ticket', value: 'ticket'},
                    {text: 'Reference', value: 'reference'},
                    {text: 'Actions', value: 'actions', sortable: false, class: 'data-actions', },
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
                    is_public: 1,
                    is_approved: 1,
                    for_approval: 0,
                    barcode_type: 'QRCODE',
                    checkout_timeout: 0,
                    department_id: 0,
                    created_by: 0,
                    edited_by: 0,
                    venue: [],
                    speakers: [],
                    tickets: [],
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
                    is_public: 1,
                    is_approved: 1,
                    for_approval: 0,
                    barcode_type: 'QRCODE',
                    checkout_timeout: 0,
                    department_id: 0,
                    created_by: 0,
                    edited_by: 0,
                    venue: [],
                    speakers: [],
                    tickets: [],
                },
                editedBookingItem : {
                    id: 0,
                    booking_reference: '',
                    first_name: '',
                    last_name: '',
                },
                bookingDefault: {
                    id: 0,
                    booking_reference: '',
                    first_name: '',
                    last_name: '',
                },
                editedAttendeeItem : {
                    id: 0,
                    private_reference_number: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                },
                attendeeDefault : {
                    id: 0,
                    private_reference_number: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                },
                textFieldProps: {
                    appendIcon: 'event',
                    label: 'sdfsdfsdfsdf'
                },
                dateProps: {
                    headerColor: 'cyan darken-2'
                },
                venue: {
                    id: 0,
                    name: '',
                    address_line_1: '',
                    address_line_2: '',
                    postcode: '',
                    country: '',
                    state: '',
                },
                speaker: {
                    id: 0,
                    name: '',
                    profile: '',
                    photo: null,
                    department_id: 0,
                },
                ticket: {
                    id: 0,
                    title: '',
                    description: '',
                    min_per_person: 0,
                    max_per_person: 0,
                    quantity_available: 0,
                    quantity_booked: 0,
                    start_book_date: '',
                    end_book_date: '',
                    start_book_time: '',
                    end_book_time: '',
                    start_book_datetime: '',
                    end_book_datetime: '',
                },
                ticketDefault: {
                    id: 0,
                    title: '',
                    description: '',
                    min_per_person: 1,
                    max_per_person: 1,
                    quantity_available: 10,
                    quantity_booked: 0,
                    start_book_date: new Date().toISOString().substr(0, 10),
                    end_book_date: new Date().toISOString().substr(0, 10),
                    start_book_time: moment().format('HH:mm'),
                    end_book_time: moment().format('HH:mm'),
                    start_book_datetime: '',
                    end_book_datetime: '',
                },
                countries: [],
                selectedDate: null,
                tickets: [],
                active_tab: 0,
                ticketExpansionPanel: null,

                defaultUploadButtonText: 'Choose a file',
                posterFile: null,
                isSelecting: false,
                uploadReady: true,
                poster: {
                    file_path: '',
                    poster_code: '',
                    created_by: 0,
                    edited_by: 0,
                    event_id: 0,
                    template_id: 0,
                },
                posterFormats: ['JPG', 'PNG' , 'PDF'],
                selectedFormat: 'JPG',
                selectedTemplate: 0,
                templatePreview: false,
                theImageSrc: '',
                generatingPoster: false,
                userProfile: [],
                isSuperAdmin: false,
                isLoading: true,
                loadingText: "Loading items, please wait.",
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Event' : 'Edit Event'
            },
            eventTitle () {
                return this.editedItem.title ? this.editedItem.title : ''
            },
            computedStartDateFormatted () {
                return this.formatDate(this.start_date)
            },
            computedEndDateFormatted () {
                return this.formatDate(this.end_date)
            },
            computedStartTimeFormatted () {
                return this.formatTime(this.start_time)
            },
            computedEndTimeFormatted () {
                return this.formatTime(this.end_time)
            },
            computedStartTicketBook () {
                return this.formatDate(this.ticket.start_book_date)
            },
            computedEndTicketBook () {
                return this.formatDate(this.ticket.end_book_date)
            },
            computedStartTicketBookTime () {
                return this.formatTime(this.ticket.start_book_time)
            },
            computedEndTicketBookTime () {
                return this.formatTime(this.ticket.end_book_time)
            },
            uploadButtonText() {
                return this.posterFile ? this.posterFile.name : this.defaultUploadButtonText
            },
            tabDisable() {
                return (this.editedItem.id) ? false : true
            },
            eventPublic() {
                return (this.editedItem.is_public) ? 'mdi-table-eye' : 'mdi-table-eye-off'
            },
            eventApprove() {
                return (this.editedItem.is_approved) ? 'mdi-thumb-up' : 'mdi-thumbs-up-down'
            },
            ticketFormTitle () {
                return (!this.ticket.id) ? 'New Ticket' : 'Edit Ticket'
            }
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
                    
                    this.editedItem.department_id = this.userProfile.department_id
                    // dirty
                    this.editedItem.is_public = 1
                    this.editedItem.is_approved = 1
                    this.start_date = new Date().toISOString().substr(0, 10)
                    this.end_date = new Date().toISOString().substr(0, 10)
                    this.start_time = moment().startOf('hour').format('HH:mm')
                    this.end_time = moment().startOf('hour').format('HH:mm')
                    // dirty
                }

                val || this.close()
            },
            /*start_date(val) {
                // always change the end date based on start date value
                this.end_date = val
            },*/

        },
        methods: {
            initialize: function() {
                axios.get('/api/events')
                .then( response => {
                    this.rows = response.data
                    this.isLoading = false
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
                    this.venues = response.data
                });
            },
            getSpeakers: function() {
                axios.get('/api/speakers')
                .then( response => {
                    this.speakers = response.data;
                });
            },
            getTickets(eventId) {
                axios.get(`/api/tickets/event/${eventId}`)
                .then( response => {
                    this.tickets = response.data;
                });
            },
            getPoster(eventId) {
                axios.get(`/api/posters/event/${eventId}`)
                .then( response => {
                    this.poster = response.data;
                });
            },
            getCountries() {
                axios.get('/api/countries')
                .then( response => {
                    this.countries = response.data;
                });
            },
            getBookings(eventId) {
                axios.get(`/api/bookings/event/${eventId}`)
                .then( response => {
                    this.bookingRows = response.data;
                });
            },
            getAttendees(eventId) {
                axios.get(`/api/attendees/event/${eventId}`)
                .then( response => {
                    this.attendeeRows = response.data;
                });
            },
            getTemplates(eventId) {
                axios.get('/api/templates')
                .then( response => {
                    this.templateRows = response.data;
                });
            },
            getUserProfile() {
                axios.get('/api/profile')
                .then( response => {
                    this.userProfile = response.data;
                    if ( this.userProfile.roles[0].name === 'Super Administrator' )
                        this.isSuperAdmin = true

                    if (this.editedIndex === -1 )
                        this.editedItem.department_id = this.userProfile.department_id
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
                // get all tickets for this event
                this.getTickets(this.editedItem.id)
                // get the poster
                this.getPoster(this.editedItem.id)
                // get all bookings of an event
                this.getBookings(this.editedItem.id)
                // get all attendees of an event
                this.getAttendees(this.editedItem.id)
                // get all templates
                this.getTemplates(this.editedItem.id)
            },
            deleteItem (item) {
                const index = this.rows.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.rows.splice(index, 1)
            },
            close () {
                // make sure the dialog box is closed
                this.dialog = false
                this.dialog1 =false
                this.dialog2 =false
                this.dialog2 =false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the defaultItem object
                    this.editedItem = Object.assign({}, this.defaultItem)
                    // reset the edit flag
                    this.editedIndex = -1
                    // reset the form
                    this.$refs.form.reset();
                    // reset all objects
                    this.tickets = []
                    this.active_tab = 0
                })
            },
            closeVenue () {
                // make sure the dialog box is closed
                this.dialog2 = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.$refs.formVenue.reset();
                    this.getVenues();
                })
            },
            closeSpeaker () {
                // make sure the dialog box is closed
                this.dialog3 = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.$refs.formSpeaker.reset();
                    this.getSpeakers();
                })
            },
            closeTicket () {
                // make sure the dialog box is closed
                this.dialog1 = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.ticket = Object.assign({}, this.ticketDefault)
                    this.$refs.formTicket.reset();
                    // make sure expansion tab in dialog is closed
                    this.ticketExpansionPanel = null
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

                axios.post('/api/events/upsert', {
                    payload: this.editedItem,
                })
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for ' + editedItem.title + ' is saved.'
                        this.snackbar = true
                        this.error = false
                
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
            saveVenue(){
                /** on change of input, upload the logo, then assign the path to logo path */
                this.$refs.formVenue.validate()

                axios.post('/api/venues/upsert', {
                    payload: this.venue,
                })
                .then(response => {
                    if (response.data.success) {
                        this.editedItem.venue_id = response.data.item.id
                        this.closeVenue()
                    }
                })
                .catch( error => {})
            },
            saveSpeaker() {
                /** on change of input, upload the logo, then assign the path to logo path */
                this.$refs.formSpeaker.validate()

                axios.post('/api/speakers/upsert', {
                    payload: this.speaker,
                })
                .then(response => {
                    if (response.data.success) {
                        // this is a pesky bug
                        this.editedItem.speakers.push(response.data.item)
                        this.closeSpeaker() 
                    }
                })
                .catch( error => {})
            },
            saveTicket() {
                this.ticket.department_id = this.editedItem.department_id
                this.ticket.event_id = this.editedItem.id

                /** on change of input, upload the logo, then assign the path to logo path */
                this.$refs.formTicket.validate()

                this.ticket.start_book_datetime = this.ticket.start_book_date + ' ' + this.ticket.start_book_time
                this.ticket.end_book_datetime = this.ticket.end_book_date + ' ' + this.ticket.end_book_time

                axios.post('/api/tickets/upsert', {
                    payload: this.ticket,
                })
                .then(response => {
                    if (response.data.success) {
                        this.getTickets(this.editedItem.id)
                        this.closeTicket()
                    }
                })
                .catch( error => {
                    
                })
            },
            uploadPoster(){
                if ( this.posterFile ){
                    let formData = new FormData()
                    formData.append('poster', this.posterFile)
                    
                    if ( this.editedItem.id )
                        formData.append('id', this.editedItem.id)

                    axios.post('/api/posters/upload', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            // set the path on the global editedItem
                            //this.poster_thumb = response.data.poster_thumb 
                            this.poster = response.data.item
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
            },
            isPublic(value){
                return (value) ? 'Public' : 'Private'
            },
            isApproved(value){
                return (value) ? 'Approved' : 'For Approval'
            },
            formatDate (date) {
                if (!date) return null

                const [year, month, day] = date.split('-')
                return `${month}/${day}/${year}`
            },
            formatTime (time) {
                if (!time) return null

                // Check correct time format and split into components
                time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                if (time.length > 1) { // If time format correct
                    time = time.slice (1);  // Remove full string match value
                    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
                    time[0] = +time[0] % 12 || 12; // Adjust hours
                }
                return time.join (''); // return adjusted time or original string
            },
            ticketPause(ticketID){
                axios.post('/api/tickets/pause', {
                    payload: ticketID,
                })
                .then(response => {
                    if (response.data.success) {
                        this.getTickets(this.editedItem.id)
                    }
                })
                .catch( error => {
                    
                })
            },
            openTicketDialog(){
                this.dialog1 = true
                this.ticket = Object.assign({}, this.ticketDefault)
                
                //let eventStartDate = new Date(this.editedItem.start_date)
                let eventStartDate = new Date(this.editedItem.start_date)
                let end_book_date = eventStartDate.toISOString().substr(0, 10)
                let end_book_time = String(eventStartDate.getHours()).padStart(2, '0') + ":" + String(eventStartDate.getMinutes()).padStart(2, '0')

                this.ticket.end_book_date = end_book_date
                this.ticket.end_book_time = moment(end_book_time, 'HH:mm:ss').subtract(60, 'minutes').format('HH:mm')
            },
            editTicket(ticket) {
                let bookStartDate =ticket.start_book_date
                let bookEndDate = ticket.end_book_date
                ticket.start_book_date = moment(bookStartDate).format('YYYY-MM-DD')
                ticket.start_book_time = moment(bookStartDate).format('HH:mm')
                ticket.end_book_date = moment(bookEndDate).format('YYYY-MM-DD')
                ticket.end_book_time = moment(bookEndDate).format('HH:mm')

                this.ticket = Object.assign({}, ticket)
                this.dialog1 = true
            },
            onButtonClick() {
                this.isSelecting = true
                window.addEventListener('focus', () => {
                    this.isSelecting = false
                }, { once: true })

                this.$refs.uploader.click()
            },
            onFileChanged(e) {
                this.posterFile = e.target.files[0]

                if (this.posterFile)
                    this.uploadReady = false
                else
                    this.uploadReady = true
            },
            eventURL(item) {
                let dID= (item) ? item.department_id : this.editedItem.department_id
                let vID = (item) ? item.id : this.editedItem.id
                let theDepartment = this.departments.find(department => department.id == dID)
                
                window.open('/d/'+theDepartment.url+'/events/'+ vID, '_blank');
            },
            cancelBooking(item){
                this.booking_cancel_dialog = true
                this.editedBookingIndex = this.bookingRows.indexOf(item)
                this.editedBookingItem = item
                
            },
            cancelAttendee(index){
                if (confirm("Are you sure you want to cancel " + this.editedBookingItem.attendees[index].private_reference_number + " booking?")) {
                    
                    let id = this.editedBookingItem.attendees[index].id

                    if (id > 0) {
                        axios.delete('/api/attendees/delete/' + id)
                    }

                    this.editedBookingItem.attendees.splice(index, 1);
                }
            },
            getTicketName(ticket_id){

                let theTicket = this.editedBookingItem.tickets.filter(function(ticket){
                    return ticket.id === ticket_id
                })
                
                return theTicket[0].title
            },
            closeCancelBooking(){
                // make sure the dialog box is closed
                this.booking_cancel_dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.editedBookingItem = Object.assign({}, this.bookingDefault)
                })
            },
            detailsBooking(item){
                this.booking_details_dialog = true
                this.editedBookingIndex = this.bookingRows.indexOf(item)
                this.editedBookingItem = item
            },
            closeDetailsBooking(){
                // make sure the dialog box is closed
                this.booking_details_dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.editedBookingItem = Object.assign({}, this.bookingDefault)
                })
            },
            resendBooking(){
                axios.post('/api/bookings/resend-booking', {
                    id : this.editedBookingItem.id
                })
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Posters are generated successfully.'
                        this.snackbar = true
                        this.error = false
                        this.booking_details_dialog = false
                    }
                })
                .catch( error => {
                    
                })
            },
            removeBooking(item){
                if (confirm("Are you sure you want to cancel this booking (" + item.booking_reference + ")?")) {

                    const index = this.bookingRows.indexOf(item)
                    //confirm('Are you sure you want to delete this item?') && this.rows.splice(index, 1)
                    
                    let id = item.id

                    if (id > 0) {
                        axios.delete(`/api/booking/delete/${id}`)
                    }

                    this.bookingRows.splice(index, 1);
                }
            },
            editBooking(){
                this.booking_edit_dialog = true
                /////this.editedBookingIndex = this.bookingRows.indexOf(item)
                //this.editedBookingItem = item
            },
            closeEditBooking(){
                // make sure the dialog box is closed
                this.booking_edit_dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.editedBookingItem = Object.assign({}, this.bookingDefault)
                })
            },
            updateBooking(){
                
                axios.post('/api/bookings/update', this.editedBookingItem)
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for booking ' + this.editedBookingItem.booking_reference + ' is saved.'
                        this.snackbar = true
                        this.error = false
                
                        if ( this.editedBookingIndex > -1 )
                            Object.assign(this.bookingRows[this.editedBookingIndex], response.data.item)
                        //else
                            //this.rows.push(response.data.item)

                        // close the dialog box
                        this.closeEditBooking()  
                        this.closeDetailsBooking()
                        //this.booking_edit_dialog = false
                    }
                })
                .catch( error => {
                    let messages = Object.values(error.response.data.errors); 
                    this.feedbacks = [].concat.apply([], messages)
                    this.snackbar = true
                    this.error = true
                })
            },
            removeAttendee(item){
                
                let index = this.attendeeRows.indexOf(item)
                
                if (confirm("Are you sure you want to cancel this attendee? (" + item.book.booking_reference + ")")) {
                    
                    let id = item.id

                    if (id > 0) {
                        axios.delete('/api/attendees/delete/' + id)
                    }

                    this.attendeeRows.splice(index, 1);
                }
                
            },
            editAttendee(item){
                this.attendee_edit_dialog = true
                this.editedAttendeeItem = item
            },
            closeEditAttendee(){
                // make sure the dialog box is closed
                this.attendee_edit_dialog = false
                // next action is to make sure that the value of editedItem is on default, and re-initialize the editedIndex value
                this.$nextTick(() => {
                    // reset the form
                    this.editedAttendeeItem = Object.assign({}, this.attendeeDefault)
                })
            },
            updateAttendee(){
                
                axios.post('/api/attendees/update', this.editedAttendeeItem)
                .then(response => {
                    if (response.data.success) {
                        this.feedbacks = []
                        this.feedbacks[0] = 'Changes for attendee with booking number ' + this.editedAttendeeItem.book.booking_reference + ' is saved.'
                        this.snackbar = true
                        this.error = false
                
                        if ( this.editedAttendeeIndex > -1 )
                            Object.assign(this.attendeeRows[this.editedAttendeeIndex], response.data.item)
                        //else
                            //this.rows.push(response.data.item)

                        // close the dialog box
                        this.closeEditAttendee()  
                        //this.booking_edit_dialog = false
                    }
                })
                .catch( error => {
                    let messages = Object.values(error.response.data.errors); 
                    this.feedbacks = [].concat.apply([], messages)
                    this.snackbar = true
                    this.error = true
                })
            },
            selectTemplate(templateID){
                this.selectedTemplate = templateID
            },
            downloadPoster(){
                let path = `${this.base_url}files/events/${this.editedItem.id}/poster/${this.editedItem.id}`
                if (this.selectedFormat == 'JPG'){
                    path = `${path}.jpg`
                }
                else if(this.selectedFormat == 'PNG'){
                    path = `${path}.png`
                }
                else if(this.selectedFormat == 'PDF'){
                    path = `${path}.pdf`
                }
                return path
            },
            imageDialogUrl(templateID){
                this.templatePreview = true
                this.theImageSrc = "/web-admin/templates/screenshot/" + templateID
            },
            posterFilePath(){
                return this.poster.file_path.split('\\').pop().split('/').pop()
            },
            deletePoster(){
                // delete poster file here
                
                if (confirm("Are you sure you want to this poster image?") ){
                    
                    let id = this.poster.id

                    if (id > 0) {
                        axios.delete('/api/poster/file/delete/' + id)
                        .then(response => {
                            this.poster = response.data.item
                            this.posterFile = ''
                        })
                    }
                }
            },
            generatePoster(){
                this.generatingPoster = true
                axios.post('/api/posters/generate', {
                    event_id : this.editedItem.id,
                    template_id: this.selectedTemplate,
                })
                .then(response => {
                    if (response.data.success) {
                        this.poster = response.data.item
                        this.feedbacks = []
                        this.feedbacks[0] = 'Posters generated successfully.'
                        this.snackbar = true
                        this.error = false
                        this.generatingPoster = false
                        this.$forceUpdate()
                    }
                })
                .catch( error => {
                    this.generatingPoster = false
                    //let messages = Object.values(error.response.data.errors); 
                    let messages = ['An error encountered, please contact the administrator.']
                    this.feedbacks = [].concat.apply([], messages)
                    this.snackbar = true
                    this.error = true
                })
            },
            openSpeakerDialog(){
                this.dialog3 = true
                this.speaker.department_id = this.editedItem.department_id
            },
            updateEndDate(e){
                this.end_date = e
            },
            updateEndTime(e){
                let endTime = moment(e, 'HH:mm:ss').add(60, 'minutes').format('HH:mm')
                this.end_time = endTime
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
            this.getUserProfile()
        },
    }
</script>
<style scoped>
    .v-icon.no-poster-icon {margin-top:35%;}
    .ticket-header:hover {cursor: pointer;}
    .poster-file-name{width:auto;}
    .poster-file-name span{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>