<div id="homeSection" class="p-8">
    <!-- Welcome Banner -->
    <div
        class="stats-card rounded-2xl p-8 text-white mb-8 relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-700">
        <div class="relative z-10">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-3">
                        Welcome back, {{ $userName }}! 👋
                    </h2>
                    <p class="text-blue-100 text-lg">
                        Here's what's happening with your events today
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold">{{ now()->format('H:i') }}</div>
                    <div class="text-blue-100 text-lg">{{ now()->format('l, d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ $totalEvents }}</div>
                    <div class="text-sm opacity-90">Total Events</div>
                </div>
                <i class="fas fa-calendar-alt text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ $pendingOrders }}</div>
                    <div class="text-sm opacity-90">Pending Orders</div>
                </div>
                <i class="fas fa-utensils text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">{{ $upcomingEvents }}</div>
                    <div class="text-sm opacity-90">This Week</div>
                </div>
                <i class="fas fa-clock text-3xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-3xl font-bold">●</div>
                    <div class="text-sm opacity-90">System Online</div>
                </div>
                <i class="fas fa-server text-3xl opacity-80"></i>
            </div>
        </div>
    </div>
</div>
