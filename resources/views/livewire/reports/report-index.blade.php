<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Portal Directory Reports & Inventory Exports</h1>
            <p class="text-xs text-slate-500">
                Generate official enterprise PDF documents and standalone offline-compatible HTML reports.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="downloadPdf" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span wire:loading.remove wire:target="downloadPdf">Download PDF Report</span>
                <span wire:loading wire:target="downloadPdf">Generating PDF...</span>
            </button>

            <button type="button" wire:click="downloadHtml" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span wire:loading.remove wire:target="downloadHtml">Download Standalone HTML</span>
                <span wire:loading wire:target="downloadHtml">Preparing HTML...</span>
            </button>
        </div>
    </x-slot>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs mb-6">
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
            Report Scope & Parameters
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            @if ($user->isAdmin())
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Department</label>
                    <select wire:model.live="departmentId"
                            class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="all">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Department (Restricted)</label>
                    <input type="text" disabled value="{{ $user->department?->name ?? 'Own Department' }}"
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs text-slate-500 cursor-not-allowed">
                </div>
            @endif

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Employee</label>
                <select wire:model.live="userId"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Employees</option>
                    @foreach($availableEmployees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Category</label>
                <select wire:model.live="categoryId"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status</label>
                <select wire:model.live="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Date From</label>
                <input type="date" wire:model.live="dateFrom"
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Date To</label>
                <input type="date" wire:model.live="dateTo"
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Live Report Summary Statistics -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-xs text-center">
            <div class="text-xl font-black text-slate-900">{{ $reportData['summary']['total_portals'] }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold mt-0.5">Total Portals</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-xs text-center">
            <div class="text-xl font-black text-emerald-600">{{ $reportData['summary']['active_portals'] }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold mt-0.5">Active</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-xs text-center">
            <div class="text-xl font-black text-slate-500">{{ $reportData['summary']['inactive_portals'] }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold mt-0.5">Inactive</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-xs text-center">
            <div class="text-xl font-black text-blue-600">{{ $reportData['summary']['total_departments'] }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold mt-0.5">Departments</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-3 shadow-xs text-center">
            <div class="text-xl font-black text-purple-600">{{ $reportData['summary']['total_employees'] }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold mt-0.5">Employees</div>
        </div>
    </div>

    <!-- On-Screen Report Preview -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-slate-900 text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                <span class="text-xs font-bold uppercase tracking-wider">Live Document Preview</span>
            </div>
            <span class="text-xs text-slate-300">Scope: {{ $reportData['department_scope'] }}</span>
        </div>

        <div class="p-6 space-y-6">
            @forelse($reportData['departments'] as $deptData)
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <div class="bg-slate-100/80 px-4 py-2.5 font-bold text-xs text-slate-900 flex justify-between items-center border-b border-slate-200">
                        <span>🏢 {{ $deptData['department']->name }} ({{ $deptData['department']->code }})</span>
                        <span class="text-slate-500">{{ $deptData['total_portals'] }} Portals</span>
                    </div>

                    <div class="p-4 space-y-4">
                        @foreach($deptData['employees'] as $empData)
                            <div>
                                <div class="text-xs font-bold text-blue-900 mb-2 flex items-center justify-between bg-blue-50/50 p-2 rounded-lg">
                                    <span>👤 {{ $empData['employee']->name }} ({{ $empData['employee']->designation ?: 'Staff' }})</span>
                                    <span class="text-[11px] text-slate-500">{{ $empData['total'] }} portal(s)</span>
                                </div>

                                <table class="w-full text-left text-xs text-slate-700">
                                    <thead class="bg-slate-50 text-[10px] uppercase text-slate-400 font-bold border-b border-slate-100">
                                        <tr>
                                            <th class="px-3 py-2">Portal System</th>
                                            <th class="px-3 py-2">Purpose</th>
                                            <th class="px-3 py-2">Endpoint URL</th>
                                            <th class="px-3 py-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($empData['portals'] as $p)
                                            <tr>
                                                <td class="px-3 py-2 font-semibold text-slate-900">
                                                    {{ $p->title }}
                                                </td>
                                                <td class="px-3 py-2 text-slate-600">
                                                    {{ $p->purpose ?: '—' }}
                                                </td>
                                                <td class="px-3 py-2 font-mono text-[11px] text-blue-600">
                                                    <a href="{{ $p->safe_url }}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                                        {{ $p->safe_url }} ↗
                                                    </a>
                                                </td>
                                                <td class="px-3 py-2">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $p->computed_status->badgeClasses() }}">
                                                        {{ $p->computed_status->label() }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400 text-xs">
                    No records found matching the report parameters.
                </div>
            @endforelse
        </div>
    </div>
</div>
