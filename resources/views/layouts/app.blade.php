<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CafeEase Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* This ensures the scrollbar is visible and fits your theme */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d4b08c;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3d2b1f;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 overflow-hidden m-0 p-0">
    <div class="flex overflow-hidden" style="height: 100vh; width: 100vw;">

        <aside class="flex-shrink-0 flex flex-col shadow-2xl z-20"
            style="width: 280px; background-color: #3d2b1f; height: 100vh;">

            <div class="p-8 mb-4">
                <h1 class="text-2xl font-black tracking-wider" style="color: #d4b08c; margin-bottom: 0.25rem;">CAFEEASE
                </h1>
                <p class="text-[10px] uppercase tracking-[0.2em]"
                    style="color: #d4b08c; opacity: 0.8; font-weight: 800;">Management System</p>
            </div>

            <nav class="flex-grow px-4 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ route('inventory.index') }}"
                    class="flex items-center w-full py-4 px-5 rounded-2xl transition-all duration-300 {{ request()->routeIs('inventory.*') ? 'bg-[#d4b08c]' : 'hover:bg-white/5' }}"
                    style="text-decoration: none;">
                    <span style="font-size: 1.25rem; margin-right: 1rem;">📦</span>
                    <span
                        style="font-weight: 700; font-size: 0.9rem; color: {{ request()->routeIs('inventory.*') ? '#ffffff' : '#d4b08c' }};">
                        Inventory
                    </span>
                </a>

                <a href="{{ route('staff.index') }}"
                    class="flex items-center w-full py-4 px-5 rounded-2xl transition-all duration-300 {{ request()->routeIs('staff.*') ? 'bg-[#d4b08c]' : 'hover:bg-white/5' }}"
                    style="text-decoration: none;">
                    <span style="font-size: 1.25rem; margin-right: 1rem;">👥</span>
                    <span
                        style="font-weight: 700; font-size: 0.9rem; color: {{ request()->routeIs('staff.*') ? '#ffffff' : '#d4b08c' }};">
                        Staff Management
                    </span>
                </a>

                <a href="{{ route('feedback.index') }}"
                    class="flex items-center w-full py-4 px-5 rounded-2xl transition-all duration-300 {{ request()->routeIs('feedback.*') ? 'bg-[#d4b08c]' : 'hover:bg-white/5' }}"
                    style="text-decoration: none;">
                    <span style="font-size: 1.25rem; margin-right: 1rem;">💬</span>
                    <span
                        style="font-weight: 700; font-size: 0.9rem; color: {{ request()->routeIs('feedback.*') ? '#ffffff' : '#d4b08c' }};">
                        Feedback
                    </span>
                </a>

                <a href="{{ route('reports.index') }}"
                    class="flex items-center w-full py-4 px-5 rounded-2xl transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-[#d4b08c]' : 'hover:bg-white/5' }}"
                    style="text-decoration: none;">
                    <span style="font-size: 1.25rem; margin-right: 1rem;">📊</span>
                    <span
                        style="font-weight: 700; font-size: 0.9rem; color: {{ request()->routeIs('reports.*') ? '#ffffff' : '#d4b08c' }};">
                        Reports
                    </span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full py-4 px-5 rounded-2xl hover:bg-red-600/10 transition-all border-none bg-transparent cursor-pointer">
                        <span style="font-size: 1.25rem; margin-right: 1rem;">🚪</span>
                        <span
                            style="font-weight: 800; font-size: 0.75rem; color: #d4b08c; text-transform: uppercase; letter-spacing: 0.1em;">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="height: 100vh;">

            <header
                class="flex-shrink-0 bg-white/60 backdrop-blur-xl border-b border-orange-50 px-10 py-6 flex justify-between items-center z-10">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-[#d4b08c] uppercase tracking-[0.3em]">Administrator</span>
                    <h2 class="text-sm font-bold text-[#3d2b1f] mt-1">{{ Auth::user()->name }}</h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-full border border-green-100">
                        <div class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-black text-green-600 uppercase tracking-widest">Live
                            Terminal</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-[#fcf9f1] custom-scrollbar">
                <div class="max-w-[1400px] mx-auto p-10 pb-40">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>
