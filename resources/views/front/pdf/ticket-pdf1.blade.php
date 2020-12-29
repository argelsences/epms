<html>
    <!--    Keep this page lean as possible.-->
    <head>
        <title>
            Ticket(s)
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <style>{{$data['css']}}]</style>
    </head>
    <body style="background-color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;color:#000000;">
        <div class="container">
            @foreach($data['attendees'] as $attendee)
                @if(!$attendee->is_cancelled)
                    <div class="ticket">
                        <div class='logo'>
				            <img alt="{{$data['event']->department->logo_path}}" src="data:image/png;base64, {{$data['logo']}}" />
                            @if($data['poster'])
                                <img style="width:200px;height:auto;" src="data:image/png;base64, {{$data['poster']}}" />
                            @endif
                        </div>
                        <div class="layout_even">
                            <div class="event_details">
                                <h4>EVENT</h4>
                                {{$data['event']->title}}
                                <h4>DEPARTMENT</h4>
                                {{$data['event']->department->name}}
                                <h4>VENUE</h4>
                                {{$data['event']->venue->name}}
                                <h4>START DATE/TIME</h4>
                                {{$data['event']->startDateFormatted()}}
                                <h4>END DATE/TIME</h4>
                                {{$data['event']->endDateFormatted()}}
                            </div>

                            <div class="attendee_details">
                                <h4>NAME</h4>
                                {{$attendee->first_name.' '.$attendee->last_name}}
                                <h4>TICKET TYPE</h4>
                                {{$attendee->ticket->title}}
                                <h4>BOOKING REFERENCE</h4>
                                {{$data['booking']->booking_reference}}
                                <h4>ATTENDEE REFERENCE</h4>
                                {{$attendee->private_reference_number}}
                                <h4>TICKET PRICE</h4>
                                FREE
                            </div>
                            <div class="barcode">
                                {!! DNS2D::getBarcodeHTML($attendee->private_reference_number, "QRCODE", 6, 6) !!}
                            </div>
                            @if($data['event']->is_1d_barcode_enabled)
                            <div class="barcode_vertical">
                                {!! DNS1D::getBarcodeHTML($attendee->private_reference_number, "C39+", 1, 50) !!}
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="bottom_info">
                @include('front.shared.partials.copyright')
            </div>
        </div>
    </body>
</html>
