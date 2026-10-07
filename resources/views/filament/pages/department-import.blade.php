<x-filament-panels::page>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-5">
        <div>
            <h1 class="text-xl font-bold text-slate-900 dark:text-white">Import Departments via Excel or CSV</h1>
            <p class="text-xs text-slate-500">Bulk upload organizational departments with automated format validation.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="downloadSampleCsv"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Download Sample CSV</span>
            </button>
            <a href="{{ route('filament.admin.resources.departments.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-xs">
                <span>Back to Departments</span>
            </a>
        </div>
    </div>

    <!-- Upload Box -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs mb-6">
        <h2 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Select Spreadsheet or CSV File</h2>
        <p class="text-xs text-slate-500 mb-4">Supported formats: <strong>.xlsx, .xls, .csv</strong>. Columns expected: <code>name</code>, <code>short_name</code>, <code>code</code>, <code>description</code>, <code>status</code>.</p>

        <form wire:submit="processImport" class="space-y-4">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <input type="file" wire:model="file" accept=".xlsx,.xls,.csv,.txt"
                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-950 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100">

                <button type="submit" wire:loading.attr="disabled"
                        class="shrink-0 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition shadow-xs cursor-pointer">
                    <span wire:loading.remove wire:target="processImport">Upload & Process</span>
                    <span wire:loading wire:target="processImport">Importing...</span>
                </button>
            </div>
            @error('file') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
        </form>
    </div>

    @if(!empty($importResult))
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Import Processing Summary</h3>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500">Total Processed</span>
                    <div class="text-xl font-bold text-slate-900 dark:text-white">{{ $importResult['total'] }}</div>
                </div>
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800">
                    <span class="text-xs text-emerald-700 dark:text-emerald-300">Successfully Imported</span>
                    <div class="text-xl font-bold text-emerald-700 dark:text-emerald-300">{{ $importResult['imported'] }}</div>
                </div>
                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800">
                    <span class="text-xs text-amber-700 dark:text-amber-300">Errors / Skipped</span>
                    <div class="text-xl font-bold text-amber-700 dark:text-amber-300">{{ count($importResult['errors']) }}</div>
                </div>
            </div>

            @if(!empty($importResult['errors']))
                <div class="mt-4 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-xs text-rose-700 dark:text-rose-300 space-y-1">
                    <div class="font-bold">Errors encountered:</div>
                    @foreach($importResult['errors'] as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
