<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Meal Order PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        h2,
        h3 {
            margin: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f5f5f5;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        .green {
            background-color: #d1fae5;
            color: #065f46;
        }

        .red {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .gray-box {
            background-color: #f3f4f6;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h2>Meal Order - {{ $order->id }}</h2>

    <!-- Event Info -->
    <div class="section">
        <div class="section-title">📅 Event Information</div>
        <div class="gray-box">
            <p><strong>Name:</strong> {{ $order->event->name }}</p>
            <p><strong>Department:</strong> {{ $order->event->department->name }}</p>
            <p><strong>Function Type:</strong> {{ $order->event->eventType->name }}</p>
            <p><strong>Contact:</strong> {{ $order->event->contact_no }}</p>
            <p><strong>Status:</strong>
                <span class="badge {{ $order->event->status == 1 ? 'green' : 'red' }}">
                    {{ $order->event->status == 1 ? 'Approve' : 'Cancel' }}
                </span>
            </p>
        </div>
    </div>

    <!-- Schedule & Venue -->
    <div class="section">
        <div class="section-title">⏰ Schedule & Venue</div>
        <div class="gray-box">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->event->date)->format('d/m/Y') }}</p>
            <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($order->event->start_time)->format('H:i') }}</p>
            <p><strong>End:</strong> {{ \Carbon\Carbon::parse($order->event->end_time)->format('H:i') }}</p>
            <p><strong>Venue:</strong> {{ $order->event->location->name }}</p>
        </div>
    </div>

    <!-- Meal Sessions -->
    <div class="section">
        <div class="section-title">🍽️ Meal Sessions - {{ $order->meal->name ?? '' }}</div>
        @foreach ($order->details as $detail)
            <div class="gray-box">
                <p><strong>Session:</strong> {{ $detail->mealSession->name ?? '-' }}</p>
                <p><strong>Time:</strong> {{ $detail->time ?? '-' }}</p>
                <p><strong>Remark:</strong> {{ $detail->remark ?? '-' }}</p>
            </div>
        @endforeach
    </div>

    <!-- Optional IT Equipment -->
    @if ($order->event->equipment && count($order->event->equipment) > 0)
        <div class="section">
            <div class="section-title">IT Equipment</div>
            <div class="gray-box">
                {{ implode(', ', $order->event->equipment) }}
            </div>
        </div>
    @endif

</body>

</html>
