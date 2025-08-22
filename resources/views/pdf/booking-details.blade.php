<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Details</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Booking Details</h2>

    <p><strong>Event Name:</strong> {{ $event->name }}</p>
    <p><strong>Department:</strong> {{ $event->department->name ?? '-' }}</p>
    <p><strong>Location:</strong> {{ $event->location->name ?? '-' }}</p>
    <p><strong>Event Type:</strong> {{ $event->eventType->name ?? '-' }}</p>
    <p><strong>Date:</strong> {{ $event->date }}</p>
    <p><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</p>
    <p><strong>Status:</strong>
        @if ($event->status == 0)
            Pending
        @elseif($event->status == 1)
            Approved
        @else
            Cancelled
        @endif
    </p>
    <p><strong>Booked By:</strong> {{ $event->user->name ?? '-' }} ({{ $event->contact_no }})</p>

    @if ($event->meals)
        <h3 class="section-title">Meal Details</h3>
        <p><strong>Total Pax:</strong> {{ $event->meals->total_pax }}</p>
        <p><strong>Vegetarian Meal:</strong> {{ $event->meals->total_vegetarian_meal }}</p>
        <p><strong>Special Guest:</strong> {{ $event->meals->specialGuest->name ?? '-' }}</p>
        <p><strong>Serving Method:</strong> {{ $event->meals->servingMethod->name ?? '-' }}</p>
        <p><strong>Remark:</strong> {{ $event->meals->remark ?? '-' }}</p>

        @if ($event->meals->details->count())
            <h4>Meal Sessions</h4>
            <table>
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Time</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->meals->details as $detail)
                        <tr>
                            <td>{{ $detail->mealSession->name ?? '-' }}</td>
                            <td>{{ $detail->time ?? '-' }}</td>
                            <td>{{ $detail->remark ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</body>

</html>
