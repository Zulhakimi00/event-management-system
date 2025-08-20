<div class="p-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-clipboard-list text-blue-600 mr-4"></i>My Bookings
            </h2>
            <div class="flex space-x-4">
                <button wire:click="exportPDF"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </button>
                <button wire:click="addToCalendar"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-calendar-plus mr-2"></i>Add to Calendar
                </button>
            </div>
        </div>

        <div class="space-y-6">
            @forelse($events as $event)
                <div
                    class="p-6 bg-{{ $statusColor ?? 'success' }}-50 rounded-xl border-l-4 border-{{ $statusColor ?? 'success' }}-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $event['name'] }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <p class="text-gray-600"><strong>📅 Date:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_date_time)->toDateString() }}</p>
                                    <p class="text-gray-600"><strong>⏰ Time:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_date_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_date_time)->format('h:i A') }}</p>
                                    <p class="text-gray-600"><strong>📍 Location:</strong> {{ $event->location->name }}
                                    </p>
                                    <p class="text-gray-600"><strong>🏢 Department:</strong>
                                        {{ $event->department->name }}
                                    </p>
                                    <p class="text-gray-600"><strong>📞 Contact:</strong> {{ $event->contact_no }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600"><strong>💻 Equipment:</strong>
                                        @foreach ($event->itEquipments as $equipment)
                                            <span class="px-2 py-1 rounded">{{ $equipment->name }}</span>
                                        @endforeach
                                    </p>
                                    <p class="{{ $event->meals ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                                        <strong>🍽️ Meals:</strong>
                                        {{ $event->meals ? 'Included' : 'Not required' }}
                                    </p>
                                    <p class="text-gray-500 text-sm"><strong>📝 Created:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_date_time)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            {{-- Meal Order --}}
                            @if ($event->meals)
                                <div
                                    class="mt-4 p-4 {{ $event->meals['status'] === 'modified' ? 'bg-yellow-50 border-2 border-yellow-300' : 'bg-blue-50 border border-blue-200' }} rounded-lg">
                                    <h4
                                        class="font-bold {{ $event->meals['status'] === 'modified' ? 'text-yellow-900' : 'text-blue-900' }} mb-2 flex items-center">
                                        🍽️
                                        {{ $event->meals['status'] === 'modified' ? 'Updated Meal Order Details' : 'Meal Order Details' }}
                                        @if ($event->meals['status'] === 'modified')
                                            <span
                                                class="ml-2 text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded">MODIFIED</span>
                                        @endif
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <p><strong>Sessions:</strong>

                                                @foreach ($event->meals->details as $meal_detail)
                                                    {{ $meal_detail->mealSession->name }}
                                                @endforeach

                                            </p>
                                            <p><strong>Total Attendees:</strong> {{ $event->meals['total_pax'] }}
                                                people</p>
                                            <p><strong>Vegetarian Meals:</strong>
                                                {{ $event->meals['total_vegetarian_meal'] }}</p>
                                            <p><strong>Serving Method:</strong>
                                                {{ $event->meals['servingMethod']->name }}
                                            </p>
                                            @if ($event->meals['specialGuest'] != null)
                                                <p><strong>Special Guests:</strong>
                                                    {{ $event->meals['specialGuest']->name }}
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            {{-- <p><strong>Order Status:</strong>
                                                <span
                                                    class="px-2 py-1 rounded text-xs 
                                            {{ $mealOrder['status'] === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($mealOrder['status'] === 'modified'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-blue-100 text-blue-800') }}">
                                                    {{ $mealOrder['status'] === 'modified' ? 'CONFIRMED (Modified)' : strtoupper($mealOrder['status']) }}
                                                </span>
                                            </p>
                                            @if (isset($mealOrder['approvedDate']))
                                                <p class="text-xs text-gray-600"><strong>Approved:</strong>
                                                    {{ \Carbon\Carbon::parse($mealOrder['approvedDate'])->format('d/m/Y') }}
                                                </p>
                                            @endif
                                            @if (isset($mealOrder['modifiedDate']))
                                                <p class="text-xs text-gray-600"><strong>Last Updated:</strong>
                                                    {{ \Carbon\Carbon::parse($mealOrder['modifiedDate'])->format('d/m/Y') }}
                                                </p>
                                            @endif --}}
                                        </div>
                                    </div>

                                    @if (!empty($mealOrder['mealDetails']))
                                        <div class="mt-3">
                                            <p class="text-sm font-medium">📝 Meal Details:</p>
                                            <p class="text-sm bg-white p-2 rounded border mt-1">
                                                {{ $mealOrder['mealDetails'] }}</p>
                                        </div>
                                    @endif

                                    @if (!empty($mealOrder['dietaryRequirements']))
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-orange-700">⚠️ Dietary Requirements:</p>
                                            <p
                                                class="text-sm text-orange-600 bg-orange-50 p-2 rounded border border-orange-200 mt-1">
                                                {{ $mealOrder['dietaryRequirements'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="text-right ml-4">
                            <span
                                class="bg-{{ $statusColor ?? 'success' }}-100 text-{{ $statusColor ?? 'success' }}-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ ucfirst($event['status']) }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2 pt-4 border-t">
                        <button wire:click="showEventMealModal({{ $event->id }})"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 flex items-center">
                            <i class="fas fa-eye mr-1"></i>View Full Details
                        </button>
                        @if ($event['status'] === 'confirmed' && \Carbon\Carbon::parse($event['start_date'])->isFuture())
                            <button
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center">
                                <i class="fas fa-edit mr-1"></i>Edit Booking
                            </button>
                        @endif
                        <button
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 flex items-center">
                            <i class="fas fa-print mr-1"></i>Print
                        </button>
                        <button
                            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 flex items-center">
                            <i class="fas fa-calendar-plus mr-1"></i>Add to Calendar
                        </button>
                        @if ($event['status'] === 'confirmed' && \Carbon\Carbon::parse($event['start_date'])->isFuture())
                            <button
                                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 flex items-center">
                                <i class="fas fa-times mr-1"></i>Cancel Booking
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No bookings yet.</p>
            @endforelse
        </div>
    </div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Order Details</h2>
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
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_date_time)->format('d/m/Y') }}
                        </p>
                        <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date_time)->format('H:i') }}
                        </p>
                        <p><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date_time)->format('H:i') }}</p>
                        <p><strong>Venue:</strong> {{ $event->location->name }}</p>
                    </div>
                </div>

                {{-- IT Equipment --}}
                @if ($event->itEquipments && $event->itEquipments->count() > 0)
                    <div class="bg-cyan-50 p-4 mt-4 rounded-lg border border-cyan-200">
                        <h3 class="font-bold text-cyan-900 mb-2">IT Equipment Required</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($event->itEquipments as $eq)
                                <span
                                    class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-sm">{{ $eq->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Meal Sessions --}}
                @if ($mealOrders && $mealOrders->details->count() > 0)
                    <div class="bg-gray-50 p-4 mt-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3">🍽️ Meal Sessions</h3>
                        <div class="space-y-3">
                            @foreach ($mealOrders->details as $detail)
                                <div class="p-3 bg-white rounded shadow-sm border">
                                    <p><strong>Session:</strong> {{ $detail->mealSession->name ?? '-' }}</p>
                                    <p><strong>Time:</strong> {{ $detail->time ?? '-' }}</p>
                                    <p><strong>Remark:</strong> {{ $detail->remark ?? '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex justify-end mt-4 gap-2">
                    <button wire:click="closeModal"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>
    @endif


</div>
