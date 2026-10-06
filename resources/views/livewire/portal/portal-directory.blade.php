<div>
    <!-- Directory Banner Header -->
    <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-800 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-6 relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>Enterprise Portal Directory</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                @if($selectedDepartmentId)
                    {{ $departments->first()?->name ?? 'Department Portal Directory' }}
                @else
                    All Departments & Portal Systems
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                Centralized registry of digital operational endpoints, administrative systems, and employee-managed workflows.
            </p>
        </div>

        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Controls Bar: Search, Department Pills, Design Switcher -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Search Input -->
            <div class="flex-1 max-w-md relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search systems, purposes, tags, or employees..."
                       class="w-full rounded-xl border border-slate-300 pl-9 pr-4 py-2 text-xs text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- View Switcher -->
            <div class="flex flex-wrap items-center gap-1.5 self-end md:self-auto">
                <span class="text-[11px] font-semibold text-slate-400 mr-1">Design:</span>
                @foreach($designs as $d)
                    <button type="button" wire:click="selectDesign('{{ $d->value }}')"
                            :class="'{{ $design === $d->value && $viewMode === 'visual' }}' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold transition" title="{{ $d->description() }}">
                        {{ $d->label() }}
                    </button>
                @endforeach

                <button type="button" wire:click="toggleViewMode('table')"
                        :class="'{{ $viewMode === 'table' }}' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold transition">
                    Table View
                </button>
            </div>
        </div>

        <!-- Department Tabs (if admin or multiple depts) -->
        @if(auth()->user()->isAdmin())
            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-thin">
                <button type="button" wire:click="selectDepartment(null)"
                        class="px-3 py-1 rounded-lg text-xs font-semibold transition whitespace-nowrap {{ is_null($selectedDepartmentId) ? 'bg-blue-600 text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                    All Departments
                </button>
                @foreach($allDepartments as $dept)
                    <button type="button" wire:click="selectDepartment({{ $dept->id }})"
                            class="px-3 py-1 rounded-lg text-xs font-semibold transition whitespace-nowrap {{ $selectedDepartmentId === $dept->id ? 'bg-blue-600 text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                        {{ $dept->short_name ?: $dept->name }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Active Presentation Stage -->
    @if ($viewMode === 'table')
        <!-- Global Directory Table View -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Department</th>
                            <th class="px-4 py-3">Owner Employee</th>
                            <th class="px-4 py-3">Portal System</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Access</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($departments as $dept)
                            @foreach ($dept->users as $employee)
                                @foreach ($employee->portals as $portal)
                                    @php $compStatus = $portal->computed_status; @endphp
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="px-4 py-3 font-semibold text-slate-900">
                                            {{ $dept->name }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-slate-800">{{ $employee->name }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $employee->designation ?: 'Staff' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-slate-900 text-sm">{{ $portal->title }}</div>
                                            <div class="text-[11px] text-slate-500 line-clamp-1">{{ $portal->purpose }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded text-[11px] bg-slate-100 text-slate-700">
                                                {{ $portal->category?->name ?? 'General' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $compStatus->badgeClasses() }}">
                                                {{ $compStatus->label() }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-600 text-white font-semibold text-xs hover:bg-blue-500 transition">
                                                <span>Open</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                    No portals found matching criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Visual Layouts (Card Grid, Employee Sections, Radial, Compact, Dashboard) -->
        @if ($design === 'card_grid')
            @include('portal.designs.card-grid', ['departments' => $departments])
        @elseif ($design === 'employee_sections')
            @include('portal.designs.employee-sections', ['departments' => $departments])
        @elseif ($design === 'radial')
            @include('portal.designs.radial', ['departments' => $departments])
        @elseif ($design === 'compact')
            @include('portal.designs.compact', ['departments' => $departments])
        @elseif ($design === 'dashboard')
            @include('portal.designs.dashboard', ['departments' => $departments])
        @endif
    @endif
</div>
