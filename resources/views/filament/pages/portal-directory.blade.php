<x-filament-panels::page>
    @include('filament.pages.partials.portal-directory-styles')

    <div class="portal-dir-container space-y-5">
        <!-- Directory Banner Header -->
        <div class="dir-hero-banner">
            <div style="position: absolute; right: -2rem; bottom: -2rem; width: 18rem; height: 18rem; background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, rgba(99,102,241,0) 70%); border-radius: 9999px; pointer-events: none;"></div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div class="max-w-2xl">
                    <div class="dir-hero-badge">
                        <span style="display: inline-block; width: 0.5rem; height: 0.5rem; border-radius: 9999px; background: #818cf8;"></span>
                        <span>Enterprise Portal Directory & Operational Hub</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-2">
                        @if($selectedDepartmentId)
                            {{ $departments->first()?->name ?? 'Department Portal Directory' }}
                        @else
                            All Departments & Organizational Systems
                        @endif
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Centralized repository of digital operational endpoints, administrative portals, and employee-managed institutional workflows.
                    </p>
                </div>

                <!-- Telemetry Counters in Banner -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 shrink-0">
                    <div class="dir-stat-card">
                        <span class="text-[10px] font-semibold text-indigo-200 uppercase tracking-wider block">Portals</span>
                        <span class="text-xl sm:text-2xl font-black text-white">{{ $totalPortalsCount }}</span>
                    </div>
                    <div class="dir-stat-card">
                        <span class="text-[10px] font-semibold text-indigo-200 uppercase tracking-wider block">Departments</span>
                        <span class="text-xl sm:text-2xl font-black text-white">{{ $allDepartments->count() }}</span>
                    </div>
                    <div class="dir-stat-card col-span-2 sm:col-span-1">
                        <span class="text-[10px] font-semibold text-emerald-300 uppercase tracking-wider block">Status</span>
                        <span class="text-xs font-bold text-emerald-400 mt-1 inline-flex items-center gap-1">
                            <span style="display:inline-block; width:6px; height:6px; border-radius:9999px; background:#34d399;"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Bar: Search, Design Switcher, Department Filter -->
        <div class="dir-controls-bar space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Search Box -->
                <div class="flex-1 max-w-lg relative">
                    <div class="relative flex items-center">
                        <span style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); font-size: 0.875rem; color: #94a3b8; pointer-events: none;">🔍</span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Search systems by title, department, purpose, or custodian..."
                               class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                               style="padding: 0.625rem 2.25rem 0.625rem 2.5rem;">
                        @if($search)
                            <button type="button" wire:click="$set('search', '')"
                                    style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); font-size: 0.75rem; color: #94a3b8; background: transparent; border: none; cursor: pointer;">
                                ✕
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Design Switcher Buttons -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1">Views:</span>
                    @php
                        $designIcons = [
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

                    @foreach($designs as $d)
                        <button type="button" wire:click="selectDesign('{{ $d->value }}')"
                                class="dir-design-btn {{ $design === $d->value && $viewMode === 'visual' ? 'active' : '' }}"
                                title="{{ $d->description() }}">
                            <span>{{ $designIcons[$d->value] ?? $d->label() }}</span>
                        </button>
                    @endforeach

                    <button type="button" wire:click="toggleViewMode('table')"
                            class="dir-design-btn {{ $viewMode === 'table' ? 'active' : '' }}">
                        <span>☰ Table</span>
                    </button>
                </div>
            </div>

            <!-- Department Filter Pills -->
            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2 overflow-x-auto pb-1">
                <button type="button" wire:click="selectDepartment(null)"
                        class="dir-dept-pill {{ is_null($selectedDepartmentId) ? 'active' : '' }}">
                    <span>All Departments</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ is_null($selectedDepartmentId) ? 'bg-indigo-700 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                        {{ $allDepartments->count() }}
                    </span>
                </button>

                @foreach($allDepartments as $dept)
                    <button type="button" wire:click="selectDepartment({{ $dept->id }})"
                            class="dir-dept-pill {{ $selectedDepartmentId === $dept->id ? 'active' : '' }}">
                        <span>{{ $dept->short_name ?: $dept->name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedDepartmentId === $dept->id ? 'bg-indigo-700 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300' }}">
                            {{ $dept->users->flatMap->portals->count() }}
                        </span>
                    </button>
                @endforeach
            </div>

            @if($search || !is_null($selectedDepartmentId))
                <div class="pt-2 flex items-center justify-between text-xs text-slate-500">
                    <span>Showing <strong>{{ $totalPortalsCount }}</strong> portal(s) in current selection</span>
                    <button type="button" wire:click="resetFilters" class="text-indigo-600 hover:text-indigo-800 font-semibold cursor-pointer underline">
                        Reset filters
                    </button>
                </div>
            @endif
        </div>

        <!-- Content Presentation Stage -->
        @if($viewMode === 'table')
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
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($departments as $dept)
                                @foreach($dept->users as $user)
                                    @foreach($user->portals as $portal)
                                        @php $compStatus = $portal->computed_status; @endphp
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                            <td class="px-5 py-3.5">
                                                <div class="font-bold text-slate-900 dark:text-white">{{ $portal->title }}</div>
                                                <div class="text-[11px] text-slate-500 truncate max-w-xs">{{ $portal->purpose ?: 'System operational endpoint' }}</div>
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $dept->name }}</span>
                                                <span class="text-[10px] text-slate-400 block font-mono">{{ $dept->code }}</span>
                                            </td>
                                            <td class="px-5 py-3.5">
                                                @if($portal->category)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
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
                                                <div class="text-slate-800 dark:text-slate-200 font-medium">{{ $user->name }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $user->designation ?: 'Staff' }}</div>
                                            </td>
                                            <td class="px-5 py-3.5 text-right">
                                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition">
                                                    <span>Open Portal</span>
                                                    <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
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
        @else
            <!-- Visual Layout Architecture -->
            @php
                $viewBlade = match($design) {
                    'radial' => 'portal.designs.radial',
                    'compact' => 'portal.designs.compact',
                    'dashboard' => 'portal.designs.dashboard',
                    'employee_sections' => 'portal.designs.employee-sections',
                    'cyber_matrix' => 'portal.designs.cyber-matrix',
                    'constellation' => 'portal.designs.constellation',
                    'prism_bento' => 'portal.designs.prism-bento',
                    'terminal_console' => 'portal.designs.terminal-console',
                    default => 'portal.designs.card-grid',
                };
            @endphp

            @include($viewBlade, ['departments' => $departments])
        @endif
    </div>
</x-filament-panels::page>
