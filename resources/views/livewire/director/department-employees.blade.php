<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Employees of {{ $department->name }}</h1>
            <p class="text-xs text-slate-500">Personnel roster and assigned systems under your direct departmental supervision.</p>
        </div>
    </x-slot>

    <!-- Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6 max-w-md">
        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Department Personnel</label>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Name, Email, Employee ID, Designation..."
               class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
    </div>

    <!-- Employee Cards with Portal Sub-Lists -->
    <div class="space-y-4">
        @forelse ($employees as $emp)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs" x-data="{ expanded: false }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white font-bold text-sm flex items-center justify-center shadow-xs">
                            {{ $emp->initials }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">{{ $emp->name }}</h3>
                            <div class="text-xs text-slate-500 flex flex-wrap items-center gap-2 mt-0.5">
                                <span>{{ $emp->designation ?: 'Staff Member' }}</span>
                                @if($emp->employee_id)
                                    <span>• ID: {{ $emp->employee_id }}</span>
                                @endif
                                <span>• ✉ {{ $emp->email }}</span>
                                @if($emp->phone)
                                    <span>• 📞 {{ $emp->phone }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 self-end sm:self-auto">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                            {{ $emp->portals_count }} {{ Str::plural('Portal', $emp->portals_count) }}
                        </span>

                        @if($emp->portals_count > 0)
                            <button type="button" @click="expanded = !expanded"
                                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                <span x-show="!expanded">View Systems ↓</span>
                                <span x-show="expanded">Hide Systems ↑</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Expanded Portals List -->
                @if($emp->portals->isNotEmpty())
                    <div x-show="expanded" x-transition style="display: none;" class="mt-5 pt-5 border-t border-slate-100">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                            Portals Managed by {{ $emp->name }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($emp->portals as $portal)
                                @php $compStatus = $portal->computed_status; @endphp
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-slate-900 truncate">{{ $portal->title }}</span>
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold border {{ $compStatus->badgeClasses() }}">
                                                {{ $compStatus->label() }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 truncate mt-0.5">{{ $portal->purpose ?: '—' }}</div>
                                    </div>

                                    <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                       class="px-2.5 py-1 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-500 transition shrink-0">
                                        Open ↗
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
                No employees found matching the search criteria.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
