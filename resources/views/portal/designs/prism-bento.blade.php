@props(['departments'])

<div class="space-y-8">
    @forelse($departments as $dept)
        <div class="relative rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xl overflow-hidden transition-all duration-300">
            <!-- Ambient Iridescent Prism Glow in Corners -->
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gradient-to-br from-indigo-500/15 via-purple-500/10 to-pink-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-gradient-to-tr from-cyan-500/15 via-blue-500/10 to-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Bento Department Showcase Header -->
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-200/80 dark:border-slate-800 mb-6 gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-violet-600 to-pink-500 text-white flex items-center justify-center text-xl font-bold shadow-lg shadow-indigo-500/25">
                        💎
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest font-mono text-indigo-600 dark:text-indigo-400">Prism Architecture</span>
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                {{ $dept->code }}
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight mt-0.5">{{ $dept->name }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                        {{ $dept->users->flatMap->portals->count() }} Systems Registered
                    </span>
                </div>
            </div>

            <!-- Prism Bento Modules Grid -->
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($dept->users as $employee)
                    @foreach($employee->portals as $portal)
                        @php
                            $compStatus = $portal->computed_status;
                        @endphp
                        <div class="group relative rounded-2xl bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 p-5 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 flex flex-col justify-between"
                             x-data="{ copied: false }">
                            
                            <div>
                                <!-- Top Metatags -->
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center text-base shadow-xs group-hover:scale-105 transition">
                                        ✨
                                    </div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $compStatus->badgeClasses() }}">
                                        {{ $compStatus->label() }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug">
                                    {{ $portal->title }}
                                </h3>

                                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 flex items-center gap-2 font-medium">
                                    <span>👤 {{ $employee->name }}</span>
                                    <span>•</span>
                                    <span>🏢 {{ $dept->short_name ?: $dept->code }}</span>
                                </div>

                                <p class="text-xs text-slate-600 dark:text-slate-300 mt-3 line-clamp-3 leading-relaxed">
                                    {{ $portal->purpose ?: $portal->description ?: 'Institutional operational workflow service.' }}
                                </p>

                                @if($portal->category)
                                    <div class="mt-3.5">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-md bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                            <span>📁</span> {{ $portal->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 mt-5 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between gap-2">
                                <button type="button"
                                        @click="navigator.clipboard.writeText('{{ $portal->safe_url }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="p-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer"
                                        title="Copy URL">
                                    <span x-show="!copied">
                                        <svg width="13" height="13" style="width: 13px; height: 13px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </span>
                                    <span x-show="copied" style="display: none;" class="text-emerald-500 font-bold text-[10px]">✓</span>
                                </button>

                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                                    <span>Access Portal</span>
                                    <svg width="11" height="11" style="width: 11px; height: 11px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-12 text-center text-slate-400 text-xs">
            No departments or portals found matching filter criteria.
        </div>
    @endforelse
</div>
