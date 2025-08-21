<div class="p-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-users-cog text-blue-600 mr-4"></i>User Management
            </h2>
            <button wire:click="openUserModal"
                class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 font-medium">
                <i class="fas fa-user-plus mr-2"></i>Add New User
            </button>
        </div>

        <!-- Venue & Department -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Venue Management</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Venues -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <h4 class="font-bold text-blue-900 mb-3">Current Venues</h4>
                    <div class="space-y-2">
                        @foreach ($venues as $venue)
                            <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                                <span>{{ $venue['name'] }}</span>

                                <div class="space-x-2">
                                    <button wire:click="editVenue({{ $venue['id'] }})"
                                        class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button wire:click="deleteVenue({{ $venue['id'] }})"
                                        class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this venue?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button wire:click="openVenueModal"
                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        <i class="fas fa-plus mr-1"></i> Add Venue
                    </button>
                </div>

                <!-- Departments -->
                <div class="bg-green-50 rounded-xl p-6">
                    <h4 class="font-bold text-green-900 mb-3">Department Management</h4>
                    <div class="space-y-2">
                        @foreach ($departments as $dept)
                            <div class="p-3 bg-white rounded-lg shadow border flex justify-between items-center">
                                <span> {{ $dept['name'] }}</span>
                                {{-- 
                                <div class="space-x-2">
                                    <button wire:click="openDepartmentModal({{ $dept['id'] }})"
                                        class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button wire:click="deleteDepartment({{ $dept['id'] }})"
                                        class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this venue?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                    {{-- <button wire:click="openDepartmentModal"
                        class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                        <i class="fas fa-plus mr-1"></i>Add Department
                    </button> --}}
                </div>
            </div>
        </div>

        <!-- Users -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">System Users</h3>
            <div class="space-y-4">
                @foreach ($users as $user)
                    <div class="p-4 bg-white rounded-lg shadow border flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->getRoleNames()->first() }} -
                                {{ $user->department->name }}</p>
                        </div>
                        <button wire:click="deleteUser({{ $user->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                            Remove
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if ($showVenueModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">Add New Venue</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Venue Name</label>
                        <input type="text" wire:model="venueName"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Capacity</label>
                        <input type="number" wire:model="venueCapacity"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeVenueModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button wire:click="saveVenue"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Save Venue
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showDepartmentModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Add New Department</h2>
                <form wire:submit.prevent="saveDepartment">
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700">Department Name</label>
                        <input type="text" wire:model="departmentName" class="w-full border rounded px-3 py-2">
                        @error('departmentName')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button wire:click="closeDepartmentModal"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showUserModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8">
                <h2 class="text-2xl font-bold mb-6">👤 Add New User</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                        <input type="text" wire:model="userName" class="w-full p-3 border rounded-lg">
                        @error('userName')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Staff ID *</label>
                        <input type="text" wire:model="userStaffId" class="w-full p-3 border rounded-lg">
                        @error('userStaffId')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Department *</label>
                        <select wire:model="userDepartmentId" class="w-full p-3 border rounded-lg">
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('userDepartmentId')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">User Role *</label>
                        <select wire:model="userRole" class="w-full p-3 border rounded-lg">
                            <option value="">Select Role</option>
                            @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('userRole')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Username *</label>
                        <input type="text" wire:model="userUsername" class="w-full p-3 border rounded-lg">
                        @error('userUsername')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password *</label>
                        <input type="password" wire:model="userPassword" class="w-full p-3 border rounded-lg">
                        @error('userPassword')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t mt-6">
                    <button wire:click="closeUserModal"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button wire:click="saveUser"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add User
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
