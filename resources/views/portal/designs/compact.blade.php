@props(['departments'])

<div class="space-y-6">
    @forelse($departments as $dept)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden transition-all duration-200 hover:shadow-md">
            <!-- Department Compact Header -->
            <div class="px-5 py-3.5 bg-slate-50/80 dark:bg-slate-800/60 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="text-base">🏢</span>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wide">
                        {{ $dept->name }}
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/50">
                        {{ $dept->code }}
                    </span>
                </div>
                <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">
                    {{ $dept->users->flatMap->portals->count() }} {{ Str::plural('System', $dept->users->flatMap->portals->count()) }}
                </span>
            </div>

            <!-- Department Employee Directory Rows -->
            <div class="p-4 space-y-2.5">
                @forelse($dept->users as $employee)
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-3 rounded-xl bg-white dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-50/50 dark:hover:bg-slate-800/70 transition">
                        <!-- Employee Info -->
                        <div class="md:w-64 shrink-0 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-slate-900 to-indigo-950 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs border border-indigo-500/20">
                                {{ $employee->initials }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $employee->name }}</div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ $employee->designation ?: 'Staff Custodian' }}</div>
                            </div>
                        </div>

                        <!-- Portals Launch Badges -->
                        <div class="flex-1 flex flex-wrap items-center gap-2">
                            @forelse($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="group relative inline-flex items-center" x-data="{ copied: false }">
                                    <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                       title="{{ $portal->purpose ?: $portal->title }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:shadow-2xs transition group-hover:pr-1.5">
                                        <span class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></span>
                                        <span class="font-semibold">{{ $portal->title }}</span>
                                        <svg width="10" height="10" style="width: 10px; height: 10px; display: inline-block; vertical-align: middle; flex-shrink: 0;" class="text-slate-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>

                                    <button type="button"
                                            @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                            class="ml-1 p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition opacity-0 group-hover:opacity-100 cursor-pointer"
                                            title="Copy link">
                                        <span x-show="!copied">
                                            <svg width="11" height="11" style="width: 11px; height: 11px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        </span>
                                        <span x-show="copied" style="display: none;" class="text-emerald-500 font-bold text-[10px]">✓</span>
                                    </button>
                                </div>
                            @empty
                                <span class="text-xs text-slate-400 dark:text-slate-500 italic">No registered portals</span>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-3 text-center">No personnel registered in this department.</div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center text-slate-400 text-xs">
            No departments or portals found matching filter.
        </div>
    @endforelse
</div>
