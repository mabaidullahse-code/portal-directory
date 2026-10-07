<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name', 'Portal Directory') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex flex-col min-h-screen selection:bg-blue-600 selection:text-white">
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Executive Top Navigation Bar -->
        <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/90 sticky top-0 z-40 shadow-xs">
            <div class="w-full px-3 sm:px-6">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <!-- Brand & Executive Badge -->
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-lg bg-white flex items-center justify-center shadow-xs p-1 shrink-0 overflow-hidden">
                            <img src="{{ asset('images/uhs-logo.png') }}" alt="UHS Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-base sm:text-lg tracking-tight">
                                    {{ config('app.name', 'Portal Directory') }}
                                </span>
                                <span class="hidden sm:inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/70">
                                    Executive Suite
                                </span>
                            </div>
                            <span class="text-xs text-slate-500 font-medium block leading-tight">
                                Office of the Vice Chancellor &bull; Direct Access Hub
                            </span>
                        </div>
                    </div>

                    <!-- Right Controls / Indicators -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        <!-- Live Operational Badge -->
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 font-medium">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Direct Link Active</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-slate-500">{{ now()->format('l, M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 w-full px-3 sm:px-6 py-4 sm:py-6">
            {{ $slot }}
        </main>

        <!-- Executive Footer -->
        <footer class="mt-auto border-t border-slate-200/80 bg-white py-6">
            <div class="w-full px-3 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-700">{{ config('app.name', 'Portal Directory') }}</span>
                    <span>&bull;</span>
                    <span>Office of the Vice Chancellor</span>
                    <span>&bull;</span>
                    <span>Institutional Executive Gateway</span>
                </div>
                <div class="text-slate-400 text-center sm:text-right">
                    &copy; {{ date('Y') }} All Rights Reserved &bull; High Availability Enterprise Network
                </div>
            </div>
        </footer>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
