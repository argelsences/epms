<section id="organiser" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="event_organiser_details" property="organizer" typeof="Organization">
                <div class="text-center">
                    <div class="logo">
                        <img alt="{{$event->department->name}}" src="{{asset($event->department->logo_path)}}" property="logo">
                    </div>
                        
                    <a href="{{route('department.homepage', [$event->department->url])}}" title="Organiser Page">
                        {{$event->department->name}}
                    </a>

                    <p property="description">
                        {!! nl2br($event->department->about)!!}
                    </p>

                    <p>
                        Find us at
                        @if($event->department->facebook)
                            <v-btn property="sameAs" icon href="https://fb.com/{{$event->department->facebook}}"  class="ma-5 white--text" fab>
                                <v-icon x-large dark >
                                    mdi-facebook
                                </v-icon>
                            </v-btn>
                        @endif
                        @if($event->department->instagram)
                            <!--<a property="sameAs" href="https://twitter.com/{{$event->department->twitter}}" class="btn btn-twitter">
                                <i class="ico-twitter"></i>&nbsp; Twitter
                            </a>-->
                            <v-btn property="sameAs" icon href="https://twitter.com/{{$event->department->twitter}}"  class="ma-5 white--text" fab>
                                <v-icon x-large dark >
                                    mdi-instagram
                                </v-icon>
                            </v-btn>
                        @endif
                        <!-- set toggle here -->
                        <v-btn icon  class="ma-5 white--text" fab>
                            <v-icon x-large dark >
                                mdi-email
                            </v-icon>
                        </v-btn>
                    </p>
                </div>
                <div class="contact_form well well-sm">
                    <contact-form :event="{{$event}}"></contact-form>
                </div>
            </div>
        </div>
    </div>
</section>

