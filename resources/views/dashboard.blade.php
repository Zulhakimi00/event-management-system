@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stats-card">
            <h2 class="text-lg font-semibold">Total Events</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalEvents }}</p>
        </div>

        <div class="stats-card">
            <h2 class="text-lg font-semibold">Bookings</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalBookings }}</p>
        </div>

        <div class="stats-card">
            <h2 class="text-lg font-semibold">Users</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
        </div>
    </div>
@endsection
