<div>
    <!-- Department Executive Header -->
    <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-6 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    <span>🏢 Director Department Headquarters</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ $department->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">
                    Director In-Charge: <strong>{{ auth()->user()->name }}</strong> ({{ $department->code }})
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('portals.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Portal</span>
                </a>
                <a href="{{ route('reports.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/10 transition">
                    <span>Export Department Report</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Department Statistics Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Department Staff</div>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $employeesCount }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Active employees</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Active Portals</div>
            <div class="mt-2 text-2xl font-black text-emerald-600">{{ $activePortals }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Live operational systems</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Inactive Portals</div>
            <div class="mt-2 text-2xl font-black text-slate-600">{{ $inactivePortals }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Offline / Archived</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Systems</div>
            <div class="mt-2 text-2xl font-black text-blue-600">{{ $totalPortals }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Department inventory</div>
        </div>
    </div>

    <!-- Main Content: Employee Roster & Portals Explorer -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Employees List -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm font-bold text-slate-900">Employees of {{ $department->short_name ?: $department->code }}</h3>
                <span class="text-xs text-slate-400 font-semibold">{{ $employees->count() }} staff</span>
            </div>

            <p class="text-[11px] text-slate-500 mb-4">Click an employee below to inspect their registered portal systems.</p>

            <div class="space-y-2">
                @forelse($employees as $emp)
                    <button type="button" wire:click="selectEmployee({{ $emp->id }})"
                            class="w-full text-left p-3 rounded-xl border transition flex items-center justify-between {{ $selectedEmployeeId === $emp->id ? 'bg-blue-50/70 border-blue-400 shadow-xs' : 'bg-slate-50 border-slate-200/70 hover:bg-slate-100' }}">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $emp->initials }}
                            </div>
                            <div class="truncate">
                                <div class="text-xs font-bold text-slate-900 truncate">{{ $emp->name }}</div>
                                <div class="text-[10px] text-slate-500 truncate">{{ $emp->designation ?: 'Staff Member' }}</div>
                            </div>
                        </div>

                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $emp->portals_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-slate-200 text-slate-600' }} shrink-0">
                            {{ $emp->portals_count }} {{ Str::plural('Portal', $emp->portals_count) }}
                        </span>
                    </button>
                @empty
                    <div class="text-xs text-slate-400 text-center py-6">No employees currently assigned to this wing.</div>
                @endforelse
            </div>
        </div>

        <!-- Selected Employee Portals / Overview Stage -->
        <div class="lg:col-span-2 space-y-6">
            @if ($selectedEmployee)
                <!-- Detailed Inspector for Selected Employee -->
                <div class="bg-white rounded-2xl border border-blue-200 p-6 shadow-xs">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold text-sm flex items-center justify-center shadow-xs">
                                {{ $selectedEmployee->initials }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $selectedEmployee->name }}'s Portals</h4>
                                <p class="text-xs text-slate-500">{{ $selectedEmployee->designation ?: 'Staff' }} • ID: {{ $selectedEmployee->employee_id ?: '—' }}</p>
                            </div>
                        </div>
                        <button type="button" wire:click="selectEmployee(null)" class="text-xs text-slate-400 hover:text-slate-600">
                            ✕ Close Inspector
                        </button>
                    </div>

                    <div class="space-y-3">
                        @forelse($selectedEmployee->portals as $portal)
                            @php $compStatus = $portal->computed_status; @endphp
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h5 class="text-xs font-bold text-slate-900">{{ $portal->title }}</h5>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $compStatus->badgeClasses() }}">
                                            {{ $compStatus->label() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1">{{ $portal->purpose ?: $portal->description ?: 'No purpose statement.' }}</p>
                                    <div class="text-[10px] text-slate-400 mt-1 font-mono">{{ $portal->safe_url }}</div>
                                </div>

                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-500 transition shrink-0 self-end sm:self-auto">
                                    <span>Open Portal ↗</span>
                                </a>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                This employee has not registered any portals yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- Director's Own Portals -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-sm font-bold text-slate-900">My Personal Portals (Director Owned)</h3>
                    <a href="{{ route('portals.create') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-500">
                        + Add Portal
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($myPortals as $portal)
                        @php $compStatus = $portal->computed_status; @endphp
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900">{{ $portal->title }}</span>
                                    <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold border {{ $compStatus->badgeClasses() }}">
                                        {{ $compStatus->label() }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-slate-500">{{ $portal->purpose }}</div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('portals.edit', $portal) }}" class="text-xs text-slate-500 hover:text-blue-600 font-medium">
                                    Edit
                                </a>
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="px-2.5 py-1 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-blue-600 transition">
                                    Open ↗
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 text-center py-4 bg-slate-50 rounded-xl">
                            You have not registered any personal director-owned portals yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
