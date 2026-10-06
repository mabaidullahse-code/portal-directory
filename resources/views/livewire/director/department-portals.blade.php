<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Department Portals: {{ $department->name }}</h1>
            <p class="text-xs text-slate-500">Grouped inventory of digital portals and enterprise workflows maintained across your wing.</p>
        </div>
        <a href="{{ route('portals.create') }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Register Portal</span>
        </a>
    </x-slot>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-xl">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Portals</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Portal title, purpose, URL..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status</label>
                <select wire:model.live="statusFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Grouped Employee Sections -->
    <div class="space-y-6">
        @forelse ($employees as $employee)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <!-- Employee Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-white font-bold text-xs flex items-center justify-center">
                            {{ $employee->initials }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">{{ $employee->name }}</h3>
                            <p class="text-xs text-slate-500">{{ $employee->designation ?: 'Staff Member' }} • {{ $department->name }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-slate-400 font-semibold">
                        {{ $employee->portals->count() }} Systems
                    </span>
                </div>

                <!-- Portal Cards Grid for this employee -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($employee->portals as $portal)
                        @php $compStatus = $portal->computed_status; @endphp
                        <div class="bg-slate-50 hover:bg-white rounded-xl border border-slate-200 hover:border-blue-400 p-4 transition shadow-2xs hover:shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="text-base">🌐</span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $compStatus->badgeClasses() }}">
                                        {{ $compStatus->label() }}
                                    </span>
                                </div>

                                <h4 class="text-xs font-bold text-slate-900">{{ $portal->title }}</h4>

                                <p class="text-[11px] text-slate-600 mt-2 line-clamp-2">
                                    {{ $portal->purpose ?: $portal->description ?: 'Operational enterprise portal.' }}
                                </p>
                            </div>

                            <div class="pt-3 mt-3 border-t border-slate-200/60 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400">
                                    {{ $portal->opening_date ? $portal->opening_date->format('M Y') : 'Active' }}
                                </span>
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-700">
                                    <span>Open Portal</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
                No portals matching your criteria found in this department.
            </div>
        @endforelse
    </div>
</div>
