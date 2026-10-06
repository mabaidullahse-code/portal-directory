<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">System Activity Audit Logs</h1>
            <p class="text-xs text-slate-500">Immutable trace record of operations, portal changes, status alterations, and security events.</p>
        </div>
    </x-slot>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Logs</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Description, IP address, event..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Action Type</label>
                <select wire:model.live="actionFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Action Types</option>
                    @foreach($distinctActions as $act)
                        <option value="{{ $act }}">{{ $act }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Actor User</label>
                <select wire:model.live="userFilter"
                        class="w-full rounded-lg border border-slate-300 px-3 py-1.5 text-xs text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="all">All Users</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Timestamp</th>
                        <th class="px-4 py-3">Actor</th>
                        <th class="px-4 py-3">Action</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">IP Address</th>
                        <th class="px-4 py-3 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono text-[11px]">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-slate-50/80 transition font-sans">
                            <td class="px-4 py-3 text-slate-500 text-[11px] whitespace-nowrap">
                                <div>{{ $log->created_at->format('d M Y, h:i:s A') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($log->user)
                                    <div class="font-semibold text-slate-900">{{ $log->user->name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $log->user->role->label() }}</div>
                                @else
                                    <span class="text-slate-400 italic">System Auto</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded font-mono text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-800">
                                {{ $log->description }}
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $log->ip_address ?: '127.0.0.1' }}
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if(!empty($log->old_values) || !empty($log->new_values))
                                    <button type="button" wire:click="viewDetails({{ $log->id }})"
                                            class="px-2 py-1 rounded bg-slate-100 text-slate-700 hover:bg-slate-200 text-[11px] font-medium transition">
                                        View Diff
                                    </button>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                No activity logs recorded for this criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Details / Diff Modal -->
    @if ($showDetailsModal && $selectedLog)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" wire:click="$set('showDetailsModal', false)"></div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Audit Trail Value Comparison</h3>
                            <p class="text-xs text-slate-500">{{ $selectedLog->description }}</p>
                        </div>
                        <button type="button" wire:click="$set('showDetailsModal', false)" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1 text-rose-600">
                                <span>Previous Values (Before)</span>
                            </h4>
                            <pre class="bg-slate-50 p-3 rounded-lg border border-slate-200 font-mono text-[11px] overflow-x-auto text-slate-700 whitespace-pre-wrap max-h-60">{{ json_encode($selectedLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: 'None recorded' }}</pre>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-2 flex items-center gap-1 text-emerald-600">
                                <span>Updated Values (After)</span>
                            </h4>
                            <pre class="bg-slate-50 p-3 rounded-lg border border-slate-200 font-mono text-[11px] overflow-x-auto text-slate-700 whitespace-pre-wrap max-h-60">{{ json_encode($selectedLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: 'None recorded' }}</pre>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-3 flex justify-end border-t border-slate-100">
                        <button type="button" wire:click="$set('showDetailsModal', false)"
                                class="px-4 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
