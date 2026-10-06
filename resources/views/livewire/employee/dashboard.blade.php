<div>
    <!-- Welcome Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 text-white rounded-3xl p-6 sm:p-8 shadow-sm mb-6 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    <span>👋 Employee Workspace</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Welcome, {{ $employee->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">
                    Department: <strong>{{ $employee->department?->name ?? 'General Staff' }}</strong>
                    @if($employee->designation)
                        • {{ $employee->designation }}
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('portals.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Register New Portal</span>
                </a>
                <a href="{{ route('directory.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/10 transition">
                    <span>View Directory</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">My Portals</div>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $totalPortals }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Registered by you</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Active Portals</div>
            <div class="mt-2 text-2xl font-black text-emerald-600">{{ $activePortals }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Live operational</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Targeted Systems</div>
            <div class="mt-2 text-2xl font-black text-blue-600">{{ $targetedToMe->count() }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Assigned for your use</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">My Department</div>
            <div class="mt-2 text-lg font-bold text-slate-800 truncate">{{ $employee->department?->short_name ?: $employee->department?->code }}</div>
            <div class="mt-1 text-[11px] text-slate-500">Official Wing</div>
        </div>
    </div>

    <!-- Controls Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex-1 max-w-sm">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search my portals..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select wire:model.live="categoryFilter"
                        class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter"
                        class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <select wire:model.live="sortOrder"
                        class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="latest">Sort: Newest</option>
                    <option value="oldest">Sort: Oldest</option>
                    <option value="title">Sort: Title (A-Z)</option>
                </select>

                <!-- Grid / List Switcher -->
                <div class="flex items-center rounded-lg border border-slate-200 p-0.5 bg-slate-50">
                    <button type="button" wire:click="$set('viewLayout', 'grid')"
                            class="p-1 rounded {{ $viewLayout === 'grid' ? 'bg-white shadow-2xs text-blue-600' : 'text-slate-400 hover:text-slate-600' }}" title="Grid View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </button>
                    <button type="button" wire:click="$set('viewLayout', 'list')"
                            class="p-1 rounded {{ $viewLayout === 'list' ? 'bg-white shadow-2xs text-blue-600' : 'text-slate-400 hover:text-slate-600' }}" title="List View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- My Portals Presentation Stage -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-slate-900">My Registered Systems</h2>
            <a href="{{ route('employee.portals.index') }}" class="text-xs text-blue-600 hover:text-blue-500 font-semibold">
                Manage Table & Settings →
            </a>
        </div>

        @if ($viewLayout === 'grid')
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($myPortals as $portal)
                    @php $compStatus = $portal->computed_status; @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 hover:border-blue-400 p-5 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center text-base shadow-xs group-hover:bg-blue-600 transition">
                                    🌐
                                </div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $compStatus->badgeClasses() }}">
                                    {{ $compStatus->label() }}
                                </span>
                            </div>

                            <h3 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">
                                {{ $portal->title }}
                            </h3>

                            @if($portal->category)
                                <div class="text-[10px] text-slate-400 mt-0.5">📁 {{ $portal->category->name }}</div>
                            @endif

                            <p class="text-xs text-slate-600 mt-2 line-clamp-2">
                                {{ $portal->purpose ?: $portal->description ?: 'Operational enterprise portal system.' }}
                            </p>
                        </div>

                        <div class="pt-3 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('portals.edit', $portal) }}" class="text-xs text-slate-500 hover:text-blue-600 font-medium">
                                Edit Portal
                            </a>

                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-xs transition">
                                <span>Open Portal</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
                        You have not registered any portals matching the filter.
                    </div>
                @endforelse
            </div>
        @else
            <!-- List Layout -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs divide-y divide-slate-100">
                @forelse($myPortals as $portal)
                    @php $compStatus = $portal->computed_status; @endphp
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold text-slate-900">{{ $portal->title }}</h3>
                                <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold border {{ $compStatus->badgeClasses() }}">
                                    {{ $compStatus->label() }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $portal->purpose ?: '—' }}</p>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $portal->safe_url }}</span>
                        </div>

                        <div class="flex items-center gap-3 shrink-0 self-end sm:self-auto">
                            <a href="{{ route('portals.edit', $portal) }}" class="text-xs text-slate-500 hover:text-blue-600 font-medium">
                                Edit
                            </a>
                            <a href="{{ $portal->safe_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-500 transition">
                                <span>Open Portal ↗</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">
                        No portals found.
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    <!-- Targeted to You Section -->
    @if ($targetedToMe->isNotEmpty())
        <div class="bg-slate-100/70 rounded-3xl p-6 border border-slate-200/80">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Systems Targeted to You & Your Department</h2>
                    <p class="text-xs text-slate-500">Cross-departmental portals assigned for your operational workflow</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($targetedToMe as $tPortal)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-2xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate">{{ $tPortal->title }}</h4>
                            <div class="text-[10px] text-slate-500 truncate">Owned by: {{ $tPortal->department?->short_name ?: $tPortal->department?->code }}</div>
                        </div>

                        <a href="{{ $tPortal->safe_url }}" target="_blank" rel="noopener noreferrer"
                           class="px-2.5 py-1 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-blue-600 transition shrink-0">
                            Open ↗
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
