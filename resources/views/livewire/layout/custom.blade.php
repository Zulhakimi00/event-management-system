<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Event Management')</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-100">

    {{-- Navbar custom --}}
    <header class="bg-blue-600 text-white p-4">
        <h1>Custom Header</h1>
    </header>

    {{-- Content --}}
    <main class="p-6">
        {{ $slot }}
    </main>

    {{-- Footer custom --}}
    <footer class="bg-gray-800 text-white p-4 text-center">
        Custom Footer © 2025
    </footer>

    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
