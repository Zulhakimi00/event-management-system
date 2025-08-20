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
    <div class="flex-1 flex flex-col">
        {{ $slot }}
    </div>
    @livewireScripts

</body>

</html>
