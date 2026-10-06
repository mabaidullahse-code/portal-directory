<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Import Departments via Excel or CSV</h1>
            <p class="text-xs text-slate-500">Bulk upload departments with automated format validation and duplicate suppression.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="downloadSampleCsv"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Download Sample CSV</span>
            </button>
            <a href="{{ route('admin.departments.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <span>Back to Departments</span>
            </a>
        </div>
    </x-slot>

    <!-- Upload Box -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs mb-6">
        <h2 class="text-sm font-bold text-slate-900 mb-2">Step 1: Select Spreadsheet or CSV File</h2>
        <p class="text-xs text-slate-500 mb-4">Supported formats: <strong>.xlsx, .xls, .csv</strong>. Columns expected: <code>name</code>, <code>short_name</code>, <code>code</code>, <code>description</code>, <code>status</code>.</p>

        <form wire:submit="previewFile" class="space-y-4">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <input type="file" wire:model="file" accept=".xlsx,.xls,.csv,.txt"
                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                <button type="submit" wire:loading.attr="disabled"
                        class="w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-xs font-semibold text-white hover:bg-slate-800 transition">
                    <span wire:loading.remove wire:target="previewFile">Parse & Preview Records</span>
                    <span wire:loading wire:target="previewFile">Parsing File...</span>
                </button>

                @if($hasPreview)
                    <button type="button" wire:click="resetUpload"
                            class="px-3 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                        Reset
                    </button>
                @endif
            </div>

            @error('file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </form>
    </div>

    <!-- Import Summary if just imported -->
    @if ($importSummary)
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg">
                    ✓
                </div>
                <div>
                    <h3 class="text-sm font-bold text-emerald-900">Import Successfully Executed</h3>
                    <p class="text-xs text-emerald-700">
                        {{ $importSummary['imported'] }} new departments imported, {{ $importSummary['skipped'] }} skipped/invalid.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Preview Section -->
    @if ($hasPreview && !empty($parsedData['rows']))
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <!-- Summary Bar -->
            <div class="p-4 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Step 2: Preview & Validation Analysis</h3>
                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold">
                            ● {{ $parsedData['valid_count'] }} Valid for Import
                        </span>
                        <span class="inline-flex items-center gap-1 text-rose-700 font-semibold">
                            ● {{ $parsedData['invalid_count'] }} Validation Errors / Duplicates
                        </span>
                    </div>
                </div>

                <div>
                    <button type="button" wire:click="commitImport"
                            @if($parsedData['valid_count'] === 0) disabled @endif
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition shadow-xs">
                        <span wire:loading.remove wire:target="commitImport">
                            Import {{ $parsedData['valid_count'] }} Valid {{ Str::plural('Department', $parsedData['valid_count']) }}
                        </span>
                        <span wire:loading wire:target="commitImport">Processing Import...</span>
                    </button>
                </div>
            </div>

            <!-- Preview Table -->
            <div class="overflow-x-auto max-h-96">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100/70 text-[10px] uppercase font-bold text-slate-500 sticky top-0 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-2.5">Row</th>
                            <th class="px-4 py-2.5">Name</th>
                            <th class="px-4 py-2.5">Short Name</th>
                            <th class="px-4 py-2.5">Code</th>
                            <th class="px-4 py-2.5">Status</th>
                            <th class="px-4 py-2.5">Validation Result</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($parsedData['rows'] as $row)
                            <tr class="{{ $row['is_valid'] ? 'hover:bg-slate-50' : 'bg-rose-50/50 hover:bg-rose-50' }}">
                                <td class="px-4 py-2 font-mono text-[11px] text-slate-400">
                                    #{{ $row['row_number'] }}
                                </td>
                                <td class="px-4 py-2 font-semibold text-slate-900">
                                    {{ $row['name'] ?: '—' }}
                                </td>
                                <td class="px-4 py-2 text-slate-600">
                                    {{ $row['short_name'] ?: '—' }}
                                </td>
                                <td class="px-4 py-2 font-mono font-bold text-[11px] text-slate-800">
                                    {{ $row['code'] ?: '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-semibold border {{ $row['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                        {{ ucfirst($row['status']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if ($row['is_valid'])
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700">
                                            ✓ Ready to import
                                        </span>
                                    @else
                                        <div class="space-y-0.5">
                                            @foreach($row['errors'] as $err)
                                                <div class="text-[11px] text-rose-600 font-medium">✕ {{ $err }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
