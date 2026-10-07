@props(['departments'])

<div class="space-y-8">
    @forelse($departments as $dept)
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-6 gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800 flex items-center justify-center text-lg font-bold shadow-2xs">
                        🏛️
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest font-mono">Division Directory</span>
                            <span class="text-xs font-mono font-semibold text-slate-400">({{ $dept->code }})</span>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">{{ $dept->name }}</h2>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-700">
                        {{ $dept->users->flatMap->portals->count() }} Systems Registered
                    </span>
                </div>
            </div>

            <!-- Bento Dashboard Grid of Portals -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($dept->users as $employee)
                    @foreach($employee->portals as $portal)
                        @php
                            $compStatus = $portal->computed_status;
                        @endphp
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 hover:border-indigo-400 dark:hover:border-indigo-500 p-5 flex flex-col justify-between transition-all duration-300 shadow-2xs hover:shadow-lg group"
                             x-data="{ copied: false }">
                            <div>
                                <!-- Top Bar with Icon & Status -->
                                <div class="flex items-center justify-between gap-2 mb-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-700 text-white flex items-center justify-center text-lg shadow-xs group-hover:bg-indigo-600 transition">
                                        🌐
                                    </div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $compStatus->badgeClasses() }}">
                                        {{ $compStatus->label() }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug">
                                    {{ $portal->title }}
                                </h3>

                                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <span>👤</span> {{ $employee->name }}
                                    </span>
                                    <span>•</span>
                                    <span class="font-mono text-[10px]">{{ $dept->short_name ?: $dept->code }}</span>
                                </div>

                                <p class="text-xs text-slate-600 dark:text-slate-300 mt-3 line-clamp-3 leading-relaxed">
                                    {{ $portal->purpose ?: $portal->description ?: 'Operational enterprise portal system.' }}
                                </p>

                                @if($portal->targetDepartments->isNotEmpty())
                                    <div class="mt-3.5 flex flex-wrap gap-1">
                                        @foreach($portal->targetDepartments->take(2) as $tDept)
                                            <span class="text-[9px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-md border border-indigo-200 dark:border-indigo-800">
                                                🎯 {{ $tDept->short_name ?: $tDept->code }}
                                            </span>
                                        @endforeach
                                        @if($portal->targetDepartments->count() > 2)
                                            <span class="text-[9px] text-slate-400 px-1">+{{ $portal->targetDepartments->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 mt-5 border-t border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-slate-400 font-mono">
                                        {{ $portal->version ?: 'v1.0' }}
                                    </span>
                                    <button type="button"
                                            @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                            class="p-1 rounded text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition cursor-pointer"
                                            title="Copy Portal Link">
                                        <span x-show="!copied">
                                            <svg width="12" height="12" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        </span>
                                        <span x-show="copied" style="display: none;" class="text-emerald-500 font-bold text-[10px]">✓</span>
                                    </button>
                                </div>

                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 dark:bg-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-500 text-white text-xs font-semibold shadow-xs transition">
                                    <span>Open Portal</span>
                                    <svg width="11" height="11" style="width: 11px; height: 11px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 text-center text-slate-400 text-xs">
            No departments or portals found.
        </div>
    @endforelse
</div>
