<x-filament-panels::page>
    <!-- Executive Reports Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl border border-indigo-900/40">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold border border-indigo-500/30 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Executive Intelligence & Inventory Analytics</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Portal Systems Dossier & Audit Reports
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                    Generate comprehensive organizational dossiers, review departmental custodians, and export offline portable audit reports.
                </p>
            </div>

            <!-- Download Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <button type="button" wire:click="downloadPdf" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-500 active:bg-rose-700 transition shadow-lg shadow-rose-900/30 cursor-pointer border border-rose-500/30">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span wire:loading.remove wire:target="downloadPdf">Download PDF Report</span>
                    <span wire:loading wire:target="downloadPdf">Generating PDF...</span>
                </button>
                <button type="button" wire:click="downloadExcel" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 transition shadow-lg shadow-emerald-900/30 cursor-pointer border border-emerald-500/30">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span wire:loading.remove wire:target="downloadExcel">Download Excel Report</span>
                    <span wire:loading wire:target="downloadExcel">Generating Excel...</span>
                </button>
                <button type="button" wire:click="downloadHtml" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-100 bg-slate-800/80 hover:bg-slate-700 active:bg-slate-900 transition shadow-md border border-slate-700 cursor-pointer">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span wire:loading.remove wire:target="downloadHtml">Standalone HTML</span>
                    <span wire:loading wire:target="downloadHtml">Generating HTML...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs">
            <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <span>Total Systems</span>
                <span class="text-indigo-500 font-mono">100%</span>
            </div>
            <div class="mt-2 text-3xl font-black text-slate-900 dark:text-white">{{ $summary['total_portals'] }}</div>
            <div class="mt-1 text-[11px] text-slate-500">In {{ $scope }} scope</div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs">
            <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-emerald-600">
                <span>Active Live</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            <div class="mt-2 text-3xl font-black text-emerald-600">{{ $summary['active_portals'] }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Fully operational systems</div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs">
            <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <span>Departments</span>
                <span class="text-indigo-500">🏛️</span>
            </div>
            <div class="mt-2 text-3xl font-black text-slate-900 dark:text-white">{{ $summary['total_departments'] }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Organizational wings covered</div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs">
            <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <span>Personnel</span>
                <span class="text-indigo-500">👤</span>
            </div>
            <div class="mt-2 text-3xl font-black text-slate-900 dark:text-white">{{ $summary['total_employees'] }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Registered system custodians</div>
        </div>
    </div>

    <!-- Departmental Breakdown Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/50 dark:bg-slate-850">
            <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Departmental Systems & Custodians Inventory</h2>
                <p class="text-xs text-slate-500">Complete hierarchy of operational systems mapped by organizational division.</p>
            </div>
            <span class="text-xs text-slate-500 font-mono">Dossier Generated: {{ $generatedAt }}</span>
        </div>

        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @forelse($departments as $deptData)
                @php $dept = $deptData['department'] ?? null; @endphp
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                {{ $dept?->code ?? 'UNIV' }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $dept?->name ?? 'General & Universal Systems' }}</h3>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 font-semibold border border-emerald-200 dark:border-emerald-800">
                                {{ $deptData['active_portals'] ?? 0 }} Active
                            </span>
                            <span class="text-slate-500 font-semibold">
                                {{ $deptData['total_portals'] ?? 0 }} Total Systems
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($deptData['employees'] ?? [] as $empData)
                            <div class="rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                            {{ substr($empData['employee']?->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $empData['employee']?->name ?? 'Staff' }}</span>
                                            @if($empData['employee']?->designation)
                                                <span class="text-[11px] text-slate-400 block sm:inline sm:ml-1">({{ $empData['employee']->designation }})</span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $empData['total'] ?? 0 }} system(s)</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($empData['portals'] ?? [] as $portal)
                                        <div class="p-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 flex flex-col justify-between hover:border-indigo-400 dark:hover:border-indigo-500 transition shadow-2xs">
                                            <div>
                                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $portal->title }}</h4>
                                                    <span class="w-2 h-2 rounded-full shrink-0 {{ $portal->status->value === 'active' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 truncate">{{ $portal->purpose ?: 'Organization operational portal' }}</p>
                                            </div>
                                            <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-[10px]">
                                                <span class="text-slate-400 font-mono">{{ $portal->category?->name ?: 'Portal' }}</span>
                                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                                   class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">
                                                    Launch ↗
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">No portals registered under this department.</div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-400 text-xs">
                    No departmental data available for the current scope.
                </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
