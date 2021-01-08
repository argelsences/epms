@if (auth()->check())
    @if( auth()->user()->can(["edit event","create event"]) )
        @if(!$event->is_public)
            <section id="goLiveBar">
                <div class="container">
                    @if(!$event->is_public)
                        This event is not visible to the public.
                        <a href="#"
                        style="background-color: green; border-color: green;"
                        class="btn btn-success btn-xs">Go Live</a>
                    @endif
                </div>
            </section>
        @endif
    @endif
@endif
<section id="organiserHead" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div onclick="window.location=`{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}#organiser`" class="event_organizer">
                    <b>{{$event->department->name}}</b> presents
                </div>
            </div>
        </div>
    </div>
</section>

<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 property="name">{{$event->title}}</h1>
            <div class="event_venue">
                <span property="startDate" content="{{ $event->start_date->toIso8601String() }}">
                    {{ $event->startDateFormatted() }}
                </span>
                -
                <span property="endDate" content="{{ $event->end_date->toIso8601String() }}">
                     @if($event->start_date->diffInDays($event->end_date) == 0)
                        {{ $event->end_date->format('H:i A') }}
                     @else
                        {{ $event->endDateFormatted() }}
                     @endif
                </span>
                @
                <span property="location" typeof="Place">
                    <b property="name">{{$event->venue->name}}</b>
                    <meta property="address" content="{{ urldecode($event->venue->address_line_1) }}">
                </span>
            </div>

            <div class="event_buttons">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-md" href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}/#tickets">
                            <v-icon left>mdi-ticket</v-icon> TICKETS
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-lg" href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}/#details">
                            <v-icon left>mdi-details</v-icon> DETAILS
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-lg" href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}/#location">
                            <v-icon left>mdi-map</v-icon> VENUE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
