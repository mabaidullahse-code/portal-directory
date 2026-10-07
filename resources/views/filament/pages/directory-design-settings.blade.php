<x-filament-panels::page>
    <!-- Page Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl border border-indigo-900/40">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold border border-indigo-500/30 mb-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    <span>Visual Experience Architecture</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Directory Architectural Design Settings
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                    Choose the visual presentation layout for the university portal directory. Preview interactions live before saving as system default.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <button type="button" wire:click="saveDefaultDesign" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 transition shadow-lg shadow-indigo-900/30 cursor-pointer border border-indigo-400/30">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span wire:loading.remove wire:target="saveDefaultDesign">Save As Default Design</span>
                    <span wire:loading wire:target="saveDefaultDesign">Saving Selection...</span>
                </button>
                <a href="{{ route('filament.admin.pages.portal-directory') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-100 bg-slate-800/80 hover:bg-slate-700 active:bg-slate-900 transition shadow-md border border-slate-700">
                    <span>View Live Directory ↗</span>
                </a>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center gap-2.5 shadow-xs">
            <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block; flex-shrink: 0;" class="text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Design Selector Grid -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Available Architectural Styles</h2>
                <p class="text-xs text-slate-500">Click any card to load its real-time interactive preview below.</p>
            </div>
            <div class="text-xs font-medium text-slate-600 dark:text-slate-400 bg-slate-50 dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700">
                Active System Default: <span class="font-bold text-indigo-600 dark:text-indigo-400 uppercase font-mono">{{ str_replace('_', ' ', $currentSavedDesign) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($designs as $d)
                @php
                    $isSelected = $selectedPreviewDesign === $d->value;
                    $isDefault = $currentSavedDesign === $d->value;
                @endphp
                <button type="button" wire:click="selectDesign('{{ $d->value }}')"
                        class="p-4 rounded-xl border text-left transition relative flex flex-col justify-between cursor-pointer {{ $isSelected ? 'border-indigo-600 bg-indigo-50/60 dark:bg-indigo-950/40 ring-2 ring-indigo-500/20 shadow-xs' : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/60' }}">
                    <div>
                        <div class="flex items-center justify-between gap-1 mb-2">
                            <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $d->label() }}</span>
                            @if($isDefault)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 uppercase">DEFAULT</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            {{ $d->description() }}
                        </p>
                    </div>

                    <div class="mt-4 pt-2 border-t border-slate-200/60 dark:border-slate-700 flex items-center justify-between text-[10px] font-semibold">
                        <span class="{{ $isSelected ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400' }}">
                            {{ $isSelected ? '● Previewing' : 'Click to preview' }}
                        </span>
                        @if($isSelected)
                            <span class="text-indigo-600 dark:text-indigo-400">✓</span>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Live Preview Stage -->
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 font-mono">Live Interactive Preview Stage</span>
            </div>
            <span class="text-xs text-slate-500 font-medium">Currently rendering: <strong class="text-indigo-600 dark:text-indigo-400">{{ $previewDesignInstance->label() }}</strong></span>
        </div>

        <div class="p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 shadow-xs">
            @php
                $viewBlade = match($selectedPreviewDesign) {
                    'radial' => 'portal.designs.radial',
                    'compact' => 'portal.designs.compact',
                    'dashboard' => 'portal.designs.dashboard',
                    'employee_sections' => 'portal.designs.employee-sections',
                    'cyber_matrix' => 'portal.designs.cyber-matrix',
                    'constellation' => 'portal.designs.constellation',
                    'prism_bento' => 'portal.designs.prism-bento',
                    'terminal_console' => 'portal.designs.terminal-console',
                    default => 'portal.designs.card-grid',
                };
            @endphp

            @include($viewBlade, ['departments' => $sampleDepartments])
        </div>
    </div>
</x-filament-panels::page>
