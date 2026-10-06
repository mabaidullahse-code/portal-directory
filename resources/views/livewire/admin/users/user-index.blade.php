<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">User Management</h1>
            <p class="text-xs text-slate-500">Manage administrator, director, and employee access accounts across all departments.</p>
        </div>
        <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Create User</span>
        </button>
    </x-slot>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Name, Email, ID..."
                           class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Role</label>
                <select wire:model.live="roleFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Roles</option>
                    <option value="admin">Administrator</option>
                    <option value="director">Director</option>
                    <option value="employee">Employee</option>
                </select>
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

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">User & Info</th>
                        <th class="px-4 py-3">Employee ID</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Department</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $user->initials }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $user->email }}</div>
                                        @if($user->designation)
                                            <div class="text-[10px] text-slate-400">{{ $user->designation }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px] text-slate-600">
                                {{ $user->employee_id ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $user->role->badgeClasses() }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-700">
                                @if($user->department)
                                    <span class="font-medium text-slate-900">{{ $user->department->name }}</span>
                                    <span class="text-[10px] text-slate-400 block">({{ $user->department->code }})</span>
                                @else
                                    <span class="text-slate-400 italic">All Departments (Global)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $user->status->badgeClasses() }}">
                                    {{ $user->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" wire:click="editUser({{ $user->id }})"
                                            class="p-1 rounded text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                    @if($user->id !== auth()->id())
                                        <button type="button" wire:click="toggleUserStatus({{ $user->id }})"
                                                class="p-1 rounded {{ $user->status->value === 'active' ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50' }} transition"
                                                title="{{ $user->status->value === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>

                                        <button type="button" wire:confirm="Are you sure you want to delete this user?" wire:click="deleteUser({{ $user->id }})"
                                                class="p-1 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                No users found matching your search and filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create / Edit User Modal -->
    @if ($showUserModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" wire:click="$set('showUserModal', false)"></div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="saveUser">
                        <div class="bg-white px-6 pt-5 pb-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                                <h3 class="text-sm font-bold text-slate-900">
                                    {{ $editingUserId ? 'Edit User Record' : 'Create New User Account' }}
                                </h3>
                                <button type="button" wire:click="$set('showUserModal', false)" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700">Full Name *</label>
                                    <input type="text" wire:model="name"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @error('name') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Employee ID</label>
                                        <input type="text" wire:model="employee_id" placeholder="e.g. EMP-1001"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('employee_id') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Email Address *</label>
                                        <input type="email" wire:model="email"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('email') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Phone</label>
                                        <input type="text" wire:model="phone"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('phone') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Designation</label>
                                        <input type="text" wire:model="designation" placeholder="e.g. Lead Engineer"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('designation') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Role *</label>
                                        <select wire:model.live="role"
                                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <option value="employee">Employee</option>
                                            <option value="director">Director</option>
                                            <option value="admin">Administrator</option>
                                        </select>
                                        @error('role') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
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
                                </div>

                                @if ($role !== 'admin')
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Department *</label>
                                        <select wire:model="department_id"
                                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <option value="">Select Department...</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">
                                            {{ $editingUserId ? 'New Password (Optional)' : 'Password *' }}
                                        </label>
                                        <input type="password" wire:model="password"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @error('password') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700">Confirm Password</label>
                                        <input type="password" wire:model="password_confirmation"
                                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-3 flex justify-end gap-2 border-t border-slate-100">
                            <button type="button" wire:click="$set('showUserModal', false)"
                                    class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-1.5 rounded-lg bg-blue-600 text-xs font-semibold text-white hover:bg-blue-500 transition">
                                {{ $editingUserId ? 'Update User' : 'Save User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
