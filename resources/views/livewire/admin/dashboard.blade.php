<div>
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Executive Administration Dashboard</h1>
            <p class="text-xs text-slate-500">System overview, organizational telemetry, portal health, and recent operations.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('portals.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add Portal</span>
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Generate Report</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Portals</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-slate-900">{{ $totalPortals }}</div>
                <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">100%</span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Across organization</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Active Portals</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-emerald-600">{{ $activePortals }}</div>
                <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                    {{ $totalPortals > 0 ? round(($activePortals / $totalPortals) * 100) : 0 }}%
                </span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Operational live</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Inactive Portals</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-slate-600">{{ $inactivePortals }}</div>
                <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded">
                    {{ $totalPortals > 0 ? round(($inactivePortals / $totalPortals) * 100) : 0 }}%
                </span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Archived or offline</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Departments</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-slate-900">{{ $totalDepartments }}</div>
                <span class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">Wings</span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Active divisions</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Employees</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-slate-900">{{ $totalEmployees }}</div>
                <span class="text-[11px] font-semibold text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded">Staff</span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Portal owners</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Directors</div>
            <div class="mt-2 flex items-baseline justify-between">
                <div class="text-2xl font-black text-slate-900">{{ $totalDirectors }}</div>
                <span class="text-[11px] font-semibold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded">Heads</span>
            </div>
            <div class="mt-2 text-[11px] text-slate-500">Department leaders</div>
        </div>
    </div>

    <!-- Charts & Distributions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Portals by Department Distribution -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Portals by Department</h3>
                    <p class="text-[11px] text-slate-500">Departmental breakdown of registered systems</p>
                </div>
                <a href="{{ route('filament.admin.resources.departments.index') }}" class="text-xs text-blue-600 hover:text-blue-500 font-semibold">View all →</a>
            </div>

            <div class="space-y-3">
                @foreach($departmentStats as $dept)
                    @php
                        $percent = $totalPortals > 0 ? round(($dept->portals_count / $totalPortals) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-slate-800">{{ $dept->name }}</span>
                            <span class="text-slate-500">{{ $dept->portals_count }} ({{ $percent }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Portals by Category Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Category Distribution</h3>
                    <p class="text-[11px] text-slate-500">Portals categorized by enterprise service domain</p>
                </div>
                <span class="text-xs font-semibold text-slate-400">{{ $categoryStats->count() }} Categories</span>
            </div>

            <div class="space-y-3">
                @foreach($categoryStats as $category)
                    @php
                        $percent = $totalPortals > 0 ? round(($category->portals_count / $totalPortals) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-slate-800">{{ $category->name }}</span>
                            <span class="text-slate-500">{{ $category->portals_count }} ({{ $percent }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Row: Top Employees & Activity Log -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Employees -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Top Portal Owners</h3>
                    <p class="text-[11px] text-slate-500">Key contributors maintaining systems</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($topEmployees as $emp)
                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $emp->initials }}
                            </div>
                            <div class="truncate">
                                <div class="text-xs font-semibold text-slate-800 truncate">{{ $emp->name }}</div>
                                <div class="text-[10px] text-slate-400 truncate">{{ $emp->department?->short_name ?: 'No Dept' }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 shrink-0">
                            {{ $emp->portals_count }} {{ Str::plural('Portal', $emp->portals_count) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Audit Activities -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Recent System Activity</h3>
                    <p class="text-[11px] text-slate-500">Immutable audit log of user & portal events</p>
                </div>
                <a href="{{ route('filament.admin.resources.activity-logs.index') }}" class="text-xs text-blue-600 hover:text-blue-500 font-semibold">View audit trail →</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($recentActivities as $activity)
                    <div class="py-2.5 flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2.5 min-w-0">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                            <div>
                                <div class="text-xs font-medium text-slate-800 leading-snug">
                                    {{ $activity->description }}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5 flex items-center gap-2">
                                    <span>👤 {{ $activity->user?->name ?? 'System' }}</span>
                                    <span>• IP: {{ $activity->ip_address }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 shrink-0">
                            {{ $activity->created_at->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
