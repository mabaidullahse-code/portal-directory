@props(['departments'])

<div wire:key="constellation-canvas-root-{{ $departments->pluck('id')->join('-') }}"
     x-data="{
        activeDeptId: {{ $departments->first()?->id ?? 'null' }},
        init() {
            const available = {{ json_encode($departments->pluck('id')->values()->all()) }};
            if (!this.activeDeptId || !available.includes(this.activeDeptId)) {
                this.activeDeptId = available.length > 0 ? available[0] : null;
            }
        }
     }"
     class="space-y-6">

    @if($departments->isEmpty())
        <div class="portal-starfield-canvas rounded-3xl p-12 text-center text-xs text-slate-500 dark:text-slate-400">
            No active orbital sectors detected.
        </div>
    @endif

    <!-- Celestial Orbital Station Selector Tabs -->
    @if($departments->count() > 1)
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
            @foreach($departments as $dept)
                <button type="button" @click="activeDeptId = {{ $dept->id }}"
                        :class="activeDeptId === {{ $dept->id }} ? 'bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-lg ring-2 ring-violet-400' : 'bg-white text-slate-700 border-slate-200 hover:bg-violet-50 dark:bg-slate-900 dark:text-slate-300 dark:border-slate-800'"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition cursor-pointer flex items-center gap-2 border">
                    <span class="text-violet-500 dark:text-violet-400">✦</span>
                    <span class="font-bold">{{ $dept->short_name ?: $dept->name }}</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-black/10 dark:bg-black/40 text-violet-800 dark:text-violet-200">
                        {{ $dept->users->flatMap->portals->count() }}
                    </span>
                </button>
            @endforeach
        </div>
    @endif

    @foreach($departments as $dept)
        <div x-show="{{ $departments->count() === 1 ? 'true' : "activeDeptId === {$dept->id}" }}" x-transition
             wire:key="constellation-dept-{{ $dept->id }}"
             class="portal-starfield-canvas relative rounded-3xl p-6 sm:p-8 shadow-xl overflow-hidden min-h-[580px] flex flex-col justify-between transition-all duration-200">

            <!-- Deep Cosmic Starfield & Nebula Glow -->
            <div class="absolute inset-0 bg-[radial-gradient(#8b5cf6_1px,transparent_1px)] [background-size:32px_32px] opacity-15 dark:opacity-25 pointer-events-none"></div>
            <div class="absolute top-10 left-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Constellation Deck Header -->
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-violet-200 dark:border-violet-900/50 gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-mono font-bold uppercase tracking-widest bg-violet-100 text-violet-800 border border-violet-200 dark:bg-violet-950/80 dark:text-violet-300 dark:border-violet-600/50">
                            SECTOR :: {{ $dept->code }}
                        </span>
                        <span class="text-[11px] font-mono uppercase tracking-widest text-violet-700 dark:text-violet-400">
                            Orbital Starfield Command Deck
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                        {{ $dept->name }}
                    </h3>
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-mono font-bold flex items-center gap-2 bg-white dark:bg-violet-950/60 text-violet-800 dark:text-violet-300 border border-violet-200 dark:border-violet-400/40 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-violet-500 dark:bg-violet-400 animate-ping"></span>
                        <span>{{ $dept->users->flatMap->portals->count() }} Stellar Satellites Online</span>
                    </span>
                </div>
            </div>

            <!-- Central Orbital Celestial Hub -->
            <div class="relative z-10 my-8 flex flex-col items-center">
                <!-- Floating Sector Core Pulsar -->
                <div class="relative group cursor-pointer mb-8">
                    <div class="absolute -inset-4 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-indigo-600 rounded-3xl blur-xl opacity-40 group-hover:opacity-80 transition duration-700 animate-pulse"></div>
                    <div class="relative px-8 py-4 rounded-2xl shadow-xl flex items-center gap-4 bg-white dark:bg-[#0c0820] border-2 border-violet-400 dark:border-violet-500">
                        <div class="w-12 h-12 rounded-2xl text-white flex items-center justify-center text-2xl shadow-inner bg-gradient-to-br from-violet-600 to-indigo-700 border border-violet-300">
                            🌌
                        </div>
                        <div>
                            <div class="text-[10px] font-mono font-bold uppercase tracking-widest text-violet-600 dark:text-violet-400">Orbital Sector Hub</div>
                            <h4 class="text-base font-black text-slate-900 dark:text-white">{{ $dept->name }}</h4>
                            <div class="text-[11px] mt-0.5 text-slate-500 dark:text-slate-400">{{ $dept->users->count() }} Custodian Commanders</div>
                        </div>
                    </div>
                </div>

                <!-- Orbiting Satellites Grid -->
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($dept->users as $employee)
                        <div class="portal-starfield-card rounded-2xl p-5 transition-all duration-300 shadow-md flex flex-col justify-between">
                            <!-- Commander Header -->
                            <div class="flex items-center gap-3 pb-3.5 mb-3 border-b border-violet-100 dark:border-violet-900/40">
                                <div class="w-9 h-9 rounded-xl font-bold text-xs flex items-center justify-center shadow-md bg-gradient-to-br from-violet-600 to-indigo-600 text-white border border-violet-300">
                                    {{ $employee->initials }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold truncate text-slate-900 dark:text-white">{{ $employee->name }}</div>
                                    <div class="text-[10px] truncate font-mono text-violet-600 dark:text-violet-400">{{ $employee->designation ?: 'Division Officer' }}</div>
                                </div>
                            </div>

                            <!-- Satellites -->
                            <div class="space-y-2.5">
                                @forelse($employee->portals as $portal)
                                    @php
                                        $compStatus = $portal->computed_status;
                                    @endphp
                                    <div class="p-3.5 rounded-xl transition-all flex items-center justify-between gap-3 group/p bg-slate-50 hover:bg-violet-50/60 dark:bg-[#171233] dark:hover:bg-violet-900/40 border border-slate-200 hover:border-violet-300 dark:border-violet-800/40 dark:hover:border-violet-500/60"
                                         x-data="{ copied: false }">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></span>
                                                <span class="text-xs font-bold truncate group-hover/p:text-violet-600 dark:group-hover/p:text-violet-300 transition text-slate-900 dark:text-white">
                                                    {{ $portal->title }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] truncate text-slate-600 dark:text-slate-300">{{ $portal->purpose ?: 'Orbital workflow node' }}</p>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <button type="button"
                                                    @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                    class="p-1.5 rounded-lg transition cursor-pointer bg-white hover:bg-slate-100 dark:bg-black/40 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white border border-slate-200 dark:border-violet-800/50"
                                                    title="Copy link">
                                                <span x-show="!copied">
                                                    <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                </span>
                                                <span x-show="copied" style="display: none;" class="text-emerald-600 font-bold text-[10px]">✓</span>
                                            </button>

                                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                               class="px-3 py-1.5 rounded-lg font-mono text-[11px] font-bold shadow-xs transition inline-flex items-center gap-1 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white">
                                                <span>WARP</span>
                                                <svg width="10" height="10" style="width: 10px; height: 10px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-[11px] italic py-2 text-center text-slate-400">
                                        No orbital satellites deployed.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-xs text-slate-400">
                            No commanders assigned to this sector.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sector Telemetry Footer -->
            <div class="relative z-10 pt-4 border-t border-violet-200 dark:border-violet-900/50 flex flex-wrap items-center justify-between gap-4 text-xs font-mono text-slate-500 dark:text-slate-400">
                <span>CONSTELLATION PROTOCOL // ORBITAL STARFIELD ARCHITECTURE</span>
                <span class="text-violet-600 dark:text-violet-400 font-bold">DEEP SPACE SECURE TELEMETRY ACTIVE</span>
            </div>
        </div>
    @endforeach
</div>
