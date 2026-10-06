<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">
                {{ $isEditing ? 'Edit Portal: ' . $portal->title : 'Register New Organizational Portal' }}
            </h1>
            <p class="text-xs text-slate-500">Provide system access endpoints, metadata, target audiences, and operational parameters.</p>
        </div>
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
            <span>← Cancel & Return</span>
        </a>
    </x-slot>

    <form wire:submit="save" class="space-y-6">
        <!-- 1. Primary Information Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span>🌐 System Endpoint & Essentials</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700">Portal Title *</label>
                    <input type="text" wire:model="title" placeholder="e.g. Employee Leave Management System"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('title') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700">Portal URL *</label>
                    <div class="mt-1 flex rounded-lg shadow-xs">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-xs font-mono">
                            https://
                        </span>
                        <input type="text" wire:model="url" placeholder="leaves.organization.org"
                               class="block w-full rounded-r-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 font-mono">
                    </div>
                    @error('url') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Operational Status *</label>
                    <select wire:model="status"
                            class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="active">Active (Available for production usage)</option>
                        <option value="inactive">Inactive (Archived / Under Maintenance)</option>
                    </select>
                    @error('status') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700">Category</label>
                    <select wire:model="category_id"
                            class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Select Category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700">Short Purpose</label>
                    <input type="text" wire:model="purpose" placeholder="One-sentence purpose description for quick directory cards..."
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('purpose') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700">Detailed Description & Features</label>
                    <textarea wire:model="description" rows="3" placeholder="Provide full details, workflow description, and operational notes..."
                              class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                    @error('description') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- 2. Ownership & Department Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span>🏢 Ownership & Departmental Alignment</span>
            </h2>

            @if(auth()->user()->isAdmin())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Portal Owner *</label>
                        <select wire:model.live="user_id"
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            @foreach($ownerUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role->label() }} - {{ $u->department?->short_name ?: 'Global' }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Owner Department (Automatically bound)</label>
                        <select wire:model="department_id"
                                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-xs text-slate-900 bg-slate-50 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Global / Select Department...</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            @else
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                        {{ auth()->user()->initials }}
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-900">
                            Registered by {{ auth()->user()->name }}
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">
                            Automatically bound to your department: <strong>{{ auth()->user()->department?->name ?? 'None' }}</strong>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- 3. Availability Schedule & Target Audiences -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span>🎯 Target Departments & Specific Target Users</span>
            </h2>

            <div class="space-y-5">
                <!-- Target Departments -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Target Departments (Optional)</label>
                    <p class="text-[11px] text-slate-500 mb-2">Select which departments this portal is primarily designed for or targeted towards.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl max-h-48 overflow-y-auto">
                        @foreach($departments as $dept)
                            <label class="flex items-center gap-2 text-xs text-slate-800 hover:text-slate-900 cursor-pointer">
                                <input type="checkbox" wire:model="target_department_ids" value="{{ $dept->id }}"
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span>{{ $dept->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Target Users -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Target Users (Optional)</label>
                    <p class="text-[11px] text-slate-500 mb-2">Grant specific target audience access to individuals across departments.</p>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="text" wire:model.live.debounce.300ms="targetUserSearch" placeholder="Search user by name..."
                                   class="flex-1 rounded-lg border border-slate-300 px-3 py-1 text-xs">
                            <select wire:model.live="targetUserDeptFilter"
                                    class="rounded-lg border border-slate-300 px-3 py-1 text-xs">
                                <option value="all">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->short_name ?: $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-40 overflow-y-auto">
                            @foreach($availableUsers as $user)
                                <label class="flex items-center gap-2 text-xs text-slate-800 hover:text-slate-900 cursor-pointer">
                                    <input type="checkbox" wire:model="target_user_ids" value="{{ $user->id }}"
                                           class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span class="truncate">{{ $user->name }} <span class="text-slate-400 text-[10px]">({{ $user->department?->code }})</span></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Schedule Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Opening Date (Optional)</label>
                        <input type="date" wire:model="opening_date"
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('opening_date') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Closing Date (Optional)</label>
                        <input type="date" wire:model="closing_date"
                               class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('closing_date') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Contact & Additional Metadata Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span>📞 Contact Person & Technical Metadata</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Contact Person</label>
                    <input type="text" wire:model="contact_person" placeholder="e.g. Lead Administrator"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Contact Email</label>
                    <input type="email" wire:model="contact_email" placeholder="support@organization.org"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Contact Phone / Extension</label>
                    <input type="text" wire:model="contact_phone" placeholder="e.g. Ext. 204"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Tags (Comma-separated)</label>
                    <input type="text" wire:model="tags_string" placeholder="leaves, hr, portal, payroll"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">System Version</label>
                    <input type="text" wire:model="version" placeholder="e.g. v2.4.0"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700">Sort Display Order</label>
                    <input type="number" wire:model="sort_order" min="0"
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ url()->previous() }}"
               class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 rounded-xl bg-blue-600 text-xs font-semibold text-white hover:bg-blue-500 transition shadow-xs">
                {{ $isEditing ? 'Save Changes' : 'Register Portal' }}
            </button>
        </div>
    </form>
</div>
