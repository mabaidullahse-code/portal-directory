@props(['departments'])

<div class="space-y-6">
    @forelse($departments as $dept)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <span>🏢 {{ $dept->name }}</span>
                    <span class="text-xs font-mono text-slate-400">({{ $dept->code }})</span>
                </h3>
            </div>

            <div class="space-y-4">
                @forelse($dept->users as $employee)
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 bg-slate-50/70 rounded-xl border border-slate-200/60">
                        <div class="sm:w-56 shrink-0 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-slate-900 text-white font-bold text-[11px] flex items-center justify-center shrink-0">
                                {{ $employee->initials }}
                            </div>
                            <div class="truncate">
                                <div class="text-xs font-bold text-slate-900 truncate">{{ $employee->name }}</div>
                                <div class="text-[10px] text-slate-500 truncate">{{ $employee->designation ?: 'Staff' }}</div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-wrap items-center gap-2">
                            @forelse($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   title="{{ $portal->purpose ?: $portal->title }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-800 hover:border-blue-400 hover:text-blue-600 hover:shadow-xs transition">
                                    <span class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }}"></span>
                                    <span>{{ $portal->title }}</span>
                                    <span class="text-[10px] text-slate-400">↗</span>
                                </a>
                            @empty
                                <span class="text-xs text-slate-400 italic">No portals</span>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 text-center py-4">No employees in this department.</div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
            No departments available.
        </div>
    @endforelse
</div>
