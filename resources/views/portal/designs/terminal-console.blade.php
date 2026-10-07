@props(['departments'])

<div class="space-y-6 font-mono text-xs">
    @forelse($departments as $dept)
        <div class="portal-terminal-canvas rounded-2xl p-6 shadow-xl transition-all duration-200">
            
            <!-- Flight Control Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800 mb-6 gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold bg-amber-100 text-amber-800 border border-amber-300 dark:bg-amber-500/15 dark:border-amber-500/40 dark:text-amber-400 shadow-2xs">
                        ⚡
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold tracking-widest uppercase text-amber-700 dark:text-amber-400">DIVISION FLIGHT OPS</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700">LOC: {{ $dept->code }}</span>
                        </div>
                        <h2 class="text-base font-bold tracking-wide mt-0.5 text-slate-900 dark:text-white">{{ $dept->name }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-[11px]">
                    <span class="px-3 py-1.5 rounded-lg flex items-center gap-2 font-bold bg-white dark:bg-[#0c1322] border border-slate-200 dark:border-slate-800 text-emerald-700 dark:text-emerald-400 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                        <span>GRID ACTIVE: {{ $dept->users->flatMap->portals->count() }} SYSTEMS</span>
                    </span>
                </div>
            </div>

            <!-- Terminal Rows -->
            <div class="space-y-4">
                @forelse($dept->users as $employee)
                    <div class="rounded-xl p-4 bg-slate-100/75 dark:bg-[#090e1c] border border-slate-200 dark:border-slate-800 shadow-2xs">
                        
                        <div class="flex items-center justify-between pb-2.5 mb-3 border-b border-slate-200 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 dark:text-slate-400 font-medium">[CUSTODIAN]</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $employee->name }}</span>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400">({{ $employee->designation ?: 'Authorized Staff' }})</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                REGISTERED: {{ $employee->portals->count() }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="portal-terminal-card rounded-xl p-3.5 flex flex-col justify-between transition-all group"
                                     x-data="{ copied: false }">
                                    <div>
                                        <div class="flex items-center justify-between gap-1 mb-2 text-[10px]">
                                            <span class="font-bold uppercase text-emerald-700 dark:text-emerald-400">● {{ $compStatus->label() }}</span>
                                            <span class="font-mono text-slate-500 dark:text-slate-400">{{ $portal->version ?: 'v1.0' }}</span>
                                        </div>

                                        <h4 class="font-bold transition text-xs truncate text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400">
                                            {{ $portal->title }}
                                        </h4>

                                        <p class="text-[11px] mt-1 line-clamp-2 leading-relaxed text-slate-600 dark:text-slate-300">
                                            {{ $portal->purpose ?: 'Tactical organizational portal service.' }}
                                        </p>
                                    </div>

                                    <div class="pt-3 mt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="px-2.5 py-1 rounded-lg text-[10px] font-bold transition cursor-pointer bg-slate-100 hover:bg-slate-200 dark:bg-[#070b14] dark:hover:bg-slate-900 text-slate-700 dark:text-slate-400 border border-slate-200 dark:border-slate-800"
                                                title="Copy System URI">
                                            <span x-show="!copied">[COPY URI]</span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-600 dark:text-emerald-400 font-bold">[COPIED ✓]</span>
                                        </button>

                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="px-3 py-1 rounded-lg font-bold text-[11px] transition inline-flex items-center gap-1.5 shadow-xs bg-amber-600 hover:bg-amber-500 text-white dark:bg-amber-500/20 dark:hover:bg-amber-500/30 dark:border dark:border-amber-500 dark:text-amber-300">
                                            <span>EXECUTE LINK</span>
                                            <svg width="10" height="10" style="width: 10px; height: 10px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-slate-500 dark:text-slate-400">
                        No personnel units found in division telemetry.
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="portal-terminal-canvas rounded-2xl p-8 text-center text-slate-500 dark:text-slate-400">
            [NO SYSTEMS ACTIVE IN FLIGHT CONSOLE]
        </div>
    @endforelse
</div>
