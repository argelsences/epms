<section id="events" class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            @include('front.department.partials.event-list',
                [
                    'panel_title' => 'Upcoming Events',
                    'events'      => $upcoming_events
                ]
            )
            @include('front.department.partials.event-list',
                [
                    'panel_title' => 'Past Events',
                    'events'      => $past_events
                ]
            )
        </div>
        <div class="col-xs-12 col-md-4">
            {{--
            @if ($department->facebook)
                @include('Shared.Partials.FacebookTimelinePanel',
                    [
                        'facebook_account' => $department->facebook
                    ]
                )
            @endif
            @if ($department->twitter)
                @include('Shared.Partials.TwitterTimelinePanel',
                    [
                        'twitter_account' => $department->twitter
                    ]
                )
            @endif
            --}}
        </div>
    </div>
</section>