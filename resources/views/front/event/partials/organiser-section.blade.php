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
                        <!--<button onclick="$(function(){ $('.contact_form').slideToggle(); });" type="button" class="btn btn-primary">
                            <i class="ico-envelop"></i>&nbsp; Contact
                        </button>-->
                        <v-btn icon  class="ma-5 white--text" fab>
                            <v-icon x-large dark >
                                mdi-email
                            </v-icon>
                        </v-btn>
                    </p>
                </div>
                <div class="contact_form well well-sm">
                    <form method="POST" action="http://127.0.0.1:8000/e/3/contact_organiser" accept-charset="UTF-8" class="reset ajax" id="contact-form">
                        @csrf
                        <h3>Contact <i>{{$event->department->name}}</i></h3>
                        <div class="form-group">
                            <label for="Your name">Your Name</label>
                            <input required="" class="form-control" placeholder="Your name" name="name" type="text">
                        </div>

                        <div class="form-group">
                            <label for="Your e-mail address">Your E-mail Address</label>
                            <input required="" class="form-control" placeholder="Your e-mail address" name="email" type="text">
                        </div>

                        <div class="form-group">
                            <label for="Your message">Your Message</label>
                            <textarea required="" class="form-control" placeholder="Your message" name="message" cols="50" rows="10"></textarea>
                        </div>

                    {{--@include('Public.LoginAndRegister.Partials.CaptchaSection')--}}

                    <div class="form-group">
                        <p><input class="btn btn-primary" type="submit" value="SEND MESSAGE"></p>
                    </div>
                    </form>
                </div>
                
                
            </div>
        </div>
    </div>
</section>

