<div id="loginScreen" class="min-h-screen flex items-center justify-center premium-gradient">
    <div class="premium-card p-10 rounded-3xl shadow-2xl w-96 border border-white/30">

        {{-- 🔴 Popup Error kalau login gagal --}}
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="text-center mb-10">
            <div
                class="w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <i class="fas fa-calendar-alt text-2xl text-white"></i>
            </div>
            <h1
                class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                SmartEvent Pro</h1>
            <p class="text-gray-600 text-lg">Advanced Event Management System</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-8">
            {{-- Username --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Username</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" wire:model="email"
                        class="w-full pl-12 pr-4 py-4 bg-white/80 border border-gray-300 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Enter your username" required>
                </div>
                {{-- error msg --}}
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" wire:model="password"
                        class="w-full pl-12 pr-4 py-4 bg-white/80 border border-gray-300 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Enter your password" required>
                </div>
                {{-- error msg --}}
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 transition duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </button>
        </form>

        <div class="mt-6 text-center">


            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm mb-2">New Staff Member?</p>
                <a href="{{ route('register') }}"
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium underline">
                    Register Here
                </a>
            </div>
        </div>
    </div>
</div>
