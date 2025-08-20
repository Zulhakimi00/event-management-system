<div class="p-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-calendar-alt text-blue-600 mr-4"></i>Event Calendar
            </h2>
            <div class="flex items-center space-x-4">
                <button wire:click="previousMonth"
                    class="p-3 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl">
                    <i class="fas fa-chevron-left text-lg"></i>
                </button>
                <span class="text-xl font-bold text-gray-900 min-w-64 text-center">
                    {{ $currentMonth->format('F Y') }}
                </span>
                <button wire:click="nextMonth"
                    class="p-3 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl">
                    <i class="fas fa-chevron-right text-lg"></i>
                </button>
                <button wire:click="goToToday"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-purple-700 font-medium shadow-lg">
                    <i class="fas fa-calendar-day mr-2"></i>Today
                </button>
            </div>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center space-x-8 mb-6 p-4 bg-gray-50 rounded-xl">
            <div class="flex items-center space-x-2">
                <div class="event-dot bg-blue-500"></div>
                <span class="text-gray-700 font-medium">Regular Events</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="event-dot bg-green-500"></div>
                <span class="text-gray-700 font-medium">🍽️ With Meals</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="event-dot bg-purple-500"></div>
                <span class="text-gray-700 font-medium">My Events</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="event-dot bg-red-500"></div>
                <span class="text-gray-700 font-medium">⚠️ Conflicts</span>
            </div>
        </div>

        <!-- Calendar Grid Header -->
        <div class="calendar-grid mb-6">
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Sun</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Mon</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Tue</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Wed</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Thu</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Fri</div>
            <div class="font-bold text-center py-4 bg-gray-100 text-gray-700">Sat</div>
        </div>

        <!-- Calendar Days -->
        <div class="calendar-grid">
            @foreach ($days as $day)
                @if ($day)
                    <div class="h-24 border p-2 relative hover:bg-blue-50 transition">
                        <span class="text-sm font-bold text-gray-700">{{ $day->day }}</span>
                        {{-- Nanti boleh letak event dot kat sini --}}
                    </div>
                @else
                    <div class="h-24 border bg-gray-50"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
