<div class="p-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-calendar-alt text-purple-600 mr-4"></i>Event Management
            </h2>
        </div>

        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Special Guest -->
            <div class="bg-purple-50 rounded-xl p-6">
                <h4 class="font-bold text-purple-900 mb-3">Special Guests</h4>
                <div class="space-y-2">
                    @foreach ($specialGuests as $guest)
                        <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                            <span>{{ $guest->name }}</span>
                            <div class="space-x-2">
                                <button wire:click="openSpecialGuestModal({{ $guest->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteSpecialGuest({{ $guest->id }})"
                                    class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure want to delete?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button wire:click="openSpecialGuestModal"
                    class="mt-4 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Guest
                </button>
            </div>

            <!-- Serving Method -->
            <div class="bg-green-50 rounded-xl p-6">
                <h4 class="font-bold text-green-900 mb-3">Serving Methods</h4>
                <div class="space-y-2">
                    @foreach ($servingMethods as $method)
                        <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                            <span>{{ $method->name }}</span>
                            <div class="space-x-2">
                                <button wire:click="openServingMethodModal({{ $method->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteServingMethod({{ $method->id }})"
                                    class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure want to delete?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button wire:click="openServingMethodModal"
                    class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Method
                </button>
            </div>

            <!-- IT Equipment -->
            <div class="bg-blue-50 rounded-xl p-6">
                <h4 class="font-bold text-blue-900 mb-3">IT Equipment</h4>
                <div class="space-y-2">
                    @foreach ($itEquipments as $equipment)
                        <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                            <span>{{ $equipment->name }}</span>
                            <div class="space-x-2">
                                <button wire:click="openITEquipmentModal({{ $equipment->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteITEquipment({{ $equipment->id }})"
                                    class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure want to delete?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button wire:click="openITEquipmentModal"
                    class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Equipment
                </button>
            </div>

            <!-- Meal Session -->
            <div class="bg-yellow-50 rounded-xl p-6">
                <h4 class="font-bold text-yellow-900 mb-3">Meal Sessions</h4>
                <div class="space-y-2">
                    @foreach ($mealSessions as $meal)
                        <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                            <span>{{ $meal->name }} ({{ $meal->start_time }} - {{ $meal->end_time }})</span>
                            <div class="space-x-2">
                                <button wire:click="openMealSessionModal({{ $meal->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteMealSession({{ $meal->id }})"
                                    class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure want to delete?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button wire:click="openMealSessionModal"
                    class="mt-4 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 text-sm">
                    <i class="fas fa-plus mr-1"></i>Add Session
                </button>
            </div>

        </div>
    </div>

    <!-- -------------------- Modals -------------------- -->

    <!-- Special Guest Modal -->
    @if ($showSpecialGuestModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add / Edit Special Guest</h2>
                <input type="text" wire:model="specialGuestName"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Guest Name" />
                <div class="flex justify-end gap-2">
                    <button wire:click="closeSpecialGuestModal"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="saveSpecialGuest"
                        class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Save</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showServingMethodModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add / Edit Serving Method</h2>
                <input type="text" wire:model="servingMethodName"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Method Name" />
                <div class="flex justify-end gap-2">
                    <button wire:click="closeServingMethodModal"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="saveServingMethod"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showITEquipmentModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add / Edit IT Equipment</h2>
                <input type="text" wire:model="itEquipmentName"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Equipment Name" />
                <div class="flex justify-end gap-2">
                    <button wire:click="closeITEquipmentModal"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="saveITEquipment"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showMealSessionModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add / Edit Meal Session</h2>
                <div class="space-y-4">
                    <input type="text" wire:model="mealSessionName"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Session Name" />
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-sm text-gray-700">Start Time</label>
                            <input type="time" wire:model="mealStartTime"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1" />
                        </div>
                        <div>
                            <label class="text-sm text-gray-700">End Time</label>
                            <input type="time" wire:model="mealEndTime"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1" />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="closeMealSessionModal"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button wire:click="saveMealSession"
                        class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Save</button>
                </div>
            </div>
        </div>
    @endif

</div>
