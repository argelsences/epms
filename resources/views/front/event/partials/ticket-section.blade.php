<section id="tickets" class="container ticket-container">
    
    @if($event->end_date->isPast())
        <div class="row">
            <h1 class='section_head text-center'>
                Ticket(s)
            </h1>
        </div>
        <div class="alert alert-boring text-center">
            The event already ended
        </div>
    @else
        <!-- set as vue component -->
        @if($event->tickets->count() > 0)
            <ticket-form :event="{{$event}}"></ticket-form>
        @else
            <div class="row">
                <h1 class='section_head text-center'>
                    Ticket(s)
                </h1>
            </div>
            <div class="alert alert-boring text-center">
                No ticket/s available
            </div>
        @endif

    @endif

</section>
