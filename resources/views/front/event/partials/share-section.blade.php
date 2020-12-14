@if($event->social_show_facebook || $event->social_show_linkedin || $event->social_show_twitter || $event->social_show_googleplus || $event->social_show_whatsapp || $event->social_show_email)
<section id="share" class="container">
    <div class="row">
        <h1 class="section_head">
            Share Event
        </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            
        
            <div class="text-center">
                @if($event->social_show_facebook)
                
                    <v-btn icon href="https://www.facebook.com/sharer/sharer.php?u={{$event->event_url}}"  class="ma-5 white--text" fab>
                        <v-icon x-large dark >
                            mdi-facebook
                        </v-icon>
                    </v-btn>
                
                @endif
                @if($event->social_show_linkedin)

                    <v-btn icon href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{$event->event_url}}?title={{urlencode($event->title)}}&amp;summary={{{Str::words(strip_tags($event->description), 20)}}}"  class="ma-5 white--text" fab>
                        <v-icon x-large dark >
                            mdi-linkedin
                        </v-icon>
                    </v-btn>
                @endif
                @if($event->social_show_twitter)
                    <v-btn icon href="http://twitter.com/intent/tweet?text=Check out: {{$event->event_url}} {{{Str::words(strip_tags($event->description), 20)}}}"  class="ma-1 white--text" fab>
                        <v-icon x-large dark >
                            mdi-twitter
                        </v-icon>
                    </v-btn>
                @endif
                @if($event->social_show_whatsapp)
                
                    <v-btn icon href="whatsapp://send?text={{urlencode($event->title . ' - ' . $event->event_url)}}"  class="ma-5 white--text" fab data-action="share/whatsapp/share">
                        <v-icon x-large dark >
                            mdi-whatsapp
                        </v-icon>
                    </v-btn>
                @endif
                @if($event->social_show_email)
                    <v-btn icon href="mailto:?subject=Check This Out&body={{urlencode($event->event_url)}}"  class="ma-5 white--text" fab>
                        <v-icon x-large dark >
                            mdi-email
                        </v-icon>
                    </v-btn>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
