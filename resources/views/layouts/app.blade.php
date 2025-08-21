<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEvent Pro - Dashboard</title>

    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        .sidebar-expanded {
            width: 280px;
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .sidebar-text {
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .sidebar-text {
            opacity: 0;
            pointer-events: none;
        }

        .nav-btn {
            transition: all 0.3s ease;
        }

        .nav-btn.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">

    {{-- SIDEBAR --}}
    <div id="sidebar"
        class="sidebar-expanded transition-all bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex flex-col shadow-2xl">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-xl text-white"></i>
                    </div>
                    <div class="sidebar-text">
                        <span
                            class="font-bold text-xl bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">SmartEvent</span>
                        <p class="text-xs text-gray-400">Pro Edition</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="p-2 hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-6 space-y-3">
            <a href="{{ route('dashboard') }}"
                class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                <i class="fas fa-tachometer-alt text-lg"></i>
                <span class="sidebar-text font-medium">Dashboard</span>
            </a>

            <a href="{{ route('calendar') }}"
                class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                <i class="fas fa-calendar text-lg"></i>
                <span class="sidebar-text font-medium">Calendar</span>
            </a>

            <a href="{{ route('booking') }}"
                class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                <i class="fas fa-book text-lg"></i>
                <span class="sidebar-text font-medium">Booking</span>
            </a>
            @role('staff')
                <a href="{{ route('create-booking') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-plus text-lg"></i>
                    <span class="sidebar-text font-medium">Create Booking</span>
                </a>
            @endrole


            @role('admin')
                <a href="{{ route('admin-dashboard') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="sidebar-text font-medium">Admin Panel</span>
                </a>
                <a href="{{ route('user-management') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-users text-lg"></i>
                    <span class="sidebar-text font-medium">User Management</span>
                </a>
                <a href="{{ route('event-management') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-calendar-alt text-lg"></i>
                    <span class="sidebar-text font-medium ml-3">Event Management</span>
                </a>
            @endrole

            @role('it admin')
                <a href="{{ route('admin-dashboard') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="sidebar-text font-medium">Admin Panel</span>
                </a>
            @endrole

            @role('dietary')
                <a href="{{ route('meal-orders-management') }}"
                    class="nav-btn w-full flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-700 transition-all">
                    <i class="fas fa-utensils text-lg"></i>
                    <span class="sidebar-text font-medium">Meal Orders Management</span>
                </a>
            @endrole

        </nav>

        {{-- User Info --}}
        <div class="p-6 border-t border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        <span
                            class="text-lg font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="sidebar-text">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->role ?? 'User' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="p-3 hover:bg-gray-700 rounded-xl transition-colors">
                        <i class="fas fa-sign-out-alt text-lg text-red-400"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- TOP HEADER BAR --}}
        <header class="bg-white shadow-lg border-b border-gray-200 px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <h1 id="pageTitle"
                        class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center space-x-6">
                    <button onclick="toggleDarkMode()" class="p-3 hover:bg-gray-100 rounded-xl transition-colors">
                        <i id="darkModeIcon" class="fas fa-moon text-gray-600"></i>
                    </button>

                    <div class="text-sm text-gray-600 font-medium">
                        <i class="fas fa-clock mr-2"></i>
                        <span id="currentDateTime"></span>
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6 flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-collapsed');
        }

        function toggleDarkMode() {
            document.body.classList.toggle('bg-gray-900');
            document.body.classList.toggle('text-white');
            document.getElementById('darkModeIcon').classList.toggle('fa-sun');
            document.getElementById('darkModeIcon').classList.toggle('fa-moon');
        }

        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDateTime').textContent =
                now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
</body>

</html>
