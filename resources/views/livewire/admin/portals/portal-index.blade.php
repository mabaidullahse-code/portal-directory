<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">All Registered Portals</h1>
            <p class="text-xs text-slate-500">Global catalog of internal and external organization endpoints across all wings.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('directory.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Directory Presentation</span>
            </a>
            <a href="{{ route('portals.create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Register Portal</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Portals</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Title, purpose, URL, owner..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Department</label>
                <select wire:model.live="departmentFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Category</label>
                <select wire:model.live="categoryFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
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

    <!-- Portals Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Portal Title & Purpose</th>
                        <th class="px-4 py-3">Owner & Department</th>
                        <th class="px-4 py-3">Access Endpoint</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($portals as $portal)
                        @php
                            $compStatus = $portal->computed_status;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                    <span>{{ $portal->title }}</span>
                                    @if($portal->version)
                                        <span class="text-[10px] text-slate-400 font-mono">({{ $portal->version }})</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                    {{ $portal->purpose ?: $portal->description ?: 'No purpose provided.' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $portal->user?->name ?? 'Unassigned' }}</div>
                                <div class="text-[10px] text-slate-400">🏢 {{ $portal->department?->name ?? 'Global' }}</div>
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px]">
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                                    <span class="truncate max-w-[200px]">{{ $portal->safe_url }}</span>
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[11px] bg-slate-100 text-slate-700">
                                    {{ $portal->category?->name ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $compStatus->badgeClasses() }}">
                                    {{ $compStatus->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" wire:click="viewDetails({{ $portal->id }})"
                                            class="p-1 rounded text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    <a href="{{ route('portals.edit', $portal) }}"
                                       class="p-1 rounded text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit Portal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <button type="button" wire:click="toggleStatus({{ $portal->id }})"
                                            class="p-1 rounded {{ $portal->status->value === 'active' ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50' }} transition"
                                            title="{{ $portal->status->value === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>

                                    <button type="button" wire:confirm="Are you sure you want to delete this portal?" wire:click="deletePortal({{ $portal->id }})"
                                            class="p-1 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Portal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                No portals found matching your search and filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $portals->links() }}
        </div>
    </div>

    <!-- Portal Details Modal -->
    @if ($showDetailsModal && $selectedPortal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" wire:click="$set('showDetailsModal', false)"></div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                    <div class="bg-slate-900 p-6 text-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-white/20 text-white">
                                    {{ $selectedPortal->category?->name ?? 'General Portal' }}
                                </span>
                                <h3 class="text-lg font-bold mt-2">{{ $selectedPortal->title }}</h3>
                                <p class="text-xs text-slate-300 mt-0.5 font-mono">{{ $selectedPortal->safe_url }}</p>
                            </div>
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold {{ $selectedPortal->computed_status->badgeClasses() }}">
                                {{ $selectedPortal->computed_status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 text-xs text-slate-700">
                        <div>
                            <div class="font-bold text-slate-900 text-xs mb-1">Purpose</div>
                            <p class="text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                {{ $selectedPortal->purpose ?: 'No purpose statement specified.' }}
                            </p>
                        </div>

                        @if ($selectedPortal->description)
                            <div>
                                <div class="font-bold text-slate-900 text-xs mb-1">Description</div>
                                <p class="text-slate-600">{{ $selectedPortal->description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <div>
                                <span class="text-slate-400 block">Owner Employee</span>
                                <span class="font-semibold text-slate-900">{{ $selectedPortal->user?->name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Department</span>
                                <span class="font-semibold text-slate-900">{{ $selectedPortal->department?->name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Contact Information</span>
                                <span class="font-semibold text-slate-900">
                                    {{ $selectedPortal->contact_person ?: '—' }}
                                    @if($selectedPortal->contact_email)
                                        <span class="block text-[11px] text-blue-600">{{ $selectedPortal->contact_email }}</span>
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Schedule Window</span>
                                <span class="font-semibold text-slate-900">
                                    {{ $selectedPortal->opening_date ? $selectedPortal->opening_date->format('d/m/Y') : 'Always open' }}
                                    @if($selectedPortal->closing_date)
                                        to {{ $selectedPortal->closing_date->format('d/m/Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Target Departments -->
                        @if($selectedPortal->targetDepartments->isNotEmpty())
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-slate-400 block mb-1">Target Departments</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($selectedPortal->targetDepartments as $tDept)
                                        <span class="px-2 py-0.5 rounded text-[11px] bg-blue-50 text-blue-800 border border-blue-200">
                                            {{ $tDept->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-100">
                        <a href="{{ $selectedPortal->safe_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-blue-600 text-xs font-semibold text-white hover:bg-blue-500 transition">
                            <span>Open Live Portal ↗</span>
                        </a>

                        <button type="button" wire:click="$set('showDetailsModal', false)"
                                class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
