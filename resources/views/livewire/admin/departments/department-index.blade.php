<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Department Management</h1>
            <p class="text-xs text-slate-500">Configure organizational wings, functional divisions, and operational departments.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.departments.import') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>Import Excel/CSV</span>
            </a>
            <button type="button" wire:click="openCreateModal"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add Department</span>
            </button>
        </div>
    </x-slot>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2">
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Departments</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Department name, short name, code, description..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
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

    <!-- Departments Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Department Name</th>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Directors</th>
                        <th class="px-4 py-3">Employees</th>
                        <th class="px-4 py-3">Portals</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($departments as $dept)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900 text-sm">{{ $dept->name }}</div>
                                @if($dept->short_name && $dept->short_name !== $dept->name)
                                    <div class="text-[11px] text-slate-500">Short: {{ $dept->short_name }}</div>
                                @endif
                                @if($dept->description)
                                    <div class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{{ $dept->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded font-mono font-bold text-[11px] bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $dept->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $dept->directors_count }}
                            </td>
                            <td class="px-4 py-3 font-semibold text-slate-800">
                                {{ $dept->employees_count }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                    {{ $dept->portals_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $dept->status === 'active' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                    {{ ucfirst($dept->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" wire:click="editDepartment({{ $dept->id }})"
                                            class="p-1 rounded text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit Department">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                    <button type="button" wire:click="toggleStatus({{ $dept->id }})"
                                            class="p-1 rounded {{ $dept->status === 'active' ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50' }} transition"
                                            title="{{ $dept->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>

                                    <button type="button" wire:confirm="Are you sure you want to delete this department? All dependent checks will be performed." wire:click="deleteDepartment({{ $dept->id }})"
                                            class="p-1 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Department">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                No departments found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $departments->links() }}
        </div>
    </div>

    <!-- Create / Edit Department Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" wire:click="$set('showModal', false)"></div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <form wire:submit="saveDepartment">
                        <div class="bg-white px-6 pt-5 pb-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                                <h3 class="text-sm font-bold text-slate-900">
                                    {{ $editingDepartmentId ? 'Edit Department' : 'Create New Department' }}
                                </h3>
                                <button type="button" wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700">Department Name *</label>
                                    <input type="text" wire:model="name" placeholder="e.g. IT Software Wing"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('name') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Short Name</label>
                                        <input type="text" wire:model="short_name" placeholder="e.g. Software"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('short_name') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Code *</label>
                                        <input type="text" wire:model="code" placeholder="e.g. ITSW"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 uppercase focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('code') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700">Status *</label>
                                    <select wire:model="status"
                                            class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700">Description</label>
                                    <textarea wire:model="description" rows="3" placeholder="Brief mandate or function of this department..."
                                              class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                                    @error('description') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-3 flex justify-end gap-2 border-t border-slate-100">
                            <button type="button" wire:click="$set('showModal', false)"
                                    class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-1.5 rounded-lg bg-blue-600 text-xs font-semibold text-white hover:bg-blue-500 transition">
                                {{ $editingDepartmentId ? 'Update Department' : 'Save Department' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
