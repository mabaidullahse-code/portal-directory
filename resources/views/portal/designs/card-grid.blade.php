@props(['departments'])

<div class="space-y-8">
    @forelse($departments as $dept)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
            <div class="bg-gradient-to-r from-slate-50 to-indigo-50/50 dark:from-slate-900 dark:to-indigo-950 text-slate-900 dark:text-white px-6 py-4 flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 dark:border-indigo-900/40">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 dark:bg-indigo-500/20 dark:text-indigo-300 dark:border-indigo-400/30">
                        {{ $dept->code }}
                    </span>
                    <div>
                        <div class="text-[10px] font-bold text-indigo-600 dark:text-indigo-300 uppercase tracking-widest font-mono">Department Operational Wing</div>
                        <h2 class="text-base font-black text-slate-900 dark:text-white">{{ $dept->name }}</h2>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white dark:bg-white/10 text-slate-700 dark:text-white border border-slate-200 dark:border-white/15 shadow-2xs">
                    {{ $dept->users->flatMap->portals->count() }} Systems Registered
                </span>
            </div>

            <div class="p-6 space-y-6 divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($dept->users as $employee)
                    <div class="pt-6 first:pt-0">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                    {{ $employee->initials }}
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900 dark:text-white">{{ $employee->name }}</h3>
                                    <p class="text-[11px] text-slate-500">{{ $employee->designation ?: $employee->role->label() }}</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-medium">
                                {{ $employee->portals->count() }} {{ Str::plural('Portal', $employee->portals->count()) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="portal-glass-card rounded-2xl border border-slate-200 dark:border-slate-800 p-5 transition-all duration-300 shadow-2xs hover:shadow-lg flex flex-col justify-between group"
                                     x-data="{ copied: false }">
                                    <div>
                                        <div class="flex items-start justify-between gap-2 mb-3">
                                            <span class="text-xl">🌐</span>
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $compStatus->badgeClasses() }}">
                                                {{ $compStatus->label() }}
                                            </span>
                                        </div>

                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                            {{ $portal->title }}
                                        </h4>

                                        @if($portal->category)
                                            <span class="inline-block text-[10px] font-semibold text-indigo-600 dark:text-indigo-400 mt-1">
                                                📁 {{ $portal->category->name }}
                                            </span>
                                        @endif

                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                                            {{ $portal->purpose ?: $portal->description ?: 'Institutional operational workflow service.' }}
                                        </p>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                                        <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 transition cursor-pointer"
                                                title="Copy Portal Link">
                                            <span x-show="!copied">
                                                <svg width="14" height="14" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </span>
                                            <span x-show="copied" style="display: none;" class="text-emerald-600 font-bold text-[10px]">✓</span>
                                        </button>

                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-xs transition">
                                            <span>Open Portal</span>
                                            <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-400 text-xs">
                        No employees with active portals registered in this department.
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center text-slate-400 text-xs">
            No departments or portals found matching your search.
        </div>
    @endforelse
</div>
