@props(['departments'])

<div class="space-y-8 font-sans">
    @forelse($departments as $dept)
        <div class="portal-cyber-canvas relative rounded-3xl p-6 sm:p-8 overflow-hidden transition-all duration-200">
            <!-- Ambient Cyber Grid Background & Glow -->
            <div class="absolute inset-0 bg-[radial-gradient(#06b6d4_1px,transparent_1px)] [background-size:24px_24px] opacity-15 dark:opacity-20 pointer-events-none"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Cyber Telemetry Diagnostics Header -->
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between pb-5 border-b border-cyan-200 dark:border-cyan-500/25 mb-6 gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-[11px] font-mono font-bold uppercase tracking-widest bg-cyan-100 text-cyan-800 border border-cyan-300 dark:bg-cyan-950/80 dark:text-cyan-300 dark:border-cyan-500/60">
                            <span class="w-2 h-2 rounded-full bg-cyan-500 dark:bg-cyan-400 animate-ping"></span>
                            <span>NODE // {{ $dept->code }}</span>
                        </span>
                        <span class="text-[11px] font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            SEC_LEVEL: 04 // PROTOCOL: TLS_1.3
                        </span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight flex items-center gap-3 text-slate-900 dark:text-white">
                        <span class="text-cyan-600 dark:text-cyan-400 font-mono">&gt;</span>
                        <span>{{ $dept->name }}</span>
                    </h2>
                </div>

                <!-- Live Network Metrics -->
                <div class="flex items-center gap-3 text-xs font-mono shrink-0">
                    <div class="px-4 py-2 rounded-xl text-right bg-white dark:bg-[#0b1324] border border-cyan-200 dark:border-cyan-500/30 shadow-2xs">
                        <span class="text-[10px] block uppercase text-slate-500 dark:text-slate-400">Bandwidth State</span>
                        <span class="font-bold text-cyan-700 dark:text-cyan-400">100% NOMINAL</span>
                    </div>
                    <div class="px-4 py-2 rounded-xl text-right bg-white dark:bg-[#0b1324] border border-emerald-200 dark:border-emerald-500/35 shadow-2xs">
                        <span class="text-[10px] block uppercase text-slate-500 dark:text-slate-400">Active Systems</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $dept->users->flatMap->portals->count() }} ONLINE</span>
                    </div>
                </div>
            </div>

            <!-- Cybernetic Portal Matrix Grid -->
            <div class="relative z-10 space-y-6">
                @forelse($dept->users as $employee)
                    <div class="rounded-2xl p-5 bg-slate-100/70 dark:bg-[#080f1e] border border-slate-200 dark:border-slate-800 shadow-2xs">
                        <!-- Personnel Telemetry Ribbon -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-200 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl font-mono font-bold text-xs flex items-center justify-center shadow-md bg-gradient-to-br from-cyan-600 to-indigo-700 text-white border border-cyan-400/50">
                                    {{ $employee->initials }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold font-mono flex items-center gap-2 text-slate-900 dark:text-white">
                                        <span>{{ $employee->name }}</span>
                                        <span class="text-[10px] font-normal px-2 py-0.5 rounded font-mono bg-cyan-50 text-cyan-800 border border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-300 dark:border-cyan-500/40">
                                            AUTH_OPERATOR
                                        </span>
                                    </h4>
                                    <p class="text-[11px] font-mono mt-0.5 text-slate-500 dark:text-slate-400">{{ $employee->designation ?: 'Staff Custodian' }}</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-mono font-bold text-slate-500 dark:text-slate-400">
                                LOAD: {{ $employee->portals->count() }} UNITS
                            </span>
                        </div>

                        <!-- Portals Grid with Holographic HUD Aesthetic -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="portal-cyber-card group relative rounded-xl p-4 transition-all duration-300 flex flex-col justify-between"
                                     x-data="{ copied: false }">
                                    
                                    <!-- Corner Bracket Markers -->
                                    <div class="absolute top-1.5 left-1.5 w-2 h-2 border-t-2 border-l-2 border-cyan-500 dark:border-cyan-400 pointer-events-none"></div>
                                    <div class="absolute top-1.5 right-1.5 w-2 h-2 border-t-2 border-r-2 border-cyan-500 dark:border-cyan-400 pointer-events-none"></div>
                                    <div class="absolute bottom-1.5 left-1.5 w-2 h-2 border-b-2 border-l-2 border-cyan-500 dark:border-cyan-400 pointer-events-none"></div>
                                    <div class="absolute bottom-1.5 right-1.5 w-2 h-2 border-b-2 border-r-2 border-cyan-500 dark:border-cyan-400 pointer-events-none"></div>

                                    <div>
                                        <!-- Top Status Pill & Category -->
                                        <div class="flex items-center justify-between gap-2 mb-2.5">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                                                    {{ $compStatus->label() }}
                                                </span>
                                            </div>
                                            @if($portal->category)
                                                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-cyan-50 text-cyan-800 border border-cyan-200 dark:bg-cyan-950/60 dark:text-cyan-300 dark:border-cyan-500/40">
                                                    {{ $portal->category->name }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Portal Title -->
                                        <h5 class="text-sm font-bold tracking-wide font-mono leading-snug text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-300 transition">
                                            {{ $portal->title }}
                                        </h5>

                                        <p class="text-xs mt-2 line-clamp-2 leading-relaxed text-slate-600 dark:text-slate-300">
                                            {{ $portal->purpose ?: 'Institutional matrix portal subsystem.' }}
                                        </p>
                                    </div>

                                    <!-- Bottom Action Bar -->
                                    <div class="pt-3.5 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="px-2.5 py-1.5 rounded-lg font-mono text-[10px] font-bold transition cursor-pointer bg-slate-50 hover:bg-slate-100 dark:bg-[#080f1e] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800 hover:text-cyan-600 dark:hover:text-cyan-300"
                                                title="Copy Network Endpoint">
                                            <span x-show="!copied">URL [COPY]</span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-600 dark:text-emerald-400 font-bold">✓ COPIED</span>
                                        </button>

                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg font-mono text-xs font-bold transition shadow-xs bg-cyan-600 hover:bg-cyan-500 text-white dark:bg-cyan-500/20 dark:hover:bg-cyan-500/30 dark:text-cyan-200 dark:border dark:border-cyan-400/50">
                                            <span>INITIATE UPLINK</span>
                                            <svg width="11" height="11" style="width: 11px; height: 11px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 font-mono text-xs text-slate-500 dark:text-slate-400">
                        NO ACTIVE NODES DETECTED FOR THIS SECTOR.
                    </div>
                @endforelse
            </div>

            <!-- Footer Monospace Ticker -->
            <div class="relative z-10 pt-4 mt-6 border-t border-cyan-200 dark:border-cyan-500/25 flex flex-wrap items-center justify-between gap-4 text-[11px] font-mono text-slate-500 dark:text-slate-400">
                <span>CYBER_MATRIX HUD // ENTERPRISE NODE DIRECTORY</span>
                <span class="text-cyan-700 dark:text-cyan-400 font-bold">LATENCY: 12ms • ZERO-TRUST ENCRYPTION ACTIVE</span>
            </div>
        </div>
    @empty
        <div class="portal-cyber-canvas rounded-3xl p-12 text-center font-mono text-xs text-slate-500 dark:text-slate-400">
            NO PORTAL SYSTEMS CURRENTLY DETECTED IN THE SECTOR MATRIX.
        </div>
    @endforelse
</div>
