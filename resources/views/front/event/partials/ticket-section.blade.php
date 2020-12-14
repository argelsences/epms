<section id="tickets" class="container">
    <div class="row">
        <h1 class='section_head text-center'>
            Ticket(s)
        </h1>
    </div>

    @if($event->end_date->isPast())
        <div class="alert alert-boring text-center">
            The event already ended
        </div>
    @else

        @if($event->tickets->count() > 0)
            <form method="POST" action="{{ route('tickets.checkout', ['department_slug'=>$department->url, 'event_id' => $department->id]) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="tickets_table_wrap">
                            <table class="table">
                                <?php
                                $is_free_event = true;
                                ?>
                                @foreach($event->tickets->where('is_hidden', false) as $ticket)
                                    <tr class="ticket" property="offers" typeof="Offer">
                                        <td>
                                            <span class="ticket-title semibold" property="name">
                                                {{$ticket->title}}
                                            </span>
                                            <p class="ticket-descripton mb0 text-muted" property="description">
                                                {{$ticket->description}}
                                            </p>
                                        </td>
                                        <td style="width:200px; text-align: right;">
                                            <div class="ticket-pricing" style="margin-right: 20px;">
                                                FREE
                                            </div>
                                        </td>
                                        <td style="width:85px;">
                                            @if($ticket->is_paused)
                                                <span class="text-danger">
                                                    Ticket currently not on sale
                                                </span>
                                            @else
                                                {{--@if($ticket->sale_status === config('attendize.ticket_status_sold_out'))--}}
                                                @if($ticket->quantity_available - $ticket->quantity_booked == 0)
                                                    <span class="text-danger" property="availability"
                                                          content="http://schema.org/SoldOut">
                                                            Sold out
                                                    </span>
                                                @elseif($ticket->start_book_date  > \Carbon\Carbon::now())
                                                    <span class="text-danger">
                                                       Sale not started yet
                                                    </span>
                                                @elseif($ticket->end_book_date <= \Carbon\Carbon::now())
                                                    <span class="text-danger">
                                                        Sale has ended
                                                    </span>
                                                @else
                                                    <input name="tickets[]" type="hidden" value="{{$ticket->id}}">
                                                    <meta property="availability" content="http://schema.org/InStock">
                                                    <select name="ticket_{{$ticket->id}}" class="form-control"
                                                            style="text-align: center">
                                                        @if ($event->tickets->count() > 1)
                                                            <option value="0">0</option>
                                                        @endif
                                                        @for($i=$ticket->min_per_person; $i<=$ticket->max_per_person; $i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" style="text-align: center">
                                        Choose the number of tickets and click "REGISTER". On the next screen you will be asked for your information.
                                    </td>
                                </tr>
                                <tr class="checkout">
                                    <td colspan="3">
                                        <input type="submit" class="btn btn-lg btn-primary pull-right" value="REGISTER" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <input name="is_embedded" type="hidden" value="0">
            </form>
        @else
            <div class="alert alert-boring text-center">
                No ticket/s available
            </div>
        @endif

    @endif

</section>
