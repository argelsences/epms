
<div class="row">
    <div class="col-md-12">
        <h1 class="event-listing-heading">{{ $panel_title }}</h1>
        <ul class="event-list">
            @if(count($events))
                @foreach($events as $event)
                    <li>
                        <time datetime="{{ $event->start_date }}">
                            <span class="day">{{\Carbon\Carbon::parse($event->start_date)->format('d')}}</span>
                            <span class="month">{{ \Carbon\Carbon::parse($event->start_date)->format('n') }}</span>
                            <span class="year">{{ \Carbon\Carbon::parse($event->start_date)->format('Y') }}</span>
                            <span class="time">{{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }}</span>
                        </time>
                        {{-- 
                        @if(count($event->images))
                        <!-- set the poster image on src here -->
                        <!--<img class="hide" alt="{{ $event->title }}" src="{{ asset($event->images->first()['image_path']) }}"/>-->
                        <!--<img class="hide" alt="{{ $event->title }}" src="/"/>-->
                        @endif 
                        --}}
                        <div class="info">
                            <h2 class="title ellipsis">
                               <a href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}">{{ $event->title }}</a>
                            </h2>
                            <p class="desc ellipsis">{{ $event->venue_name }}</p>
                            <ul>
                                <li style="width:50%;"><a href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}/#tickets">Tickets</a></li>
                                <li style="width:50%;"><a href="{{route('event.display', ['department_slug' => $department->url, 'event_id' => $event->id])}}/#details">Details</a></li>
                            </ul>
                        </div>
                    </li>
                @endforeach
            @else
                <div class="alert alert-info">
                    There are no events to display
                </div>
            @endif

        </ul>
    </div>
</div>