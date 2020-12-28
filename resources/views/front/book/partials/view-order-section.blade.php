<section id="order_form" class="container">
    <div class="row">
        <div class="row text-center">
            <div class="order_header col-sm-12 col-md-12 col-12">
                <span class="mdi mdi-checkbox-marked-circle-outline" style="font-size:128px;color:#4CAF50"></span>
                <h1>Thank you for your booking</h1>
                <h2>
                    Your <a href="{{ route('booking.tickets', ['reference' => $booking->booking_reference] ).'?download=1' }}" target="_blank">Ticket(s)</a> and a confirmation email have been sent to you.
                </h2>
            </div>
        </div>
        <v-card class="col-12 mb-5">
            <v-card-title>
            </v-card-title>
            <v-card-text>
                <div class="row">
                    <div class="col-sm-4 col-xs-6">
                        <b>First Name</b><br> {{$booking->first_name}}
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <b>Last Name</b><br> {{$booking->last_name}}
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <b>Amount</b><br> FREE
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <b>Reference</b><br> {{$booking->booking_reference}}
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <b>Date</b><br> {{$booking->created_at->format(config('eppms.default.datetime_format'))}}
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <b>Email</b><br> {{$booking->email}}
                    </div>
                    @if ($booking->is_business)
                    <div class="col-sm-4 col-xs-6">
                        <b>Business Name</b><br> {{$booking->business_name}}
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <b>Business Tax Number</b><br> {{$booking->business_tax_number}}
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <b>Business Address</b><br />
                        @if ($booking->business_address_line_one)
                        {{$booking->business_address_line_one}},
                        @endif
                        @if ($booking->business_address_line_two)
                        {{$booking->business_address_line_two}},
                        @endif
                        @if ($booking->business_address_state_province)
                        {{$booking->business_address_state_province}},
                        @endif
                        @if ($booking->business_address_city)
                        {{$booking->business_address_city}},
                        @endif
                        @if ($booking->business_address_code)
                        {{$booking->business_address_code}}
                        @endif
                    </div>
                    @endif
                </div>
            </v-card-text>
        </v-card>

        <div class="row text-center">
            <div class="col-sm-12 col-md-12 col-12">
                <h3>Booking Items</h3>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>
                            Ticket
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Booking Fee
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->book_items as $booking_item)
                        <tr>
                            <td>
                                {{$booking_item->title}}
                            </td>
                            <td>
                                {{$booking_item->quantity}}
                            </td>
                            <td>
                                FREE
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                FREE
                            </td>
                        </tr>
                    @endforeach
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
            </table>

        </div>

        <div class="row text-center">
            <div class="col-sm-12 col-md-12 col-12">
                <h3>Booking Attendees</h3>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tbody>
                    @foreach($booking->attendees as $attendee)
                    <tr>
                        <td>
                            {{$attendee->first_name}}
                            {{$attendee->last_name}}
                            (<a href="mailto:{{$attendee->email}}">{{$attendee->email}}</a>)
                        </td>
                        <td>
                            {{{$attendee->ticket->title}}}
                        </td>
                        <td>
                            @if($attendee->is_cancelled)
                                Cancelled
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</section>
