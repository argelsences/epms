<html>
    <!--    Keep this page lean as possible.-->
    <head>
        <title>
            Ticket(s)
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <style>
            table.ticket{width:100%;border: 1px solid #000000;border-collapse: collapse;margin-bottom:20px;font-size:14px;color:grey}
            table.ticket tr {border: 1px solid black;}
            table.ticket tr td {padding: 40px 20px 40px 20px;vertical-align:top;}
            .logo img {display:block;}
            .cell-barcode {width:20%;}
            .cell-logo{width:10%;}
            .cell-event-details, .cell-attendee-details{width:35%;}
            h4{font-size:16px;color:black;margin-bottom:2px;margin-top:10px;}
            .cell-logo img {width:150px;height:auto;}
            .bottom_info{text-align:center;}
            .bottom_info a {color:#000 !important;}
        </style>
    </head>
    <body style="background-color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;color:#000000;">
        <div class="container">
            @foreach($data['attendees'] as $attendee)
                @if(!$attendee->is_cancelled)
                    <table class="ticket">
                        <tr>
                            <td class="cell-barcode">
                                <div class="barcode">
                                    {!! DNS2D::getBarcodeHTML($attendee->private_reference_number, "QRCODE", 6, 6) !!}
                                </div>
                                
                            </td>
                            <td rowspan="2" class="cell-event-details">
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
                            </td>
                            <td rowspan="2" class="cell-attendee">
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
                            </td>
                            <td class="cell-logo">
                                <div class='logo'>
                                    <img alt="{{$data['event']->department->logo_path}}" src="data:image/png;base64, {{$data['logo']}}" />
                                    @if($data['poster'])
                                        <img src="data:image/png;base64, {{$data['poster']}}" />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                @endif
            @endforeach

            <div class="bottom_info">
                @include('front.shared.partials.copyright')
            </div>
        </div>
    </body>
</html>
