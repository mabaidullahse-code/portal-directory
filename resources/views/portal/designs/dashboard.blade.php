@props(['departments'])

<div class="space-y-8">
    @forelse($departments as $dept)
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                <div>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Division Directory</span>
                    <h2 class="text-lg font-black text-slate-900">{{ $dept->name }}</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        {{ $dept->users->flatMap->portals->count() }} Systems Registered
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($dept->users as $employee)
                    @foreach($employee->portals as $portal)
                        @php
                            $compStatus = $portal->computed_status;
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 hover:border-slate-400 p-5 flex flex-col justify-between transition-all duration-200 shadow-xs hover:shadow-md group">
                            <div>
                                <!-- Top Bar with Icon & Status -->
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg shadow-xs group-hover:bg-blue-600 transition">
                                        🌐
                                    </div>
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $compStatus->badgeClasses() }}">
                                        {{ $compStatus->label() }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition">
                                    {{ $portal->title }}
                                </h3>

                                <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-2">
                                    <span>👤 {{ $employee->name }}</span>
                                    <span>•</span>
                                    <span>🏢 {{ $dept->short_name ?: $dept->code }}</span>
                                </div>

                                <p class="text-xs text-slate-600 mt-3 line-clamp-3 leading-relaxed">
                                    {{ $portal->purpose ?: $portal->description ?: 'Operational enterprise portal system.' }}
                                </p>

                                @if($portal->targetDepartments->isNotEmpty())
                                    <div class="mt-3 flex flex-wrap gap-1">
                                        @foreach($portal->targetDepartments->take(2) as $tDept)
                                            <span class="text-[9px] font-semibold bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">
                                                🎯 {{ $tDept->short_name ?: $tDept->code }}
                                            </span>
                                        @endforeach
                                        @if($portal->targetDepartments->count() > 2)
                                            <span class="text-[9px] text-slate-400 px-1">+{{ $portal->targetDepartments->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-mono">
                                    {{ $portal->version ?: 'v1.0' }}
                                </span>
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-semibold shadow-xs transition">
                                    <span>Open Portal</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
            No departments found.
        </div>
    @endforelse
</div>
