{{-- <?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div id="loginScreen" class="min-h-screen flex items-center justify-center premium-gradient">
    <div class="premium-card p-10 rounded-3xl shadow-2xl w-96 border border-white/30">
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

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form wire:submit="login" class="space-y-8">
            <div>
                <x-input-label for="email" :value="__('Email')"
                    class="block text-sm font-semibold text-gray-700 mb-3" />
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <x-text-input wire:model="form.email" id="email" type="email" name="email"
                        class="w-full pl-12 pr-4 py-4 bg-white/80 border border-gray-300 rounded-xl 
                        text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 
                        focus:border-transparent transition-all"
                        placeholder="Enter your email" required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')"
                    class="block text-sm font-semibold text-gray-700 mb-3" />
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <x-text-input wire:model="form.password" id="password" type="password" name="password"
                        class="w-full pl-12 pr-4 py-4 bg-white/80 border border-gray-300 rounded-xl 
                        text-gray-800 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 
                        focus:border-transparent transition-all"
                        placeholder="Enter your password" required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember" class="inline-flex items-center text-sm text-gray-600">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 font-medium underline"
                        href="{{ route('password.request') }}" wire:navigate>
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl 
                hover:from-blue-700 hover:to-purple-700 transition duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-500 text-sm font-medium">🚀 Demo Credentials:</p>
            <div class="mt-3 text-xs text-gray-400 space-y-1">
                <p><span class="font-semibold">Staff:</span> staff@example.com / password</p>
                <p><span class="font-semibold">Dietary:</span> dietary@example.com / password</p>
                <p><span class="font-semibold">Admin:</span> admin@example.com / password</p>
                <p><span class="font-semibold">IT Admin:</span> itadmin@example.com / password</p>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm mb-2">New Staff Member?</p>
                <a href="{{ route('register') }}" wire:navigate
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium underline">
                    Register Here
                </a>
            </div>
        </div>
    </div>
</div> --}}
