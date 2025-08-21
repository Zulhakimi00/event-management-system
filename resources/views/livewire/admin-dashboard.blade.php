<div class="p-8">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
            <i class="fas fa-cog text-blue-600 mr-4"></i>Admin Panel
        </h2>

        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="p-6 bg-blue-50 rounded-xl border border-blue-200">
                <h3 class="text-lg font-bold text-blue-900 mb-4">System Overview</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Total Events:</span>
                        <span class="font-bold">{{ $totalEvents }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Active Users:</span>
                        <span class="font-bold">{{ $activeUsers }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pending Orders:</span>
                        <span class="font-bold">{{ $pendingOrders }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-red-50 rounded-xl border border-red-200">
                <h3 class="text-lg font-bold text-red-900 mb-4">🚨 Priority Actions</h3>
                <div class="space-y-3">
                    <button wire:click="$dispatch('showPriorityModal')"
                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-medium">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Cancel Event for Urgent Use
                    </button>
                    <p class="text-xs text-red-700 mt-2">⚠️ Use only for urgent venue requirements. This will
                        immediately cancel existing bookings.</p>
                </div>
            </div>

            <div class="p-6 bg-green-50 rounded-xl border border-green-200">
                <h3 class="text-lg font-bold text-green-900 mb-4">📊 System Status</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span>System Online</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span>Booking System Active</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                        <span>Meal Orders Processing</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Venue & Department Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                <h3 class="text-lg font-bold text-blue-900 mb-4">📍 Available Venues (View Only)</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @forelse ($venues as $venue)
                        <div class="bg-white px-3 py-2 rounded shadow-sm border">{{ $venue->name }}</div>
                    @empty
                        <p class="text-sm text-gray-500">No venues available.</p>
                    @endforelse
                </div>
                <p class="text-xs text-blue-600 mt-3">ℹ️ Contact IT Admin to modify venues</p>
            </div>

            <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                <h3 class="text-lg font-bold text-green-900 mb-4">🏢 Departments (View Only)</h3>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @forelse ($departments as $department)
                        <div class="bg-white px-3 py-2 rounded shadow-sm border">{{ $department->name }}</div>
                    @empty
                        <p class="text-sm text-gray-500">No departments available.</p>
                    @endforelse
                </div>
                <p class="text-xs text-green-600 mt-3">ℹ️ Contact IT Admin to modify departments</p>
            </div>
        </div>

        {{-- Event Management --}}
        <div class="bg-gray-50 rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">🗓️ Event Management & Cancellation</h3>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Admin can cancel events for urgent venue needs
                </div>
            </div>

            <div class="space-y-4">
                @forelse ($events as $event)
                    <div class="p-4 bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Title & badges -->
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-bold text-gray-900">{{ $event->name }}</h4>

                                    @if ($event->has_meals)
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">🍽️
                                            Meals</span>
                                    @endif

                                    @if (now()->diffInDays($event->event_date, false) <= 2)
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">⏰
                                            Soon</span>
                                    @endif
                                </div>

                                <!-- Event Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">
                                            <strong>📅 Date:</strong> {{ $event->date }}
                                        </p>
                                        <p class="text-gray-600">
                                            <strong>⏰ Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}
                                        </p>
                                        <p class="text-gray-600">
                                            <strong>📍 Venue:</strong> {{ $event->location->name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">
                                            <strong>🏢 Department:</strong> {{ $event->department->name ?? '-' }}
                                        </p>
                                        <p class="text-gray-600">
                                            <strong>👤 Organizer:</strong> {{ $event->createdBy->name ?? '-' }}
                                        </p>

                                        @if ($event->mealOrder)
                                            <p class="text-blue-600">
                                                <strong>👥 Attendees:</strong> {{ $event->mealOrder->pax }} people
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Meal details -->
                                @if ($event->meals)
                                    <div class="mt-2 p-2 bg-blue-50 rounded text-xs">
                                        <strong>Meal Sessions:</strong>
                                        {{ implode(', ', $event->meals->sessions ?? []) }} •
                                        <strong>Status:</strong>
                                        <span
                                            class="{{ $event->meals->status == 1
                                                ? 'bg-green-100 text-green-800'
                                                : ($event->meals->status == 2
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}
    px-2 py-1 rounded text-xs
">
                                            {{ $event->meals->status == 1 ? 'Approve' : ($event->meals->status == 2 ? 'Cancel' : 'Pending') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="ml-4 space-y-2">
                                <button wire:click="showEventMealModal({{ $event->id }})"
                                    class="w-full bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </button>

                                <button wire:click="confirmCancel({{ $event->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Cancel
                                </button>

                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent events found.</p>
                @endforelse
            </div>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('livewire:init', () => {
        // Listener untuk popup
        Livewire.on('show-cancel-popup', (data) => {
            console.log('show-cancel-popup triggered:', data); // Debug
            Swal.fire({
                title: 'Pasti nak batalkan event?',
                text: "Tindakan ini tidak boleh diundurkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('cancelEventConfirmed', {
                        eventId: data.id // <-- guna data.id, bukan event.id
                    });
                }
            });
        });
        // Listener untuk toast
        Livewire.on('show-toast', (data) => {
            console.log('show-toast triggered:', data); // Debug
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.type,
                title: data.message,
                showConfirmButton: false,
                timer: 3000
            });
        });
    });
</script>
