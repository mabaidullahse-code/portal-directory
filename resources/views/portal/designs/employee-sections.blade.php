@props(['departments'])

<div class="space-y-6">
    @forelse($departments as $dept)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs">
            <!-- Department Section Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center font-bold text-base">
                        🏢
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider font-mono">Department Roster</div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">{{ $dept->name }}</h2>
                    </div>
                </div>
                <span class="text-xs font-mono font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-2.5 py-1 rounded-md">
                    {{ $dept->code }}
                </span>
            </div>

            <!-- Employee Rows -->
            <div class="space-y-6 divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($dept->users as $employee)
                    <div class="pt-6 first:pt-0">
                        <div class="flex items-center justify-between mb-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                    {{ $employee->initials }}
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900 dark:text-white">{{ $employee->name }}</h3>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $employee->designation ?: $employee->role->label() }}</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400">
                                {{ $employee->portals->count() }} {{ Str::plural('Portal', $employee->portals->count()) }}
                            </span>
                        </div>

                        <!-- Employee's Portals -->
                        <div class="space-y-2">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700/60 hover:bg-indigo-50/40 dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-600 transition gap-3 group"
                                     x-data="{ copied: false }">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-2.5 h-2.5 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></div>
                                        <div class="min-w-0">
                                            <div class="text-xs font-bold text-slate-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                                {{ $portal->title }}
                                                @if($portal->category)
                                                    <span class="font-normal text-[10px] text-slate-500 dark:text-slate-400">• {{ $portal->category->name }}</span>
                                                @endif
                                            </div>
                                            @if($portal->purpose)
                                                <div class="text-[11px] text-slate-600 dark:text-slate-400 truncate">{{ $portal->purpose }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2.5 shrink-0 self-end sm:self-auto">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $compStatus->badgeClasses() }}">
                                            {{ $compStatus->label() }}
                                        </span>

                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition cursor-pointer"
                                                title="Copy Link">
                                            <span x-show="!copied">
                                                <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-500 font-bold text-[10px]">✓</span>
                                        </button>

                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-900 dark:bg-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-500 text-white text-xs font-semibold shadow-2xs transition">
                                            <span>Launch</span>
                                            <svg width="11" height="11" style="width: 11px; height: 11px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-slate-400 text-xs py-4 text-center">
                        No employees found with active portals in this department.
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center text-slate-400 text-xs">
            No department records to display.
        </div>
    @endforelse
</div>
