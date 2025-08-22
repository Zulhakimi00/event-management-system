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
        .premium-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .premium-gradient {
            background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 50%, #45b7d1 100%);
        }

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
    <div class="flex-1 flex flex-col">
        {{ $slot }}
    </div>
    @livewireScripts

</body>

</html>
