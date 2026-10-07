@props(['departments'])

<div wire:key="radial-canvas-root-{{ $departments->pluck('id')->join('-') }}"
     x-data="{
        activeDeptId: {{ $departments->first()?->id ?? 'null' }},
        selectedPortal: null,
        init() {
            const available = {{ json_encode($departments->pluck('id')->values()->all()) }};
            if (!this.activeDeptId || !available.includes(this.activeDeptId)) {
                this.activeDeptId = available.length > 0 ? available[0] : null;
            }
        }
     }"
     class="space-y-6">

    @if($departments->isEmpty())
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center shadow-xs">
            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                🔍
            </div>
            <h3 class="text-base font-bold text-slate-800 dark:text-white">No Active Portals Found</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                No active departments with registered portals match your current filter criteria.
            </p>
        </div>
    @endif

    <!-- Department Selector Tabs for Radial Focus -->
    @if($departments->count() > 1)
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            @foreach($departments as $dept)
                <button type="button" @click="activeDeptId = {{ $dept->id }}"
                        :class="activeDeptId === {{ $dept->id }} ? 'bg-indigo-600 text-white shadow-md ring-2 ring-indigo-400' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700'"
                        class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition cursor-pointer flex items-center gap-2">
                    <span>🏛️</span>
                    <span>{{ $dept->short_name ?: $dept->name }}</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-black/20 text-white font-mono">
                        {{ $dept->users->flatMap->portals->count() }}
                    </span>
                </button>
            @endforeach
        </div>
    @endif

    @foreach($departments as $dept)
        <div x-show="{{ $departments->count() === 1 ? 'true' : "activeDeptId === {$dept->id}" }}" x-transition
             wire:key="radial-dept-canvas-{{ $dept->id }}"
             class="bg-gradient-to-b from-slate-50 via-indigo-50/30 to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950 text-slate-900 dark:text-white rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xl dark:shadow-2xl relative overflow-hidden min-h-[580px] flex flex-col justify-between transition-all duration-200">
            
            <!-- Background Radial Glow / Grid -->
            <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] dark:bg-[radial-gradient(#312e81_1px,transparent_1px)] [background-size:28px_28px] opacity-15 dark:opacity-30 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Header in Canvas -->
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-indigo-100 dark:border-white/10 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 dark:bg-indigo-500/20 dark:text-indigo-300 dark:border-indigo-500/30">
                            {{ $dept->code }}
                        </span>
                        <span class="text-[11px] font-mono text-indigo-600 dark:text-indigo-400 uppercase tracking-widest font-semibold">Interactive Radial Architecture</span>
                    </div>
                    <h3 class="text-xl font-black tracking-tight text-slate-900 dark:text-white mt-1">{{ $dept->name }}</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-500/20 dark:text-emerald-300 dark:border-emerald-500/30 flex items-center gap-1.5 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                        <span>{{ $dept->users->flatMap->portals->count() }} Systems Connected</span>
                    </span>
                </div>
            </div>

            <!-- Central Radial Architecture Visual Hub -->
            <div class="relative z-10 my-8 py-4 flex flex-col items-center justify-center">
                
                <!-- Central Department Core Pulsar -->
                <div class="relative group cursor-pointer mb-8">
                    <div class="absolute -inset-3 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl blur-lg opacity-30 dark:opacity-50 group-hover:opacity-75 dark:group-hover:opacity-100 transition duration-500 animate-pulse"></div>
                    <div class="relative bg-white/95 dark:bg-slate-900/90 border-2 border-indigo-400 text-slate-900 dark:text-white px-8 py-4 rounded-2xl shadow-xl flex items-center gap-4 backdrop-blur-xl">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-600/40 border border-indigo-200 dark:border-indigo-400/50 flex items-center justify-center text-2xl shadow-inner">
                            🏛️
                        </div>
                        <div>
                            <div class="text-[10px] uppercase font-bold text-indigo-600 dark:text-indigo-400 tracking-widest font-mono">Department Operational Hub</div>
                            <div class="text-base font-black text-slate-900 dark:text-white">{{ $dept->name }}</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $dept->users->count() }} Assigned Staff Custodians</div>
                        </div>
                    </div>
                </div>

                <!-- Concentric Radial Orbit Ring Dividers -->
                <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($dept->users as $employee)
                        <div class="relative bg-white dark:bg-slate-900/70 backdrop-blur-md rounded-2xl border border-slate-200 dark:border-slate-800/80 p-5 hover:border-indigo-400 dark:hover:border-indigo-500/60 transition-all duration-300 shadow-md dark:shadow-xl flex flex-col justify-between hover:shadow-indigo-500/10">
                            <!-- Employee Node Header -->
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-100 dark:border-white/5 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white font-bold text-xs flex items-center justify-center shadow-md border border-indigo-400/30">
                                    {{ $employee->initials }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $employee->name }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $employee->designation ?: 'Authorized Staff' }}</div>
                                </div>
                            </div>

                            <!-- Radiating System Satellites -->
                            <div class="space-y-2">
                                @forelse($employee->portals as $portal)
                                    @php
                                        $compStatus = $portal->computed_status;
                                    @endphp
                                    <div class="group/p p-3 rounded-xl bg-slate-50 hover:bg-indigo-50/80 dark:bg-slate-800/40 dark:hover:bg-indigo-600/20 border border-slate-200 hover:border-indigo-300 dark:border-slate-700/40 dark:hover:border-indigo-400/80 transition-all flex items-center justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></span>
                                                <span class="text-xs font-bold text-slate-900 dark:text-white group-hover/p:text-indigo-600 dark:group-hover/p:text-indigo-300 truncate">
                                                    {{ $portal->title }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-slate-600 dark:text-slate-400 truncate">{{ $portal->purpose ?: 'Operational endpoint' }}</p>
                                        </div>
                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="shrink-0 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold shadow-xs transition inline-flex items-center gap-1">
                                            <span>Open</span>
                                            <svg width="10" height="10" style="width: 10px; height: 10px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-[11px] text-slate-500 italic py-2 text-center">
                                        No registered portals
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-slate-500 text-xs">
                            No active employees with registered portals in this department.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Canvas Bottom Guide -->
            <div class="relative z-10 pt-4 border-t border-slate-200 dark:border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-xs"></span> Active Live</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-xs"></span> Scheduled</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-500 shadow-xs"></span> Maintenance</span>
                </div>
                <span class="font-mono text-[11px] text-slate-400 dark:text-slate-500">Radial Architectural Engine • High Security Safe URL Launch</span>
            </div>
        </div>
    @endforeach
</div>
