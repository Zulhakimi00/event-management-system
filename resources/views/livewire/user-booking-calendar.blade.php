<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-calendar-alt text-blue-600 mr-4"></i>Event Calendar
        </h2>
        <div class="flex items-center space-x-4">
            <button wire:click="previousMonth" class="p-3 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>
            <span class="text-xl font-bold text-gray-900 min-w-64 text-center">
                {{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
            </span>
            <button wire:click="nextMonth" class="p-3 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>
            <button wire:click="goToToday"
                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-purple-700 font-medium shadow-lg">
                <i class="fas fa-calendar-day mr-2"></i>Today
            </button>
        </div>
    </div>

    <!-- Days Header -->
    <div class="calendar-grid mb-6 grid grid-cols-7 gap-2">
        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="font-bold text-center py-4 bg-gray-100 rounded">{{ $day }}</div>
        @endforeach
    </div>

    <!-- Days Grid -->
    @php
        $startOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeek;
    @endphp

    <div class="calendar-grid grid grid-cols-7 gap-2">
        {{-- Empty cells --}}
        @for ($i = 0; $i < $firstDayOfWeek; $i++)
            <div class="border p-4"></div>
        @endfor

        {{-- Days --}}
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $dayEvents = collect($events[$day] ?? []);
            @endphp
            <div class="border p-4 hover:bg-gray-50 rounded-lg transition relative">
                <div class="font-bold">{{ $day }}</div>

                @foreach ($dayEvents as $eventDetail)
                    <div wire:click="showEvent({{ $eventDetail['id'] }})"
                        class="mt-1 px-2 py-1 rounded text-white text-xs cursor-pointer {{ $eventDetail['is_my_event'] ? 'bg-purple-500' : 'bg-blue-500' }}">
                        {{ $eventDetail['name'] }}
                    </div>
                @endforeach
            </div>
        @endfor
    </div>
    @if ($showModal && $event)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Event Details</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                    {{-- Event Info --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">Event Information</h3>
                        <p><strong>Name:</strong> {{ $event->name }}</p>
                        <p><strong>Department:</strong> {{ $event->department->name }}</p>
                        <p><strong>Function:</strong> {{ $event->eventType->name }}</p>
                        <p><strong>Contact:</strong> {{ $event->contact_no }}</p>
                        <p><strong>Status:</strong> {{ $event->status == 1 ? 'Approved' : 'Cancelled' }}</p>
                    </div>

                    {{-- Schedule & Venue --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">Schedule & Venue</h3>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                        <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</p>
                        <p><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</p>
                        <p><strong>Venue:</strong> {{ $event->location->name }}</p>
                    </div>
                </div>
                @if ($event->meals)
                    <div class="bg-purple-50 p-4 mt-4 rounded-lg border border-purple-200">
                        <h3 class="font-bold text-purple-900 mb-3">🥗 Meal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <p><strong>Total Attendees:</strong> {{ $event->meals->total_pax ?? '-' }}</p>
                            <p><strong>Vegetarian Meals:</strong> {{ $event->meals->total_vegetarian_meal ?? '-' }}</p>
                            <p><strong>Serving Method:</strong> {{ $event->meals->servingMethod->name ?? '-' }}</p>
                            <p><strong>Special Guests:</strong> {{ $event->meals->specialGuest->name ?? '-' }}</p>
                        </div>

                        {{-- Meal Sessions --}}
                        @if ($event->meals->details && $event->meals->details->count() > 0)
                            <div class="mt-3 space-y-3">
                                @foreach ($event->meals->details as $detail)
                                    <div class="p-3 bg-white rounded shadow-sm border">
                                        <p><strong>Session:</strong> {{ $detail->mealSession->name ?? '-' }}</p>
                                        <p><strong>Time:</strong> {{ $detail->time ?? '-' }}</p>
                                        <p><strong>Remark:</strong> {{ $detail->remark ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
                {{-- Close button --}}
                <div class="flex justify-end mt-4 gap-2">
                    <button wire:click="closeModal"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
