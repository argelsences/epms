<template>
    <v-app>
        <div class="text-h4 text-left">Create template</div>
        <div class="text-subtitle-1 text-left">In here you see the overview</div>
        <v-divider></v-divider>
        <v-row>
            <v-col cols="12" sm="12" md="12">
                <v-card>
                    <v-card-title>How do you want to create the template?</v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-list class="text-left">
                                <v-list-item link :to="{name: `add-by-upload`}" class="ma-5">
                                    <v-list-item-action>
                                        <v-icon>mdi-view-dashboard-outline</v-icon>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>Uploading HTML, CSS, and image files</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item link :to="{name: `add-by-code`}" class="ma-5">
                                    <v-list-item-action>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>By HTML, CSS source code and uploading image files</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item link :to="{name: `add-by-canvas`}" class="ma-5">
                                    <v-list-item-action>
                                        <v-icon>mdi-bullhorn</v-icon>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>By using drawing canvas.</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-app>
</template>