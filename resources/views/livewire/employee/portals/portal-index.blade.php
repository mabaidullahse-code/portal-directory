<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">My Registered Portals</h1>
            <p class="text-xs text-slate-500">Manage all portal systems and operational tools registered under your employee account.</p>
        </div>
        <a href="{{ route('portals.create') }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Register New Portal</span>
        </a>
    </x-slot>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6 max-w-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search My Systems</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Title, purpose, URL..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
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

    <!-- Complete Management Table (Requirement 13) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Portal Title</th>
                        <th class="px-4 py-3">Purpose</th>
                        <th class="px-4 py-3">URL</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Opening Date</th>
                        <th class="px-4 py-3">Closing Date</th>
                        <th class="px-4 py-3">Target Departments</th>
                        <th class="px-4 py-3">Target Users</th>
                        <th class="px-4 py-3">Created At</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($portals as $portal)
                        @php $compStatus = $portal->computed_status; @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- 1. Title -->
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900 text-xs">{{ $portal->title }}</div>
                                @if($portal->category)
                                    <div class="text-[10px] text-slate-400">📁 {{ $portal->category->name }}</div>
                                @endif
                            </td>

                            <!-- 2. Purpose -->
                            <td class="px-4 py-3 max-w-xs truncate text-[11px] text-slate-600">
                                {{ $portal->purpose ?: '—' }}
                            </td>

                            <!-- 3. URL -->
                            <td class="px-4 py-3 font-mono text-[11px]">
                                <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                   class="text-blue-600 hover:text-blue-700 truncate block max-w-[140px]">
                                    {{ $portal->safe_url }}
                                </a>
                            </td>

                            <!-- 4. Status -->
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $compStatus->badgeClasses() }}">
                                    {{ $compStatus->label() }}
                                </span>
                            </td>

                            <!-- 5. Opening Date -->
                            <td class="px-4 py-3 text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $portal->opening_date ? $portal->opening_date->format('d/m/Y') : 'Always open' }}
                            </td>

                            <!-- 6. Closing Date -->
                            <td class="px-4 py-3 text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $portal->closing_date ? $portal->closing_date->format('d/m/Y') : 'None' }}
                            </td>

                            <!-- 7. Target Departments -->
                            <td class="px-4 py-3">
                                @if($portal->targetDepartments->isNotEmpty())
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700">
                                        {{ $portal->targetDepartments->count() }} Depts
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px]">General</span>
                                @endif
                            </td>

                            <!-- 8. Target Users -->
                            <td class="px-4 py-3">
                                @if($portal->targetUsers->isNotEmpty())
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-50 text-purple-700">
                                        {{ $portal->targetUsers->count() }} Staff
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px]">All</span>
                                @endif
                            </td>

                            <!-- 9. Created At -->
                            <td class="px-4 py-3 text-[11px] text-slate-400 whitespace-nowrap">
                                {{ $portal->created_at->format('d M Y') }}
                            </td>

                            <!-- 10. Actions: View, Edit, Delete, Activate/Deactivate, Open Portal -->
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Open Portal -->
                                    <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                                       class="p-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Open Portal ↗">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>

                                    <!-- View Details -->
                                    <button type="button" wire:click="viewPortal({{ $portal->id }})"
                                            class="p-1 rounded text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition" title="View Record">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('portals.edit', $portal) }}"
                                       class="p-1 rounded text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <!-- Toggle Active/Inactive -->
                                    <button type="button" wire:click="toggleStatus({{ $portal->id }})"
                                            class="p-1 rounded {{ $portal->status->value === 'active' ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50' }} transition"
                                            title="{{ $portal->status->value === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>

                                    <!-- Delete -->
                                    <button type="button" wire:confirm="Are you sure you want to delete this portal?" wire:click="deletePortal({{ $portal->id }})"
                                            class="p-1 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-slate-400">
                                No registered portals found matching your filters.
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

    <!-- Portal Details Inspector Modal -->
    @if ($showDetailsModal && $selectedPortal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" wire:click="$set('showDetailsModal', false)"></div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-slate-900 p-5 text-white">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-base font-bold">{{ $selectedPortal->title }}</h3>
                                <p class="text-xs text-blue-300 font-mono mt-0.5">{{ $selectedPortal->safe_url }}</p>
                            </div>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $selectedPortal->computed_status->badgeClasses() }}">
                                {{ $selectedPortal->computed_status->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 space-y-3 text-xs text-slate-700">
                        <div>
                            <span class="font-bold text-slate-900 block mb-0.5">Purpose</span>
                            <p class="text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                {{ $selectedPortal->purpose ?: 'No purpose specified.' }}
                            </p>
                        </div>

                        @if ($selectedPortal->description)
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">Description</span>
                                <p class="text-slate-600">{{ $selectedPortal->description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px]">Opening Date</span>
                                <span class="font-semibold text-slate-800">{{ $selectedPortal->opening_date ? $selectedPortal->opening_date->format('d/m/Y') : 'Immediate' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px]">Closing Date</span>
                                <span class="font-semibold text-slate-800">{{ $selectedPortal->closing_date ? $selectedPortal->closing_date->format('d/m/Y') : 'None (Permanent)' }}</span>
                            </div>
                        </div>

                        @if($selectedPortal->targetDepartments->isNotEmpty())
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-slate-400 block text-[10px] mb-1">Target Departments</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($selectedPortal->targetDepartments as $d)
                                        <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-semibold border border-blue-200">
                                            {{ $d->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-50 px-5 py-3 flex justify-between border-t border-slate-100">
                        <a href="{{ $selectedPortal->safe_url }}" target="_blank" rel="noopener noreferrer"
                           class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-500 transition">
                            Open Portal ↗
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
