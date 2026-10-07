<div class="portal-dir-container space-y-6 sm:space-y-8">
    @include('filament.pages.partials.portal-directory-styles')

    <!-- Executive Welcome Banner (Professional Light Theme) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-white via-sky-50/30 to-blue-50/50 p-6 sm:p-10 border border-blue-100/80 shadow-xs">
        <!-- Soft decorative light glows -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-200/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -top-20 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 sm:gap-8">
            <div class="flex items-start gap-4 sm:gap-6 max-w-3xl">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white border border-blue-100/90 shadow-sm ring-4 ring-blue-50/80 p-2 shrink-0 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('images/uhs-logo.png') }}" alt="UHS Logo" class="w-full h-full object-contain">
                </div>
                <div class="space-y-3 flex-1 min-w-0">
                    <!-- Executive Seal Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 text-blue-900 text-xs font-semibold border border-blue-200/70 shadow-2xs">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Office of the Vice Chancellor &bull; Direct Executive Access</span>
                    </div>

                    <!-- Grand Executive Welcome Heading -->
                    <div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Welcome, Worthy Vice Chancellor
                        </h1>
                        <div class="text-sm sm:text-base font-semibold text-blue-700 mt-1.5">
                            <span>Vice Chancellor Executive Portal Dashboard</span>
                        </div>
                    </div>

                    <!-- Warm Welcome Narrative -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl">
                        Welcome to your centralized institutional portal hub. You have instant, one-click direct access to all academic management systems, administrative services, faculty portals, and university infrastructure. Select any portal below to visit it immediately.
                    </p>
                </div>
            </div>

            <!-- Quick Access Report Actions (Always Visible on VC Dashboard) -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
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

        <!-- Metric Telemetry Cards (Light Cards) -->
        <div class="mt-8 pt-6 border-t border-blue-100/80 grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
            <div class="bg-white/90 backdrop-blur-xs rounded-2xl p-4 border border-blue-100/80 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Active Portals</span>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalPortals }}</span>
                    <span class="text-[11px] text-slate-400 font-medium">operational</span>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-xs rounded-2xl p-4 border border-blue-100/80 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Departments</span>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalDepartments }}</span>
                    <span class="text-[11px] text-slate-400 font-medium">units</span>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-xs rounded-2xl p-4 border border-blue-100/80 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Categories</span>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalCategories }}</span>
                    <span class="text-[11px] text-slate-400 font-medium">domains</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-xs space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5 items-center">
            <!-- Search Input -->
            <div class="sm:col-span-5">
                <div class="relative flex items-center">
                    <div style="position: absolute; left: 0.875rem; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: 10;">
                        <svg style="width: 1rem; height: 1rem; display: block;" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Search portals by name, keyword, department, or url..."
                           style="padding-left: 2.5rem !important;"
                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-10 pr-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                </div>
            </div>

            <!-- Department Filter -->
            <div class="sm:col-span-4">
                <select wire:model.live="departmentFilter"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-xs text-slate-900 focus:bg-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                    <option value="all">All Departments ({{ $allDepartments->count() }})</option>
                    @foreach($allDepartments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div class="sm:col-span-3">
                <select wire:model.live="categoryFilter"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-xs text-slate-900 focus:bg-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                    <option value="all">All Categories</option>
                    @foreach($allCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Directory Design Layout Switcher -->
        <div class="pt-3.5 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $layout === 'buttons' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                            title="Direct 1-Click Launch Button Cards Grid">
                        <span>⚡ Launch Grid</span>
                        @if(($defaultDesign ?? '') === 'buttons')
                            <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                        @endif
                    </button>

                    @foreach($designs as $d)
                        <button type="button" wire:click="setLayout('{{ $d->value }}')"
                                class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $layout === $d->value ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                                title="{{ $d->description() }}">
                            <span>{{ $designIcons[$d->value] ?? $d->label() }}</span>
                            @if(($defaultDesign ?? '') === $d->value)
                                <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                            @endif
                        </button>
                    @endforeach

                    <button type="button" wire:click="setLayout('departments')"
                            class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $layout === 'departments' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                            title="Group Portals by Department">
                        <span>🏛️ By Dept</span>
                        @if(($defaultDesign ?? '') === 'departments')
                            <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                        @endif
                    </button>

                    <button type="button" wire:click="setLayout('categories')"
                            class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $layout === 'categories' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                            title="Group Portals by Category">
                        <span>🏷️ By Category</span>
                        @if(($defaultDesign ?? '') === 'categories')
                            <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                        @endif
                    </button>

                    <button type="button" wire:click="setLayout('table')"
                            class="px-2.5 py-1.5 rounded-xl text-xs font-semibold transition cursor-pointer flex items-center gap-1.5 {{ $layout === 'table' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                            title="Tabular Data Registry View">
                        <span>☰ Table View</span>
                        @if(($defaultDesign ?? '') === 'table')
                            <span class="text-xs text-amber-400 font-bold" title="Current Default">★</span>
                        @endif
                    </button>
                </div>

                <!-- Set Default View Button -->
                <div class="flex items-center gap-1.5 sm:pl-2 sm:border-l sm:border-slate-200">
                    @if($layout === ($defaultDesign ?? ''))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs"
                              title="This view design is currently saved as your default">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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

        @if (session()->has('status'))
            <div class="px-3.5 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs"
                 x-data="{ show: true }" x-show="show">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('status') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 text-xs font-bold cursor-pointer">✕</button>
            </div>
        @endif

        @if($search || $departmentFilter !== 'all' || $categoryFilter !== 'all')
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Active filter: <strong>{{ $portals->count() }}</strong> portal(s) matched</span>
                <button type="button" wire:click="resetFilters" class="text-blue-600 hover:text-blue-800 font-semibold transition cursor-pointer">
                    Clear all filters
                </button>
            </div>
        @endif
    </div>

    <!-- Main Portals Presentation Stage -->
    @if ($layout === 'buttons')
        <!-- All Portals Direct 1-Click Link Grid View -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4 sm:gap-5">
            @forelse ($portals as $portal)
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-blue-300 transition-all duration-200 flex flex-col justify-between p-5 sm:p-6 group">
                    <div class="space-y-3.5">
                        <!-- Card Badges & Department Header -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/70">
                                <span>🏛️</span>
                                <span class="truncate max-w-[130px]">
                                    {{ $portal->target_department ?: ($portal->department ? ($portal->department->short_name ?: $portal->department->code) : 'Universal') }}
                                </span>
                            </span>

                            @if($portal->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold tracking-wide"
                                      style="background-color: {{ $portal->category->color }}15; color: {{ $portal->category->color }};">
                                    {{ $portal->category->name }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Online</span>
                                </span>
                            @endif
                        </div>

                        <!-- Portal Information -->
                        <div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition leading-snug line-clamp-1">
                                {{ $portal->title }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $portal->purpose ?: ($portal->description ?: 'Institutional operational portal for campus users.') }}
                            </p>
                        </div>

                        <!-- Host Link Preview -->
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-mono truncate">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <span class="truncate">{{ parse_url($portal->safe_url, PHP_URL_HOST) ?: $portal->url }}</span>
                        </div>
                    </div>

                    <!-- Direct Action Link Button (One-Click Launch) -->
                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between gap-2.5">
                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-bold shadow-xs hover:shadow transition group/btn">
                            <span>Open Portal</span>
                            <svg class="w-3.5 h-3.5 transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        <!-- Clipboard Copy Button -->
                        <button type="button"
                                x-data="{ copied: false }"
                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition cursor-pointer"
                                title="Copy portal link address">
                            <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <svg x-show="copied" style="display: none;" class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3.5">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">No Portals Found</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto leading-relaxed">
                        There are no active portals matching your current search or filter criteria.
                    </p>
                    <button type="button" wire:click="resetFilters"
                            class="mt-4 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition cursor-pointer">
                        Reset Filters
                    </button>
                </div>
            @endforelse
        </div>

    @elseif ($layout === 'departments')
        <!-- Grouped by Department View -->
        <div class="space-y-6 sm:space-y-8">
            @forelse ($departments as $dept)
                <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                    <!-- Department Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shadow-2xs">
                                {{ $dept->code }}
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900">{{ $dept->name }}</h2>
                                <p class="text-xs text-slate-500">{{ $dept->portals->count() }} active portal(s)</p>
                            </div>
                        </div>

                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $dept->code }}
                        </span>
                    </div>

                    <!-- Department Portals Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-3.5 sm:gap-4">
                        @foreach ($dept->portals as $portal)
                            <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-300 hover:shadow-xs transition duration-150 group">
                                <div class="space-y-1 min-w-0 pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                        <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-700 truncate">
                                            {{ $portal->title }}
                                        </h4>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate">
                                        {{ $portal->purpose ?: 'Access portal' }}
                                    </p>
                                </div>

                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-2xs transition">
                                    <span>Open</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                    <h3 class="text-base font-bold text-slate-900">No Department Portals</h3>
                    <p class="text-xs text-slate-500 mt-1">No departments with active portals matched your filters.</p>
                </div>
            @endforelse
        </div>

    @elseif ($layout === 'categories')
        <!-- Grouped by Category View -->
        <div class="space-y-6 sm:space-y-8">
            @forelse ($categories as $cat)
                <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs">
                    <!-- Category Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-base shadow-2xs">
                                <span>{{ $cat->emoji ?? '🏷️' }}</span>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-900">{{ $cat->name }}</h2>
                                <p class="text-xs text-slate-500">
                                    {{ $cat->portals->count() }} active portal(s)
                                    @if(!empty($cat->description))
                                        &bull; <span class="text-slate-400">{{ $cat->description }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $cat->code }}
                        </span>
                    </div>

                    <!-- Category Portals Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-3.5 sm:gap-4">
                        @foreach ($cat->portals as $portal)
                            <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-300 hover:shadow-xs transition duration-150 group">
                                <div class="space-y-1 min-w-0 pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                        <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-700 truncate">
                                            {{ $portal->title }}
                                        </h4>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate">
                                        {{ $portal->purpose ?: 'Access portal' }}
                                    </p>
                                    <div class="flex items-center gap-1.5 pt-0.5">
                                        <span class="text-[10px] text-slate-400 font-medium truncate">
                                            🏛️ {{ $portal->target_department ?: ($portal->department ? ($portal->department->short_name ?: $portal->department->code) : 'Universal') }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-2xs transition">
                                    <span>Open</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
                    <h3 class="text-base font-bold text-slate-900">No Category Portals</h3>
                    <p class="text-xs text-slate-500 mt-1">No categories with active portals matched your filters.</p>
                </div>
            @endforelse
        </div>

    @elseif ($layout === 'table')
        <!-- Tabular Presentation -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Portal Title</th>
                            <th class="px-5 py-3">Department</th>
                            <th class="px-5 py-3">Category</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Custodian</th>
                            <th class="px-5 py-3 text-right">Direct Access</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($directoryDepartments as $dept)
                            @foreach($dept->users as $user)
                                @foreach($user->portals as $portal)
                                    @php $compStatus = $portal->computed_status; @endphp
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-3.5">
                                            <div class="font-bold text-slate-900">{{ $portal->title }}</div>
                                            <div class="text-[11px] text-slate-500 truncate max-w-xs">{{ $portal->purpose ?: 'System operational endpoint' }}</div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="font-medium text-slate-800">{{ $dept->name }}</span>
                                            <span class="text-[10px] text-slate-400 block font-mono">{{ $dept->code }}</span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($portal->category)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700">
                                                    {{ $portal->category->name }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-[10px]">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $compStatus->badgeClasses() }}">
                                                {{ $compStatus->label() }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <div class="text-slate-800 font-medium">{{ $user->name }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $user->designation ?: 'Staff' }}</div>
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition">
                                                <span>Open Portal</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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

    @elseif ($layout === 'card_grid')
        @include('portal.designs.card-grid', ['departments' => $directoryDepartments])
    @elseif ($layout === 'compact')
        @include('portal.designs.compact', ['departments' => $directoryDepartments])
    @elseif ($layout === 'radial')
        @include('portal.designs.radial', ['departments' => $directoryDepartments])
    @elseif ($layout === 'dashboard')
        @include('portal.designs.dashboard', ['departments' => $directoryDepartments])
    @elseif ($layout === 'cyber_matrix')
        @include('portal.designs.cyber-matrix', ['departments' => $directoryDepartments])
    @elseif ($layout === 'constellation')
        @include('portal.designs.constellation', ['departments' => $directoryDepartments])
    @elseif ($layout === 'prism_bento')
        @include('portal.designs.prism-bento', ['departments' => $directoryDepartments])
    @elseif ($layout === 'terminal_console')
        @include('portal.designs.terminal-console', ['departments' => $directoryDepartments])
    @elseif ($layout === 'employee_sections')
        @include('portal.designs.employee-sections', ['departments' => $directoryDepartments])
    @else
        @include('portal.designs.card-grid', ['departments' => $directoryDepartments])
    @endif
</div>
