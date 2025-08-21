<div>
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-utensils text-green-600 mr-4"></i>Meal Orders Management
        </h2>

        <div class="flex items-center space-x-4">
            <label class="text-sm font-medium text-gray-700">View Orders:</label>
            <select wire:model="filter"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500">
                <option value="all">All Orders</option>
                <option value="reminders">⏰ Reminders (2 days)</option>
                <option value="3days">📅 Next 3 Days</option>
                <option value="week">📆 This Week</option>
                <option value="month">🗓️ This Month</option>
                <option value="pending">⏳ Pending Only</option>
                <option value="approved">✅ Approved Only</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-800">{{ $remindersCount }}</div>
                    <div class="text-sm text-yellow-600">2-Day Reminders</div>
                </div>
                <i class="fas fa-bell text-2xl text-yellow-500"></i>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-800">{{ $pendingCount }}</div>
                    <div class="text-sm text-blue-600">Pending Orders</div>
                </div>
                <i class="fas fa-clock text-2xl text-blue-500"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-800">{{ $approvedCount }}</div>
                    <div class="text-sm text-green-600">Approved Orders</div>
                </div>
                <i class="fas fa-check-circle text-2xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-purple-800">{{ $totalPaxCount }}</div>
                    <div class="text-sm text-purple-600">Total Attendees</div>
                </div>
                <i class="fas fa-users text-2xl text-purple-500"></i>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @foreach ($mealOrders as $order)
            @php
                $statusColors = [
                    1 => ['bg' => 'green-50', 'border' => 'green-500'],
                    0 => ['bg' => 'yellow-50', 'border' => 'yellow-500'],
                    2 => ['bg' => 'red-50', 'border' => 'red-500'],
                ];
                $statusBadge = [
                    1 => ['bg' => 'green-100', 'text' => 'green-800', 'label' => 'Approve'],
                    0 => ['bg' => 'yellow-100', 'text' => 'yellow-800', 'label' => 'Pending'],
                    2 => ['bg' => 'red-100', 'text' => 'red-800', 'label' => 'Cancel'],
                ];

                $color = $statusColors[$order->status] ?? ['bg' => 'gray-50', 'border' => 'gray-500'];
                $badge = $statusBadge[$order->status] ?? [
                    'bg' => 'gray-100',
                    'text' => 'gray-800',
                    'label' => 'Unknown',
                ];
            @endphp
            <div class="p-6 bg-{{ $color['bg'] }} rounded-xl border-l-4 border-{{ $color['border'] }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $order->event->name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                            <div>
                                <p class="text-gray-600"><strong>👥 Attendees:</strong> {{ $order->total_pax }}</p>
                                <p class="text-gray-600"><strong>🥬 Vegetarian:</strong>
                                    {{ $order->total_vegetarian_meal }}</p>
                                <p class="text-gray-600"><strong>🍽️ Sessions:</strong>
                                    {{ $order->details->pluck('mealSession.name')->join(', ') }}
                                </p>
                                <p class="text-gray-600"><strong>🍴 Serving:</strong>
                                    {{ $order->servingMethod->name ?? '-' }}</p>
                                <p class="text-gray-600"><strong>📅 Event Date:</strong>
                                    {{ \Carbon\Carbon::parse($order->event->date)->format('d/m/Y') }}</p>
                                @if ($order->specialGuest)
                                    <p class="text-purple-600"><strong>👑 Special Guests:</strong>
                                        {{ $order->specialGuest->name }}</p>
                                @endif
                            </div>
                            <div>
                                @if ($order->details->pluck('time')->filter()->isNotEmpty())
                                    <p class="text-blue-600"><strong>⏰ Custom Timing:</strong>
                                        {{ $order->details->pluck('time')->join(', ') }}
                                    </p>
                                @endif
                                @if ($order->details->pluck('remark')->filter()->isNotEmpty())
                                    <p class="text-gray-600"><strong>📝 Meal Details:</strong>
                                        {{ $order->details->pluck('remark')->join('; ') }}
                                    </p>
                                @endif
                                <p class="text-gray-500 text-sm"><strong>👤 Ordered by:</strong>
                                    {{ $order->created_by ?? 'System' }}</p>
                                <p class="text-gray-500 text-sm"><strong>📅 Order Date:</strong>
                                    {{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-right ml-4">
                        <span
                            class="bg-{{ $badge['bg'] }} text-{{ $badge['text'] }} px-3 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst($badge['label']) }}
                        </span>
                        <div class="flex flex-col gap-2 mt-2">
                            <div class="flex flex-col gap-2 mt-2">
                                <button wire:click="approve({{ $order->id }})"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm w-full">
                                    ✅ Approve
                                </button>

                                <button wire:click="cancel({{ $order->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm w-full">
                                    ❌ Cancel
                                </button>


                                <button wire:click="openEditModal({{ $order->id }})"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                                    ✏️ Edit
                                </button>
                                <button wire:click="showOrder({{ $order->id }})"
                                    class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Show
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach

    </div>


    @if ($isEditModalOpen)


        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">✏️ Edit Meal Order</h2>
                        <button wire:click="closeEditModal" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="updateOrder">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Total Attendees</label>
                                <input type="number" wire:model="editForm.total_pax" min="1"
                                    class="w-full p-3 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Vegetarian Meals</label>
                                <input type="number" wire:model="editForm.total_vegetarian_meal" min="0"
                                    class="w-full p-3 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Serving Method</label>
                                <select wire:model="editForm.serving_method_id"
                                    class="w-full p-3 border border-gray-300 rounded-lg">
                                    <option value="">-- Pilih Cara Hidangan --</option>
                                    @foreach ($servingMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Special Guest</label>
                                <select wire:model="editForm.special_guest_id"
                                    class="w-full p-3 border border-gray-300 rounded-lg">
                                    <option value="">-- Pilih Tetamu Khas --</option>
                                    @foreach ($specialGuests as $guest)
                                        <option value="{{ $guest->id }}">{{ $guest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Meal Details</label>
                            <textarea wire:model="editForm.remark" class="w-full p-3 border border-gray-300 rounded-lg h-24"></textarea>
                        </div>

                        <div class="mt-3">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Meal Sessions</h4>
                            <div class="space-y-4">
                                @foreach ($editForm['details'] as $detailId => $detail)
                                    <div class="p-4 border rounded-xl shadow-sm bg-white hover:shadow-md transition">

                                        {{-- Header: Session --}}
                                        <div class="flex items-center justify-between border-b pb-2 mb-3">
                                            <span class="text-sm font-medium text-gray-600">Session</span>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                {{ $mealSessions->firstWhere('id', $detail['meal_session_id'])->name ?? '-' }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {{-- Time --}}
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">⏰
                                                    Time</label>
                                                <input type="time"
                                                    wire:model.defer="editForm.details.{{ $detailId }}.time"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                            </div>

                                            {{-- Remark --}}
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">📝
                                                    Remark</label>
                                                <textarea rows="3" placeholder="Masukkan remark..."
                                                    wire:model.defer="editForm.details.{{ $detailId }}.remark"
                                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>


                        <div class="flex justify-end space-x-3 pt-4 border-t mt-6 bg-white sticky bottom-0">
                            <button type="button" wire:click="closeEditModal"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                💾 Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif
    @if ($showModal && $selectedOrder)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Order Details</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">Event Information</h3>
                        <p><strong>Name:</strong> {{ $selectedOrder->event->name }}</p>
                        <p><strong>Department:</strong> {{ $selectedOrder->event->department->name }}</p>
                        <p><strong>Function:</strong> {{ $selectedOrder->event->eventType->name }}</p>
                        <p><strong>Contact:</strong> {{ $selectedOrder->event->contact_no }}</p>
                        <p><strong>Status:</strong>
                            {{ ucfirst($selectedOrder->event->status == 1 ? 'approve' : 'cancel') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">Schedule & Venue</h3>
                        <p><strong>Date:</strong>
                            {{ \Carbon\Carbon::parse($selectedOrder->event->date)->format('d/m/Y') }}</p>
                        <p><strong>Start:</strong>
                            {{ \Carbon\Carbon::parse($selectedOrder->event->start_time)->format('H:i') }}</p>
                        <p><strong>End:</strong>
                            {{ \Carbon\Carbon::parse($selectedOrder->event->end_time)->format('H:i') }}</p>

                        <p><strong>Venue:</strong> {{ $selectedOrder->event->location->name }}</p>
                    </div>
                </div>
                @if ($selectedOrder)
                    <div class="bg-blue-50 p-4 mt-4 rounded-lg border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-2">🍴 Meal Information</h3>
                        <p><strong>Total Attendees:</strong> {{ $selectedOrder->total_pax ?? '-' }}</p>
                        <p><strong>Vegetarian Meals:</strong> {{ $selectedOrder->total_vegetarian_meal ?? '0' }}
                        </p>
                        <p><strong>Serving Method:</strong> {{ $selectedOrder->servingMethod->name ?? '-' }}</p>
                        <p><strong>Special Guests:</strong> {{ $selectedOrder->specialGuest->name ?? '-' }}</p>
                    </div>
                @endif
                @if ($selectedOrder->event->equipment && count($selectedOrder->event->equipment) > 0)
                    <div class="bg-cyan-50 p-4 mt-4 rounded-lg border border-cyan-200">
                        <h3 class="font-bold text-cyan-900 mb-2">IT Equipment Required</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($selectedOrder->event->equipment as $eq)
                                <span
                                    class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-sm">{{ ucfirst($eq) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($selectedOrder->details && $selectedOrder->details->count() > 0)
                    <div class="bg-gray-50 p-4 mt-4 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3">🍽️ Meal Sessions -
                            {{ $selectedOrder->meal->name ?? '' }}</h3>
                        <div class="space-y-3">
                            @foreach ($selectedOrder->details as $detail)
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
                    {{-- <button wire:click="exportPdf({{ $selectedOrder->id }})"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Export PDF</button> --}}
                    <button wire:click="closeModal"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>

</div>
