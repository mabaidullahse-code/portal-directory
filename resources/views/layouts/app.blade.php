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
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex flex-col min-h-screen">
    <div x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="flex-1 flex flex-col">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Brand & Left items -->
                    <div class="flex items-center gap-4">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                                class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <a href="{{ route('directory.index') }}" class="flex items-center gap-3 group">
                            <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shadow-xs border border-slate-200 p-1 overflow-hidden shrink-0">
                                <img src="{{ asset('images/uhs-logo.png') }}" alt="UHS Logo" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 text-base tracking-tight block leading-tight">
                                    {{ config('app.name', 'Portal Directory') }}
                                </span>
                                <span class="text-[11px] text-slate-500 font-medium block leading-none">
                                    Enterprise Portal System
                                </span>
                            </div>
                        </a>
                    </div>

                    <!-- Right Navigation / User Menu -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('directory.index') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Live Directory</span>
                        </a>

                        @auth
                            <!-- User Profile Dropdown -->
                            <div class="relative" @click.away="userDropdownOpen = false">
                                <button type="button" @click="userDropdownOpen = !userDropdownOpen"
                                        class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition focus:outline-none">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                        {{ auth()->user()->initials }}
                                    </div>
                                    <div class="text-left hidden md:block">
                                        <div class="text-xs font-semibold text-slate-800 leading-tight">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 flex items-center gap-1.5">
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-semibold border {{ auth()->user()->role->badgeClasses() }}">
                                                {{ auth()->user()->role->label() }}
                                            </span>
                                            @if(auth()->user()->department)
                                                <span class="truncate max-w-[120px]">{{ auth()->user()->department->short_name ?: auth()->user()->department->code }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="userDropdownOpen" x-transition
                                     style="display: none;"
                                     class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-lg ring-1 ring-black/5 divide-y divide-slate-100 z-50">
                                    <div class="p-3">
                                        <p class="text-xs font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                        <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                        @if(auth()->user()->department)
                                            <p class="text-[10px] text-blue-600 font-medium mt-1 truncate">
                                                🏢 {{ auth()->user()->department->name }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span>My Profile</span>
                                        </a>
                                    </div>
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 transition text-left">
                                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                <span>Sign Out</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-slate-900 hover:bg-slate-800 transition">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Wrapper with Sidebar (Full width) -->
        <div class="flex-1 w-full px-4 sm:px-6 lg:px-8 py-6 flex gap-6">
            @auth
                <!-- Desktop Sidebar -->
                <aside class="hidden lg:block w-64 shrink-0">
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 sticky top-22 shadow-xs space-y-6">
                        @include('layouts.navigation-sidebar')
                    </div>
                </aside>

                <!-- Mobile Drawer -->
                <div x-show="mobileMenuOpen"
                     style="display: none;"
                     class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
                    <div x-show="mobileMenuOpen"
                         x-transition:enter="transition-opacity ease-linear duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity ease-linear duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs"></div>

                    <div class="fixed inset-0 flex">
                        <div x-show="mobileMenuOpen"
                             x-transition:enter="transition ease-in-out duration-300 transform"
                             x-transition:enter-start="-translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transition ease-in-out duration-300 transform"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="-translate-x-full"
                             @click.away="mobileMenuOpen = false"
                             class="relative mr-16 flex w-full max-w-xs flex-1">
                            <div class="flex-1 bg-white p-5 overflow-y-auto">
                                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-4">
                                    <span class="font-bold text-slate-900">{{ config('app.name') }}</span>
                                    <button @click="mobileMenuOpen = false" class="p-1 rounded text-slate-400 hover:text-slate-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                @include('layouts.navigation-sidebar')
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

        <footer class="mt-auto border-t border-slate-200 bg-white py-4">
            <div class="w-full px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Portal Directory') }}. Professional Enterprise Solution.
            </div>
        </footer>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
