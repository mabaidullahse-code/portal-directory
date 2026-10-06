@props(['departments'])

<div class="space-y-6">
    @forelse($departments as $dept)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-6">
                <div>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Department</span>
                    <h2 class="text-base font-bold text-slate-900">{{ $dept->name }}</h2>
                </div>
                <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">
                    {{ $dept->code }}
                </span>
            </div>

            <div class="space-y-6 divide-y divide-slate-100">
                @forelse($dept->users as $employee)
                    <div class="pt-6 first:pt-0">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-bold text-xs flex items-center justify-center">
                                {{ $employee->initials }}
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900">{{ $employee->name }}</h3>
                                <p class="text-[10px] text-slate-500">{{ $employee->designation ?: $employee->role->label() }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            @foreach($employee->portals as $portal)
                                @php
                                    $compStatus = $portal->computed_status;
                                @endphp
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-2 h-2 rounded-full {{ $compStatus->dotClasses() }} shrink-0"></div>
                                        <div class="min-w-0">
                                            <div class="text-xs font-bold text-slate-900 truncate">
                                                {{ $portal->title }}
                                                @if($portal->category)
                                                    <span class="font-normal text-[10px] text-slate-500">• {{ $portal->category->name }}</span>
                                                @endif
                                            </div>
                                            @if($portal->purpose)
                                                <div class="text-[11px] text-slate-600 truncate">{{ $portal->purpose }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 shrink-0 self-end sm:self-auto">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $compStatus->badgeClasses() }}">
                                            {{ $compStatus->label() }}
                                        </span>
                                        <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-blue-600 text-white text-xs font-semibold transition">
                                            <span>Launch</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
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
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
            No department records to display.
        </div>
    @endforelse
</div>
