<div class="p-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-clipboard-list text-blue-600 mr-4"></i>My Bookings
            </h2>
            <div class="flex space-x-4">
                {{-- <button wire:click="exportPDF"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </button>
                <button wire:click="addToCalendar"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-calendar-plus mr-2"></i>Add to Calendar
                </button> --}}
            </div>
        </div>

        <div class="space-y-6">
            @forelse($events as $event)


                <div
                    class="p-6 bg-{{ $event->status == 1 ? 'green' : 'red' }}-50 rounded-xl border-l-4 border-{{ $event->status == 1 ? 'green' : 'red' }}-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $event['name'] }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <p class="text-gray-600"><strong>📅 Date:</strong>
                                        {{ \Carbon\Carbon::parse($event->date)->toDateString() }}</p>
                                    <p class="text-gray-600"><strong>⏰ Time:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
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
                                        {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
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
                                class="bg-{{ $event['status'] == 1 ? 'green' : 'red' }}-100 text-{{ $event['status'] == 1 ? 'green' : 'red' }}-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ ucfirst($event['status'] == 0 ? 'Cancel' : 'Confirm') }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}

                    @if ($event->status == 1)
                        <div class="flex flex-wrap gap-2 pt-4 border-t">
                            <button wire:click="showEventMealModal({{ $event->id }})"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 flex items-center">
                                <i class="fas fa-eye mr-1"></i>View Full Details
                            </button>
                            @if ($event->status == 1 && \Carbon\Carbon::parse($event['date'])->isFuture())
                                <button wire:click="openEditModal({{ $event->id }})"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center">
                                    <i class="fas fa-edit mr-1"></i>Edit Booking
                                </button>
                            @endif
                            <a href="{{ route('booking.pdf', $event->id) }}"
                                class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 flex items-center">
                                <i class="fas fa-print mr-1"></i>Print
                            </a>
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 flex items-center">
                                <i class="fas fa-calendar-plus mr-1"></i>Add to Calendar
                            </button>
                            @if ($event->status == 1 && \Carbon\Carbon::parse($event['date'])->isFuture())
                                <button wire:click="confirmCancel({{ $event->id }})"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 flex items-center">
                                    <i class="fas fa-times mr-1"></i>Cancel Booking
                                </button>
                            @endif
                        </div>
                    @endif


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
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                        </p>
                        <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                        </p>
                        <p><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</p>
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
                @if ($mealOrders)
                    <div class="bg-purple-50 p-4 mt-4 rounded-lg border border-purple-200">
                        <h3 class="font-bold text-purple-900 mb-3">🥗 Meal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <p>
                                <strong>Total Attendees:</strong>
                                {{ $mealOrders->total_pax ?? '-' }}
                            </p>
                            <p>
                                <strong>Vegetarian Meals:</strong>
                                {{ $mealOrders->total_vegetarian_meal ?? '-' }}
                            </p>
                            <p>
                                <strong>Serving Method:</strong>
                                {{ $mealOrders->servingMethod->name ?? '-' }}
                            </p>
                            <p>
                                <strong>Special Guests:</strong>
                                {{ $mealOrders->specialGuest->name ?? '-' }}
                            </p>
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
    @if ($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">✏️ Edit Booking</h2>
                    <button wire:click="closeEditModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <form wire:submit.prevent="saveEdit" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Event Name</label>
                        <input type="text" wire:model.defer="editName"
                            class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Contact Person</label>
                        <input type="text" wire:model.defer="editContact"
                            class="w-full p-3 border border-gray-300 rounded-lg">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                            <input type="date" wire:model.defer="editDate"
                                class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Start Time</label>
                            <select wire:model.defer="editStartTime"
                                class="w-full p-3 border border-gray-300 rounded-lg">
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">End Time</label>
                            <select wire:model.defer="editEndTime"
                                class="w-full p-3 border border-gray-300 rounded-lg">
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Venue</label>
                        <select wire:model.defer="editLocationId"
                            class="w-full p-3 border border-gray-300 rounded-lg">
                            @foreach ($locations as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" wire:click="closeEditModal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showCancelModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 max-h-[80vh] overflow-y-auto">
                @if ($mealOrder && $mealOrder->status != 2)
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-6">
                            <i class="fas fa-utensils text-4xl text-orange-500 mb-4"></i>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">🍽️ Meal Order Detected</h2>
                            <p class="text-gray-600">This booking includes meal orders</p>
                        </div>

                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-orange-600 mr-3 mt-1"></i>
                                <div>
                                    <p class="text-orange-800 font-medium mb-2">Dietary Department Contact Required</p>
                                    <p class="text-orange-700 text-sm">
                                        Since this booking includes meal orders, contact dietary to cancel.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <h3 class="font-bold text-blue-900 mb-3">📞 Contact Information</h3>
                            <div class="space-y-2 text-sm">
                                <p><strong>Dietary Department:</strong></p>
                                <p>📧 Email: dietary@company.com</p>
                                <p>📱 Phone: +60 3-1234-5678</p>
                                <p>🏢 Office: Ground Floor, Admin Block</p>
                                <p>⏰ Hours: 8:00 AM - 5:00 PM (Mon-Fri)</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h4 class="font-bold text-gray-900 mb-2">🍽️ Your Meal Order Details</h4>
                            <div class="text-sm space-y-1">
                                <p><strong>Sessions:</strong>
                                    {{ implode(', ', $mealOrder->details->pluck('mealSession.name')->toArray()) }}</p>
                                <p><strong>Attendees:</strong> {{ $mealOrder->total_pax }} people</p>@php
                                    $statusMap = [
                                        0 => [
                                            'label' => 'Pending',
                                            'bg' => 'bg-yellow-100',
                                            'text' => 'text-yellow-800',
                                        ],
                                        1 => [
                                            'label' => 'Approved',
                                            'bg' => 'bg-green-100',
                                            'text' => 'text-green-800',
                                        ],
                                        2 => ['label' => 'Cancelled', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                    ];

                                    $status = $mealOrder->status ?? 0; // default 0 if null
                                @endphp
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $statusMap[$status]['bg'] }} {{ $statusMap[$status]['text'] }}">
                                    {{ $statusMap[$status]['label'] }}
                                </span>
                                <p class="text-orange-600 font-medium mt-2">⚠️ Please mention Order ID:
                                    {{ $mealOrder->id }} when contacting</p>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button wire:click="$set('showCancelModal', false)"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Close
                            </button>
                            <button onclick="copyContactInfo()"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-copy mr-2"></i>Copy Contact Info
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Cancel Booking?</h2>
                        <p class="text-gray-600 mb-6">Are you sure you want to cancel this booking?</p>
                        <div class="flex justify-center gap-4">
                            <button wire:click="$set('showCancelModal', false)"
                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">No</button>
                            <button wire:click="cancelBooking"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes,
                                Cancel</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('show-meal-cancel-modal', event => {
        const mealOrder = event.detail.mealOrder;
        const eventName = event.detail.eventName;

        // Show your custom meal order popup here
        console.log("Meal Order Detected for:", eventName, mealOrder);
        // Tulis code untuk render modal HTML yang awak dah buat
    });

    window.addEventListener('show-cancel-confirmation-modal', event => {
        const eventName = event.detail.eventName;
        const eventId = event.detail.eventId;

        if (confirm(`Are you sure you want to cancel "${eventName}" booking?`)) {
            Livewire.emit('cancelEvent', eventId);
        }
    });
</script>
