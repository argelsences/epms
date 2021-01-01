<html>
    <head>
        <title>
            Attendees
        </title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style type="text/css">
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                padding: 3px;
            }
            table {
                font-size: 13px;
            }
            @page {
                size: landscape;
                margin: 5mm 5mm 5mm 5mm; /* change the margins as you want them to be. */
            }
        </style>
    </head>
    <body style="background-color: #FFFFFF;" onload="window.print();">
        <div class="well" style="border:none; margin: 0;">
            {{ $attendees->count() }} attendees for event: {{$event->title}} on {{ $event->start_date->format(config("eppms.default.datetime_format")) }}
            <br>
        </div>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Ticket</th>
                    <th>Reference</th>
                    <th>Booking Date</th>
                    <th>Arrived</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $attendee)
                <tr>
                    <td>{{{$attendee->full_name}}}</td>
                    <td>{{{$attendee->email}}}</td>
                    <td>{{{$attendee->ticket->title}}}</td>
                    <td>{{{$attendee->book->booking_reference}}}</td>
                    <td>{{$attendee->created_at->format(config("eppms.default.datetime_format"))}}</td>
                    <td><input type="checkbox" style="border: 1px solid #000; height: 15px; width: 15px;" /></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>