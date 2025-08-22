<div class="min-h-screen flex items-center justify-center premium-gradient">
    <div class="premium-card p-10 rounded-3xl shadow-2xl w-96 border border-white/30 bg-">
        <div class="text-center mb-8">
            <div
                class="w-20 h-20 bg-gradient-to-r from-green-600 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <i class="fas fa-user-plus text-2xl text-white"></i>
            </div>
            <h1
                class="text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-3">
                New Staff Registration</h1>
            <p class="text-gray-600">Join SmartEvent Pro System</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model="email" class="w-full border rounded p-2">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Staff ID</label>
                <input type="text" wire:model="staff_id" class="w-full border rounded p-2">
                @error('staff_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Department</label>
                <select wire:model="department_id" class="w-full border rounded p-2">
                    <option value="">-- Pilih Department --</option>
                    @foreach (\App\Models\Department::all() as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Kata Laluan</label>
                <input type="password" wire:model="password" class="w-full border rounded p-2">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Sahkan Kata Laluan</label>
                <input type="password" wire:model="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Daftar
            </button>
        </form>
    </div>
</div>
