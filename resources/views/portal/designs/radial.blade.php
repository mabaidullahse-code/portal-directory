@props(['departments'])

<div x-data="{
    activeDeptId: {{ $departments->first()?->id ?? 'null' }},
    hoveredPortal: null,
}" class="space-y-6">
    <!-- Department Selector Tabs for Radial Focus -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
        @foreach($departments as $dept)
            <button type="button" @click="activeDeptId = {{ $dept->id }}"
                    :class="activeDeptId === {{ $dept->id }} ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition">
                🏢 {{ $dept->short_name ?: $dept->name }}
            </button>
        @endforeach
    </div>

    @foreach($departments as $dept)
        <div x-show="activeDeptId === {{ $dept->id }}" x-transition
             class="bg-slate-950 text-white rounded-3xl border border-slate-800 p-8 shadow-xl relative overflow-hidden min-h-[580px] flex flex-col justify-between">
            <!-- Background Radial Glow / Grid -->
            <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-40 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Header in Canvas -->
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-mono text-blue-400 uppercase tracking-widest">Interactive Radial Architecture</span>
                    <h3 class="text-lg font-black tracking-tight text-white">{{ $dept->name }}</h3>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                        {{ $dept->users->flatMap->portals->count() }} Systems Connected
                    </span>
                </div>
            </div>

            <!-- Radial Tree Visualization -->
            <div class="relative z-10 my-8 py-6 flex flex-col items-center justify-center">
                <!-- Center: Department Hub -->
                <div class="relative group cursor-pointer mb-10">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur-md opacity-60 group-hover:opacity-100 transition duration-300 animate-pulse"></div>
                    <div class="relative bg-slate-900 border-2 border-blue-400 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
                        <span class="text-xl">🏢</span>
                        <div>
                            <div class="text-[10px] uppercase font-bold text-blue-400 tracking-wider">Department Center</div>
                            <div class="text-sm font-black">{{ $dept->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Spokes to Employees -->
                <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($dept->users as $employee)
                        <div class="relative bg-slate-900/80 backdrop-blur-md rounded-2xl border border-slate-800 p-5 hover:border-blue-500/50 transition-all duration-300 shadow-lg flex flex-col justify-between">
                            <!-- Employee Node Header -->
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-800 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-md">
                                    {{ $employee->initials }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-white truncate">{{ $employee->name }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">{{ $employee->designation ?: 'Staff Member' }}</div>
                                </div>
                            </div>

                            <!-- Radiating Portals -->
                            <div class="space-y-2.5">
                                @forelse($employee->portals as $portal)
                                    @php
                                        $compStatus = $portal->computed_status;
                                    @endphp
                                    <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                       class="group/p flex items-center justify-between p-2.5 rounded-xl bg-slate-800/60 hover:bg-blue-600/20 border border-slate-700/60 hover:border-blue-400 transition-all gap-2">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></span>
                                            <span class="text-xs font-medium text-slate-200 group-hover/p:text-white truncate">
                                                {{ $portal->title }}
                                            </span>
                                        </div>
                                        <span class="shrink-0 text-slate-400 group-hover/p:text-blue-400 text-xs">↗</span>
                                    </a>
                                @empty
                                    <div class="text-[11px] text-slate-500 italic py-2 text-center">
                                        No registered portals
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-slate-500 text-xs">
                            No active employees registered in this department.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Canvas Bottom Guide -->
            <div class="relative z-10 pt-4 border-t border-slate-800/80 flex flex-wrap items-center justify-between text-[11px] text-slate-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Active</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Scheduled</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-slate-500"></span> Inactive</span>
                </div>
                <span>Click any portal node to launch in a new window</span>
            </div>
        </div>
    @endforeach
</div>
