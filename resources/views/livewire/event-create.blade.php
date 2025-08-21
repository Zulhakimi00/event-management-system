<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
                <i class="fas fa-plus-circle text-blue-600 mr-4"></i>Create New Event
            </h2>

            @if (session()->has('message'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-8">

                <!-- Event Info -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Event Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Event Name *</label>
                            <input type="text" wire:model="name"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter event name">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Department *</label>
                            <select wire:model="department_id"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Function Type *</label>
                            <select wire:model="function_type"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Function</option>
                                @foreach ($allEventType as $event_type)
                                    <option value="{{ $event_type->id }}">{{ $event_type->name }}</option>
                                @endforeach
                            </select>
                            @error('function_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Contact Person *</label>
                            <input type="text" wire:model="contact_no"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Contact person/phone">
                            @error('contact_no')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule & Venue -->
                <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clock text-purple-600 mr-2"></i>Schedule & Venue
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Pilih Tarikh --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Date *</label>
                            <input type="date" wire:model="date"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Masa Mula --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Start Time *</label>
                            <select wire:model="start_time"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select Start Time</option>
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            </select>
                            @error('start_time')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Masa Tamat --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">End Time *</label>
                            <select wire:model="end_time"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select End Time</option>
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endforeach
                            </select>
                            @error('end_time')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Venue --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Venue *</label>
                            <select wire:model="location_id"
                                class="w-full p-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Select Venue</option>
                                @foreach ($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- IT Equipment -->
                <div class="bg-cyan-50 rounded-xl p-6 border border-cyan-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-laptop text-cyan-600 mr-2"></i>IT Equipment Requirements
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($allEquipments as $equipment)
                            <label
                                class="flex items-center p-3 bg-white rounded-lg border hover:border-cyan-300 cursor-pointer">
                                <input type="checkbox" value="{{ $equipment->id }}" wire:model="it_equipment"
                                    class="mr-2">
                                {{ $equipment->name }}
                            </label>
                        @endforeach
                    </div>

                </div>

                <!-- Meal Section -->
                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-utensils text-green-600 mr-2"></i>Meal Requirements
                        </h3>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.live="require_meals" class="mr-2">
                            <span class="font-medium">This event requires meals</span>
                        </label>

                    </div>
                    @error('require_meals')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @if ($require_meals)
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Select Meal Sessions *</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($mealSessions as $session)
                                        <div wire:click="$toggle('selectedMeals.{{ $session->id }}')"
                                            class="meal-session-card p-4 rounded-lg border cursor-pointer transition-all
                                            @if (isset($selectedMeals[$session->id]) && $selectedMeals[$session->id]) bg-green-200 border-green-400 @else bg-white border-gray-300 @endif">
                                            <input type="checkbox" wire:model="selectedMeals.{{ $session->id }}"
                                                class="hidden">
                                            <div class="text-center">
                                                <i class="fas fa-utensils text-2xl text-green-500 mb-2"></i>
                                                <p class="font-medium">{{ $session->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $session->start_time }} -
                                                    {{ $session->end_time }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-4">
                                @foreach ($mealSessions as $session)
                                    @if (isset($selectedMeals[$session->id]) && $selectedMeals[$session->id])
                                        <div class="bg-white p-4 rounded-lg border w-full">
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                {{ $session->name }} Time
                                            </label>
                                            <input type="time" wire:model.lazy="mealTimes.{{ $session->id }}"
                                                class="w-full p-2 border border-gray-300 rounded-lg"
                                                value="{{ $mealTimes[$session->id] ?? \Carbon\Carbon::parse($session->start_time)->format('H:i') }}"
                                                min="{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}"
                                                max="{{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}"
                                                required>

                                            <label class="block text-sm font-bold text-gray-700 mt-4 mb-2">
                                                {{ $session->name }} Request
                                            </label>
                                            <textarea wire:model.lazy="mealRequests.{{ $session->id }}" class="w-full p-2 border border-gray-300 rounded-lg"
                                                placeholder="Masukkan permintaan makanan untuk {{ $session->name }}..." required></textarea>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Pax</label>
                                    <input type="number" wire:model="total_pax"
                                        class="w-full p-3 border border-gray-300 rounded-lg" min="1">
                                    @error('total_pax')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Vegetarian Meals</label>
                                    <input type="number" wire:model="total_vegetarian_meal"
                                        class="w-full p-3 border border-gray-300 rounded-lg" min="0">
                                    @error('total_vegetarian_meal')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Special Guests</label>
                                    <select wire:model="special_guest_id"
                                        class="w-full p-3 border border-gray-300 rounded-lg">
                                        <option value="">Select Special Guest</option>
                                        @foreach ($specialGuests as $guest)
                                            <option value="{{ $guest->id }}">{{ $guest->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('special_guest_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Serving Method</label>
                                    <select wire:model="serving_method_id"
                                        class="w-full p-3 border border-gray-300 rounded-lg">
                                        <option value="">Select Method</option>
                                        @foreach ($servingMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('serving_method_id')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Meal Remarks /
                                    Requests</label>
                                <textarea wire:model="meal_remark" class="w-full p-3 border border-gray-300 rounded-lg"
                                    placeholder="Special meal instructions"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Dietary Requirements</label>
                                <textarea wire:model="dietary_requirements" class="w-full p-3 border border-gray-300 rounded-lg"
                                    placeholder="Allergies or special dietary needs"></textarea>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <button type="button" wire:click="resetForm"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium">
                        Reset Form
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold shadow-lg">
                        🚀 Create Event
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
