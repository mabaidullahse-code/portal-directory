<x-filament-panels::page>
    @include('filament.pages.partials.portal-directory-styles')

    <div class="portal-dir-container space-y-6">
        <!-- Executive Header Banner (Professional Light/Dark Theme) -->
        <div class="relative overflow-hidden rounded-3xl from-white via-sky-50/30 to-blue-50/50 p-6 sm:p-8 text-slate-900 dark:text-white shadow-xs border border-blue-100/80 dark:border-slate-800">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start gap-4 max-w-3xl">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white border border-blue-100/90 dark:border-slate-700 shadow-sm ring-4 ring-blue-50/80 dark:ring-slate-800 p-1.5 shrink-0 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/uhs-logo.png') }}" alt="UHS Logo" class="w-full h-full object-contain">
                    </div>
                    <div class="space-y-2 flex-1 min-w-0">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/80 text-blue-900 dark:bg-blue-900/40 dark:text-blue-200 text-xs font-semibold border border-blue-200/70 dark:border-blue-700/50 shadow-2xs">
                            <svg width="14" height="14" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Vice Chancellor Oversight &bull; Executive Systems Access</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                            Welcome, Worthy Vice Chancellor
                        </h1>
                        <div class="text-sm font-semibold text-blue-700 dark:text-blue-400">Vice Chancellor Executive Portal Dashboard</div>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-2xl leading-relaxed">
                            Centralized launchpad for all organizational systems, institutional workflows, and university endpoints. Direct 1-click access to all active portals.
                        </p>
                    </div>
                </div>

                <!-- Quick Access Report Actions (Always Visible on VC Dashboard) -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <button type="button" wire:click="downloadPdf" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white text-xs sm:text-sm font-bold shadow-xs hover:shadow transition cursor-pointer disabled:opacity-75">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v6m0 0l-2.5-2.5M12 17l2.5-2.5" />
                        </svg>
                        <span wire:loading.remove wire:target="downloadPdf">Download PDF Report</span>
                        <span wire:loading wire:target="downloadPdf">Generating PDF...</span>
                    </button>

                    <!-- <button type="button" wire:click="downloadExcel" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs sm:text-sm font-bold shadow-xs hover:shadow transition cursor-pointer disabled:opacity-75">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6" />
                        </svg>
                        <span wire:loading.remove wire:target="downloadExcel">Download Excel Report</span>
                        <span wire:loading wire:target="downloadExcel">Generating Excel...</span>
                    </button> -->
                </div>
            </div>

            <!-- Telemetry Counters -->
            <div class="mt-6 pt-6 border-t border-blue-100/80 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-blue-100/80 dark:border-slate-700 shadow-2xs">
                    <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Active Portals</span>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $totalPortals }}</span>
                </div>
                <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-blue-100/80 dark:border-slate-700 shadow-2xs">
                    <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Departments</span>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $totalDepartments }}</span>
                </div>
                <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-blue-100/80 dark:border-slate-700 shadow-2xs">
                    <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Categories</span>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $totalCategories }}</span>
                </div>
                <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-3.5 border border-blue-100/80 dark:border-slate-700 shadow-2xs">
                    <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block uppercase tracking-wider">Staff Custodians</span>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $totalEmployees }}</span>
                </div>
            </div>
        </div>


        <!-- Search & Filter Controls Bar -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 shadow-xs">
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <!-- Search -->
                <div class="sm:col-span-5">
                    <div class="relative flex items-center">
                        <div style="position: absolute; left: 0.875rem; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: 10;">
                            <svg width="16" height="16" style="width: 16px; height: 16px; display: block;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Search portals by name, keyword, or purpose..."
                               style="padding-left: 2.5rem !important;"
                               class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 pl-10 pr-3 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Department Filter -->
                <div class="sm:col-span-4">
                    <select wire:model.live="departmentFilter"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-xs text-slate-900 dark:text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="all">All Departments ({{ $allDepartments->count() }})</option>
                        @foreach($allDepartments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="sm:col-span-3">
                    <select wire:model.live="categoryFilter"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-2 text-xs text-slate-900 dark:text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="all">All Categories</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Directory Design Layout Switcher -->
            <div class="mt-3.5 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>View Layout:</span>
                    </span>
                </div>

                @php
                    $designIcons = [
                        'buttons' => '⚡ Quick Launch',
                        'card_grid' => '▦ Card Grid',
                        'employee_sections' => '▤ Sections',
                        'radial' => '◉ Radial',
                        'compact' => '▧ Compact',
                        'dashboard' => '◫ Dashboard',
                        'cyber_matrix' => '⚡ Cyber HUD',
                        'constellation' => '✦ Starfield',
                        'prism_bento' => '◈ Bento',
                        'terminal_console' => '⌨ Terminal',
                    ];
                @endphp

                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <button type="button" wire:click="setLayout('buttons')"
                                class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $viewLayout === 'buttons' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                                title="Direct 1-Click Launch Button Cards Grid">
                            <span>⚡ Launch Grid</span>
                            @if(($defaultDesign ?? '') === 'buttons')
                                <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                            @endif
                        </button>

                        @foreach($designs as $d)
                            <button type="button" wire:click="setLayout('{{ $d->value }}')"
                                    class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $viewLayout === $d->value ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                                    title="{{ $d->description() }}">
                                <span>{{ $designIcons[$d->value] ?? $d->label() }}</span>
                                @if(($defaultDesign ?? '') === $d->value)
                                    <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                                @endif
                            </button>
                        @endforeach

                        <button type="button" wire:click="setLayout('departments')"
                                class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $viewLayout === 'departments' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                                title="Group Portals by Department">
                            <span>🏛️ By Dept</span>
                            @if(($defaultDesign ?? '') === 'departments')
                                <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                            @endif
                        </button>

                        <button type="button" wire:click="setLayout('categories')"
                                class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $viewLayout === 'categories' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                                title="Group Portals by Category">
                            <span>🏷️ By Category</span>
                            @if(($defaultDesign ?? '') === 'categories')
                                <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                            @endif
                        </button>

                        <button type="button" wire:click="setLayout('table')"
                                class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $viewLayout === 'table' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}"
                                title="Tabular Data Registry View">
                            <span>☰ Table View</span>
                            @if(($defaultDesign ?? '') === 'table')
                                <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                            @endif
                        </button>
                    </div>

                    <!-- Set Default View Button -->
                    <div class="flex items-center gap-1.5 sm:pl-2 sm:border-l sm:border-slate-200 dark:sm:border-slate-700">
                        @if($viewLayout === ($defaultDesign ?? ''))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-2xs"
                                  title="This view design is currently saved as your default">
                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Default</span>
                            </span>
                        @else
                            <button type="button" wire:click="makeDefault"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white shadow-xs hover:shadow transition cursor-pointer"
                                    title="Make the currently selected view layout the default design">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span>Make Default</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($search || $departmentFilter !== 'all' || $categoryFilter !== 'all')
                <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                    <span>Filtering active portals: <strong>{{ $portals->count() }}</strong> portal(s) matched</span>
                    <button type="button" wire:click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-semibold cursor-pointer">
                        Clear all filters
                    </button>
                </div>
            @endif
        </div>

        <!-- Main View Section: Link Buttons Only -->
        @if ($viewLayout === 'buttons')
            <!-- Direct Link Button Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4">
                @forelse ($portals as $portal)
                    <div class="portal-glass-card rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-md hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-300 flex flex-col justify-between p-5 group">
                        <div class="space-y-3">
                            <!-- Top Badges & Department -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                    🏛️ {{ $portal->target_department ?: ($portal->department ? ($portal->department->short_name ?: $portal->department->code) : 'Global') }}
                                </span>
                                @if($portal->category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                        {{ $portal->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Portal Identity -->
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                    {{ $portal->title }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $portal->purpose ?: 'Institutional operational workflow and management service.' }}
                                </p>
                            </div>

                            <!-- Target Departments Chips -->
                            @if($portal->targetDepartments->isNotEmpty())
                                <div class="flex flex-wrap items-center gap-1 pt-1">
                                    <span class="text-[10px] text-slate-400">Target:</span>
                                    @foreach($portal->targetDepartments->take(3) as $td)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                            {{ $td->short_name ?: $td->code }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Executive Action Buttons: LINK BUTTONS ONLY -->
                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2"
                             x-data="{ copied: false }">
                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                               class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white text-xs font-bold transition shadow-xs">
                                <span>Open Portal</span>
                                <svg width="14" height="14" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                            <button type="button"
                                    @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer"
                                    title="Copy portal URL to clipboard">
                                <span x-show="!copied">
                                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </span>
                                <span x-show="copied" style="display: none;" class="text-emerald-600 font-bold text-xs">✓</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-12 text-center">
                        <p class="text-xs text-slate-400">No active portals matching the current selection.</p>
                    </div>
                @endforelse
            </div>
        @elseif ($viewLayout === 'departments')
            <!-- Grouped by Department View -->
            <div class="space-y-6">
                @forelse ($departments as $dept)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                    {{ $dept->code }}
                                </span>
                                <h2 class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $dept->name }}
                                </h2>
                            </div>
                            <span class="text-xs font-semibold text-slate-500 font-mono">
                                {{ $dept->portals->count() }} System(s)
                            </span>
                        </div>

                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4">
                            @foreach ($dept->portals as $portal)
                                <div class="portal-glass-card p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 flex flex-col justify-between hover:border-indigo-400 transition"
                                     x-data="{ copied: false }">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $portal->title }}</h4>
                                            <span class="w-2 h-2 rounded-full shrink-0 bg-emerald-500"></span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">{{ $portal->purpose ?: 'Institutional workflow' }}</p>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-xs transition">
                                            <span>Open Portal</span>
                                            <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="p-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 transition cursor-pointer"
                                                title="Copy URL">
                                            <span x-show="!copied">
                                                <svg width="14" height="14" style="width: 14px; height: 14px; display: inline-block; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-600 font-bold text-xs">✓</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-12 text-center">
                        <p class="text-xs text-slate-400">No active portals matching the current selection.</p>
                    </div>
                @endforelse
            </div>
        @elseif ($viewLayout === 'categories')
            <!-- Grouped by Category View -->
            <div class="space-y-6">
                @forelse ($categories as $cat)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                    {{ $cat->emoji ?? '🏷️' }}
                                </span>
                                <div>
                                    <h2 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                        <span>{{ $cat->name }}</span>
                                    </h2>
                                    @if(!empty($cat->description))
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $cat->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 font-mono">
                                    {{ $cat->portals->count() }} System(s)
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    {{ $cat->code }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4">
                            @foreach ($cat->portals as $portal)
                                <div class="portal-glass-card p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 flex flex-col justify-between hover:border-indigo-400 transition"
                                     x-data="{ copied: false }">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-2">
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $portal->title }}</h4>
                                            <span class="w-2 h-2 rounded-full shrink-0 bg-emerald-500"></span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">{{ $portal->purpose ?: 'Institutional workflow' }}</p>
                                        <div class="flex items-center gap-1.5 mt-2">
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate">
                                                🏛️ {{ $portal->target_department ?: ($portal->department ? ($portal->department->short_name ?: $portal->department->code) : 'Universal') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-xs transition">
                                            <span>Open Portal</span>
                                            <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="p-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 transition cursor-pointer"
                                                title="Copy URL">
                                            <span x-show="!copied">
                                                <svg width="14" height="14" style="width: 14px; height: 14px; display: inline-block; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-600 font-bold text-xs">✓</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-12 text-center">
                        <p class="text-xs text-slate-400">No active portals matching the current selection.</p>
                    </div>
                @endforelse
            </div>
        @elseif ($viewLayout === 'table')
            <!-- Tabular Presentation -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-5 py-3">Portal Title</th>
                                <th class="px-5 py-3">Department</th>
                                <th class="px-5 py-3">Category</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Custodian</th>
                                <th class="px-5 py-3 text-right">Direct Access</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($departments as $dept)
                                @foreach ($dept->portals as $portal)
                                    @php
                                        $user = $portal->user;
                                    @endphp
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition">
                                        <td class="px-5 py-3.5">
                                            <div class="font-bold text-slate-900 dark:text-white">{{ $portal->title }}</div>
                                            <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ $portal->safe_url }}</div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                                {{ $dept->name }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($portal->category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                                    {{ $portal->category->name }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-[11px]">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-emerald-600 dark:text-emerald-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Operational
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($user)
                                                <div class="text-slate-800 dark:text-slate-200 font-medium">{{ $user->name }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $user->designation ?: 'Staff' }}</div>
                                            @else
                                                <span class="text-slate-400 text-[11px]">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-xs transition">
                                                <span>Open Portal</span>
                                                <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-slate-400">
                                        No portals found matching current filter criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif ($viewLayout === 'card_grid')
            @include('portal.designs.card-grid', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'compact')
            @include('portal.designs.compact', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'radial')
            @include('portal.designs.radial', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'dashboard')
            @include('portal.designs.dashboard', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'cyber_matrix')
            @include('portal.designs.cyber-matrix', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'constellation')
            @include('portal.designs.constellation', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'prism_bento')
            @include('portal.designs.prism-bento', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'terminal_console')
            @include('portal.designs.terminal-console', ['departments' => $directoryDepartments])
        @elseif ($viewLayout === 'employee_sections')
            @include('portal.designs.employee-sections', ['departments' => $directoryDepartments])
        @else
            @include('portal.designs.card-grid', ['departments' => $directoryDepartments])
        @endif
    </div>
</x-filament-panels::page>
