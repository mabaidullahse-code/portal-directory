@props(['departments'])

<div class="space-y-8">
    @forelse($departments as $dept)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="bg-slate-900 text-white px-6 py-4 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Department Wing</div>
                    <h2 class="text-base font-bold">{{ $dept->name }}</h2>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold bg-white/10 text-white border border-white/20">
                    {{ $dept->code }}
                </span>
            </div>

            <div class="p-6 space-y-6">
                @forelse($dept->users as $employee)
                    <div class="border-b border-slate-100 last:border-0 pb-6 last:pb-0">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                    {{ $employee->initials }}
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900">{{ $employee->name }}</h3>
                                    <p class="text-[11px] text-slate-500">{{ $employee->designation ?: $employee->role->label() }}</p>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-medium">
                                {{ $employee->portals->count() }} {{ Str::plural('Portal', $employee->portals->count()) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-blue-400 p-4 transition-all duration-200 shadow-2xs hover:shadow-sm flex flex-col justify-between group">
                                    <div>
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <span class="text-lg">🌐</span>
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border {{ $compStatus->badgeClasses() }}">
                                                {{ $compStatus->label() }}
                                            </span>
                                        </div>

                                        <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">
                                            {{ $portal->title }}
                                        </h4>

                                        @if($portal->category)
                                            <span class="inline-block text-[10px] text-slate-400 mt-0.5">📁 {{ $portal->category->name }}</span>
                                        @endif

                                        <p class="text-[11px] text-slate-600 mt-2 line-clamp-2">
                                            {{ $portal->purpose ?: $portal->description ?: 'Enterprise organizational portal.' }}
                                        </p>
                                    </div>

                                    <div class="pt-3 mt-3 border-t border-slate-200/60 flex items-center justify-between">
                                        <span class="text-[10px] text-slate-400">
                                            {{ $portal->opening_date ? $portal->opening_date->format('M Y') : 'Always Active' }}
                                        </span>
                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 group-hover:text-blue-700 hover:underline">
                                            <span>Open Portal</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
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
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
            No departments or portals found matching your search.
        </div>
    @endforelse
</div>
